<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

/**
 * Transizione da IntegrationCompleted a IntegrationRequested.
 * 
 * Questa transizione avviene quando durante la verifica si scopre che servono
 * ulteriori documenti, correzioni o chiarimenti da parte dell'utente.
 */
class IntegrationCompletedToIntegrationRequested extends BaseTransition
{
    //---
} 