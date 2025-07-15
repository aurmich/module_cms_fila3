<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment\Transitions;

/**
 * Transition from Pending to Rejected state.
 * 
 * This transition is used when a pending appointment is rejected by the medical staff.
 */
class RefundAcceptedToRefundCompleted extends BaseTransition
{
    // No additional logic needed as BaseTransition handles the state change
}
