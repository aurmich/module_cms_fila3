<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment\Transitions;

/**
 * Transition from Pending to Confirmed state.
 */
class PendingToConfirmed extends BaseTransition
{
    //--- (Funziona automaticamente grazie al pattern BaseTransition!)


    
    public function getNotificationRecipients(): array
    {
        return [
            'patient' => $this->appointment->patient,
            'doctor' => $this->appointment->doctor,
        ];
    }
} 