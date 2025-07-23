<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents a cancelled appointment.
 *
 * The appointment has been cancelled by either party.
 */
class RefundAccepted extends AppointmentState
{
    /** @var string */
    public static $name = 'refund_accepted';

}