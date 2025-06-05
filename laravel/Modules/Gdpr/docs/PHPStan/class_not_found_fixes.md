# Class Not Found Fixes for GDPR Module

## PHPDoc Type Issues

### 1. Unknown Builder Class in Event Model

**Error Messages:**
```
PHPDoc tag @method for method Modules\Gdpr\Models\Event::newModelQuery() return type contains unknown class Modules\Gdpr\Models\Builder.

PHPDoc tag @method for method Modules\Gdpr\Models\Event::newQuery() return type contains unknown class Modules\Gdpr\Models\Builder.

PHPDoc tag @method for method Modules\Gdpr\Models\Event::query() return type contains unknown class Modules\Gdpr\Models\Builder.

PHPDoc tag @method for method Modules\Gdpr\Models\Event::whereAction() return type contains unknown class Modules\Gdpr\Models\Builder.
```

**File Location:**
`Modules/Gdpr/Models/Event.php`

**Problem Analysis:**
The PHPDoc for several methods in the Event model references a non-existent Builder class in the `Modules\Gdpr\Models` namespace. The correct class to reference is `Illuminate\Database\Eloquent\Builder`.

**Implementation Strategy:**
- Update PHPDoc references to use the fully qualified namespace for the Builder class
- Ensure consistent use of the Builder class throughout all method PHPDoc blocks
- Follow the Laraxot framework documentation standards

### Benefits:
- Corrects PHPStan type checking errors
- Improves code documentation accuracy
- Ensures proper IDE autocompletion support

## Collegamenti tra versioni di CLASS_NOT_FOUND_FIXES.md
* [CLASS_NOT_FOUND_FIXES.md](laravel/Modules/Gdpr/docs/phpstan/CLASS_NOT_FOUND_FIXES.md)
* [CLASS_NOT_FOUND_FIXES.md](laravel/Modules/Gdpr/docs/PHPStan/CLASS_NOT_FOUND_FIXES.md)


## Collegamenti tra versioni di class_not_found_fixes.md
* [class_not_found_fixes.md](../PHPStan/class_not_found_fixes.md)
* [class_not_found_fixes.md](../phpstan/class_not_found_fixes.md)

