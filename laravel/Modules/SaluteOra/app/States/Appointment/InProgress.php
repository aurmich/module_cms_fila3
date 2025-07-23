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
    public static string $name = 'in_progress';

}