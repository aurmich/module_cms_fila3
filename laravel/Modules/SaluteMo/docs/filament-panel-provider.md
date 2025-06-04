# Filament Admin Panel Provider

## Overview

The `AdminPanelProvider` is responsible for configuring the Filament admin panel for the SaluteMo module. It extends the `XotBasePanelProvider` to inherit standard behaviors while allowing module-specific customizations.

## Location

```php
app/Providers/Filament/AdminPanelProvider.php
```

## Key Responsibilities

1. **Panel Configuration**
   - Sets up the Filament panel for the module
   - Configures navigation, widgets, and resources
   - Handles authentication and authorization

2. **Customization**
   - Adds module-specific widgets and resources
   - Configures plugins and features
   - Customizes the panel appearance and behavior

## Implementation Details

### Class Structure

```php
namespace Modules\SaluteMo\Providers\Filament;

use Filament\Panel;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'SaluteMo';
    
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);
        
        // Module-specific customizations here
        
        return $panel;
    }
}
```

### Common Customizations

#### Adding Widgets

```php
$panel->widgets([
    \Modules\SaluteMo\Filament\Widgets\StatsOverview::class,
    // Add more widgets as needed
]);
```

#### Registering Resources

```php
$panel->resources([
    \Modules\SaluteMo\Filament\Resources\YourResource::class,
    // Add more resources as needed
]);
```

#### Configuring Plugins

```php
$panel->plugin(
    \Saade\FilamentFullCalendar\FilamentFullCalendarPlugin::make()
        ->config([
            // Plugin configuration
        ])
);
```

## Best Practices

1. **Extend XotBasePanelProvider**
   - Always extend `XotBasePanelProvider` for consistency
   - Override only what's necessary

2. **Keep It Clean**
   - Move complex logic to dedicated service classes
   - Use configuration files for static values

3. **Document Changes**
   - Document all customizations
   - Add comments for non-obvious configurations

## Related Documentation

- [Filament Documentation](https://filamentphp.com/docs)
- [Module Configuration](module-configuration.md)
- [Widgets](widgets.md)
- [Resources](resources.md)
