<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\IntegrationRequested;
use Modules\SaluteOra\States\User\Rejected;
use Modules\SaluteOra\Models\User;

class IntegrationRequestedToRejected extends BaseTransition
{
    //---
}
