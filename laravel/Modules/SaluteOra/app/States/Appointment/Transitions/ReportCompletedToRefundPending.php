<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment\Transitions;

use Webmozart\Assert\Assert;
use Modules\SaluteOra\Models\Appointment;

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
class ReportCompletedToRefundPending extends BaseTransition
{
    //--- (Funziona automaticamente grazie al pattern BaseTransition!)
    public function getNotificationRecipients(): array
    {
        $record=$this->record;
        Assert::isInstanceOf($record, Appointment::class);
        return [
            'doctor' => $record->doctor,
        ];
    }
}
