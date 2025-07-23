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
    /** @var string */
    public static string $name = 'completed';

}