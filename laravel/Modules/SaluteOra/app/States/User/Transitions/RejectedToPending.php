<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Rejected;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\Models\User;

class RejectedToPending extends BaseTransition
{
    //---
}
