<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Illuminate\Support\Str;
use Modules\SaluteOra\Models\User;
use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\Pending;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Datas\RecordNotificationData;
use Modules\User\Actions\User\GetNewPasswordAction;
use Modules\Notify\Notifications\RecordNotification;
use Modules\SaluteOra\States\User\IntegrationCompleted;
use Modules\SaluteOra\States\User\IntegrationRequested;

/**
 * Transizione da IntegrationCompleted a Active.
 * 
 * Questa transizione avviene quando l'amministratore approva l'utente
 * che ha completato l'integrazione dei dati richiesti.
 */
class IntegrationCompletedToActive extends BaseTransition
{
   

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