<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents a confirmed appointment.
 *
 * The appointment has been confirmed by both parties.
 */
class Confirmed extends AppointmentState
{
    public static $name = 'confirmed';

    public function label(): string
    {
        return 'Confermato';
    }

    public function color(): string
    {
        return 'success';
    }

    public function icon(): string
    {
        return 'heroicon-o-check-circle';
    }

    public function canBeModified(): bool
    {
        return true;
    }

    public function isActive(): bool
    {
        return true;
    }
}