<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
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
     * 
     * @param array $data
     * @return Model
     */
    protected function createEvent(array $data): Model
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
     * 
     * @param Model $event
     * @param array $data
     * @return Model
     */
    protected function updateEvent(Model $event, array $data): Model
    {
        /** @var Appointment $event */
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
     * 
     * @param Model $event
     * @return void
     */
    protected function deleteEvent(Model $event): void
    {
        /** @var Appointment $event */
        $event->delete();

        // Notifica
        Notification::make()
            ->title(__('saluteora::availability.deleted'))
            ->success()
            ->send();
    }
}