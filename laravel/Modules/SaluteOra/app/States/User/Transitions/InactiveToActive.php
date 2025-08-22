<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Illuminate\Support\Str;
use Modules\SaluteOra\Models\User;
use Spatie\ModelStates\Transition;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\Inactive;
use Modules\Notify\Datas\RecordNotificationData;

/**
 * @property \Modules\SaluteOra\Models\User $record
 */
class InactiveToActive extends BaseTransition
{
   //---
   public function getNotificationData(): array{
      $user=$this->record;
      $password=Str::random(10);
      $user->update(['password'=>$password]);
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
            'me_mail' => RecordNotificationData::from(['record' => $record, 'channel' => 'mail']),
            'me_sms' => RecordNotificationData::from(['record' => $record, 'channel' => 'sms']),
            // 'patient' => $this->record->patient,
            // 'doctor' => $this->record->doctor,
            // 'patient_mail' => RecordNotificationData::from(['record' => $record->patient, 'channel' => 'mail']),
            // 'doctor_mail' => RecordNotificationData::from(['record' => $record->doctor, 'channel' => 'mail']),
        ];
    }
}
