# Affected Files - Appointment Time Fields

This document tracks all files that need to be updated to fix the incorrect usage of `start_time`/`end_time` instead of `starts_at`/`ends_at`.

## Notification System

| File Path | Status | Notes |
|-----------|--------|-------|
| `Modules/Notify/app/Actions/SendAppointmentNotificationAction.php.old` | ⚠️ Needs Update | Uses `start_time`/`end_time` instead of `starts_at`/`ends_at` |

## Email Templates

| File Path | Status | Notes |
|-----------|--------|-------|
| `Modules/Notify/resources/views/emails/appointments/confirmed.blade.php` | ✅ Correct | Uses `starts_at`/`ends_at` |
| `Modules/Notify/resources/views/emails/appointments/reminder.blade.php` | ✅ Correct | Uses `starts_at`/`ends_at` |
| `Modules/Notify/resources/views/emails/appointments/rescheduled.blade.php` | ✅ Correct | Uses `starts_at`/`ends_at` |
| `Modules/Notify/resources/views/emails/appointments/generic.blade.php` | ✅ Correct | Uses `starts_at`/`ends_at` |
| `Modules/Notify/resources/views/emails/appointments/cancelled.blade.php` | ✅ Correct | Uses `starts_at`/`ends_at` |

## Database Migrations

| File Path | Status | Notes |
|-----------|--------|-------|
| `Modules/SaluteOra/database/migrations/2025_05_16_222901_create_appointments_table.php` | ✅ Correct | Uses `starts_at`/`ends_at` |

## Other Files

| File Path | Status | Notes |
|-----------|--------|-------|
| `Modules/SaluteOra/app/Models/Appointment.php` | ✅ Correct | Uses `starts_at`/`ends_at` |
| `Modules/SaluteOra/app/Filament/Resources/AppointmentResource.php` | ✅ Correct | Uses `starts_at`/`ends_at` |
| `Modules/SaluteOra/app/Filament/Widgets/DoctorCalendarWidget.php` | ✅ Correct | Uses `starts_at`/`ends_at` |
| `Modules/SaluteOra/app/Filament/Widgets/PatientCalendarWidget.php` | ✅ Correct | Uses `starts_at`/`ends_at` |
| `Modules/SaluteOra/app/Filament/Widgets/AdminCalendarWidget.php` | ✅ Correct | Uses `starts_at`/`ends_at` |
| `Modules/SaluteOra/app/Actions/Calendar/FetchCalendarEventsAction.php` | ✅ Correct | Uses `starts_at`/`ends_at` |

## Legend
- ✅ Correct: File uses the correct field names
- ⚠️ Needs Update: File needs to be updated to use correct field names
- ❌ Not Checked: File has not been checked yet
