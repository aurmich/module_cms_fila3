<?php

namespace Modules\UI\Actions;

use Illuminate\Support\Facades\Auth;
use Modules\UI\Data\UserData;
use Spatie\QueueableAction\QueueableAction;

class GetUserDataAction
{
    use QueueableAction;

    public function execute(): ?UserData
    {
        $user = Auth::user();
        
        if ($user === null) {
            return null;
        }

        return new UserData(
            id: $user->id ?? null,
            name: $user->name ?? null,
            email: $user->email ?? null,
            avatar: $user->avatar ?? null,
            role: $user->role ?? null,
            permissions: $user->permissions->toArray() ?? null,
            //settings: is_array($user->settings) ? $user->settings : ($user->settings?->toArray() ?? null)
            settings:  null
        );
    }
} 