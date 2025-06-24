<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Exception;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Layout;
use Filament\Forms\Components\TextInput as FormsTextInput;
use Filament\Forms\Components\Checkbox as FormsCheckbox;

/**
 * LoginWidget: Widget di login conforme alle regole Windsurf/Xot.
 * - Estende XotBaseWidget
 * - Usa solo componenti Filament importati
 * - Validazione e sicurezza integrate
 * - Facilmente estendibile (2FA, captcha, login social)
 *
 * @property-read static string $view La view del widget segue il pattern {module}::filament.widgets.{type}
 * @property array<string, mixed>|null $data
 */
class LoginWidget extends XotBaseWidget
{
    /**
     * Blade view del widget nel modulo User.
     * IMPORTANTE: quando il widget viene usato con @livewire() direttamente nelle Blade,
     * il path deve essere senza il namespace del modulo (senza "user::").
     * 
     * @see \Modules\User\docs\WIDGETS_STRUCTURE.md - Sezione B
     * @var view-string
     */
    protected static string $view = 'user::filament.widgets.login';
    
    /** @var int|string|array<string, mixed> */
    protected int | string | array $columnSpan = 'full';
    
    /**
     * Dati del form per il login
     *
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    /**
     * Inizializza il widget quando viene montato.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * Definisce lo schema del form di login.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autofocus(),
            'password' => TextInput::make('password')
                ->password()
                ->required(),
            'remember' => Toggle::make('remember')
                ->label('Ricordami'),
        ];
    }

    /**
     * Handle login form submission.
     *
     * @return void
     */
    public function save(): void
    {
        try {
            $data = $this->form->getState();
            
            // Cast esplicito per type safety PHPStan
            $remember = (bool) ($data['remember'] ?? false);
            
            if (!Auth::attempt([
                'email' => (string) $data['email'],
                'password' => (string) $data['password']
            ], $remember)) {
                throw ValidationException::withMessages([
                    'email' => [__('Le credenziali fornite non sono corrette.')],
                ]);
            }

            session()->regenerate();
            
            redirect()->intended(route('home'));
        } catch (ValidationException $e) {
            $this->addError('email', $e->getMessage());
        } catch (Exception $e) {
            report($e);
            $this->addError('email', __('Si è verificato un errore durante il login. Riprova più tardi.['.$e->getMessage().']'));
        }
    }
}
