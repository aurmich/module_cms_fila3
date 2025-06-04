# Filament Integration

## Required Directory Structure

The following directory structure is required for proper Filament integration in the SaluteMo module:

```
app/
├── Filament/                   # Filament components
│   ├── Pages/                 # Custom Filament pages
│   ├── Resources/             # Resource classes
│   │   └── {ResourceName}.php # Resource definitions
│   └── Widgets/               # Dashboard widgets
└── Providers/
    └── Filament/              # Filament service providers
        └── SaluteMoPanelProvider.php
```

## Implementation Details

### 1. Panel Provider

The `SaluteMoPanelProvider` should be created to configure the Filament panel for this module.

**Location:** `app/Providers/Filament/SaluteMoPanelProvider.php`

```php
<?php

namespace Modules\SaluteMo\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Navigation\NavigationGroup;
use Nwidart\Modules\Facades\Module;

class SaluteMoPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('salutemo')
            ->path('salutemo')
            ->login()
            ->colors([
                'primary' => '#2563eb',
            ])
            ->discoverResources(in: module_path('SaluteMo', 'app/Filament/Resources'), for: 'Modules\\SaluteMo\\Filament\\Resources')
            ->discoverPages(in: module_path('SaluteMo', 'app/Filament/Pages'), for: 'Modules\\SaluteMo\\Filament\\Pages')
            ->discoverWidgets(in: module_path('SaluteMo', 'app/Filament/Widgets'), for: 'Modules\\SaluteMo\\Filament\\Widgets')
            ->navigationGroups([
                NavigationGroup::make()
                    ->label(__('salutemo::navigation.group')),
            ]);
    }
}
```

### 2. Resource Structure

Resources should be placed in the `app/Filament/Resources` directory. Each resource should follow this structure:

```php
<?php

namespace Modules\SaluteMo\Filament\Resources;

use Filament\Resources\Resource;
use Modules\SaluteMo\Models\YourModel;

class YourModelResource extends Resource
{
    protected static ?string $model = YourModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getNavigationGroup(): ?string
    {
        return __('salutemo::navigation.group');
    }
    
    // Other resource methods...
}
```

### 3. Pages

Custom pages should be placed in the `app/Filament/Pages` directory:

```php
<?php

namespace Modules\SaluteMo\Filament\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'salutemo::filament.pages.dashboard';
    
    protected function getHeaderWidgets(): array
    {
        return [
            // Your widgets here
        ];
    }
}
```

### 4. Widgets

Widgets should be placed in the `app/Filament/Widgets` directory:

```php
<?php

namespace Modules\SaluteMo\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Users', '1,234')
                ->description('32k increase')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];
    }
}
```

## Service Provider Registration

Register the Filament panel provider in your module's service provider:

```php
// In SaluteMoServiceProvider.php

public function register()
{
    $this->app->register(\Modules\SaluteMo\Providers\Filament\SaluteMoPanelProvider::class);
}
```

## Best Practices

1. **Naming Conventions**
   - Use singular names for resources (e.g., `UserResource.php`)
   - Follow PSR-4 autoloading standards
   - Use kebab-case for view files

2. **Translations**
   - All user-facing strings should be translatable
   - Use the module's translation files for labels and messages

3. **Navigation**
   - Group related resources under the same navigation group
   - Use appropriate icons from Heroicons
   - Keep the navigation structure consistent with other modules

4. **Performance**
   - Use eager loading for relationships
   - Implement pagination for large datasets
   - Cache expensive queries

## Common Issues

1. **Routes Not Found**
   - Ensure the panel provider is registered
   - Check route caching with `php artisan route:clear`

2. **Views Not Found**
   - Verify view namespace is correctly set in service provider
   - Clear view cache with `php artisan view:clear`

3. **Permissions**
   - Ensure proper permissions are set for the storage directory
   - Check file ownership in the `bootstrap/cache` directory

## Testing

Test your Filament components using Laravel's testing framework:

```php
public function test_can_render_resource_index_page()
{
    $this->get(route('filament.resources.your-resource.index'))
         ->assertSuccessful();
}
```

## Deployment

1. Clear all caches:
   ```bash
   php artisan cache:clear
   php artisan view:clear
   php artisan route:clear
   php artisan config:clear
   ```

2. Cache routes and config for production:
   ```bash
   php artisan config:cache
   php artisan route:cache
   ```

3. Ensure storage directory is writable:
   ```bash
   chmod -R 775 storage/
   chmod -R 775 bootstrap/cache/
   ```
