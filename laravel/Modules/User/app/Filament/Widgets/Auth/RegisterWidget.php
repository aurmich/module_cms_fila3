<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Form;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Modules\User\Models\User;
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
     * Handle user registration.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(): \Illuminate\Http\RedirectResponse
    {
        $data = $this->form->getState();

        $user = User::create([
            'name' => (string) $data['name'],
            'email' => (string) $data['email'],
            'password' => Hash::make((string) $data['password']),
        ]);

        Auth::login($user);

        return redirect()->intended(route('dashboard'));
    }
}
