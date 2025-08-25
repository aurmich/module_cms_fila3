<?php

declare(strict_types=1);

namespace Modules\User\Actions\User;

use Illuminate\Support\Str;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Xot\Contracts\UserContract;

class GetNewPasswordAction
{
    public function execute(UserContract $user): string
    {
        $password=Str::random(10);
        $user->update([
            'password' => Hash::make($password),
        ]);
        return $password;
    }
}
