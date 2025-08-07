# HTTP Directory Structure and Conventions

## Directory Structure

All HTTP-related classes must be placed under the `app/Http/` directory within each module:

```
Modules/
  {ModuleName}/
    app/
      Http/
        Controllers/     # Controller classes
        Middleware/      # HTTP middleware
        Requests/        # Form request classes
        Resources/       # API resources
```

## Controller Placement

- ✅ **Correct**: `Modules/{ModuleName}/app/Http/Controllers/`
- ❌ **Incorrect**: `Modules/{ModuleName}/Http/Controllers/`

## Naming Conventions

- Controller class names should be in `PascalCase`
- Controller filenames should match the class name with `.php` extension
- Use the `Controller` suffix for controller classes
- Group related controllers in subdirectories when appropriate

## Example Structure

```
app/
  Http/
    Controllers/
      Auth/
        LoginController.php
        RegisterController.php
      UserController.php
      SettingsController.php
    Middleware/
      CheckAdmin.php
    Requests/
      StoreUserRequest.php
```

## Common Mistakes

1. Placing controllers directly under `Http/` instead of `app/Http/`
2. Forgetting to update namespaces when moving files
3. Not following PSR-4 autoloading standards

## Automatic Fix

To move files to the correct location:

```bash

# For a single controller
mkdir -p Modules/{ModuleName}/app/Http/Controllers/
mv Modules/{ModuleName}/Http/Controllers/SomeController.php Modules/{ModuleName}/app/Http/Controllers/

# For a directory of controllers
mkdir -p Modules/{ModuleName}/app/Http/Controllers/
mv Modules/{ModuleName}/Http/Controllers/* Modules/{ModuleName}/app/Http/Controllers/
```

## Namespace

Ensure the namespace matches the directory structure:

```php
// Correct
namespace Modules\{ModuleName}\Http\Controllers;

// Incorrect
namespace Modules\{ModuleName}\App\Http\Controllers;
```

## Related Documentation

- [Module Directory Structure](./directory-structure.md)
- [PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/)
- [Laravel HTTP Documentation](https://laravel.com/docs/http-tests)
