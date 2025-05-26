# Multi-Tenant Calendar Implementation

## Overview

This document outlines the implementation of three distinct FullCalendar widgets for the SaluteOra application, each tailored to different user roles (Patient, Doctor, Admin) with proper tenancy support using Filament's tenancy system.

## Architecture

### User Roles & Permissions

1. **Admin**
   - Can view all appointments across all clinics
   - Can manage all resources
   - Access to global analytics

2. **Doctor**
   - Can view/manage appointments for their current clinic (tenancy)
   - Limited to their own schedule and patients
   - Can update appointment statuses

3. **Patient**
   - Can only view their own appointments
   - Can request/cancel appointments
   - Limited to their personal schedule

## Database Structure

### Required Tables

```php
// clinics table
Schema::create('clinics', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('address');
    $table->string('phone');
    $table->string('email');
    $table->timestamps();
});

// clinic_user pivot table for many-to-many relationship
Schema::create('clinic_user', function (Blueprint $table) {
    $table->id();
    $table->foreignId('clinic_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->json('working_hours')->nullable();
    $table->timestamps();
});

// appointments table
Schema::create('appointments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('clinic_id')->constrained()->cascadeOnDelete();
    $table->foreignId('doctor_id')->constrained('users');
    $table->foreignId('patient_id')->constrained('users');
    $table->dateTime('start_time');
    $dateTime->dateTime('end_time');
    $table->string('status'); // scheduled, confirmed, completed, cancelled, no_show
    $table->text('notes')->nullable();
    $table->string('type'); // checkup, consultation, follow_up, etc.
    $table->timestamps();
});
```

## Implementation

### 1. Configure Tenancy

In your `config/filament.php`:

```php
'tenant' => [
    'model' => \App\Models\Clinic::class,
    'slugger' => 'slug',
    'route_slugger' => 'slug',
    'ownership_relationship' => 'clinic',
],
```

### 2. Base Calendar Widget

Create a base calendar widget that will be extended by specific role-based widgets:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Filament\Forms;
use Filament\Forms\Form;

abstract class BaseCalendarWidget extends FullCalendarWidget
{
    protected static ?string $model = null;
    protected static ?string $heading = 'Calendar';
    protected static ?string $maxWidth = 'full';
    protected static ?int $sort = 1;
    protected static bool $isLazy = false;

    // Common configuration
    protected function getViewData(): array
    {
        return [
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
            ],
            'initialView' => 'timeGridWeek',
            'slotMinTime' => '07:00:00',
            'slotMaxTime' => '21:00:00',
            'slotDuration' => '00:15:00',
            'slotLabelInterval' => '01:00',
            'allDaySlot' => false,
            'nowIndicator' => true,
            'editable' => $this->canEdit(),
            'selectable' => $this->canCreate(),
            'selectMirror' => true,
            'dayMaxEvents' => true,
            'locale' => app()->getLocale(),
            'timeZone' => config('app.timezone'),
            'firstDay' => 1, // Monday
            'hiddenDays' => [],
            'businessHours' => $this->getBusinessHours(),
        ];
    }

    // Override in child classes
    abstract protected function canEdit(): bool;
    abstract protected function canCreate(): bool;
    abstract protected function getBusinessHours(): array;
}
```

### 3. Admin Calendar Widget

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets\Admin;

use Modules\SaluteOra\Filament\Widgets\BaseCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Filament\Forms;

class AdminCalendarWidget extends BaseCalendarWidget
{
    protected static ?string $model = Appointment::class;
    protected static string $heading = 'Admin Calendar';

    public function fetchEvents(array $fetchInfo): array
    {
        return Appointment::query()
            ->with(['patient', 'doctor', 'clinic'])
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'title' => $this->formatEventTitle($appointment),
                    'start' => $appointment->start_time,
                    'end' => $appointment->end_time,
                    'backgroundColor' => $this->getStatusColor($appointment->status),
                    'borderColor' => $this->getStatusColor($appointment->status),
                    'extendedProps' => [
                        'clinic' => $appointment->clinic->name,
                        'doctor' => $appointment->doctor->name,
                        'patient' => $appointment->patient->name,
                        'status' => $appointment->status,
                        'type' => $appointment->type,
                        'notes' => $appointment->notes,
                    ],
                ];
            })
            ->toArray();
    }

    protected function canEdit(): bool
    {
        return true; // Admin can edit everything
    }

    protected function canCreate(): bool
    {
        return true; // Admin can create appointments
    }

    protected function getBusinessHours(): array
    {
        return [
            'daysOfWeek' => [1, 2, 3, 4, 5], // Monday to Friday
            'startTime' => '08:00',
            'endTime' => '20:00',
        ];
    }

}
```

### 4. Doctor Calendar Widget

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets\Doctor;

use Modules\SaluteOra\Filament\Widgets\BaseCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DoctorCalendarWidget extends BaseCalendarWidget
{
    protected static ?string $model = Appointment::class;
    protected static string $heading = 'My Schedule';

    public function fetchEvents(array $fetchInfo): array
    {
        return Appointment::query()
            ->where('clinic_id', app('currentTenant')->id)
            ->where('doctor_id', Auth::id())
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
            ->with(['patient', 'clinic'])
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'title' => $appointment->patient->full_name . ' - ' . $appointment->type,
                    'start' => $appointment->start_time,
                    'end' => $appointment->end_time,
                    'backgroundColor' => $this->getStatusColor($appointment->status),
                    'borderColor' => $this->getStatusColor($appointment->status),
                    'extendedProps' => [
                        'patient' => $appointment->patient->name,
                        'status' => $appointment->status,
                        'type' => $appointment->type,
                        'notes' => $appointment->notes,
                    ],
                ];
            })
            ->toArray();
    }

    protected function canEdit(): bool
    {
        return true; // Doctors can edit their own appointments
    }

    protected function canCreate(): bool
    {
        return true; // Doctors can create appointments
    }

    protected function getBusinessHours(): array
    {
        // Get doctor's working hours for the current clinic
        $workingHours = Auth::user()
            ->clinics()
            ->where('clinic_id', app('currentTenant')->id)
            ->first()
            ->pivot
            ->working_hours;

        return $workingHours ?? [
            'daysOfWeek' => [1, 2, 3, 4, 5],
            'startTime' => '09:00',
            'endTime' => '18:00',
        ];
    }
}
```

### 5. Patient Calendar Widget

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets\Patient;

use Modules\SaluteOra\Filament\Widgets\BaseCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class PatientCalendarWidget extends BaseCalendarWidget
{
    protected static ?string $model = Appointment::class;
    protected static string $heading = 'My Appointments';

    public function fetchEvents(array $fetchInfo): array
    {
        return Auth::user()
            ->patientAppointments()
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
            ->with(['doctor', 'clinic'])
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'title' => 'Dr. ' . $appointment->doctor->last_name . ' - ' . $appointment->type,
                    'start' => $appointment->start_time,
                    'end' => $appointment->end_time,
                    'backgroundColor' => $this->getStatusColor($appointment->status),
                    'borderColor' => $this->getStatusColor($appointment->status),
                    'extendedProps' => [
                        'clinic' => $appointment->clinic->name,
                        'doctor' => 'Dr. ' . $appointment->doctor->full_name,
                        'status' => $appointment->status,
                        'type' => $appointment->type,
                    ],
                ];
            })
            ->toArray();
    }

    protected function canEdit(): bool
    {
        return false; // Patients can't directly edit appointments
    }

    protected function canCreate(): bool
    {
        return true; // Patients can request new appointments
    }

    protected function getBusinessHours(): array
    {
        // Return standard business hours for patient view
        return [
            'daysOfWeek' => [1, 2, 3, 4, 5],
            'startTime' => '08:00',
            'endTime' => '20:00',
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            // Simplified form for patients to request appointments
            Forms\Components\Select::make('clinic_id')
                ->label('Clinic')
                ->options(\App\Models\Clinic::pluck('name', 'id'))
                ->required(),
                
            Forms\Components\Select::make('doctor_id')
                ->label('Doctor')
                ->options(function (callable $get) {
                    if (!$get('clinic_id')) {
                        return [];
                    }
                    return \App\Models\User::whereHas('clinics', function ($query) use ($get) {
                        $query->where('clinic_id', $get('clinic_id'));
                    })->pluck('name', 'id');
                })
                ->required(),
                
            Forms\Components\Select::make('type')
                ->options([
                    'checkup' => 'Routine Checkup',
                    'consultation' => 'Consultation',
                    'follow_up' => 'Follow-up',
                    'emergency' => 'Emergency',
                ])
                ->required(),
                
            Forms\Components\DateTimePicker::make('start_time')
                ->required()
                ->minDate(now())
                ->minutesStep(15)
                ->displayFormat('l, M j, Y H:i'),
                
            Forms\Components\Textarea::make('notes')
                ->label('Additional Notes')
                ->maxLength(500),
        ];
    }
}
```

## Dashboard Configuration

In your panel provider, register the appropriate widget based on user role:

```php
protected function getWidgets(): array
{
    $user = auth()->user();
    
    return [
        // Common widgets
        Widgets\AccountWidget::class,
        
        // Role-specific widgets
        ...match(true) {
            $user->hasRole('admin') => [
                Widgets\Admin\AdminCalendarWidget::class,
                Widgets\Admin\AppointmentStatsWidget::class,
            ],
            $user->hasRole('doctor') => [
                Widgets\Doctor\DoctorCalendarWidget::class,
                Widgets\Doctor\TodayAppointmentsWidget::class,
            ],
            $user->hasRole('patient') => [
                Widgets\Patient\PatientCalendarWidget::class,
                Widgets\Patient\UpcomingAppointmentsWidget::class,
            ],
            default => [],
        },
    ];
}
```

## Tenancy Middleware

Create a middleware to handle tenancy:

```php
<?php

namespace Modules\SaluteOra\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetClinicTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($clinicId = $request->route('clinic')) {
            $clinic = \App\Models\Clinic::findOrFail($clinicId);
            Filament::setTenant($clinic);
        }
        
        return $next($request);
    }
}
```

## Testing

### Feature Test Example

```php
<?php

namespace Tests\Feature\Calendar;

use App\Models\User;
use App\Models\Clinic;
use Modules\SaluteOra\Models\Appointment;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    public function test_admin_can_view_all_appointments()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $clinic = Clinic::factory()->create();
        $doctor = User::factory()->create()->assignRole('doctor');
        $patient = User::factory()->create()->assignRole('patient');
        
        $appointment = Appointment::factory()->create([
            'clinic_id' => $clinic->id,
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'start_time' => now()->addDay(),
            'end_time' => now()->addDay()->addHour(),
        ]);
        
        $this->actingAs($admin)
            ->get(route('filament.admin.resources.appointments.index'))
            ->assertStatus(200)
            ->assertSee($appointment->patient->name);
    }
    
    public function test_doctor_can_only_view_own_clinic_appointments()
    {
        $clinic1 = Clinic::factory()->create();
        $clinic2 = Clinic::factory()->create();
        
        $doctor = User::factory()->create()->assignRole('doctor');
        $doctor->clinics()->attach($clinic1->id);
        
        $patient = User::factory()->create()->assignRole('patient');
        
        // Appointment in doctor's clinic
        $appointment1 = Appointment::factory()->create([
            'clinic_id' => $clinic1->id,
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
        ]);
        
        // Appointment in different clinic
        $appointment2 = Appointment::factory()->create([
            'clinic_id' => $clinic2->id,
            'patient_id' => $patient->id,
        ]);
        
        $this->actingAs($doctor)
            ->get(route('filament.app.resources.appointments.index'))
            ->assertStatus(200)
            ->assertSee($appointment1->patient->name)
            ->assertDontSee($appointment2->patient->name);
    }
}
```

## Security Considerations

1. **Authorization**: Always check user permissions in both the widget and related actions
2. **Data Scoping**: Use tenancy middleware to ensure users can only access data from their clinic
3. **Validation**: Validate all user inputs, especially for appointment creation/updates
4. **Rate Limiting**: Implement rate limiting for API endpoints to prevent abuse
5. **Audit Logging**: Log all sensitive actions for security and compliance

## Performance Optimization

1. **Eager Loading**: Always eager load relationships to prevent N+1 queries
2. **Caching**: Cache frequently accessed data like doctor availability
3. **Pagination**: For large datasets, implement server-side pagination
4. **Lazy Loading**: Use lazy loading for calendar resources that aren't immediately needed
5. **Query Optimization**: Add appropriate database indexes for frequently queried columns

## Future Enhancements

1. **Recurring Appointments**: Support for recurring appointment patterns
2. **Waitlist**: Feature to manage waitlists for fully booked time slots
3. **Telehealth Integration**: Add video consultation capabilities
4. **Mobile App**: Native mobile app with push notifications
5. **Analytics Dashboard**: Advanced analytics for clinic performance
