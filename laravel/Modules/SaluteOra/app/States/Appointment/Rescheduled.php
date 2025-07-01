<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents a rescheduled appointment.
 *
 * The appointment has been moved to a new date/time.
 */
class Rescheduled extends AppointmentState
{
    /** @var string */
    public static $name = 'rescheduled';

    public function label(): string
    {
        return 'Riprogrammato';
    }

    public function color(): string
    {
        return 'info';
    }

    public function icon(): string
    {
        return 'heroicon-o-arrow-path';
    }

    public function canBeModified(): bool
    {
        return true;
    }
} 