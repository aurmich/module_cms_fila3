<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\IntegrationCompleted;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\States\User\Pending;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Notifications\RecordNotification;
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
        $password=Str::random(10);
        $user->update(['password'=>$password]);
        return [
            'message' => $this->message,
            'password' => $password,
        ];
    }
} 