<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\IntegrationCompleted;
use Modules\SaluteOra\States\User\Rejected;
use Modules\SaluteOra\Models\User;

/**
 * Transizione da IntegrationCompleted a Rejected.
 * 
 * Questa transizione avviene quando l'amministratore respinge l'utente
 * dopo aver verificato i dati completati (documenti falsi, criteri non rispettati, ecc.).
 */
class IntegrationCompletedToRejected extends BaseTransition
{
   //---
} 