<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\Suspended;
use Modules\SaluteOra\Models\User;

class ActiveToSuspended extends Transition
{
    public User $user;
    public ?string $message;
    public function __construct(User $user, ?string $message='') {
        $this->user = $user;
        $this->message = $message;
    }

    public function handle(): User
    {

        $this->user->state = new Suspended($this->user);
        $this->user->save();
        return $this->user;
    }
}
