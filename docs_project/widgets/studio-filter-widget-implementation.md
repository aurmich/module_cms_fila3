# StudioFilterWidget - Implementation Guide

## Table of Contents
- [Architecture Overview](#architecture-overview)
- [Component Structure](#component-structure)
- [Data Flow](#data-flow)
- [Event System](#event-system)
- [Performance Considerations](#performance-considerations)
- [Testing Strategy](#testing-strategy)
- [Common Issues and Solutions](#common-issues-and-solutions)
- [Upgrade Guide](#upgrade-guide)

## Architecture Overview

The `StudioFilterWidget` follows the MVVM (Model-View-ViewModel) pattern, where:

- **Model**: `Studio` and `Doctor` Eloquent models
- **View**: Blade templates in `resources/views/filament/widgets/`
- **ViewModel**: The `StudioFilterWidget` Livewire component

## Component Structure

```
app/
  Filament/
    Widgets/
      StudioFilterWidget.php       # Main widget class
  Models/
    Studio.php                    # Studio model
    Doctor.php                    # Doctor model

resources/views/
  filament/
    widgets/
      studio-filter.blade.php     # Main widget view
      studio-details.blade.php    # Studio details component
```

## Data Flow

1. **Initialization**:
   - Widget loads the current doctor's studios
   - Retrieves the currently selected studio from the session
   - Loads studio details and associated doctors

2. **Studio Selection**:
   - User selects a studio from the dropdown
   - Widget updates the session with the new studio ID
   - Dispatches `studioChanged` event
   - Refreshes the page to update all components

3. **Data Loading**:
   - Uses eager loading to minimize database queries
   - Caches studio data to improve performance
   - Implements proper error handling for missing data

## Event System

The widget dispatches the following events:

### `studioChanged`
- **Payload**: `{ studioId: number, studioName: string }`
- **Purpose**: Notifies other components that the studio has changed
- **Usage**:
  ```javascript
  document.addEventListener('studioChanged', (event) => {
      const { studioId, studioName } = event.detail;
      // Update your component
  });
  ```

## Performance Considerations

### Eager Loading
Always use eager loading when retrieving studios with their relationships:

```php
$studios = $doctor->studios()->with(['address', 'doctors'])->get();
```

### Caching
Cache studio data that doesn't change frequently:

```php
$studios = Cache::remember("doctor_{$doctorId}_studios", 3600, function() use ($doctor) {
    return $doctor->studios()->with(['address', 'doctors'])->get();
});
```

### Lazy Loading
Load heavy components only when needed:

```blade
@if($showDetails)
    @include('filament.widgets.studio-details', ['studio' => $studio])
@endif
```

## Testing Strategy

### Unit Tests
- Test studio loading and filtering
- Verify session handling
- Test event dispatching

### Feature Tests
- Test studio selection flow
- Verify UI updates
- Test error scenarios

### Browser Tests
- Test the widget in different screen sizes
- Verify accessibility
- Test with different user roles

## Common Issues and Solutions

### Studio Not Updating
**Issue**: Studio selection doesn't update the UI
**Solution**:
1. Check if the `studioChanged` event is being dispatched
2. Verify the session is being updated
3. Check for JavaScript errors in the console

### Missing Studio Data
**Issue**: Studio details are not showing
**Solution**:
1. Verify the studio exists in the database
2. Check if the user has permission to view the studio
3. Verify the relationships are properly defined

### Performance Issues
**Issue**: Widget is slow to load
**Solution**:
1. Implement caching for studio data
2. Use eager loading for relationships
3. Limit the number of studios loaded at once

## Upgrade Guide

### From v1.0 to v1.1
- Added support for studio favorites
- Improved mobile responsiveness
- Added loading states

### From v0.9 to v1.0
- Initial release
- Basic studio selection
- Studio details display
- Event dispatching

## Best Practices

### Code Organization
- Keep widget logic in the widget class
- Use components for reusable UI elements
- Follow PSR-12 coding standards

### Error Handling
- Validate all user input
- Provide meaningful error messages
- Log all errors for debugging

### Security
- Validate studio ownership
- Use Laravel's authorization system
- Sanitize all user input

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a pull request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
