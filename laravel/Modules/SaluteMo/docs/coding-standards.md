# Coding Standards and Conventions

## Import and Alias Conventions

### Class Aliasing

When importing classes that might have naming conflicts or need clarification, follow these aliasing conventions:

1. **Vendor/Package Prefixing**
   - Always prefix the alias with the vendor/package name
   - Example: `use Filament\Pages\Dashboard as FilamentDashboard;`
   - This makes the source of the class immediately clear

2. **Avoid Generic Aliases**
   - Don't use generic aliases like `Base*`
   - Instead of `use Package\Class as BaseClass;`
   - Use `use Package\Class as PackageClass;`

3. **Consistency**
   - Apply the same aliasing pattern across the entire module
   - Document any exceptions to this rule

### Rationale

1. **Clarity**
   - Makes the code more self-documenting
   - Reduces cognitive load when reading code

2. **Maintainability**
   - Easier to track where classes come from
   - Reduces chance of naming conflicts

3. **Consistency**
   - Follows established PHP community standards
   - Matches the pattern used in other parts of the application

## Dashboard Implementation

### Required Import

```php
use Filament\Pages\Dashboard as FilamentDashboard;
```

### Why Not `BaseDashboard`?

1. `Base` prefix is typically used for abstract base classes in our codebase
2. `Filament` prefix clearly indicates the package the class comes from
3. Matches the pattern used in other parts of the application

## Best Practices

1. **Use Full Namespace**
   - Always use the fully qualified class name in the import statement
   - Makes dependencies explicit

2. **Group Imports**
   - Group related imports together
   - Separate standard library, framework, and custom imports

3. **Alphabetical Order**
   - Sort imports alphabetically within each group
   - Makes it easier to find specific imports

## Example

```php
<?php

namespace Modules\SaluteMo\Filament\Pages;

use Filament\Pages\Dashboard as FilamentDashboard;
use Filament\Pages\Page;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Modules\SaluteMo\Filament\Widgets\StatsOverview;

class Dashboard extends FilamentDashboard
{
    // Implementation...
}
```

## Related Documentation

- [Dashboard Requirements](dashboard-requirements.md)
- [Filament Integration](filament-integration.md)
- [Service Provider](service-provider.md)
