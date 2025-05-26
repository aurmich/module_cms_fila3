# Patient Calendar Widget

## Overview

The `PatientCalendarWidget` enables patients to view and manage their appointments. It extends the `BaseCalendarWidget` and is tailored for patient-specific functionality.

## Features

- View all personal appointments
- Access appointment details
- Request rescheduling or cancellation
- View clinic and doctor information
- Receive reminders and notifications

## Implementation

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets\Patient;

use Filament\Support\Facades\Filament;
use Modules\SaluteOra\Filament\Widgets\BaseCalendarWidget;
use Modules\SaluteOra\Models\Appointment;

class PatientCalendarWidget extends BaseCalendarWidget
{
    protected static ?string $model = Appointment::class;
    protected static string $heading = 'My Appointments';
    
    protected function getEventsQuery()
    {
        $patient = Filament::auth()->user()->patient;
        
        return parent::getEventsQuery()
            ->where('patient_id', $patient->id)
            ->with([
                'doctor.user',
                'clinic',
                'status'
            ]);
    }
    
    protected function mapToEvent($appointment): array
    {
        return [
            'id' => $appointment->id,
            'title' => $appointment->doctor->user->name . ' - ' . $appointment->service->name,
            'start' => $appointment->start,
            'end' => $appointment->end,
            'allDay' => $appointment->all_day,
            'backgroundColor' => $appointment->status->color,
            'borderColor' => $appointment->status->color,
            'textColor' => $this->getContrastColor($appointment->status->color),
            'extendedProps' => [
                'doctor' => $appointment->doctor->user->name,
                'clinic' => $appointment->clinic->name,
                'address' => $appointment->clinic->address,
                'status' => $appointment->status->name,
                'notes' => $appointment->patient_notes,
                'can_cancel' => $appointment->canBeCancelled(),
                'can_reschedule' => $appointment->canBeRescheduled(),
            ],
            'url' => route('filament.resources.appointments.view', $appointment),
        ];
    }
    
    protected function getView(): string
    {
        return 'saluteora::widgets.patient-calendar';
    }
    
    protected function getCalendarConfig(): array
    {
        return [
            'initialView' => 'dayGridMonth',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
            'editable' => false,
            'selectable' => true,
            'selectMirror' => true,
            'dayMaxEvents' => true,
            'eventTimeFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'hour12' => false,
            ],
            'eventDidMount' => 'function(info) {
                if (info.event.extendedProps.can_cancel) {
                    const cancelButton = document.createElement("button");
                    cancelButton.innerHTML = `<x-heroicon-o-x-circle class="w-4 h-4 text-red-500" />`;
                    cancelButton.classList.add("ml-2", "opacity-50", "hover:opacity-100", "transition-opacity");
                    cancelButton.title = "Cancel appointment";
                    cancelButton.onclick = (e) => {
                        e.stopPropagation();
                        if (confirm("Are you sure you want to cancel this appointment?")) {
                            // Handle cancellation
                        }
                    };
                    info.el.querySelector(".fc-event-title").appendChild(cancelButton);
                }
            }',
        ];
    }
}
```

## Usage

### Registration

Register the widget in your panel provider:

```php
use Modules\SaluteOra\Filament\Widgets\Patient\PatientCalendarWidget;

public function getWidgets(): array
{
    return [
        // ...
        PatientCalendarWidget::class,
    ];
}
```

### Template

Create a view at `resources/views/vendor/saluteora/widgets/patient-calendar.blade.php`:

```blade
<x-filament::widget>
    <x-filament::card>
        <div 
            x-data="{ 
                calendar: null,
                config: @js($this->getCalendarConfig())
            }"
            x-init="
                calendar = new FullCalendar.Calendar($el, {
                    ...config,
                    events: @js($this->getEvents()),
                    eventClick: function(info) {
                        if (info.event.url) {
                            window.location.href = info.event.url;
                            info.jsEvent.preventDefault();
                        }
                    },
                    select: function(selectionInfo) {
                        // Handle new appointment creation
                        window.location.href = route('filament.resources.appointments.create', {
                            start: selectionInfo.startStr,
                            end: selectionInfo.endStr
                        });
                    },
                    eventDidMount: function(info) {
                        // Custom event rendering
                        if (info.event.extendedProps.can_cancel) {
                            const cancelButton = document.createElement('button');
                            cancelButton.innerHTML = `
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            `;
                            cancelButton.classList.add('ml-2', 'opacity-50', 'hover:opacity-100', 'transition-opacity');
                            cancelButton.title = 'Cancel appointment';
                            cancelButton.onclick = (e) => {
                                e.stopPropagation();
                                if (confirm('Are you sure you want to cancel this appointment?')) {
                                    // Handle cancellation
                                    window.location.href = route('appointments.cancel', info.event.id);
                                }
                            };
                            info.el.querySelector('.fc-event-title').appendChild(cancelButton);
                        }
                    }
                });
                calendar.render();
            "
            class="w-full h-[600px]"
        ></div>
    </x-filament::card>
</x-filament::widget>
```

## Customization

### Event Display

Customize how events are displayed by overriding the `mapToEvent` method:

```php
protected function mapToEvent($appointment): array
{
    $event = parent::mapToEvent($appointment);
    
    // Add custom fields or modify existing ones
    $event['title'] = "Dr. " . $appointment->doctor->user->name;
    $event['extendedProps']['service'] = $appointment->service->name;
    
    return $event;
}
```

### Available Views

Customize the available views by overriding the `getCalendarConfig` method:

```php
protected function getCalendarConfig(): array
{
    return array_merge(parent::getCalendarConfig(), [
        'headerToolbar' => [
            'left' => 'prev,next today',
            'center' => 'title',
            'right' => 'dayGridMonth,timeGridWeek,listWeek',
        ],
        'slotMinTime' => '07:00:00',
        'slotMaxTime' => '21:00:00',
    ]);
}
```

## Security

- Patients can only view their own appointments
- All actions are protected by authorization policies
- Sensitive data is never exposed

## Related Documentation

- [Base Calendar Widget](../architecture.md)
- [Doctor Calendar Widget](./doctor-calendar-widget.md)
- [Admin Calendar Widget](./admin-calendar-widget.md)
- [Filament Widgets](https://filamentphp.com/docs/3.x/panels/widgets)
