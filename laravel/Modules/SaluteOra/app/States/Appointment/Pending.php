<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents an appointment that is pending confirmation.
 *
 * This is the default state for newly requested appointments.
 */
class Pending extends AppointmentState
{
    /** @var string */
    public static $name = 'pending';

} 