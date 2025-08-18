# Doctor Calendar Widget

## Overview

The `DoctorCalendarWidget` provides doctors with a tailored view of their appointments across different clinics. It extends the `BaseCalendarWidget` and includes doctor-specific functionality.

## Features

- View appointments for the current clinic (tenant)
- Switch between different clinics
- View patient details and medical history
- Update appointment status
- Drag-and-drop rescheduling within allowed timeframes

## Implementation

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets\Doctor;

use Filament\Support\Facades\Filament;
use Modules\SaluteOra\Filament\Widgets\BaseCalendarWidget;
use Modules\SaluteOra\Models\Appointment;

class DoctorCalendarWidget extends BaseCalendarWidget
{
    protected static ?string $model = Appointment::class;
    protected static string $heading = 'My Schedule';
    
    protected function getEventsQuery()
    {
        $doctor = Filament::auth()->user()->doctor;
        
        return parent::getEventsQuery()
            ->where('doctor_id', $doctor->id)
            ->where('clinic_id', Filament::getTenant()?->id)
            ->with([
                'patient',
                'clinic',
                'status',
                'medicalRecords'
            ]);
    }
    
    protected function mapToEvent($appointment): array
    {
        return [
            'id' => $appointment->id,
            'title' => $appointment->patient->name,
            'start' => $appointment->start,
            'end' => $appointment->end,
            'allDay' => $appointment->all_day,
            'backgroundColor' => $appointment->status->color,
            'borderColor' => $appointment->status->color,
            'textColor' => $this->getContrastColor($appointment->status->color),
            'extendedProps' => [
                'patient' => $appointment->patient->name,
                'patient_id' => $appointment->patient_id,
                'clinic' => $appointment->clinic->name,
                'status' => $appointment->status->name,
                'notes' => $appointment->notes,
                'medical_notes' => $appointment->medicalRecords->map->summary->join("\n"),
            ],
            'url' => route('filament.resources.appointments.edit', $appointment),
        ];
    }
    
    protected function getHeaderWidgets(): array
    {
        return [
            \Modules\SaluteOra\Filament\Widgets\ClinicSwitcher::class,
        ];
    }
    
    protected function getViewData(): array
    {
        return [
            'headerWidgets' => $this->getHeaderWidgets(),
        ];
    }
    
    protected function getView(): string
    {
        return 'saluteora::widgets.doctor-calendar';
    }
    
    protected function getCalendarConfig(): array
    {
        return [
            'initialView' => 'timeGridDay',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'timeGridDay,timeGridWeek,dayGridMonth',
            ],
            'slotMinTime' => '08:00:00',
            'slotMaxTime' => '20:00:00',
            'editable' => true,
            'selectable' => true,
            'selectMirror' => true,
            'dayMaxEvents' => true,
            'eventTimeFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'hour12' => false,
            ],
        ];
    }
}
```

## Tenant Awareness

The widget automatically filters appointments based on the current clinic (tenant) using Filament's tenancy system. The clinic is determined by the current URL or the user's default clinic.

## Usage

### Registration

Register the widget in your panel provider:

```php
use Modules\SaluteOra\Filament\Widgets\Doctor\DoctorCalendarWidget;

public function getWidgets(): array
{
    return [
        // ...
        DoctorCalendarWidget::class,
    ];
}
```

### Clinic Switcher

Include a clinic switcher in your panel provider:

```php
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\IdentifyTenant;

public function getPanel(
    \Filament\Panel $panel
): \Filament\Panel {
    return $panel
        // ...
        ->tenantMiddleware([
            IdentifyTenant::class,
            // other tenant middleware...
        ], isPersistent: true);
}
```

## Customization

### Event Display

Customize how events are displayed by overriding the `mapToEvent` method:

```php
protected function mapToEvent($appointment): array
{
    $event = parent::mapToEvent($appointment);
    
    // Add custom fields or modify existing ones
    $event['title'] = "{$appointment->patient->name} - {$appointment->service->name}";
    
    return $event;
}
```

### Available Actions

Add custom actions to the calendar header by overriding the `getHeaderWidgets` method:

```php
protected function getHeaderWidgets(): array
{
    return [
        \Modules\SaluteOra\Filament\Widgets\ClinicSwitcher::class,
        \Modules\SaluteOra\Filament\Widgets\QuickAddAppointment::class,
    ];
}
```

## Security

- Appointments are scoped to the current doctor and clinic
- User permissions are checked before any actions
- Sensitive patient data is protected

## Related Documentation

- [Base Calendar Widget](../architecture.md)
- [Admin Calendar Widget](./admin-calendar-widget.md)
- [Patient Calendar Widget](./patient-calendar-widget.md)
- [Filament Tenancy](https://filamentphp.com/docs/3.x/panels/tenancy)

## [AGGIORNAMENTO 2024-06-XX] - Disponibilità solo su appointments

**Regola fondamentale:**
- Le disponibilità dei dottori vanno gestite solo tramite la tabella `appointments` (con `patient_id` null o flag dedicato).
- È vietato creare tabelle o modelli separati (es. doctor_availabilities) per le disponibilità.
- Tutto il calendario (FullCalendar/Filament) lavora su appointments, distinguendo tra disponibilità e appuntamenti tramite i campi esistenti.

**Motivazione:**
- Filosofia: un solo punto di verità, nessuna duplicazione, serenità del codice.
- Logica: DRY, KISS, nessun lock-in, massima compatibilità con FullCalendar e Filament.
- Religione: non avrai altro modello di disponibilità all'infuori di Appointment.
- Politica: ogni modulo è autonomo, ma rispetta la centralizzazione delle entità.
- Zen: serenità, nessun errore di sync, nessuna tabella fantasma, nessun refactor doloroso.

**Checklist aggiornata:**
- Gestire sempre le disponibilità tramite appointments
- Vietato creare/gestire tabelle o modelli separati per le disponibilità
- Aggiornare la documentazione ogni volta che si modifica la logica di disponibilità/appuntamenti
- Seguire sempre la filosofia DRY, KISS, centralizzazione

**Collegamenti:**
- [../../appointment-management.md](../../appointment-management.md)
- [../../fullcalendar_parental_widgets.md](../../fullcalendar_parental_widgets.md)
- [../doctor-availability-management.md](../doctor-availability-management.md)
