# Appointment Field Naming Issues

## Overview

The Appointment model in SaluteOra defines both legacy field names (`start_time`, `end_time`) and canonical field names (`starts_at`, `ends_at`). This document tracks instances where the legacy field names are used instead of the canonical ones.

## Model Definition Issues

### Appointment Model

**File Path**: `/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/app/Models/Appointment.php`

**Issues**:
- PHPDoc comments mention legacy fields (lines 32-33)
- Legacy fields included in $fillable array (lines 119-120)
- Legacy fields cast in casts() method (lines 143-144)
- Legacy fields used in method implementations like getDurationAttribute() (line 246)
- Legacy fields used in scope methods like scopeInDateRange() (line 299)

**Correction Needed**: 
- Update PHPDoc to emphasize `starts_at` and `ends_at` as the preferred fields
- Consider deprecation annotations for legacy fields
- Refactor methods to use canonical field names with backward compatibility

## Resource Issues

### AppointmentResource.php

**File Path**: `/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/app/Filament/Resources/AppointmentResource.php`

**Issues**:
- Form schema uses `start_time` and `end_time` instead of `starts_at` and `ends_at` (lines 48-52)

**Correction Needed**:
- Update form schema to use canonical field names
- Ensure validation rules reference canonical field names

### ListAppointments.php

**File Path**: `/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/app/Filament/Resources/AppointmentResource/Pages/ListAppointments.php`

**Issues**:
- Table columns reference `start_time` and `end_time` (lines 41-45)

**Correction Needed**:
- Update column definitions to use canonical field names

## Widget Issues

### AdminCalendarWidget.php

**File Path**: `/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/app/Filament/Widgets/AdminCalendarWidget.php`

**Issues**:
- Uses legacy field names in transformToEventData() (lines 217-218)
- Uses legacy field names in fetchEvents() (line 243)
- Uses legacy field names in form schema (lines 315-317)
- Uses legacy field names in event handlers (lines 428-429, 462)
- Uses legacy field names in stats calculations (lines 485-488)

**Correction Needed**:
- Update all references to use canonical field names

### PatientCalendarWidget.php

**File Path**: `/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/app/Filament/Widgets/PatientCalendarWidget.php`

**Issues**:
- Uses legacy field names in fetchEvents() (line 140)
- Uses legacy field names in transformToEventData() (lines 178-179)

**Correction Needed**:
- Update all references to use canonical field names

### StudioOverviewWidget.php

**File Path**: `/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/app/Filament/Widgets/StudioOverviewWidget.php`

**Issues**:
- Uses legacy field names in getViewData() (lines 38-39)

**Correction Needed**:
- Update all references to use canonical field names

## Action Issues

### FetchCalendarEventsAction.php

**File Path**: `/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/app/Actions/Calendar/FetchCalendarEventsAction.php`

**Issues**:
- Uses legacy field names in execute() (line 34)
- Uses legacy field names in transformAppointment() (lines 85-86)
- Uses legacy field names in isEditable() (line 193)

**Correction Needed**:
- Update all references to use canonical field names

## State Transition Issues

### BaseTransition.php

**File Path**: `/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/app/States/Appointment/Transitions/BaseTransition.php`

**Issues**:
- Uses legacy field name in getNotificationData() (line 59)

**Correction Needed**:
- Update to use canonical field name

## Documentation Issues

### calendar-widgets.md

**File Path**: `/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/calendar-widgets.md`

**Issues**:
- Code examples use legacy field names (lines 50, 56-57, 109)

**Correction Needed**:
- Update documentation to use canonical field names

## Translation Issues

Various translation files reference legacy field names:
- `/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/lang/de/doctor_availability.php`
- `/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/lang/de/doctor_availability_calendar.php`

**Correction Needed**:
- Update translation keys to use canonical field names

## Implementation Strategy

The Appointment model currently supports both legacy and canonical field names. A strategic approach to migration is needed:

1. **Short-term**: Implement getters/setters in the model to ensure both field naming conventions work
2. **Mid-term**: Update all code to use canonical field names with backward compatibility
3. **Long-term**: Deprecate legacy field names and eventually remove them

## Recommended Approach

Add accessor/mutator methods to the Appointment model to maintain backward compatibility:

```php
/**
 * Get the appointment start time (legacy).
 *
 * @return \Illuminate\Support\Carbon|null
 * @deprecated Use starts_at instead
 */
public function getStartTimeAttribute()
{
    return $this->starts_at;
}

/**
 * Set the appointment start time (legacy).
 *
 * @param \Illuminate\Support\Carbon|string|null $value
 * @return void
 * @deprecated Use starts_at instead
 */
public function setStartTimeAttribute($value)
{
    $this->attributes['starts_at'] = $value;
}

/**
 * Get the appointment end time (legacy).
 *
 * @return \Illuminate\Support\Carbon|null
 * @deprecated Use ends_at instead
 */
public function getEndTimeAttribute()
{
    return $this->ends_at;
}

/**
 * Set the appointment end time (legacy).
 *
 * @param \Illuminate\Support\Carbon|string|null $value
 * @return void
 * @deprecated Use ends_at instead
 */
public function setEndTimeAttribute($value)
{
    $this->attributes['ends_at'] = $value;
}
```

This approach will maintain backward compatibility while allowing gradual migration to the canonical field names.
