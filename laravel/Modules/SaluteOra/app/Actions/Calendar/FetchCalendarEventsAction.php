<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Actions\Calendar;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\QueueableAction\QueueableAction;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;

class FetchCalendarEventsAction
{
    use QueueableAction;

    /**
     * Execute the action to fetch calendar events
     *
     * @param  CarbonInterface  $start
     * @param  CarbonInterface  $end
     * @param  array<string, mixed>  $filters
     * @return Collection<int, array<string, mixed>>
     */
    public function execute(
        CarbonInterface $start, 
        CarbonInterface $end,
        array $filters = []
    ): Collection {
        $query = Appointment::query()
            ->with(['patient', 'doctor', 'studio'])
            ->whereBetween('starts_at', [$start, $end]);

        $this->applyFilters($query, $filters);

        return $query->get()->map(function (Appointment $appointment) {
            return $this->transformAppointment($appointment);
        });
    }

    /**
     * Apply filters to the query
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array<string, mixed>  $filters
     * @return void
     */
    protected function applyFilters($query, array $filters): void
    {
        $user = Auth::user();
        
        // Apply role-based filters
        if ($user) {
            match ($user->type) {
                UserTypeEnum::DOCTOR => $query->where('doctor_id', $user->id),
                UserTypeEnum::PATIENT => $query->where('patient_id', $user->id),
                default => $query,
            };
        }

        // Apply additional filters
        foreach ($filters as $key => $value) {
            if ($value !== null && $value !== '') {
                $query->where($key, $value);
            }
        }
    }

    /**
     * Transform appointment to calendar event format
     *
     * @param  Appointment  $appointment
     * @return array<string, mixed>
     */
    protected function transformAppointment(Appointment $appointment): array
    {
        $title = $this->formatEventTitle($appointment);
        $color = $this->getEventColor($appointment);
        
        return [
            'id' => $appointment->id,
            'title' => $title,
            'start' => $appointment->starts_at?->toIso8601String(),
            'end' => $appointment->ends_at?->toIso8601String(),
            'allDay' => false,
            'backgroundColor' => $color,
            'borderColor' => $color,
            'textColor' => $this->getContrastColor($color),
            'extendedProps' => [
                'type' => $appointment->type->value,
                'status' => $appointment->status->value,
                'patient_id' => $appointment->patient_id,
                'patient_name' =>  $appointment->patient->full_name,
                'doctor_id' => $appointment->doctor_id,
                'doctor_name' => $appointment->doctor->full_name,
                'studio_id' => $appointment->studio_id,
                'studio_name' => $appointment->studio->name,
                'emergency' => $appointment->emergency,
                'notes' => $appointment->notes,
            ],
            'editable' => $this->isEditable($appointment),
        ];
    }

    /**
     * Format the event title
     *
     * @param  Appointment  $appointment
     * @return string
     */
    protected function formatEventTitle(Appointment $appointment): string
    {
        $parts = [];
        
        if ($appointment->patient) {
            $parts[] =  $appointment->patient->full_name;
        }
        
        if ($appointment->type) {
            $parts[] = $appointment->type->getLabel();
        }
        
        if ($appointment->emergency) {
            $parts[] = '🚨 ' . __('saluteora::app.emergency');
        }
        
        if ($appointment->status !== \Modules\SaluteOra\Enums\AppointmentStatusEnum::CONFIRMED) {
            $parts[] = '(' . $appointment->status->getLabel() . ')';
        }
        
        return implode(' • ', $parts);
    }

    /**
     * Get event color based on appointment properties
     *
     * @param  Appointment  $appointment
     * @return string
     */
    protected function getEventColor(Appointment $appointment): string
    {
        if ($appointment->emergency) {
            return '#dc3545'; // Red for emergencies
        }
        
        return match ($appointment->type) {
            AppointmentTypeEnum::CONSULTATION->value => '#fd7e14',
            AppointmentTypeEnum::CLEANING->value => '#17a2b8',
            AppointmentTypeEnum::TREATMENT->value => '#28a745',
            AppointmentTypeEnum::EMERGENCY->value => '#dc3545',
            AppointmentTypeEnum::FOLLOWUP->value => '#ffc107',
            AppointmentTypeEnum::SURGERY->value => '#6f42c1',
            AppointmentTypeEnum::ORTHODONTICS->value => '#6f42c1',
            AppointmentTypeEnum::PREVENTION->value => '#17a2b8',
            default => '#3490dc',
        };
    }

    /**
     * Get contrast color (black or white) for text
     *
     * @param  string  $hexColor
     * @return string
     */
    protected function getContrastColor(string $hexColor): string
    {
        $hexColor = ltrim($hexColor, '#');
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        return $luminance > 0.5 ? '#000000' : '#ffffff';
    }

    /**
     * Check if appointment is editable by current user
     *
     * @param  Appointment  $appointment
     * @return bool
     */
    protected function isEditable(Appointment $appointment): bool
    {
        $user = Auth::user();
        
        if (!$user) {
            return false;
        }

        // Only allow editing if the appointment is not in the past
        // and the user is the assigned doctor or has admin rights
        return $appointment->starts_at->isFuture() && 
               ($user->type === UserTypeEnum::ADMIN || 
                $user->id === $appointment->doctor_id);
    }
}
