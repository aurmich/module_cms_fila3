<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment\Transitions;

use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
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
        $record=$this->record;
        Assert::isInstanceOf($record, Appointment::class);
        return [
            'patient' => $record->patient,
            //'doctor' => $record->doctor,
        ];
    }

    
        
    
    public function getNotificationData(): array
    {
        $record=$this->record;
        Assert::isInstanceOf($record, Appointment::class);
        return [
            'message' => $this->message,
            'appointment_date' => $record->starts_at?->format('d/m/Y H:i') ?? 'N/A',
            'patient_name' => $record->patient->name ?? 'N/A',
            'doctor_name' => $record->doctor->name ?? 'N/A',
        ];
    }
} 