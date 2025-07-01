<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents an appointment currently in progress.
 *
 * The appointment session has started and is actively taking place.
 */
class InProgress extends AppointmentState
{
    /** @var string */
    public static $name = 'in_progress';

    public function label(): string
    {
        return 'In corso';
    }

    public function color(): string
    {
        return 'info';
    }

    public function icon(): string
    {
        return 'heroicon-o-play-circle';
    }

    public function isActive(): bool
    {
        return true;
    }
}