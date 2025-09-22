<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt\Password;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

/**
 * @see https://github.com/thedevdojo/genesis/blob/main/stubs/class/resources/views/pages/auth/password/reset.blade.php
 */
#[Layout('cms::layouts.auth')]
class ResetComponent extends Component
{
    #[Validate('required|email')]
<<<<<<< HEAD
    public null|string $email = null;
=======
    public ?string $email = null;
>>>>>>> bc33217 (.)

    /**
     * Summary of emailSentMessage.
     *
     * @var bool|string
     */
    public $emailSentMessage = false;

    public function sendResetPasswordLink(): void
    {
        $this->validate();

        $response = Password::broker()->sendResetLink(['email' => $this->email]);

<<<<<<< HEAD
        if (Password::RESET_LINK_SENT === $response) {
=======
        if (Password::RESET_LINK_SENT == $response) {
>>>>>>> bc33217 (.)
            $this->emailSentMessage = trans($response);

            return;
        }

        $this->addError('email', trans($response));
    }
}
