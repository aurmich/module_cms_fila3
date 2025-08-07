# Calendar Module Documentation

## Overview

This directory contains comprehensive documentation for the multi-tenant calendar implementation in the SaluteOra module. The calendar system is built using FullCalendar with Filament integration and supports multiple user types with different permission levels.

## Documentation Structure

- [Architecture](architecture.md) - High-level overview of the calendar system architecture
- [Widgets](widgets/README.md) - Documentation for each calendar widget
- [Rules](rules/README.md) - Implementation rules and best practices
- [Tenancy](tenancy.md) - Multi-tenancy implementation details
- [Testing](testing.md) - Testing strategies and examples

## Key Features

- **Multi-tenant support** - Separate data between different clinics
- **Role-based access control** - Different views for Admin, Doctor, and Patient users
- **Responsive design** - Works on desktop and mobile devices
- **Real-time updates** - Using Livewire for dynamic content updates
- **Customizable views** - Day, week, month, and list views

## Getting Started

### Prerequisites

- PHP 8.1+
- Laravel 10.x
- Filament 3.x
- `saade/filament-fullcalendar` package

### Installation

1. Install the required package:
   ```bash
   composer require saade/filament-fullcalendar
   ```

2. Publish the configuration:
   ```bash
   php artisan vendor:publish --tag="filament-fullcalendar-config"
   ```

3. Publish assets (if needed):
   ```bash
   php artisan vendor:publish --tag="filament-fullcalendar-assets" --force
   ```

## Widgets

### Admin Calendar Widget
- **Location**: `Filament/Widgets/Admin/AdminCalendarWidget.php`
- **Description**: Shows all appointments across all clinics
- **Access**: Admin users only

### Doctor Calendar Widget
- **Location**: `Filament/Widgets/Doctor/DoctorCalendarWidget.php`
- **Description**: Shows appointments for the current doctor in the selected clinic
- **Access**: Doctor users only

### Patient Calendar Widget
- **Location**: `Filament/Widgets/Patient/PatientCalendarWidget.php`
- **Description**: Shows appointments for the current patient
- **Access**: Patient users only

## Best Practices

1. Always extend `BaseCalendarWidget` when creating new calendar widgets
2. Use the `getEventsQuery()` method to scope data properly
3. Implement proper authorization checks
4. Eager load relationships to prevent N+1 queries
5. Cache expensive queries when appropriate

## Related Documentation

- [FullCalendar Documentation](https://fullcalendar.io/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [Saade Filament FullCalendar](https://github.com/saade/filament-fullcalendar)

## Changelog

- **2023-10-15**: Initial implementation
- **2023-10-16**: Added multi-tenant support
- **2023-10-17**: Improved performance with caching

## Contributing

When contributing to the calendar module, please follow these guidelines:

1. Follow PSR-12 coding standards
2. Write tests for new features
3. Update documentation when making changes
4. Create a pull request with a clear description of changes
