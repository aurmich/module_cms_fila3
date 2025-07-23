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
    /** @var string */
    public static $name = 'confirmed';

}