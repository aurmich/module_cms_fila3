<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\Suspended;
use Modules\SaluteOra\Models\User;

class ActiveToSuspended extends Transition
{
    public function __construct(public User $user) {}

    public function handle(): User
    {
        $this->user->state = new Suspended($this->user);
        $this->user->save();
        return $this->user;
    }
}
