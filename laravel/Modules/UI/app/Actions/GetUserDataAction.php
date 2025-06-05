<?php

namespace Modules\UI\Actions;

use Illuminate\Support\Facades\Auth;
use Modules\UI\Data\UserData;
use Spatie\QueueableAction\QueueableAction;

class GetUserDataAction
{
    use QueueableAction;

    public function execute(): UserData
    {
        $user = Auth::user();

        return new UserData(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            avatar: $user->avatar,
            role: $user->role,
            permissions: $user->permissions,
            settings: $user->settings
        );
    }
} 