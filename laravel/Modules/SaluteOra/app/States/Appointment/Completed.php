<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents a completed appointment.
 *
 * The appointment has been successfully conducted and finished.
 * This is a final state with no further transitions.
 */
class Completed extends AppointmentState
{
    public static $name = 'completed';

    public function label(): string
    {
        return 'Completato';
    }

    public function color(): string
    {
        return 'success';
    }

    public function icon(): string
    {
        return 'heroicon-o-check-badge';
    }

    public function isCompleted(): bool
    {
        return true;
    }
}