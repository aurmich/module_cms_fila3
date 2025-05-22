<?php

namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\IntegrationRequested;
use Modules\SaluteOra\Models\User;

class PendingToIntegrationRequested extends Transition
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): User
    {
        $this->user->state = new IntegrationRequested($this->user);
        $this->user->save();

        return $this->user;
    }
}
