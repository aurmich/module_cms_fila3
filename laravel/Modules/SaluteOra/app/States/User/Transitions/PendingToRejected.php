<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\Rejected;
use Modules\SaluteOra\Models\User;

class PendingToRejected extends Transition
{
    public function __construct(public User $user) {}

    public function handle(): User
    {
        $this->user->state = new Rejected($this->user);
        $this->user->save();
        return $this->user;
    }
}
