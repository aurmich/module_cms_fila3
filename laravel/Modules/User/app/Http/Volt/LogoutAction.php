<?php

declare(strict_types=1);

namespace Modules\User\Http\Volt;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Volt\Routing\Attribute\Post;
<<<<<<< HEAD
<<<<<<< HEAD

#[Post('/logout', name: 'logout', middleware: ['web', 'auth'])]
=======
=======
>>>>>>> a3f7230 (.)
/*
Attribute class Volt\Routing\Attribute\Post does not exist.

#[Post('/logout', name: 'logout', middleware: ['web', 'auth'])]
*/
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
final class LogoutAction
{
    public function __invoke(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('home');
    }
}
