<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

<<<<<<< HEAD
<<<<<<< HEAD
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Filament\Forms;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class ResetPasswordWidget extends XotBaseWidget
{
    protected static string $view = 'user::widgets.auth.reset-password-widget';

=======
=======
>>>>>>> a3f7230 (.)
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
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
<<<<<<< HEAD
<<<<<<< HEAD
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
=======
                    ->schema($this->getFormSchema())
>>>>>>> aurmich/dev
=======
                    ->schema($this->getFormSchema())
>>>>>>> a3f7230 (.)
                    ->columns(1),
            ])
            ->statePath('data');
    }

<<<<<<< HEAD
<<<<<<< HEAD
    public function resetPassword(): void
=======
=======
>>>>>>> a3f7230 (.)
    /**
     * Handle password reset.
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function resetPassword()
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
    {
        $data = $this->form->getState();

        $status = Password::reset(
            [
<<<<<<< HEAD
<<<<<<< HEAD
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
                'token' => request()->route('token'),
            ],
            function ($user, $password) {
=======
=======
>>>>>>> a3f7230 (.)
                'email' => (string) $data['email'],
                'password' => (string) $data['password'],
                'password_confirmation' => (string) $data['password_confirmation'],
                'token' => (string) request()->route('token'),
            ],
            function ($user, $password): void {
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
<<<<<<< HEAD
<<<<<<< HEAD
            session()->flash('status', __($status));
            redirect()->route('login');
        } else {
            $this->addError('email', __($status));
        }
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('password')
                ->password()
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->maxLength(255)
                ->same('password'),
        ];
    }
=======
=======
>>>>>>> a3f7230 (.)
            session()->flash('status', __((string) $status));
            return redirect()->route('login');
        } else {
            $this->addError('email', __((string) $status));
        }
    }
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
}
