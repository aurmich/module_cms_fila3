<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\Models\User;

class PendingToActive extends Transition
{
    public function __construct(
        public User $user,
        public ?string $message=''
    ) {

    }

    public function handle(): User
    {
        // Additional logic before transition can be added here
        $this->user->state = new Active($this->user);
        $this->user->save();

        return $this->user;
    }
}
