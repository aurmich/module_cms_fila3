<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Traits;

use Filament\Facades\Filament;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\UserTypeEnum;

/**
 * Trait per configurazioni comuni dei widget FullCalendar.
 *
 * Fornisce metodi condivisi per configurazione, caching, formattazione
 * e gestione colori per tutti i widget FullCalendar del modulo SaluteOra.
 */
trait HasFullCalendarConfig
{
    /**
     * Configurazione base per tutti i widget FullCalendar.
     *
     * @return array<string, mixed>
     */
    public function config(): array
    {
        return [
            'locale' => 'it',
            'timezone' => 'Europe/Rome',
            'firstDay' => 1, // Lunedì
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
            'buttonText' => [
                'today' => 'Oggi',
                'month' => 'Mese',
                'week' => 'Settimana',
                'day' => 'Giorno',
            ],
            'businessHours' => [
                'daysOfWeek' => [1, 2, 3, 4, 5, 6], // Lun-Sab
                'startTime' => '08:00',
                'endTime' => '19:00',
            ],
            'eventTimeFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'hour12' => false,
            ],
            'slotDuration' => '00:30:00',
            'slotMinTime' => '08:00:00',
            'slotMaxTime' => '19:00:00',
            'height' => 'auto',
            'aspectRatio' => 1.35,
            'eventDisplay' => 'block',
            'displayEventTime' => true,
            'displayEventEnd' => true,
            'dayMaxEvents' => true,
            'moreLinkClick' => 'popover',
            'eventConstraint' => 'businessHours',
            'selectConstraint' => 'businessHours',
            'allDaySlot' => false,
            'nowIndicator' => true,
            'scrollTime' => '08:00:00',
            'weekNumbers' => true,
            'weekNumberFormat' => [
                'week' => 'numeric',
            ],
        ];
    }

    /**
     * Genera chiave cache per eventi.
     *
     * @param array<string, mixed> $fetchInfo
     * @return string
     */
    protected function getCacheKey(array $fetchInfo): string
    {
        $user = auth()->user();
        $tenant = Filament::getTenant();

        return sprintf(
            'fullcalendar_events_%s_%s_%s_%s_%s',
            class_basename(static::class),
            $user?->id ?? 'guest',
            $user?->type?->value ?? 'unknown',
            $tenant?->id ?? 'no_tenant',
            md5(serialize($fetchInfo))
        );
    }

    /**
     * Formatta il titolo dell'evento.
     *
     * @param Appointment $appointment
     * @return string
     */
    protected function formatEventTitle(Appointment $appointment): string
    {
        if ($appointment->emergency) {
            return "🚨 {$appointment->title}";
        }

        return $appointment->title ?: $appointment->type->getLabel();
    }

    /**
     * Formatta tooltip per l'evento.
     *
     * @param Appointment $appointment
     * @return string
     */
    protected function formatTooltip(Appointment $appointment): string
    {
        $lines = [
            "Tipo: {$appointment->type->getLabel()}",
            "Stato: {$appointment->status->getLabel()}",
            "Orario: {$appointment->start_time->format('H:i')} - {$appointment->end_time->format('H:i')}",
        ];

        if ($appointment->patient) {
            $lines[] = "Paziente: {$appointment->patient->full_name}";
        }

        if ($appointment->doctor) {
            $lines[] = "Medico: {$appointment->doctor->full_name}";
        }

        if ($appointment->studio) {
            $lines[] = "Studio: {$appointment->studio->name}";
        }

        if ($appointment->notes) {
            $lines[] = "Note: " . \Str::limit($appointment->notes, 100);
        }

        return implode("\n", $lines);
    }

    /**
     * Ottiene colore per tipo appuntamento.
     *
     * @param string $type
     * @return string
     */
    /**
     * Ottiene colore per tipo appuntamento.
     *
     * @param string $type
     * @return string
     */
    protected function getAppointmentTypeColor(string $type): string
    {
        /** @var array<string, string> $colors */
        $colors = (array) config('fullcalendar.colors.appointment_types', []);
        
        if (array_key_exists($type, $colors)) {
            return $colors[$type];
        }
        
        // Default colors for known appointment types
        $defaultColors = [
            'consultation' => '#3b82f6', // blu
            'cleaning' => '#10b981', // verde
            'treatment' => '#f59e0b', // arancione
            'emergency' => '#ef4444', // rosso
            'followup' => '#8b5cf6', // viola
            'surgery' => '#6b7280', // grigio
            'orthodontics' => '#ec4899', // rosa
            'prevention' => '#059669', // verde scuro
        ];
        
        return $defaultColors[$type] ?? '#6b7280';
    }

    /**
     * Ottiene colore per stato appuntamento.
     *
     * @param string $status
     * @return string
     */
    /**
     * Ottiene colore per stato appuntamento.
     *
     * @param string $status
     * @return string
     */
    protected function getAppointmentStatusColor(string $status): string
    {
        /** @var array<string, string> $colors */
        $colors = (array) config('fullcalendar.colors.appointment_status', []);
        
        if (array_key_exists($status, $colors)) {
            return $colors[$status];
        }
        
        // Default colors for known statuses
        $defaultColors = [
            'scheduled' => '#3b82f6', // blu
            'confirmed' => '#10b981', // verde
            'in_progress' => '#f59e0b', // arancione
            'completed' => '#059669', // verde scuro
            'cancelled' => '#ef4444', // rosso
            'no_show' => '#dc2626', // rosso scuro
            'rescheduled' => '#8b5cf6', // viola
            'pending' => '#6b7280', // grigio
        ];
        
        return $defaultColors[$status] ?? '#6b7280';
    }

    /**
     * Ottiene colore per studio basato sul suo ID.
     *
     * @param Studio|null $studio L'istanza dello studio o null
     * @return string Il colore esadecimale per lo studio
     */
    protected function getStudioColor(?Studio $studio): string
    {
        if ($studio === null || !isset($studio->id)) {
            return '#6b7280'; // Default gray color for null or invalid studio
        }

        /** @var array<int, string> $colors */
        $colors = [
            '#3b82f6', // blue-500
            '#10b981', // emerald-500
            '#f59e0b', // amber-500
            '#ef4444', // red-500
            '#8b5cf6', // violet-500
            '#ec4899', // pink-500
            '#06b6d4', // cyan-500
            '#84cc16', // lime-500
            '#f97316', // orange-500
            '#14b8a6', // teal-400
            '#a855f7', // purple-500
            '#e11d48'  // rose-600
        ];
        
        $index = abs($studio->id) % count($colors);
        return $colors[$index] ?? '#6b7280'; // Fallback to gray
    }

    /**
     * Verifica se l'utente può modificare l'appuntamento.
     *
     * @param Appointment $appointment
     * @return bool
     */
    protected function canEditAppointment(Appointment $appointment): bool
    {
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        return match ($user->type) {
            UserTypeEnum::ADMIN => true,
            UserTypeEnum::DOCTOR => $appointment->doctor_id === $user->id ||
                               $user->hasRole('studio_admin'),
            UserTypeEnum::PATIENT => false,
            default => false,
        };
    }

    /**
     * Verifica se l'utente può visualizzare l'appuntamento.
     *
     * @param Appointment $appointment
     * @return bool
     */
    protected function canViewAppointment(Appointment $appointment): bool
    {
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        return match ($user->type) {
            UserTypeEnum::ADMIN => true,
            UserTypeEnum::DOCTOR => $appointment->doctor_id === $user->id ||
                               ($user->hasRole('studio_admin') &&
                                $appointment->studio_id === $user->studio_id),
            UserTypeEnum::PATIENT => $appointment->patient_id === $user->id,
            default => false,
        };
    }

    /**
     * Ottiene la query base per gli eventi.
     *
     * @param array<string, mixed> $fetchInfo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getEventsQuery(array $fetchInfo): \Illuminate\Database\Eloquent\Builder
    {
        return Appointment::query()
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
            ->with(['patient', 'doctor', 'studio']);
    }

    /**
     * Trasforma un appuntamento in EventData per FullCalendar.
     *
     * @param Appointment $appointment L'appuntamento da trasformare
     * @return \Saade\FilamentFullCalendar\Data\EventData
     * @throws \InvalidArgumentException Se i dati richiesti non sono validi
     */
    protected function transformToEventData(Appointment $appointment): \Saade\FilamentFullCalendar\Data\EventData
    {
        if ($appointment->start_time === null || $appointment->end_time === null) {
            throw new \InvalidArgumentException('Appointment must have both start_time and end_time set');
        }

        // Ensure required enum values are set
        $type = $appointment->type?->value ?? 'default';
        $status = $appointment->status?->value ?? 'scheduled';

        // Get colors based on type and status
        $backgroundColor = $this->getAppointmentTypeColor($type);
        $borderColor = $this->getAppointmentStatusColor($status);
        $textColor = '#ffffff'; // White text for better contrast on colored backgrounds

        // Create extended props with null coalescing for optional relationships
        $extendedProps = [
            'patient_id' => $appointment->patient_id,
            'patient_name' => $appointment->patient?->full_name ?? 'Unknown Patient',
            'doctor_id' => $appointment->doctor_id,
            'doctor_name' => $appointment->doctor?->full_name ?? 'Unknown Doctor',
            'studio_id' => $appointment->studio_id,
            'studio_name' => $appointment->studio?->name ?? 'Unknown Studio',
            'status' => $status,
            'type' => $type,
            'emergency' => (bool) ($appointment->emergency ?? false),
            'tooltip' => $this->formatTooltip($appointment),
            'can_edit' => $this->canEditAppointment($appointment),
            'can_view' => $this->canViewAppointment($appointment),
            'duration' => (int) ($appointment->duration ?? 0),
            'notes' => $appointment->notes ? \Illuminate\Support\Str::limit((string) $appointment->notes, 100) : null,
        ];

        // Build and return the EventData object
        return \Saade\FilamentFullCalendar\Data\EventData::make()
            ->id((string) $appointment->id)
            ->title($this->formatEventTitle($appointment))
            ->start($appointment->start_time)
            ->end($appointment->end_time)
            ->backgroundColor($backgroundColor)
            ->borderColor($borderColor)
            ->textColor($textColor)
            ->extendedProps($extendedProps);
    }

    /**
     * Invalida la cache per gli eventi.
     *
     * @return void
     */
    protected function invalidateCache(): void
    {
        $pattern = sprintf(
            'fullcalendar_events_%s_*',
            class_basename(static::class)
        );

        // Nota: Implementazione specifica dipende dal driver di cache utilizzato
        // Per Redis: cache()->getRedis()->del(cache()->getRedis()->keys($pattern))
        // Per file: più complesso, potrebbe richiedere un comando personalizzato

        // Implementazione semplice: flush di tutta la cache (non ottimale per produzione)
        if (app()->environment('local', 'testing')) {
            cache()->flush();
        }
    }

    /**
     * Ottiene le configurazioni specifiche per il tipo di widget.
     *
     * @return array<string, mixed>
     */
    protected function getWidgetSpecificConfig(): array
    {
        $widgetType = match (class_basename(static::class)) {
            'PatientCalendarWidget' => 'patient',
            'DoctorCalendarWidget' => 'doctor',
            'AdminCalendarWidget' => 'admin',
            default => 'default',
        };

        return config("fullcalendar.widgets.{$widgetType}", []);
    }

    /**
     * Merge delle configurazioni base con quelle specifiche del widget.
     *
     * @return array<string, mixed>
     */
    public function getFullConfig(): array
    {
        $baseConfig = $this->config();
        $widgetConfig = $this->getWidgetSpecificConfig();

        return array_merge($baseConfig, $widgetConfig);
    }
}
