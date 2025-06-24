<?php
<<<<<<< HEAD
<<<<<<< HEAD
=======

>>>>>>> aurmich/dev
=======

>>>>>>> a3f7230 (.)
declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

<<<<<<< HEAD
<<<<<<< HEAD
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
=======
>>>>>>> aurmich/dev
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Modules\User\Models\User;
<<<<<<< HEAD
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput as FormsTextInput;

class RegisterWidget extends XotBaseWidget 
{
    protected static string $view = 'user::widgets.auth.register-widget';
    
    public function getFormSchema(): array
    {
        return [
            Form\Components\TextInput::make('name')
                ->label('Nome')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->required()
                ->minLength(8),
        ];
    }

    public ?array $data = [];

=======
=======
use Filament\Forms\Form;
use Modules\User\Models\User;
>>>>>>> a3f7230 (.)
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\Rules\Password;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Register widget for user registration functionality.
 *
 * @property ComponentContainer $form
 */
class RegisterWidget extends XotBaseWidget
{
    /**
     * The view for this widget.
     *
     * @var view-string
     */
    protected static string $view = 'user::widgets.auth.register-widget';
<<<<<<< HEAD
    

=======
>>>>>>> a3f7230 (.)

    /**
     * Widget data array.
     * 
     * CRITICAL: Do not remove or redeclare this property - it's managed by XotBaseWidget.
     *
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    /**
     * Get the form schema for this widget.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->autocomplete('name'),
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->unique(table: User::class)
                ->autocomplete('email'),
            'password' => TextInput::make('password')
                ->password()
                ->required()
                ->rule(Password::default())
                ->autocomplete('new-password'),
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->same('password')
                ->autocomplete('new-password'),
        ];
    }

    /**
     * Mount the widget and initialize the form.
     *
     * @return void
     */
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
    public function mount(): void
    {
        $this->form->fill();
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> a3f7230 (.)
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
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->autocomplete('name'),

                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(table: User::class)
                            ->autocomplete('email'),

                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->rule(Password::default())
                            ->autocomplete('new-password'),

                        TextInput::make('password_confirmation')
                            ->password()
                            ->required()
                            ->same('password')
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
    public function register(): void
=======
=======
>>>>>>> a3f7230 (.)
    /**
     * Handle user registration.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(): \Illuminate\Http\RedirectResponse
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
    {
        $data = $this->form->getState();

        $user = User::create([
<<<<<<< HEAD
<<<<<<< HEAD
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
=======
            'name' => (string) $data['name'],
            'email' => (string) $data['email'], 
            'password' => Hash::make((string) $data['password']),
>>>>>>> aurmich/dev
=======
            'name' => (string) $data['name'],
            'email' => (string) $data['email'], 
            'password' => Hash::make((string) $data['password']),
>>>>>>> a3f7230 (.)
        ]);

        Auth::login($user);

<<<<<<< HEAD
<<<<<<< HEAD
        redirect()->intended(route('dashboard'));
=======
        return redirect()->intended(route('dashboard'));
>>>>>>> aurmich/dev
=======
        return redirect()->intended(route('dashboard'));
>>>>>>> a3f7230 (.)
    }
}
