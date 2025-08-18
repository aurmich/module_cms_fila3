# Calendar Architecture

## Overview

The calendar system is built on top of Filament and FullCalendar, with multi-tenancy support through Filament's tenancy system. It provides three distinct calendar views for different user types: Admin, Doctor, and Patient.

## Core Components

### 1. Base Calendar Widget

Located at `Modules/SaluteOra/Filament/Widgets/BaseCalendarWidget.php`:

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

### 2. User Types

We use the `tighten/parental` package to handle different user types:

- `User` (base model)
  - `Admin` (extends User)
  - `Doctor` (extends User)
  - `Patient` (extends User)

### 3. Tenancy

We use Filament's built-in tenancy to manage which clinic's data is visible. Each `Doctor` can be associated with multiple clinics through the `clinic_user` pivot table.

## Data Flow

1. **Authentication**: User logs in and their type is determined
2. **Tenant Resolution**: For doctors, the current clinic is determined
3. **Widget Loading**: The appropriate calendar widget is loaded based on user type
4. **Data Fetching**: Widget fetches events based on user type and tenant
5. **Rendering**: FullCalendar renders the events in the UI

## Security Considerations

- Role-based access control for all calendar operations
- Tenant scoping for all database queries
- Input validation for all user-provided data
- CSRF protection for all form submissions
