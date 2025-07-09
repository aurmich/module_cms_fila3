<?php
declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\ComponentContainer;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * @property ComponentContainer $form
 */
class LoginWidget extends XotBaseWidget
{
    public ?array $data = [];

    protected static string $view = 'pub_theme::filament.widgets.auth.login';

    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('email')
                ->email()
                ->required(),

            Forms\Components\TextInput::make('password')
                ->password()
                ->required(),

            Forms\Components\Checkbox::make('remember')
                ,
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
