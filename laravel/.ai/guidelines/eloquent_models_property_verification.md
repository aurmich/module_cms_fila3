# Eloquent Models Property Verification Guidelines

## Critical Error: property_exists() with Eloquent Models

### The Problem
Using `property_exists()` on Eloquent models is a critical error because:
- Eloquent models use magic properties via `__get()` and `__set()`
- Database fields are NOT real PHP properties
- `property_exists()` always returns `false` for database fields
- This leads to incorrect logic and unpredictable behavior

### Correct Alternatives

#### Model Attribute Verification
```php
// ✅ Check if an attribute exists on the model
if ($model->hasAttribute('field_name')) {
    // correct logic
}

// ✅ Check if a field is fillable
if ($model->isFillable('field_name')) {
    // correct logic
}

// ✅ Check if an attribute has been set
if (isset($model->field_name)) {
    // correct logic
}

// ✅ Check if attribute is not null
if (!is_null($model->field_name)) {
    // correct logic
}
```

#### Database Structure Verification
```php
use Illuminate\Support\Facades\Schema;

// ✅ Check if a column exists in the database table
if (Schema::hasColumn('table_name', 'column_name')) {
    // correct logic
}

// ✅ Get all columns for a table
$columns = Schema::getColumnListing('table_name');
if (in_array('field_name', $columns)) {
    // correct logic
}
```

#### Cast and Relationship Verification
```php
// ✅ Check if an attribute is in the casts array
if (array_key_exists('field_name', $model->getCasts())) {
    // correct logic
}

// ✅ Check if a relationship exists
if (method_exists($model, 'relationshipName')) {
    // correct logic
}
```

### Forbidden Code Examples

```php
// ❌ NEVER DO THIS - Always returns false for database fields
if (property_exists($model, 'email')) {
    // This condition will NEVER be true for database fields
}

// ❌ NEVER DO THIS - Incorrect logic
$hasEmail = property_exists($user, 'email'); // Always false!

// ❌ NEVER DO THIS - Wrong approach
if (property_exists($model, 'created_at')) {
    // Will never work as expected
}
```

### Migration from Incorrect Code

#### Before (Incorrect)
```php
if (property_exists($model, 'field_name')) {
    $model->field_name = $value;
}
```

#### After (Correct)
```php
if ($model->isFillable('field_name')) {
    $model->field_name = $value;
}
// OR
if (Schema::hasColumn($model->getTable(), 'field_name')) {
    $model->field_name = $value;
}
```

### Testing Considerations
When writing tests, use the correct methods. However, note that testing basic model properties like fillable fields should be avoided - focus on functional behavior instead:

```php
// ✅ Correct test assertions for functionality
$this->assertTrue($model->hasAttribute('field_name'));
$this->assertTrue(isset($model->field_name));

// ❌ Avoid testing basic properties - focus on functionality
// $this->assertTrue($model->isFillable('field_name')); // Don't test fillable

// ❌ Incorrect test assertions
$this->assertTrue(property_exists($model, 'field_name')); // Always fails
```

### Code Review Checklist
- [ ] No usage of `property_exists()` on Eloquent models
- [ ] Proper use of `hasAttribute()` for attribute checks
- [ ] Proper use of `isFillable()` for fillable checks
- [ ] Proper use of `Schema::hasColumn()` for database structure checks
- [ ] Correct logic flow based on actual model capabilities

### Impact Assessment
Using `property_exists()` on Eloquent models causes:
- Broken validation logic
- Unpredictable application behavior
- Runtime errors that are difficult to trace
- Violation of Laravel/Eloquent best practices
- False negative results in all cases

### Documentation Updates Required
When this error is found:
1. Update all relevant documentation
2. Fix all occurrences in the codebase
3. Update tests that depend on the incorrect logic
4. Review related code for similar issues
5. Add this guideline to project documentation

*Last updated: August 2025*