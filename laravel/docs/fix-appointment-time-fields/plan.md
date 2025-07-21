# Plan for Fixing Appointment Time Fields

## Overview

This document tracks the progress of fixing the incorrect usage of `start_time`/`end_time` instead of `starts_at`/`ends_at` in the Appointment model.

## Affected Files

### 1. Notification System

- [ ] `Modules/Notify/app/Actions/SendAppointmentNotificationAction.php.old`
  - Status: Needs update
  - Changes required: Update `start_time` to `starts_at` and `end_time` to `ends_at`

### 2. Email Templates

- [ ] `Modules/Notify/resources/views/emails/appointments/confirmed.blade.php`
- [ ] `Modules/Notify/resources/views/emails/appointments/reminder.blade.php`
- [ ] `Modules/Notify/resources/views/emails/appointments/rescheduled.blade.php`
- [ ] `Modules/Notify/resources/views/emails/appointments/generic.blade.php`
- [ ] `Modules/Notify/resources/views/emails/appointments/cancelled.blade.php`

### 3. Database Migrations

- [ ] Verify all migrations use `starts_at` and `ends_at`

## Implementation Steps

### 1. Phase 1: Notification System

- [ ] Update `SendAppointmentNotificationAction` to use correct field names
- [ ] Test notification sending functionality

### 2. Phase 2: Email Templates

- [ ] Update all email templates to use correct field names
- [ ] Test email rendering with sample data

### 3. Phase 3: Database and Migrations

- [ ] Verify all migrations use correct field names
- [ ] Create new migration if any corrections are needed

### 4. Phase 4: Testing

- [ ] Unit tests for all modified components
- [ ] Integration tests for appointment workflows
- [ ] Manual testing of appointment creation, update, and notifications

## Verification

- [ ] All tests pass
- [ ] Manual testing confirms correct behavior
- [ ] No regressions in existing functionality

## Notes

- Always use the enum values when working with appointment statuses and types
- Ensure all datetime fields are properly cast in the Appointment model
- Update any related documentation as needed