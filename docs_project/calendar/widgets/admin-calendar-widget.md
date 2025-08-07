# Admin Calendar Widget

## Overview

The `AdminCalendarWidget` provides administrators with a comprehensive view of all appointments across all clinics. This widget extends the `BaseCalendarWidget` and implements admin-specific functionality.

## Features

- View all appointments across all clinics
- Filter appointments by clinic, doctor, or date range
- Quick access to appointment details
- Drag-and-drop rescheduling
- Bulk actions for multiple appointments

## Implementation

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets\Admin;

use Modules\SaluteOra\Filament\Widgets\BaseCalendarWidget;
use Modules\SaluteOra\Models\Appointment;

class AdminCalendarWidget extends BaseCalendarWidget
{
    protected static ?string $model = Appointment::class;
    protected static string $heading = 'Admin Calendar';
    
    protected function getEventsQuery()
    {
        return parent::getEventsQuery()
            ->with([
                'patient',
                'doctor',
                'clinic',
                'status'
            ]);
    }
    
    protected function mapToEvent($appointment): array
    {
        return [
            'id' => $appointment->id,
            'title' => $appointment->title,
            'start' => $appointment->start,
            'end' => $appointment->end,
            'allDay' => $appointment->all_day,
            'backgroundColor' => $appointment->status->color,
            'borderColor' => $appointment->status->color,
            'textColor' => $this->getContrastColor($appointment->status->color),
            'extendedProps' => [
                'description' => $appointment->description,
                'patient' => $appointment->patient->name,
                'patient_id' => $appointment->patient_id,
                'doctor' => $appointment->doctor->name,
                'doctor_id' => $appointment->doctor_id,
                'clinic' => $appointment->clinic->name,
                'clinic_id' => $appointment->clinic_id,
                'status' => $appointment->status->name,
                'status_id' => $appointment->status_id,
            ],
            'url' => route('filament.resources.appointments.edit', $appointment),
        ];
    }
    
    protected function headerActions(): array
    {
        return [
            \Filament\Actions\Action::make('create')
                ->label(__('filament::resources/actions/create.multiple', ['label' => 'Appointment']))
                ->url(route('filament.resources.appointments.create'))
                ->icon('heroicon-o-plus')
                ->button(),
        ];
    }
    
    protected function getViewData(): array
    {
        return [
            'headerActions' => $this->headerActions(),
        ];
    }
    
    protected function getView(): string
    {
        return 'saluteora::widgets.admin-calendar';
    }
    
    protected function getCalendarView(): string
    {
        return 'fullcalendar::calendar';
    }
    
    protected function getCalendarConfig(): array
    {
        return [
            'initialView' => 'timeGridWeek',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
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
    
    protected function getContrastColor($hexColor): string
    {
        // Implementation of contrast color calculation
        $r = hexdec(substr($hexColor, 1, 2));
        $g = hexdec(substr($hexColor, 3, 2));
        $b = hexdec(substr($hexColor, 5, 2));
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        return ($yiq >= 128) ? '#1f2937' : '#ffffff';
    }
}
```

## Usage

### Registration

Register the widget in your panel provider:

```php
use Modules\SaluteOra\Filament\Widgets\Admin\AdminCalendarWidget;

public function getWidgets(): array
{
    return [
        // ...
        AdminCalendarWidget::class,
    ];
}
```

### Template

Create a view at `resources/views/vendor/saluteora/widgets/admin-calendar.blade.php`:

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
                    eventContent: function(arg) {
                        // Custom event rendering
                        let html = `
                            <div class="fc-event-main-frame">
                                <div class="fc-event-title">${arg.event.title}</div>
                                <div class="fc-event-time">${arg.timeText}</div>
                            </div>
                        `;
                        return { html };
                    }
                });
                calendar.render();
            "
            class="w-full h-[800px]"
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
    
    // Add custom fields
    $event['extendedProps']['custom_field'] = $appointment->custom_field;
    
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
            'right' => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
        ],
        'views' => [
            'dayGridMonth' => [
                'dayMaxEventRows' => 4,
            ],
        ],
    ]);
}
```

## Security

- All database queries are automatically scoped to the current tenant
- User permissions are checked before performing any actions
- Sensitive data is never exposed in the frontend

## Dependencies

- `saade/filament-fullcalendar`
- `tighten/parental`
- `filament/filament`

## Related Documentation

- [Base Calendar Widget](../architecture.md)
- [Filament Documentation](https://filamentphp.com/docs)
- [FullCalendar Documentation](https://fullcalendar.io/docs)
