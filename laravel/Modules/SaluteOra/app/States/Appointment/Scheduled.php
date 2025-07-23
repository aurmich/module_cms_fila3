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
    /** @var string */
    public static $name = 'scheduled';

}