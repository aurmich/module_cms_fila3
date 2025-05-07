<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt;

use Illuminate\Auth\Events\Verified;
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
use Illuminate\Contracts\Auth\MustVerifyEmail;
>>>>>>> origin/dev
>>>>>>> feb96d7 (.)
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Webmozart\Assert\Assert;

/**
 * Componente per la verifica dell'email dell'utente.
 *
 * @see https://github.com/thedevdojo/genesis/blob/main/stubs/class/resources/views/pages/auth/verify.blade.php
 */
class VerifyComponent extends Component
{
    /**
     * Reinvia l'email di verifica.
     */
    public function resend(): void
    {
        Assert::notNull($user = auth()->user());
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
        Assert::isInstanceOf($user, MustVerifyEmail::class);
<<<<<<< HEAD
>>>>>>> origin/dev
>>>>>>> feb96d7 (.)
=======

>>>>>>> f1c9277 (.)
        if ($user->hasVerifiedEmail()) {
            redirect('/');
        }

        $user->sendEmailVerificationNotification();

        event(new Verified($user));

        $this->dispatch('resent');
        session()->flash('resent');
    }
}
