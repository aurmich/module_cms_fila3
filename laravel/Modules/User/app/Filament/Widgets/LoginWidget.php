<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form as FilamentForm;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * LoginWidget: Widget di login conforme alle regole Windsurf/Xot.
 * - Estende XotBaseWidget
 * - Usa solo componenti Filament importati
 * - Validazione e sicurezza integrate
 * - Facilmente estendibile (2FA, captcha, login social)
 *
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
    /** @phpstan-ignore-next-line property.defaultValue */
    protected static string $view = 'pub_theme::filament.widgets.auth.login';
    
   
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
     * Get the form schema for the login form.
     *
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->required()
                ->autofocus(),
            TextInput::make('password')
                ->password()
                ->required(),
            Toggle::make('remember')
            ->visible(false),
        ];
    }

    /**
     * Get the form model.
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected function getFormModel(): ?\Illuminate\Database\Eloquent\Model
    {
        return null;
    }
    
    /**
     * Get the form fill data.
     *
     * @return array<string, mixed>
     */
    public function getFormFill(): array
    {
        return [
            'email' => old('email'),
            'remember' => true,
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
            $attempt_data =Arr::only($data,['email','password']);
            
            if (!Auth::attempt($attempt_data, $remember)) {
                throw ValidationException::withMessages([
                    'email' => [__('Le credenziali fornite non sono corrette.')],
                ]);
            }

            session()->regenerate();
            
            Notification::make()
                ->title('Accesso effettuato con successo')
                ->success()
                ->send();
                
            $this->redirect(route('home'));
            
        } catch (ValidationException $e) {
            Notification::make()
                ->title('Errore di validazione')
                ->body($e->getMessage())
                ->danger()
                ->send();
                
            $this->form->fill();
            $this->form->saveRelationships();
            //$this->form->callAfter();
            
            foreach ($e->errors() as $field => $messages) {
                $this->form->getComponent($field)?->getContainer()->getParentComponent()?->getStatePath()
                    ? $this->addError($field, implode(' ', $messages))
                    : $this->addError('email', implode(' ', $messages));
            }
            
        } catch (Exception $e) {
            report($e);
            
            Notification::make()
                ->title('Errore durante il login')
                ->body(__('Si è verificato un errore durante il login. Riprova più tardi.'))
                ->danger()
                ->send();
                
            $this->form->fill();
            $this->form->saveRelationships();
            //$this->form->callAfter();
            
            $this->addError('email', __('Si è verificato un errore durante il login. Riprova più tardi.'));
        }
    }
    

}
