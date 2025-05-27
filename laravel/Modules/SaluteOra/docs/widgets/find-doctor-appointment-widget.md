# FindDoctorAndAppointmentWidget

## Overview

The `FindDoctorAndAppointmentWidget` provides a multi-step wizard interface for patients to find available dentists and book appointments.

## Features

- Multi-step wizard interface
- Location-based dentist search
- Specialization filtering
- Real-time availability checking
- Responsive design
- Form validation
- Error handling
- Loading states

## Implementation Details

### Class Structure

```php
class FindDoctorAndAppointmentWidget extends XotBaseWidget
{
    protected static string $view = 'saluteora::widgets.find-doctor-and-appointment';
    protected int|string|array $columnSpan = 'full';
    public ?array $data = [];
    
    // ...
}
```

### Methods

#### `form(Form $form): Form`
Defines the wizard form structure with multiple steps:
1. **Search Criteria**
   - Location input
   - Specialization dropdown
   - Appointment type selection
2. **Date & Time Selection**
   - Date picker
   - Time slot selection
   - Duration options
3. **Confirmation**
   - Appointment summary
   - Patient details form
   - Terms acceptance

#### `submit()`
Handles form submission, including:
- Validation
- Appointment creation
- Error handling
- Success/error notifications
- Redirection

## View Components

The widget uses the following Blade components:
- `filament::widgets.widget`
- `filament-forms::wizard`
- Custom form components
- Loading indicators
- Error messages

## Usage Example

```php
// In a service provider's boot method
Filament\Facades\Filament::registerWidgets([
    \Modules\SaluteOra\Filament\Widgets\Patient\FindDoctorAndAppointmentWidget::class,
]);
```

## Styling

Uses Tailwind CSS classes for styling. Custom styles can be added in:
```
resources/css/filament/patient/widgets/find-doctor-appointment.css
```

## Dependencies

- Filament Forms
- Filament Widgets
- Livewire
- Alpine.js
- Tailwind CSS

## Testing

Test cases cover:
- Form validation
- Wizard navigation
- API integration
- Error scenarios
- Success flow

## Localization

All user-facing strings are localized using Laravel's translation system. Translation keys are in:
```
lang/vendor/saluteora/en/widgets.php
```

## Performance Considerations

- Uses Livewire for dynamic updates
- Implements loading states
- Optimized database queries
- Cached results where appropriate
- Lazy-loaded components

## Security

- CSRF protection
- Input validation
- Authorization checks
- Rate limiting
- Data sanitization

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile Safari
- Chrome for Android

## Known Issues

- None currently

## Changelog

### 1.0.0
- Initial release

## Contributing

Please follow the project's coding standards and submit pull requests to the `develop` branch.

## License

This widget is part of the SaluteOra module and is licensed under the [MIT license](LICENSE).
