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
 * Reset password widget for user password reset functionality.
 *
 * @property ComponentContainer $form
 */
class ResetPasswordWidget extends XotBaseWidget
{
    /**
     * The view for this widget.
     *
     * @var view-string
     */
    protected static string $view = 'user::widgets.auth.reset-password-widget';

    /**
     * Widget data array.
     * 
     * CRITICAL: Do not remove or redeclare this property - it's managed by XotBaseWidget.
     *
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    /**
     * Get the form schema for password reset.
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

    /**
     * Mount the widget and initialize the form.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * Configure the form for this widget.
     *
     * @param \Filament\Forms\Form $form
     * @return \Filament\Forms\Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema($this->getFormSchema())
                    ->columns(1),
            ])
            ->statePath('data');
    }

    /**
     * Handle password reset.
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function resetPassword()
    {
        $data = $this->form->getState();

        $status = Password::reset(
            [
                'email' => (string) $data['email'],
                'password' => (string) $data['password'],
                'password_confirmation' => (string) $data['password_confirmation'],
                'token' => (string) request()->route('token'),
            ],
            function ($user, $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', __((string) $status));
            return redirect()->route('login');
        } else {
            $this->addError('email', __((string) $status));
        }
    }
}
