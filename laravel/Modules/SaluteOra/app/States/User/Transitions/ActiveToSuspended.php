<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\Suspended;
use Modules\SaluteOra\Models\User;

/**
 * @property \Modules\SaluteOra\Models\User $record
 */
class ActiveToSuspended extends BaseTransition
{
    //---
}
