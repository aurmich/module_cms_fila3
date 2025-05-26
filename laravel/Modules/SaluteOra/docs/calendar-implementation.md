# Calendar Implementation Guide

## Overview

This document provides a comprehensive guide to the multi-tenant calendar implementation in the SaluteOra module, covering the architecture, components, and usage patterns for the FullCalendar integration.

## Table of Contents

- [Architecture](#architecture)
- [Components](#components)
- [Usage](#usage)
- [Testing](#testing)
- [Best Practices](#best-practices)

## Architecture

### Base Calendar Widget

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

abstract class BaseCalendarWidget extends FullCalendarWidget
{
    protected static ?string $model = null;
    protected static string $heading = 'Calendar';
    
    protected function getEventsQuery()
    {
        return static::$model::query();
    }
    
    public function fetchEvents(array $fetchInfo): array
    {
        return $this->getEventsQuery()
            ->where('start', '>=', $fetchInfo['start'])
            ->where('end', '<=', $fetchInfo['end'])
            ->get()
            ->map(fn ($event) => $this->mapToEvent($event))
            ->toArray();
    }
    
    abstract protected function mapToEvent($model): array;
}
```

## Components

### Admin Calendar Widget

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets\Admin;

use Modules\SaluteOra\Filament\Widgets\BaseCalendarWidget;
use Modules\SaluteOra\Models\Appointment;

class AdminCalendarWidget extends BaseCalendarWidget
{
    protected static ?string $model = Appointment::class;
    protected static string $heading = 'Admin Calendar';
    
    protected function mapToEvent($appointment): array
    {
        return [
            'id' => $appointment->id,
            'title' => $appointment->title,
            'start' => $appointment->start,
            'end' => $appointment->end,
            'allDay' => $appointment->all_day,
            'backgroundColor' => $appointment->color,
            'extendedProps' => [
                'description' => $appointment->description,
                'patient' => $appointment->patient->name,
                'doctor' => $appointment->doctor->name,
                'clinic' => $appointment->clinic->name,
            ],
        ];
    }
}
```

## Testing

### Feature Tests

```php
<?php

namespace Tests\Feature\Calendar;

use App\Models\User;
use App\Models\Clinic;
use Modules\SaluteOra\Models\Appointment;
use Tests\TestCase;

class CalendarAccessTest extends TestCase
{
    public function test_admin_can_view_all_appointments()
    {
        $admin = User::factory()->admin()->create();
        $clinic = Clinic::factory()->create();
        
        $appointment = Appointment::factory()
            ->for($clinic)
            ->create();
            
        $this->actingAs($admin)
            ->get(route('filament.resources.appointments.index'))
            ->assertOk()
            ->assertSee($appointment->title);
    }
}
```

## Best Practices

1. **Role-Based Access**
   - Always check user roles before displaying sensitive information
   - Use policy methods to authorize calendar actions
   - Cache expensive calendar queries where appropriate

2. **Performance**
   - Eager load relationships to prevent N+1 queries
   - Implement pagination for large datasets
   - Use database indexes for frequently queried fields

3. **UI/UX**
   - Provide clear loading states
   - Implement proper error handling
   - Ensure mobile responsiveness

4. **Security**
   - Validate all user inputs
   - Sanitize output to prevent XSS
   - Implement rate limiting for API endpoints

## Related Documentation

- [Filament Documentation](https://filamentphp.com/docs)
- [FullCalendar Documentation](https://fullcalendar.io/docs)
- [Laravel Tenancy](https://tenancyforlaravel.com/)

## Changelog

- 2023-10-15: Initial implementation
- 2023-10-16: Added multi-tenant support
- 2023-10-17: Improved performance with eager loading
