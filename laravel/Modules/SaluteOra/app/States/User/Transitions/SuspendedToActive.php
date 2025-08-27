<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Illuminate\Support\Str;
use Modules\SaluteOra\Models\User;
use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\Suspended;
use Modules\Notify\Datas\RecordNotificationData;
use Modules\User\Actions\User\GetNewPasswordAction;

class SuspendedToActive extends BaseTransition
{
    //---

    public function getNotificationData(): array{
        $user=$this->record;
        $password=app(GetNewPasswordAction::class)->execute($user);
        return [
            'message' => $this->message,
            'password' => $password,
        ];
    }


     /**
     * @return  array<string, RecordNotificationData>
     */
    public function getNotificationRecipients(): array
    {
        $record=$this->record;
        //dddx($record->type==UserTypeEnum::PATIENT);
        return [
            // 'me' => $this->record,
            'me_sms' => RecordNotificationData::from(['record' => $record, 'channel' => 'sms']),
            'me_mail' => RecordNotificationData::from(['record' => $record, 'channel' => 'mail']),
            // 'patient' => $this->record->patient,
            // 'doctor' => $this->record->doctor,
            // 'patient_mail' => RecordNotificationData::from(['record' => $record->patient, 'channel' => 'mail']),
            // 'doctor_mail' => RecordNotificationData::from(['record' => $record->doctor, 'channel' => 'mail']),
        ];
    }
}
