# FullCalendar Integration Guide

## Overview
This document outlines the implementation of FullCalendar in the SaluteOra module using the Filament Saade FullCalendar plugin.

## Prerequisites
- Filament 3.x
- Saade\FilamentFullCalendar\FilamentFullCalendarServiceProvider
- FullCalendar 6.x

## Installation

1. Install the required package:
```bash
composer require saade/filament-fullcalendar
```

2. Publish the configuration file:
```bash
php artisan vendor:publish --tag="filament-fullcalendar-config"
```

## Basic Implementation

### 1. Create Calendar Widget

Create a new widget in `app/Filament/Widgets/`:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class AppointmentCalendar extends \Saade\FilamentFullCalendar\Widgets\FullCalendarWidget
{
    protected static string $view = 'saluteora::widgets.appointment-calendar';
    
    protected static ?string $heading = 'Appointments';
    
    public function fetchEvents(array $fetchInfo): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Appointment #1',
                'start' => now(),
                'end' => now()->addHour(),
                'url' => '#',
                'shouldOpenUrlInNewTab' => false,
            ],
        ];
    }
}
```

### 2. Create View File

Create a new view at `resources/views/vendor/filament/widgets/appointment-calendar.blade.php`:

```php
<x-filament-widgets::widget>
    <x-filament::card>
        <div 
            x-data="calendar({
                events: $wire.entangle('events').defer,
            })"
            wire:ignore
            class="fi-wi-stats-overview-stats-container"
        >
            <div id='calendar'></div>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>
```

## Advanced Features

### Event Handling

```php
// In your widget class
protected function getListeners(): array
{
    return [
        'eventClick' => 'onEventClick',
        'eventDrop' => 'onEventDrop',
        'eventResize' => 'onEventResize',
        'select' => 'onDateSelect',
    ];
}

public function onEventClick($event): void
{
    $this->dispatchBrowserEvent('open-modal', ['id' => 'edit-event']);
    $this->event = $event;
}
```

### Recurring Events

```php
public function fetchEvents(array $fetchInfo): array
{
    return [
        [
            'id' => 'event1',
            'title' => 'Recurring Event',
            'start' => now()->toIso8601String(),
            'rrule' => [
                'freq' => 'weekly',
                'interval' => 2,
                'byweekday' => ['mo', 'we'],
                'dtstart' => now()->toIso8601String(),
                'until' => now()->addMonths(3)->toIso8601String(),
            ],
        ],
    ];
}
```

## Customization

### Available Views
- timeGridWeek
- timeGridDay
- dayGridMonth
- listWeek
- listMonth

Change the default view in your widget:

```php
protected function getViewData(): array
{
    return [
        'headerToolbar' => [
            'left' => 'prev,next today',
            'center' => 'title',
            'right' => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
        ],
        'initialView' => 'timeGridWeek',
        'slotMinTime' => '08:00:00',
        'slotMaxTime' => '20:00:00',
        'allDaySlot' => false,
    ];
}
```

## Best Practices

1. **Performance Optimization**
   - Use server-side pagination for large datasets
   - Implement caching for calendar events
   - Use eager loading for related models

2. **Error Handling**
   - Implement proper error boundaries
   - Validate all user inputs
   - Handle timezone conversions properly

3. **Accessibility**
   - Ensure proper ARIA labels
   - Support keyboard navigation
   - Test with screen readers

## Troubleshooting

### Common Issues

1. **Events not showing**
   - Check browser console for JavaScript errors
   - Verify the fetchEvents method is returning the correct format
   - Ensure the FullCalendar CSS and JS are properly loaded

2. **Time zone issues**
   - Set the timezone in your config/app.php
   - Ensure all dates are in UTC when storing in the database

## Resources

- [FullCalendar Documentation](https://fullcalendar.io/docs)
- [Saade Filament FullCalendar](https://filamentphp.com/plugins/saade-fullcalendar)
- [Filament Widgets](https://filamentphp.com/docs/3.x/panels/widgets)
