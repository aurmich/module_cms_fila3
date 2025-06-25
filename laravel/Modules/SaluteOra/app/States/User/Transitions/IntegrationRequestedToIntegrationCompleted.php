<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\IntegrationRequested;
use Modules\SaluteOra\States\User\IntegrationCompleted;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\Active;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Notifications\RecordNotification;


/**
 * Transizione da IntegrationRequested a IntegrationCompleted.
 * 
 * Questa transizione avviene quando l'utente ha fornito tutti i dati richiesti
 * per completare l'integrazione delle informazioni mancanti.
 */
class IntegrationRequestedToIntegrationCompleted extends BaseTransition
{
   //---
} 