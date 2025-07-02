<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Inactive;
use Modules\SaluteOra\Models\User;

class ToInactive extends Transition
{
    public function __construct(
        public User $user
    ) {
    }

    public function handle(): User
    {
        // Additional logic before transition can be added here
        $this->user->state = new Inactive($this->user);
        $this->user->save();

        return $this->user;
    }
}
