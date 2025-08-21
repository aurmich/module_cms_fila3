<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment\Transitions;

use Modules\Notify\Datas\RecordNotificationData;
use Modules\SaluteOra\Models\Appointment;
use Webmozart\Assert\Assert;

/**
 * Transition from Rejected to Confirmed state.
 *
 * This transition is used when a previously rejected appointment
 * is reconsidered and confirmed by the medical staff or patient.
 * Common scenarios:
 * - Doctor reconsiders a rejected appointment
 * - Patient provides additional required information
 * - Administrative review reverses the rejection decision
 *
 * @property Appointment $record
 */
class ReportCompletedToRefundPending extends BaseTransition
{
    // --- (Funziona automaticamente grazie al pattern BaseTransition!)
    public function getNotificationRecipients(): array
    {
        $record = $this->record;
        // Assert::isInstanceOf($record, Appointment::class);

        return [
            // 'patient_mail' => RecordNotificationData::from(['record' => $record->patient, 'channel' => 'mail']),
            'doctor_mail' => RecordNotificationData::from(['record' => $record->doctor, 'channel' => 'mail']),
        ];
    }
}
