# Issue: Incorrect Time Field Usage in Appointment Model

## Problem Description

In the codebase, there are several instances where `start_time` and `end_time` are used instead of the correct field names `starts_at` and `ends_at` in the Appointment model. This inconsistency can lead to bugs and unexpected behavior in the application.

## Affected Areas

1. **Notification System**: The `SendAppointmentNotificationAction` class is using incorrect field names when recording notifications.
2. **Email Templates**: Some email templates might be using the wrong field names for displaying appointment times.
3. **Database Queries**: There might be queries that use the incorrect field names for filtering or sorting appointments.

## Root Cause

The issue likely originated from a schema change where the field names were updated from `start_time`/`end_time` to `starts_at`/`ends_at`, but not all references were updated accordingly.

## Impact

- Inaccurate appointment time display in notifications and emails
- Potential database query issues when filtering or sorting by appointment times
- Inconsistent behavior across different parts of the application

## Solution

1. Update all references to `start_time` to use `starts_at`
2. Update all references to `end_time` to use `ends_at`
3. Update any related documentation and tests
4. Verify that all database queries use the correct field names

## Verification

After making the changes, verify that:

- Appointment creation and updates work correctly
- Appointment times are displayed correctly in all views and emails
- All reports and statistics that use appointment times are accurate
- No regression in existing functionality