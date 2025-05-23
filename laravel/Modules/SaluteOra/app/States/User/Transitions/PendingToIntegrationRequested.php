<?php

namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\IntegrationRequested;
use Modules\SaluteOra\Models\User;

class PendingToIntegrationRequested extends Transition
{
    private User $user;
    private ?string $message;

    public function __construct(User $user,?string $message='')
    {
        $this->user = $user;
        $this->message = $message;
    }

    public function handle(): User
    {
        $this->user->state = new IntegrationRequested($this->user);
        $this->user->save();

        return $this->user;
    }
}
