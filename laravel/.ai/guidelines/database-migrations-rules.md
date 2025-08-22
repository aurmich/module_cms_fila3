# Database Migrations Rules

## ⚠️ CRITICAL: Single Migration Per Table Rule

### Fundamental Principle
**Each table MUST have a single primary migration** that defines its complete structure. Avoid fragmented migrations for the same table.

### ❌ WRONG Approach - Multiple Migrations
```php
// 2023_03_31_103351_create_activity_table.php
Schema::create('activity_log', function (Blueprint $table) {
    $table->id();
    $table->string('description');
    $table->integer('causer_id'); // WRONG: will need to change later
});

// 2024_01_15_140500_update_activity_log_table_causer_nullable.php
Schema::table('activity_log', function (Blueprint $table) {
    $table->string('causer_id')->nullable()->change();
});
```

### ✅ CORRECT Approach - Single Unified Migration
```php
// 2023_03_31_103351_create_activity_table.php (updated timestamp if needed)
Schema::create('activity_log', function (Blueprint $table) {
    $table->id();
    $table->string('description');
    $table->string('causer_id')->nullable(); // CORRECT: complete definition
});
```

## Why String IDs for Polymorphic Relations

### UUID Support
```php
// Users use UUID primary keys
$table->uuid('id')->primary();

// Activity log must support UUID references
$table->string('causer_id')->nullable(); // Can store UUID strings
```

### Polymorphic Flexibility
```php
// causer_id can reference different model types:
// User: "123e4567-e89b-12d3-a456-426614174000" (UUID)
// Admin: "admin_001" (custom string)
// System: "system" (system actions)
// Integer models: "123" (converted to string)
```

## Migration Best Practices

### 1. Plan Complete Table Structure
Before creating a migration, plan the complete table structure including:
- All columns and their final types
- All indexes
- All foreign key constraints
- Nullable/default considerations

### 2. Update Timestamps When Consolidating
When consolidating multiple migrations into one:
```bash
# Original files:
2023_03_31_103351_create_activity_table.php
2024_01_15_140500_update_activity_log_table_causer_nullable.php

# After consolidation:
2024_01_15_140500_create_activity_table.php (updated timestamp)
# Delete the separate update migration
```

### 3. Consider Data Types Carefully
```php
// ✅ String for polymorphic/UUID references
$table->string('causer_id')->nullable();

// ✅ Integer for standard auto-increment references  
$table->foreignId('user_id')->constrained();

// ✅ UUID when model uses UUID primary key
$table->uuid('id')->primary();
```

### 4. Environment Consistency
Single migrations ensure:
- ✅ Consistent schema across environments
- ✅ Easier deployment
- ✅ Simpler rollbacks
- ✅ Cleaner migration history
- ✅ Reduced dependency complexity

### 5. Shared Resources Rule
**CRITICAL**: The `/var/www/html/_bases/base_saluteora/bashscripts/` directory is shared across multiple projects.

**❌ NEVER put project-specific files in shared directories:**
```bash
# WRONG - project-specific files in shared location
bashscripts/database/seeding/saluteora-*.php
bashscripts/database/seeding/salutemo-*.php
bashscripts/database/seeding/tinker-*.php
```

**✅ Project-specific files belong in project directories:**
```bash
# CORRECT - project files in project location
laravel/database/seeders/
laravel/Modules/*/database/seeders/
```

## When Multiple Migrations Are Acceptable

### ✅ Legitimate Cases for Multiple Migrations
1. **Different Tables**: Each table gets its own migration
2. **Data Migrations**: Separate from schema changes
3. **Index Additions**: Performance improvements to existing tables
4. **Major Refactoring**: When renaming/restructuring existing tables

### ❌ Avoid Multiple Migrations For
1. **Column Type Changes**: Consolidate into original migration
2. **Nullable Changes**: Plan nullability from the start
3. **Default Value Changes**: Include in original schema
4. **Adding Missing Columns**: Plan complete structure initially

## Implementation Strategy

### For New Tables
1. Plan complete schema upfront
2. Create single comprehensive migration
3. Include all columns, indexes, constraints
4. Test thoroughly before deployment

### For Existing Problematic Migrations
1. Identify fragmented migrations
2. Consolidate into single migration file
3. Update timestamp if needed
4. Remove duplicate migration files
5. Test migration rollback/recreation

## Benefits of Single Migration Approach

### Development
- ✅ Clear table ownership
- ✅ Complete schema visibility
- ✅ Easier debugging
- ✅ Reduced complexity

### Deployment
- ✅ Atomic table creation
- ✅ Predictable rollbacks
- ✅ Environment consistency
- ✅ Reduced failure points

### Maintenance
- ✅ Single source of truth
- ✅ Easier schema changes
- ✅ Clear dependency management
- ✅ Simplified testing