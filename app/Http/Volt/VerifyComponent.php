<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt;

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Webmozart\Assert\Assert;

/**
 * Summary of VerifyComponent.
 *
 * @see https://github.com/thedevdojo/genesis/blob/main/stubs/class/resources/views/pages/auth/verify.blade.php
 */
class VerifyComponent extends Component
{
    public function resend(): void
    {
        /*
<<<<<<< HEAD
         * if (auth()->user()->hasVerifiedEmail()) {
         * return redirect()->intended(route('dashboard'));
         * }
         *
         * auth()->user()->sendEmailVerificationNotification();
         *
         * return back()->with('status', 'verification-link-sent');
         */
=======
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        auth()->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
        */
>>>>>>> bc33217 (.)
        Assert::notNull($user = auth()->user());
        if ($user->hasVerifiedEmail()) {
            redirect('/');
        }

        $user->sendEmailVerificationNotification();

<<<<<<< HEAD
        // Cast to MustVerifyEmail for the Verified event
        if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail) {
            event(new Verified($user));
        }
=======
        event(new Verified($user));
>>>>>>> bc33217 (.)

        $this->dispatch('resent');
        session()->flash('resent');
    }
}
