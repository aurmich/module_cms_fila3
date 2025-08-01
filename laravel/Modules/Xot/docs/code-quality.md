# Laraxot Code Quality Standards

## Overview

This document defines the mandatory code quality standards for Laraxot projects. These rules ensure consistency, maintainability, and adherence to the Laraxot framework philosophy across all modules.

## Core Principles

### 1. Strict Typing and PHPStan Level 9+
- **ALWAYS** use `declare(strict_types=1);` at the beginning of every PHP file
- **MINIMUM** PHPStan level 9 for all new code
- **NEVER** use `mixed` types unless absolutely necessary
- **ALWAYS** provide explicit return types and parameter types

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Models;

use Modules\ModuleName\Models\BaseModel;

/**
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 */
class ExampleModel extends BaseModel
{
    /** @var list<string> */
    protected $fillable = ['name'];
    
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }
}
```

### 2. Laraxot Module Structure Compliance

#### Model Inheritance
- **ALWAYS** extend `BaseModel` of the same module
- **NEVER** extend `Illuminate\Database\Eloquent\Model` directly
- **NEVER** extend `Modules\Xot\Models\XotBaseModel` directly

```php
// ✅ CORRECT
class User extends \Modules\User\Models\BaseModel

// ❌ WRONG
class User extends \Illuminate\Database\Eloquent\Model
class User extends \Modules\Xot\Models\XotBaseModel
```

#### Migration Standards
- **ALWAYS** use anonymous classes extending `XotBaseMigration`
- **NEVER** implement `down()` method
- **ALWAYS** use `hasTable()` and `hasColumn()` checks

```php
return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name');
        });
        
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table, false);
        });
    }
};
```

### 3. Namespace Conventions
- **NEVER** include 'App' segment in module namespaces
- **ALWAYS** use `Modules\{ModuleName}\{Directory}\{ClassName}` pattern

```php
// ✅ CORRECT
namespace Modules\Performance\Models;
namespace Modules\Performance\Http\Controllers;

// ❌ WRONG
namespace Modules\Performance\App\Models;
namespace App\Modules\Performance\Models;
```

### 4. Translation File Standards
- **NEVER** remove existing keys from translation files
- **ALWAYS** use expanded structure for fields and actions
- **ALWAYS** use short array syntax `[]`
- **NEVER** hardcode strings in components

```php
// ✅ CORRECT
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome completo dell\'utente',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea',
            'success' => 'Creato con successo',
            'error' => 'Errore durante la creazione',
        ],
    ],
];
```

### 5. Filament Component Rules
- **NEVER** use `->label()` in form components
- **ALWAYS** extend XotBase classes
- **ALWAYS** return associative arrays from `getFormSchema()`

```php
// ✅ CORRECT
public static function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name'),
        'email' => TextInput::make('email'),
    ];
}

// ❌ WRONG
public static function getFormSchema(): array
{
    return [
        TextInput::make('name')->label('Nome'),
        TextInput::make('email')->label('Email'),
    ];
}
```

## PHPStan Configuration

### Execution Rules
- **ALWAYS** run from `/laravel` directory
- **NEVER** use `php artisan test:phpstan`
- **ALWAYS** use `./vendor/bin/phpstan analyze --level=9 --memory-limit=2G`

### Error Resolution Patterns
1. **Property Access**: Add `@property` annotations to models
2. **Method Returns**: Add explicit return types
3. **Generics**: Use specific types instead of interfaces in collections
4. **Null Safety**: Add null checks before method/property access

## Safe Library Integration

**ALWAYS** use Safe library functions for potentially unsafe operations:

```php
use function Safe\json_encode;
use function Safe\file_get_contents;
use function Safe\preg_match;

// ✅ CORRECT
$json = json_encode($data);
$content = file_get_contents($file);

// ❌ WRONG
$json = \json_encode($data); // Can return false
$content = \file_get_contents($file); // Can return false
```

## Documentation Standards

### Module Documentation
- **ALWAYS** document in module-specific `docs/` folder
- **ALWAYS** create bidirectional links with root documentation
- **NEVER** use obvious comments in code
- **ALWAYS** follow DRY and KISS principles

### PHPDoc Requirements
- **ALWAYS** document all public methods and properties
- **ALWAYS** use generics for collections: `Collection<int, User>`
- **ALWAYS** specify array shapes: `array<string, mixed>`

## Quality Assurance Checklist

- [ ] `declare(strict_types=1);` in all PHP files
- [ ] PHPStan level 9+ passes without errors
- [ ] All models extend module-specific BaseModel
- [ ] No hardcoded strings in components
- [ ] Translation files use expanded structure
- [ ] Migrations use anonymous classes
- [ ] Namespace follows Laraxot conventions
- [ ] Documentation updated in module docs/
- [ ] Safe library used for unsafe functions
- [ ] Complete PHPDoc for all public APIs

## Enforcement

These standards are **MANDATORY** and will be enforced through:
- Automated PHPStan checks in CI/CD
- Code review requirements
- Pre-commit hooks
- Regular quality audits

---

*This document reflects the Laraxot framework philosophy and must be followed without exception.*

## Documentation and Updates
- Document any deviations from these guidelines or custom quality rules in the relevant module's documentation folder.
- Update this document if new tools or standards for code quality are introduced.

## Links to Related Documentation
- [Xot Base Classes](../Xot/docs/XOT_BASE_CLASSES.md)
- [Filament Extension Pattern](../../Notify/docs/FILAMENT_EXTENSION_PATTERN.md)
- [Filament Extension Pattern Analysis](../../Notify/docs/FILAMENT_EXTENSION_PATTERN_ANALYSIS.md)
- [Patient Module - Namespace Conventions](../../Patient/docs/NAMESPACE_CONVENTIONS.md)
- [Patient Module - Validation Errors](../../Patient/docs/VALIDATION_ERRORS.md)
- [PHP Strict Types](./PHP-STRICT-TYPES.md)
- [PHPStan Implementation Guide](./PHPSTAN-IMPLEMENTATION-GUIDE.md)
- [Naming Conventions](./NAMING-CONVENTIONS.md)
- [Service Provider Best Practices](./SERVICE-PROVIDER-BEST-PRACTICES.md)
- [Filament Best Practices](./FILAMENT-BEST-PRACTICES.md)
