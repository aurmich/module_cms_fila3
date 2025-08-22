<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment\Transitions;

use Modules\Notify\Datas\RecordNotificationData;

/**
 * Transition from Pending to Rejected state.
 * 
 * This transition is used when a pending appointment is rejected by the medical staff.
 */
class RefundToIntegrateToRefundCompleted extends BaseTransition
{
    // No additional logic needed as BaseTransition handles the state change

    //---
    public function getNotificationRecipients(): array
    {
        $record = $this->record;
        // Assert::isInstanceOf($record, Appointment::class);

        return [
           // 'patient_mail' => RecordNotificationData::from(['record' => $record->patient, 'channel' => 'mail']),
           // 'patient_sms' => RecordNotificationData::from(['record' => $record->patient, 'channel' => 'sms']),
           'doctor_mail' => RecordNotificationData::from(['record' => $record->doctor, 'channel' => 'mail']),
        ];
    }
}
