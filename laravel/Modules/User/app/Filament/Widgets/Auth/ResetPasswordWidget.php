<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Password;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * @property ComponentContainer $form
 */
class ResetPasswordWidget extends XotBaseWidget
{
    protected static string $view = 'user::widgets.auth.reset-password-widget';

    /**
     * Get the form schema for this widget.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autocomplete('email'),
            'password' => TextInput::make('password')
                ->password()
                ->required()
                ->minLength(8)
                ->same('password_confirmation')
                ->autocomplete('new-password'),
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->autocomplete('new-password'),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->autocomplete('email'),

                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->same('password_confirmation')
                            ->autocomplete('new-password'),

                        TextInput::make('password_confirmation')
                            ->password()
                            ->required()
                            ->autocomplete('new-password'),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    public function resetPassword(): void
    {
        $data = $this->form->getState();

        $status = Password::reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
                'token' => request()->route('token'),
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', __($status));
            redirect()->route('login');
        } else {
            $this->addError('email', __($status));
        }
    }
}
