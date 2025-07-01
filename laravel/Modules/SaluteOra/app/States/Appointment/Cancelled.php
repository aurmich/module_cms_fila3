<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents a cancelled appointment.
 *
 * The appointment has been cancelled by either party.
 */
class Cancelled extends AppointmentState
{
    /** @var string */
    public static $name = 'cancelled';

    public function label(): string
    {
        return 'Annullato';
    }

    public function color(): string
    {
        return 'danger';
    }

    public function icon(): string
    {
        return 'heroicon-o-x-circle';
    }

    public function isCancelled(): bool
    {
        return true;
    }
}