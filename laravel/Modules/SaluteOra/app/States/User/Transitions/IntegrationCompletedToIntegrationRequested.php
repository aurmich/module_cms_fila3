<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Modules\SaluteOra\Models\User;
use Modules\Notify\Datas\RecordNotificationData;

/**
 * Transizione da IntegrationCompleted a IntegrationRequested.
 * 
 * Questa transizione avviene quando durante la verifica si scopre che servono
 * ulteriori documenti, correzioni o chiarimenti da parte dell'utente.
 * 
 * @property User $record
 */
class IntegrationCompletedToIntegrationRequested extends BaseTransition
{
    //---
    public function getNotificationData(): array{
        $user=$this->record;
        Assert::isInstanceOf($user, User::class);
        if($user->remember_token==null){
            $user->remember_token = Str::random(40);
            $user->save();
        }

        $register_url = route('register.type',[
            'type'=>$user->type->value,
            'email'=>$user->email,
            'token'=>$user->remember_token,
        ]);

        $data = [
            'message' => $this->message,
            'register_url' => $register_url,
        ];
        return $data;
    }


     /**
     * @return  array<string, RecordNotificationData>
     */
    public function getNotificationRecipients(): array
    {
        $record=$this->record;
        //dddx($record->type==UserTypeEnum::PATIENT);
        $res= [
            // 'me' => $this->record,
            'me_sms' => RecordNotificationData::from(['record' => $record, 'channel' => 'sms']),
            'me_mail' => RecordNotificationData::from(['record' => $record, 'channel' => 'mail']),
            // 'patient' => $this->record->patient,
            // 'doctor' => $this->record->doctor,
            // 'patient_mail' => RecordNotificationData::from(['record' => $record->patient, 'channel' => 'mail']),
            // 'doctor_mail' => RecordNotificationData::from(['record' => $record->doctor, 'channel' => 'mail']),
        ];
        return $res;
    }
} 