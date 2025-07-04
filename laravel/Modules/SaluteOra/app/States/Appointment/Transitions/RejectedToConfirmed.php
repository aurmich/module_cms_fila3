<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment\Transitions;

/**
 * Transition from Rejected to Confirmed state.
 *
 * This transition is used when a previously rejected appointment 
 * is reconsidered and confirmed by the medical staff or patient.
 * Common scenarios:
 * - Doctor reconsiders a rejected appointment
 * - Patient provides additional required information
 * - Administrative review reverses the rejection decision
 */
class RejectedToConfirmed extends BaseTransition
{
    //--- (Funziona automaticamente grazie al pattern BaseTransition!)
}
