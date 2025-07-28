<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment\Transitions;

use Illuminate\Support\Str;
use Spatie\ModelStates\Transition;
use Modules\Xot\Contracts\UserContract;
use Modules\SaluteOra\Models\Appointment;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Xot\States\Transitions\XotBaseTransition;

abstract class BaseTransition extends XotBaseTransition
{
    
    


    public function getNotificationRecipients(): array
    {
        return [
            'patient' => $this->record->patient,
            //'doctor' => $this->record->doctor,
        ];
    }

    
        
    
    public function getNotificationData(): array
    {
        return [
            'message' => $this->message,
            'appointment_date' => $this->record->starts_at?->format('d/m/Y H:i') ?? 'N/A',
            'patient_name' => $this->record->patient->name ?? 'N/A',
            'doctor_name' => $this->record->doctor->name ?? 'N/A',
        ];
    }
} 