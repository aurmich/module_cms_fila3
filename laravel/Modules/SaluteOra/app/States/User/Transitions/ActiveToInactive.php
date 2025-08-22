<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Modules\SaluteOra\Models\User;
use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\Inactive;
use Modules\Notify\Datas\RecordNotificationData;

/**
 * @property \Modules\SaluteOra\Models\User $record
 */
class ActiveToInactive extends BaseTransition
{
    //---

    /**
     * @return  array<string, RecordNotificationData>
     */
    public function getNotificationRecipients(): array
    {
        return [
            // 'me' => $this->record,
            //'me_mail' => RecordNotificationData::from(['record' => $this->record, 'channel' => 'mail']),
            'me_sms' => RecordNotificationData::from(['record' => $this->record, 'channel' => 'sms']),
            // 'patient' => $this->record->patient,
            // 'doctor' => $this->record->doctor,
            // 'patient_mail' => RecordNotificationData::from(['record' => $record->patient, 'channel' => 'mail']),
            // 'doctor_mail' => RecordNotificationData::from(['record' => $record->doctor, 'channel' => 'mail']),
        ];
    }
}
