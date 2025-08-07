# Widget Calendario Disponibilità Medico

## Implementazione raccomandata

Nel modulo SaluteOra, il calendario delle disponibilità del medico è implementato utilizzando una classe widget dedicata che estende `FullCalendarWidget` di Saade, seguendo le best practices di Filament e le convenzioni del progetto.

## Struttura

### 1. Widget dedicato

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\User;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class DoctorAvailabilityCalendarWidget extends FullCalendarWidget
{
    protected User $doctor;
    protected $studio;

    public function __construct(User $doctor, $studio)
    {
        parent::__construct();
        $this->doctor = $doctor;
        $this->studio = $studio;
    }

    /**
     * Recupera gli eventi per il calendario in base all'intervallo di date richiesto.
     *
     * @param array $fetchInfo Contiene 'start' e 'end' come stringhe ISO 8601
     * @return array Array di eventi formattati per FullCalendar
     */
    public function fetchEvents(array $fetchInfo): array
    {
        $start = Carbon::parse($fetchInfo['start']);
        $end = Carbon::parse($fetchInfo['end']);
        
        return Appointment::query()
            ->where('doctor_id', $this->doctor->id)
            ->where('studio_id', $this->studio->id)
            ->whereBetween('start_time', [$start, $end])
            ->get()
            ->map(function (Appointment $appointment) {
                // Colore in base al tipo e stato
                $color = match ($appointment->status) {
                    AppointmentStatusEnum::Available => '#10B981', // Verde - Disponibile
                    AppointmentStatusEnum::Pending => '#F59E0B',   // Giallo - In attesa
                    AppointmentStatusEnum::Confirmed => '#3B82F6', // Blu - Confermato
                    AppointmentStatusEnum::Completed => '#059669', // Verde scuro - Completato
                    AppointmentStatusEnum::Cancelled => '#EF4444', // Rosso - Annullato
                    default => '#6B7280', // Grigio - Default
                };

                // Titolo in base al tipo
                $title = match ($appointment->type) {
                    AppointmentTypeEnum::Availability => __('saluteora::appointment.availability.title'),
                    default => $appointment->title ?? __('saluteora::appointment.appointment_with', [
                        'patient' => optional($appointment->patient)->full_name ?? __('saluteora::appointment.patient')
                    ]),
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
     * Configura il calendario.
     *
     * @return array
     */
    protected function getViewData(): array
    {
        return array_merge(parent::getViewData(), [
            'config' => [
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
            ]
        ]);
    }

    /**
     * Gestisce la creazione di un nuovo evento.
     *
     * @param array $data
     * @return Appointment
     */
    public function createEvent(array $data): Appointment
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
     * Gestisce l'aggiornamento di un evento esistente.
     *
     * @param Appointment $event
     * @param array $data
     * @return Appointment
     */
    public function updateEvent(Appointment $event, array $data): Appointment
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
     * Gestisce l'eliminazione di un evento.
     *
     * @param Appointment $event
     * @return void
     */
    public function deleteEvent(Appointment $event): void
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

### 2. Utilizzo nella pagina DoctorAvailabilityCalendar

```php
<?php

namespace Modules\SaluteOra\Filament\Pages;

use Carbon\CarbonInterval;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\SaluteOra\Filament\Widgets\DoctorAvailabilityCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\User;
use Modules\Xot\Filament\Pages\XotBasePage;
use Filament\Actions\Action as FilamentAction;

class DoctorAvailabilityCalendar extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'saluteora::filament.pages.doctor-availability-calendar';

    public function getTitle(): string
    {
        return __('saluteora::appointment.calendar_title');
    }

    protected function getHeaderActions(): array
    {
        return [
            FilamentAction::make('refresh')
                ->label(__('saluteora::appointment.actions.refresh'))
                ->action(fn () => $this->refresh())
                ->icon('heroicon-o-arrow-path'),
            FilamentAction::make('legenda')
                ->label(__('saluteora::appointment.actions.legend.label'))
                ->modalHeading(__('saluteora::appointment.actions.legend.modal_heading'))
                ->modalContent(view('saluteora::components.appointment-legend')),
        ];
    }

    /**
     * Crea il widget del calendario.
     *
     * @return DoctorAvailabilityCalendarWidget
     */
    protected function calendarWidget(): DoctorAvailabilityCalendarWidget
    {
        $doctor = $this->getCurrentDoctor();
        $studio = Filament::getTenant();

        return new DoctorAvailabilityCalendarWidget($doctor, $studio);
    }

    /**
     * Registrare i widget della pagina.
     *
     * @return array
     */
    protected function getHeaderWidgets(): array
    {
        return [
            $this->calendarWidget(),
        ];
    }

    /**
     * Restituisce l'utente autenticato come dottore (STI/Parental).
     * Doctor non è una tabella separata, ma un tipo di User (campo type o enum).
     * Motivazione: un solo punto di verità, nessuna duplicazione, DRY, KISS, serenità del codice.
     */
    protected function getCurrentDoctor(): User
    {
        $user = Filament::auth()->user();
        if (!$user || $user->type->value !== 'doctor') { // oppure enum UserTypeEnum::DOCTOR->value
            throw new \Exception('L\'utente corrente non è un dottore è un ['.$user->type->value.']');
        }
        return $user;
    }
}
```

## Vantaggi di questo approccio

1. **Separazione delle responsabilità**: La logica del calendario è contenuta nel widget dedicato
2. **Riutilizzabilità**: Il widget può essere utilizzato in più pagine o pannelli
3. **Manutenibilità**: Più facile da testare e aggiornare
4. **Conformità alle convenzioni Filament**: Segue le best practices del framework

## Punti da considerare

### Type Hinting

- Il metodo `calendarWidget()` deve restituire l'istanza corretta `DoctorAvailabilityCalendarWidget`
- La classe `DoctorAvailabilityCalendarWidget` deve estendere `FullCalendarWidget`

### Single Table Inheritance (STI)

Il modello `User` utilizza il pattern STI con Parental per gestire diversi tipi di utenti:

```php
// Ottenere l'utente autenticato come Doctor (usando STI)
protected function getCurrentDoctor(): User
{
    $user = Filament::auth()->user();
    if (!$user || $user->type->value !== 'doctor') {
        throw new \Exception('L\'utente corrente non è un dottore è un ['.$user->type->value.']');
    }
    return $user;
}
```

### Multi-tenancy

Tutti gli eventi sono filtrati per il tenant corrente (studio):

```php
$studio = Filament::getTenant();

// Nei filtri delle query
->where('studio_id', $studio->id)
```

## Traduzione

Tutte le etichette utilizzate sono chiavi di traduzione, come richiesto dalle convenzioni del progetto:

```php
__('saluteora::appointment.availability.title')
```

## Risorse correlate

- [Documentazione Saade FilamentFullCalendar](https://github.com/saade/filament-fullcalendar)
- [Documentazione Single Table Inheritance con Parental](../models/single-table-inheritance.md)
- [Convenzioni di Filament in SaluteOra](../filament/resources/conventions.md)
