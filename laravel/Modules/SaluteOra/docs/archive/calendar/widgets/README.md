# Calendar Widgets

## Overview

This directory contains documentation for the calendar widgets used in the SaluteOra module. Each widget is tailored to a specific user type and provides appropriate functionality based on the user's role.

## Available Widgets

1. [Admin Calendar Widget](admin-calendar-widget.md) - For administrators to manage all appointments
2. [Doctor Calendar Widget](doctor-calendar-widget.md) - For doctors to manage their appointments
3. [Patient Calendar Widget](patient-calendar-widget.md) - For patients to view their appointments

## Base Widget

All calendar widgets extend the `BaseCalendarWidget` class, which provides common functionality:

- Event fetching and formatting
- Date range handling
- Basic configuration

## Usage

To use a calendar widget in your Filament panel, register it in your panel provider:

```php
use Modules\SaluteOra\Filament\Widgets\Admin\AdminCalendarWidget;
use Modules\SaluteOra\Filament\Widgets\Doctor\DoctorCalendarWidget;
use Modules\SaluteOra\Filament\Widgets\Patient\PatientCalendarWidget;

public function getWidgets(): array
{
    return [
        // ...
        AdminCalendarWidget::class,
        DoctorCalendarWidget::class,
        PatientCalendarWidget::class,
    ];
}
```

## Customization

Each widget can be customized by overriding methods in the base class. Common customizations include:

- Event display
- Available views (day, week, month)
- Header toolbar configuration
- Event colors and styling

See the individual widget documentation for more details.
