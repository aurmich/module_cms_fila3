<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment\Transitions;

use Webmozart\Assert\Assert;
use Modules\SaluteOra\Models\Appointment;

/**
 * Transition from Pending to Confirmed state.
 */
class PendingToConfirmed extends BaseTransition
{
    //--- (Funziona automaticamente grazie al pattern BaseTransition!)


    
    public function getNotificationRecipients(): array
    {
        $record=$this->record;
        Assert::isInstanceOf($record, Appointment::class);
        return [
            'patient' => $record->patient,
            'doctor' => $record->doctor,
        ];
    }
} 