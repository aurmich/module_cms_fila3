<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Events;

use Modules\SaluteOra\Models\User;
use Illuminate\Queue\SerializesModels;
use Modules\SaluteOra\States\User\UserState;
use Illuminate\Foundation\Events\Dispatchable;

class UserStateChanged
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public User $user,
        public UserState $oldState,
        public UserState $newState
    ) {}
} 