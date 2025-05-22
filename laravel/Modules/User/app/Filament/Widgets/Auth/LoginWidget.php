<?php
declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class LoginWidget extends XotBaseWidget
{
    public ?array $data = [];

    protected static string $view = 'user::filament.widgets.auth.login';

    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('email')
                ->label(__('user::auth.email'))
                ->email()
                ->required(),

            Forms\Components\TextInput::make('password')
                ->label(__('user::auth.password'))
                ->password()
                ->required(),

            Forms\Components\Checkbox::make('remember')
                ->label(__('user::auth.remember_me')),
        ];
    }

    public function login(): void
    {
        $data = $this->form->getState();

        if (Auth::attempt($data)) {
            session()->regenerate();
            redirect()->intended(route('filament.admin.pages.dashboard'));
        }

        $this->addError('email', __('auth.failed'));
    }
}
