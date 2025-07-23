<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents a rejected appointment.
 *
 * The appointment has been rejected by the medical staff.
 */
class Rejected extends AppointmentState
{
    /** @var string */
    public static string $name = 'rejected';

}
