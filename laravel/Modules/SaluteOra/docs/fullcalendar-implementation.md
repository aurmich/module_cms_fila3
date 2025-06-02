# Implementazione Corretta di FullCalendarWidget

## Descrizione del Package

`saade/filament-fullcalendar` v3.2.4 è un plugin ufficiale di Filament che integra FullCalendar.js nel pannello di amministrazione. Questo documento descrive l'implementazione corretta secondo le convenzioni del progetto SaluteOra.

## Struttura di Base

La struttura corretta per l'implementazione del widget è:

```
Modules/
  SaluteOra/
    app/
      Filament/
        Widgets/
          DoctorAvailabilityCalendarWidget.php  # Widget dedicato
        Pages/
          DoctorAvailabilityCalendar.php        # Pagina che utilizza il widget
    resources/
      views/
        filament/
          widgets/
            doctor-availability-calendar-widget.blade.php  # Template Blade
```

## Implementazione Corretta

L'implementazione corretta richiede di **estendere direttamente la classe `FullCalendarWidget`** e sovrascrivere i metodi necessari:

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\User;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class DoctorAvailabilityCalendarWidget extends FullCalendarWidget
{
    protected static string $view = 'saluteora::filament.widgets.doctor-availability-calendar-widget';

    protected User $doctor;
    protected $studio;

    public function __construct(User $doctor, $studio)
    {
        $this->doctor = $doctor;
        $this->studio = $studio;
        
        parent::__construct();
    }

    /**
     * Configurazione del calendario
     */
    public function config(): array
    {
        return [
            'headerToolbar' => [
                'start' => 'prev,next today',
                'center' => 'title',
                'end' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
            'initialView' => 'timeGridWeek',
            'selectable' => true,
            'editable' => true,
            'dayMaxEvents' => true,
            'contentHeight' => 'auto',
            'slotMinTime' => '07:00:00',
            'slotMaxTime' => '20:00:00',
            'slotDuration' => '00:15:00',
            'locale' => app()->getLocale(),
            'firstDay' => 1, // Lunedì
            'businessHours' => [
                'startTime' => '08:00',
                'endTime' => '19:00',
                'daysOfWeek' => [1, 2, 3, 4, 5], // Lunedì a Venerdì
            ],
            'timezone' => config('app.timezone'),
        ];
    }

    /**
     * FullCalendar chiama questa funzione quando ha bisogno di nuovi dati sugli eventi.
     * Questo è attivato quando l'utente clicca prev/next o cambia visualizzazione.
     * 
     * @param array{start: string, end: string, timezone: string} $fetchInfo
     * @return array
     */
    public function fetchEvents(array $fetchInfo): array
    {
        // Prepara le date
        $start = Carbon::parse($fetchInfo['start']);
        $end = Carbon::parse($fetchInfo['end']);
        
        // Query per le disponibilità e gli appuntamenti
        return Appointment::query()
            ->where('doctor_id', $this->doctor->id)
            ->where('studio_id', $this->studio->id)
            ->whereBetween('start_time', [$start, $end])
            ->get()
            ->map(function (Appointment $appointment) {
                // Colore in base al tipo e stato
                $color = match ($appointment->status) {
                    AppointmentStatusEnum::Available => '#10B981', // Verde - Disponibile
                    AppointmentStatusEnum::Pending => '#F59E0B', // Giallo - In attesa
                    AppointmentStatusEnum::Confirmed => '#3B82F6', // Blu - Confermato
                    AppointmentStatusEnum::Completed => '#059669', // Verde scuro - Completato
                    AppointmentStatusEnum::Cancelled => '#EF4444', // Rosso - Annullato
                    default => '#6B7280', // Grigio - Default
                };
                
                // Titolo in base al tipo
                $title = match ($appointment->type) {
                    AppointmentTypeEnum::Availability => __('saluteora::appointment.availability.title'),
                    default => $appointment->title ?? __('saluteora::appointment.appointment_with', ['patient' => optional($appointment->patient)->full_name ?? 'Paziente']),
                };
                
                return [
                    'id' => $appointment->id,
                    'title' => $title,
                    'start' => $appointment->start_time->toDateTimeString(),
                    'end' => $appointment->end_time->toDateTimeString(),
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'textColor' => '#ffffff',
                    'extendedProps' => [
                        'appointment' => $appointment->id,
                        'doctorId' => $appointment->doctor_id,
                        'patientId' => $appointment->patient_id,
                        'studioId' => $appointment->studio_id,
                        'type' => $appointment->type->value,
                        'status' => $appointment->status->value,
                        'isAvailability' => $appointment->type === AppointmentTypeEnum::Availability,
                    ],
                ];
            })
            ->toArray();
    }
    
    /**
     * Gestione creazione evento
     */
    protected function createEvent(array $data): Appointment
    {
        $event = Appointment::create([
            'doctor_id' => $this->doctor->id,
            'studio_id' => $this->studio->id,
            'start_time' => $data['start'],
            'end_time' => $data['end'],
            'title' => __('saluteora::appointment.availability.title'),
            'type' => AppointmentTypeEnum::Availability->value,
            'status' => AppointmentStatusEnum::Available->value,
        ]);

        // Notifica
        Notification::make()
            ->title(__('saluteora::availability.created'))
            ->success()
            ->send();

        return $event;
    }
    
    /**
     * Gestione aggiornamento evento
     */
    protected function updateEvent(Appointment $event, array $data): Appointment
    {
        $event->update([
            'start_time' => $data['start'] ?? $event->start_time,
            'end_time' => $data['end'] ?? $event->end_time,
        ]);

        // Notifica
        Notification::make()
            ->title(__('saluteora::availability.updated'))
            ->success()
            ->send();

        return $event;
    }
    
    /**
     * Gestione eliminazione evento
     */
    protected function deleteEvent(Appointment $event): void
    {
        $event->delete();

        // Notifica
        Notification::make()
            ->title(__('saluteora::availability.deleted'))
            ->success()
            ->send();
    }
}
```

## Utilizzo nella Pagina Filament

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Pages;

use Filament\Facades\Filament;
use Modules\SaluteOra\Filament\Widgets\DoctorAvailabilityCalendarWidget;
use Modules\SaluteOra\Models\User;
use Modules\Xot\Filament\Pages\XotBasePage;

class DoctorAvailabilityCalendar extends XotBasePage
{
    // Altri metodi...
    
    protected function calendarWidget(): DoctorAvailabilityCalendarWidget
    {
        $doctor = $this->getCurrentDoctor();
        $studio = Filament::getTenant();

        return new DoctorAvailabilityCalendarWidget($doctor, $studio);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            $this->calendarWidget(),
        ];
    }
}
```

## Vista Blade per il Widget

Il template Blade deve essere posizionato in:

```
Modules/SaluteOra/resources/views/filament/widgets/doctor-availability-calendar-widget.blade.php
```

Contenuto di base:

```blade
<x-filament::widget>
    <x-filament::section>
        <div
            wire:ignore
            x-data="calendarWidget({
                config: {{ json_encode($this->getConfig()) }},
                events: {{ json_encode([]) }},
                locale: @js(app()->getLocale()),
                timezone: @js(config('app.timezone')),
            })"
        >
            <div x-ref="calendar" wire:ignore></div>
        </div>
    </x-filament::section>
</x-filament::widget>
```

## Errori da Evitare

1. ❌ **Non utilizzare API fluente**: `FullCalendarWidget::make()->config([])` - NON funziona
2. ❌ **Non utilizzare classi anonime**: `new class extends FullCalendarWidget` - NON rispetta le convenzioni
3. ❌ **Non estendere direttamente classi Filament**: Rispettare il pattern XotBase quando necessario

## Riferimenti Ufficiali

- [Documentazione Filament v3](https://filamentphp.com/docs/3.x/widgets/installation)
- [Package saade/filament-fullcalendar v3.2.4](https://github.com/saade/filament-fullcalendar)
- [Documentazione plugin](https://filamentphp.com/plugins/saade-fullcalendar)