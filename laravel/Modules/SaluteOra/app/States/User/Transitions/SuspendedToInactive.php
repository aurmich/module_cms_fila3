<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Suspended;
use Modules\SaluteOra\States\User\Inactive;
use Modules\SaluteOra\Models\User;

class SuspendedToInactive extends BaseTransition
{
    //---
}
