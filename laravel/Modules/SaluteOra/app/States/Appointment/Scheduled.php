<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents a scheduled appointment.
 *
 * In this state, the appointment has been scheduled for a specific date/time.
 */
class Scheduled extends AppointmentState
{
    public static $name = 'scheduled';

    public function label(): string
    {
        return 'Programmato';
    }

    public function color(): string
    {
        return 'info';
    }

    public function icon(): string
    {
        return 'heroicon-o-calendar';
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