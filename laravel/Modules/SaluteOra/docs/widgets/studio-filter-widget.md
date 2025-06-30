# StudioFilterWidget

## Overview

The `StudioFilterWidget` is a Filament widget designed to allow doctors to switch between their associated studios. It provides a user-friendly interface to view studio details and quickly switch between different studios.

## Features

- Displays current studio information (name, address, contact details)
- Allows switching between multiple studios
- Shows a list of all available studios
- Persists the selected studio in the session
- Dispatches events when the studio changes
- Responsive design that works on all screen sizes

## Requirements

- PHP 8.1+
- Laravel 10+
- Filament 3.x
- `mcamara/laravel-localization` package

## Installation

The widget is automatically registered with the Filament panel. No additional installation steps are required.

## Usage

### Adding to a Panel

To add the widget to a Filament panel, include it in the `widgets` method of your panel provider:

```php
use Modules\SaluteOra\Filament\Widgets\StudioFilterWidget;

public function panel(Panel $panel): Panel
{
    return $panel
        // ... other configuration
        ->widgets([
            StudioFilterWidget::class,
            // ... other widgets
        ]);
}
```

### Displaying in a View

The widget can also be included in any Blade view using the Livewire component syntax:

```blade
<livewire:studio-filter-widget />
```

## Components

### StudioFilterWidget

The main widget class that handles the studio selection logic and data retrieval.

### Views

- `studio-filter.blade.php` - Main view template
- `studio-details.blade.php` - Reusable studio details component

## Events

The widget dispatches the following events:

- `studioChanged` - Dispatched when a new studio is selected

## Methods

### getStudio()

Retrieves the currently selected studio model.

### getStudioAddress()

Gets the formatted address of the current studio.

### getStudioDoctors()

Retrieves a list of doctors associated with the current studio.

## Styling

The widget uses Tailwind CSS classes for styling and follows Filament's design system. Custom styling can be added by publishing the views and modifying the Blade templates.

## Best Practices

1. **Performance**: The widget uses eager loading to minimize database queries.
2. **Accessibility**: Follows WCAG 2.1 AA standards.
3. **Responsiveness**: Works on all screen sizes.
4. **Error Handling**: Includes proper error handling and user feedback.

## Troubleshooting

### Widget Not Appearing

- Ensure the widget is registered in your panel provider
- Check that the authenticated user has the correct permissions
- Verify that the user has at least one associated studio

### Studio Not Changing

- Check the browser's developer console for JavaScript errors
- Verify that the studio ID exists and is associated with the current user
- Check the Laravel logs for any server-side errors

## Related Components

- `Studio` - The studio model
- `Doctor` - The doctor model with studio relationships
- `StudioFilter` - The Livewire component powering the widget

## Version History

- **1.0.0** - Initial release
  - Basic studio selection functionality
  - Studio details display
  - Responsive design
  - Event dispatching

## Contributing

Contributions are welcome! Please read the [contributing guide](CONTRIBUTING.md) before submitting a pull request.

## License

This widget is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
