# Calendar Widgets Implementation Guide

## Overview
This document provides guidelines for implementing calendar widgets in the SaluteOra module using Filament and FullCalendar.

## Widget Types

### 1. Doctor's Schedule Widget

#### Implementation

```php
namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\App\Enums\AppointmentType;

class DoctorScheduleWidget extends \Saade\FilamentFullCalendar\Widgets\FullCalendarWidget
{
    protected static string $view = 'saluteora::widgets.doctor-schedule';
    
    protected static ?string $heading = 'My Schedule';
    
    protected function getViewData(): array
    {
        return [
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'timeGridWeek,timeGridDay,listWeek',
            ],
            'initialView' => 'timeGridWeek',
            'slotMinTime' => '08:00:00',
            'slotMaxTime' => '20:00:00',
            'slotDuration' => '00:15:00',
            'slotLabelInterval' => '01:00',
            'allDaySlot' => false,
            'nowIndicator' => true,
            'editable' => true,
            'selectable' => true,
            'selectMirror' => true,
            'dayMaxEvents' => true,
        ];
    }
    
    public function fetchEvents(array $fetchInfo): array
    {
        return auth()->user()->doctorAppointments()
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'title' => $appointment->patient->name,
                    'start' => $appointment->start_time,
                    'end' => $appointment->end_time,
                    'backgroundColor' => $this->getAppointmentColor($appointment->status),
                    'borderColor' => $this->getAppointmentColor($appointment->status),
                    'extendedProps' => [
                        'type' => $appointment->type,
                        'status' => $appointment->status,
                        'patient' => $appointment->patient->name,
                        'notes' => $appointment->notes,
                    ],
                ];
            })
            ->toArray();
    }
}
```

### 2. Patient Appointments Widget

#### Implementation

```php
namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\App\Enums\AppointmentType;

class PatientAppointmentsWidget extends \Saade\FilamentFullCalendar\Widgets\FullCalendarWidget
{
    protected static string $view = 'saluteora::widgets.patient-appointments';
    
    protected static ?string $heading = 'My Appointments';
    
    protected function getViewData(): array
    {
        return [
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
            'initialView' => 'timeGridWeek',
            'slotMinTime' => '08:00:00',
            'slotMaxTime' => '20:00:00',
            'allDaySlot' => false,
        ];
    }
    
    public function fetchEvents(array $fetchInfo): array
    {
        return auth()->user()->patientAppointments()
            ->with('doctor')
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
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
                        'doctor' => $appointment->doctor->name,
                        'type' => $appointment->type,
                        'status' => $appointment->status,
                        'notes' => $appointment->notes,
                    ],
                ];
            })
            ->toArray();
    }
}
```

## Custom Calendar Views

### Doctor Schedule View
Create `resources/views/vendor/filament/widgets/doctor-schedule.blade.php`:

```php
<x-filament-widgets::widget>
    <x-filament::card>
        <div 
            x-data="calendar({
                events: $wire.entangle('events').defer,
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay,listWeek'
                },
                slotMinTime: '08:00:00',
                slotMaxTime: '20:00:00',
                slotDuration: '00:15:00',
                slotLabelInterval: '01:00',
                allDaySlot: false,
                nowIndicator: true,
                editable: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                eventDidMount: function(info) {
                    // Add tooltip
                    tippy(info.el, {
                        content: `
                            <div class="p-2 space-y-1">
                                <div class="font-bold">${info.event.title}</div>
                                <div class="text-sm">${info.event.extendedProps.type}</div>
                                <div class="text-sm">${info.event.extendedProps.status}</div>
                                ${info.event.extendedProps.notes ? 
                                    `<div class="mt-1 pt-1 border-t border-gray-200 text-sm">
                                        ${info.event.extendedProps.notes}
                                    </div>` : ''
                                }
                            </div>
                        `,
                        allowHTML: true,
                        theme: 'light',
                        placement: 'top',
                    });
                },
                dateClick: function(info) {
                    window.Livewire.emit('openCreateAppointmentModal', info.dateStr);
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    window.Livewire.emit('openEditAppointmentModal', info.event.id);
                },
                eventDrop: function(info) {
                    window.Livewire.emit('updateAppointmentTime', {
                        id: info.event.id,
                        start: info.event.start,
                        end: info.event.end || info.event.start,
                    });
                },
                eventResize: function(info) {
                    window.Livewire.emit('updateAppointmentTime', {
                        id: info.event.id,
                        start: info.event.start,
                        end: info.event.end,
                    });
                },
            })"
            wire:ignore
            class="fi-wi-stats-overview-stats-container"
        >
            <div id='calendar'></div>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>
```

## Livewire Components

### Create/Edit Appointment Modal

```php
namespace Modules\SaluteOra\Filament\Pages\Appointments;

use Livewire\Component;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\App\Enums\AppointmentType;

class AppointmentModal extends Component
{
    public $showModal = false;
    public $appointmentId;
    public $patientId;
    public $start;
    public $end;
    public $type;
    public $notes;
    public $status = 'scheduled';
    
    protected $listeners = [
        'openCreateAppointmentModal' => 'openCreateModal',
        'openEditAppointmentModal' => 'openEditModal',
    ];
    
    public function openCreateModal($date = null)
    {
        $this->resetForm();
        $this->start = $date ?: now()->format('Y-m-d\TH:i');
        $this->end = $date ? date('Y-m-d\TH:i', strtotime($date . ' +1 hour')) : now()->addHour()->format('Y-m-d\TH:i');
        $this->showModal = true;
    }
    
    public function openEditModal($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        
        $this->appointmentId = $appointment->id;
        $this->patientId = $appointment->patient_id;
        $this->start = $appointment->start_time->format('Y-m-d\TH:i');
        $this->end = $appointment->end_time->format('Y-m-d\TH:i');
        $this->type = $appointment->type;
        $this->notes = $appointment->notes;
        $this->status = $appointment->status;
        
        $this->showModal = true;
    }
    
    public function save()
    {
        $validated = $this->validate([
            'patientId' => 'required|exists:users,id',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'type' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:scheduled,confirmed,completed,cancelled',
        ]);
        
        $data = [
            'patient_id' => $validated['patientId'],
            'start_time' => $validated['start'],
            'end_time' => $validated['end'],
            'type' => $validated['type'],
            'notes' => $validated['notes'],
            'status' => $validated['status'],
            'doctor_id' => auth()->id(),
        ];
        
        if ($this->appointmentId) {
            $appointment = Appointment::findOrFail($this->appointmentId);
            $appointment->update($data);
            $this->dispatch('appointmentUpdated', $appointment->id);
        } else {
            $appointment = Appointment::create($data);
            $this->dispatch('appointmentCreated', $appointment->id);
        }
        
        $this->showModal = false;
        $this->resetForm();
    }
    
    public function delete()
    {
        if ($this->appointmentId) {
            $appointment = Appointment::findOrFail($this->appointmentId);
            $appointment->delete();
            $this->dispatch('appointmentDeleted', $this->appointmentId);
        }
        
        $this->showModal = false;
        $this->resetForm();
    }
    
    public function render()
    {
        $patients = Patient::query()
            ->where('clinic_id', auth()->user()->clinic_id)
            ->orderBy('last_name')
            ->get()
            ->map(fn($patient) => [
                'id' => $patient->id,
                'name' => $patient->full_name,
            ]);
            
        return view('saluteora::livewire.appointment-modal', [
            'patients' => $patients,
            'appointmentTypes' => [
                'checkup' => __('Checkup'),
                'consultation' => __('Consultation'),
                'follow_up' => __('Follow-up'),
                'treatment' => __('Treatment'),
                'emergency' => __('Emergency'),
            ],
        ]);
    }
    
    protected function resetForm()
    {
        $this->reset([
            'appointmentId',
            'patientId',
            'start',
            'end',
            'type',
            'notes',
            'status',
        ]);
    }
}
```

## Styling and Theming

### Custom CSS
Add to `resources/css/filament.css`:

```css
/* Calendar overrides */
.fc {
    --fc-border-color: var(--gray-200);
    --fc-page-bg-color: #fff;
    --fc-today-bg-color: rgba(219, 234, 254, 0.3);
    --fc-now-indicator-color: #ef4444;
}

/* Event colors */
.fc-event {
    @apply border-none rounded-md text-sm p-1;
}

.fc-event.scheduled {
    @apply bg-blue-100 text-blue-800 border-blue-200;
}

.fc-event.confirmed {
    @apply bg-green-100 text-green-800 border-green-200;
}

.fc-event.completed {
    @apply bg-gray-100 text-gray-800 border-gray-200;
}

.fc-event.cancelled {
    @apply bg-red-100 text-red-800 border-red-200;
}

/* Time slots */
.fc-timegrid-slot {
    @apply h-12;
}

/* Header */
.fc-col-header-cell {
    @apply bg-gray-50;
}

.fc-col-header-cell-cushion {
    @apply py-2 text-sm font-medium text-gray-700;
}

/* Buttons */
.fc-button {
    @apply bg-white border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 inline-flex items-center px-3 py-2 border text-sm font-medium rounded-md shadow-sm focus:outline-none;
}

.fc-button-primary:not(:disabled).fc-button-active, 
.fc-button-primary:not(:disabled):active {
    @apply bg-primary-600 border-transparent focus:ring-2 focus:ring-offset-2 focus:ring-primary-500;
}

/* Event dot */
.fc-event-dot {
    @apply rounded-full w-2 h-2 inline-block mr-1;
}
```

## Performance Optimization

### Lazy Loading
```php
// In your Filament provider
public function boot()
{
    FilamentView::registerRenderHook(
        'panels::body.end',
        fn (): string => view('components.calendar-assets')
    );
}
```

Create `resources/views/components/calendar-assets.blade.php`:
```php
@once
    @push('styles')
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
        <link href='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/main.min.css' rel='stylesheet' />
        <link href='https://cdn.jsdelivr.net/npm/tippy.js@6.3.7/themes/light.css' rel='stylesheet' />
        <style>
            [x-cloak] { display: none !important; }
        </style>
    @endpush

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/tippy.js@6.3.7/umd/tippy-bundle.umd.min.js'></script>
        
        <script>
            function calendar(config) {
                return {
                    calendar: null,
                    events: config.events,
                    
                    init() {
                        this.calendar = new FullCalendar.Calendar(this.$refs.calendar, {
                            ...config,
                            initialView: config.initialView || 'dayGridMonth',
                            headerToolbar: config.headerToolbar || {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay',
                            },
                            events: this.events,
                            eventDidMount: (info) => {
                                if (config.eventDidMount) {
                                    config.eventDidMount(info);
                                }
                            },
                            eventClick: (info) => {
                                info.jsEvent.preventDefault();
                                if (config.eventClick) {
                                    config.eventClick(info);
                                }
                            },
                            dateClick: (info) => {
                                if (config.dateClick) {
                                    config.dateClick(info);
                                }
                            },
                            eventDrop: (info) => {
                                if (config.eventDrop) {
                                    config.eventDrop(info);
                                }
                            },
                            eventResize: (info) => {
                                if (config.eventResize) {
                                    config.eventResize(info);
                                }
                            },
                        });
                        
                        this.calendar.render();
                        
                        this.$watch('events', (newEvents) => {
                            this.calendar.removeAllEvents();
                            this.calendar.addEventSource(newEvents);
                        });
                    },
                };
            }
        </script>
    @endpush
@endonce
```

## Testing Calendar Widgets

### Feature Test
```php
namespace Tests\Feature\Filament\Widgets;

use App\Models\User;
use Modules\SaluteOra\Models\Appointment;
use Tests\TestCase;
use Modules\SaluteOra\App\Enums\AppointmentType;

class CalendarWidgetsTest extends TestCase
{
    public function test_doctor_can_view_schedule_widget()
    {
        $doctor = User::factory()->doctor()->create();
        $patient = User::factory()->patient()->create();
        
        $appointment = Appointment::factory()->create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'start_time' => now(),
            'end_time' => now()->addHour(),
        ]);
        
        $this->actingAs($doctor)
            ->get(route('filament.admin.pages.dashboard'))
            ->assertStatus(200)
            ->assertSeeLivewire('doctor-schedule-widget')
            ->assertSee($patient->name);
    }
    
    public function test_patient_can_view_appointments_widget()
    {
        $patient = User::factory()->patient()->create();
        $doctor = User::factory()->doctor()->create();
        
        $appointment = Appointment::factory()->create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'start_time' => now(),
            'end_time' => now()->addHour(),
        ]);
        
        $this->actingAs($patient)
            ->get(route('filament.patient.pages.dashboard'))
            ->assertStatus(200)
            ->assertSeeLivewire('patient-appointments-widget')
            ->assertSee('Dr. ' . $doctor->last_name);
    }
}
```

## Accessibility Considerations

1. **Keyboard Navigation**
   - Ensure all calendar controls are keyboard accessible
   - Add proper ARIA labels to interactive elements
   - Implement focus management for modals

2. **Screen Reader Support**
   - Add proper ARIA roles and labels
   - Provide text alternatives for visual elements
   - Ensure proper heading structure

3. **Color Contrast**
   - Ensure sufficient contrast for text and interactive elements
   - Don't rely solely on color to convey information
   - Test with color blindness simulators

## Internationalization

### Translations
Add to your language files:

```php
// resources/lang/en/calendar.php
return [
    'today' => 'Today',
    'month' => 'Month',
    'week' => 'Week',
    'day' => 'Day',
    'list' => 'List',
    'more' => 'more',
    'no_events' => 'No events to display',
    'create_appointment' => 'Create Appointment',
    'edit_appointment' => 'Edit Appointment',
    'delete_appointment' => 'Delete Appointment',
    'appointment_created' => 'Appointment created successfully',
    'appointment_updated' => 'Appointment updated successfully',
    'appointment_deleted' => 'Appointment deleted successfully',
];

// resources/lang/it/calendar.php
return [
    'today' => 'Oggi',
    'month' => 'Mese',
    'week' => 'Settimana',
    'day' => 'Giorno',
    'list' => 'Lista',
    'more' => 'altro',
    'no_events' => 'Nessun evento da visualizzare',
    'create_appointment' => 'Crea Appuntamento',
    'edit_appointment' => 'Modifica Appuntamento',
    'delete_appointment' => 'Elimina Appuntamento',
    'appointment_created' => 'Appuntamento creato con successo',
    'appointment_updated' => 'Appuntamento aggiornato con successo',
    'appointment_deleted' => 'Appuntamento eliminato con successo',
];
```

### Timezone Handling
```php
// In your AppServiceProvider or dedicated provider
public function boot()
{
    // Set application timezone
    config(['app.timezone' => 'Europe/Rome']);
    date_default_timezone_set('Europe/Rome');
    
    // For FullCalendar
    $this->app->bind(\Saade\FilamentFullCalendar\Actions\CreateAction::class, function ($app) {
        return new \Saade\FilamentFullCalendar\Actions\CreateAction(
            timezone: 'Europe/Rome'
        );
    });
    
    $this->app->bind(\Saade\FilamentFullCalendar\Actions\EditAction::class, function ($app) {
        return new \Saade\FilamentFullCalendar\Actions\EditAction(
            timezone: 'Europe/Rome'
        );
    });
}
```

## Deployment Checklist

1. **Assets**
   - Compile and minify CSS/JS
   - Version assets for cache busting
   - Upload to CDN if applicable

2. **Database**
   - Run migrations
   - Seed initial data if needed
   - Create necessary indexes

3. **Caching**
   - Clear application cache
   - Clear route cache
   - Clear view cache
   - Clear config cache

4. **Monitoring**
   - Set up error tracking
   - Configure logging
   - Set up performance monitoring

> **Nota di prevenzione:**
> L'enum AppointmentType deve essere sempre posizionato in `Modules/SaluteOra/app/Enums/AppointmentType.php` e importato con il namespace corretto. Aggiornare sempre la documentazione e i file .mdc windsurf/cursor in caso di modifica del path.
