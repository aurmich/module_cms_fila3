<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Logout widget for user logout functionality.
 */
class LogoutWidget extends XotBaseWidget
{
    /**
     * Blade view del widget.
     * IMPORTANTE: quando il widget viene usato con @livewire() direttamente nelle Blade,
     * il path deve essere senza il namespace del modulo.
     */
    /** @phpstan-ignore-next-line */
    protected static string $view = 'user::widgets.logout';

    /**
     * Widget data array.
     * 
     * CRITICAL: Do not remove or redeclare this property - it's managed by XotBaseWidget.
     *
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    /**
     * Stato del widget.
     */
    public bool $isLoggingOut = false;

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
     * Implementazione del metodo astratto getFormSchema.
     * NON sovrascrivere il metodo form() che è dichiarato come final.
     *
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'message' => View::make('filament.widgets.auth.logout-message')
                ->columnSpanFull(),
        ];
    }

    /**
     * Azione di logout.
     * Gestisce il logout dell'utente con eventi, logging e reindirizzamento localizzato.
     *
     * @return void
     */
    public function logout(): void
    {
        try {
            $this->isLoggingOut = true;

            // Ottieni l'utente prima del logout per il logging
            $user = Auth::user();

            if (!$user) {
                $this->isLoggingOut = false;
                return;
            }

            // Evento pre-logout
            Event::dispatch('auth.logout.attempting', [$user]);

            // Esegui il logout
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            // Evento post-logout
            Event::dispatch('auth.logout.successful');

            // Log dell'operazione
            Log::info('Utente disconnesso', [
                'user_id' => $user->id,
                'timestamp' => now()
            ]);

            // Reindirizzamento con localizzazione
            $locale = app()->getLocale();
            redirect()->to('/' . $locale)
                ->with('success', __('Logout effettuato con successo'));

        } catch (\Exception $e) {
            Log::error('Errore durante il logout: ' . $e->getMessage());
            $this->isLoggingOut = false;
            session()->flash('error', __('Errore durante il logout'));
        }
    }

    /**
     * Azioni del form.
     *
     * @return array<string, Action>
     */
    public function getFormActions(): array
    {
        return [
            'logout' => Action::make('logout')
                ->color('danger')
                ->size('lg')
                ->extraAttributes(['class' => 'w-full justify-center'])
                ->action(fn () => $this->logout()),
            'cancel' => Action::make('cancel')
                ->color('gray')
                ->size('lg')
                ->extraAttributes(['class' => 'w-full justify-center mt-2'])
                ->url(function (): string {
                    $locale = app()->getLocale();
                    return '/' . $locale;
                }),
        ];
    }

    /**
     * Get view data for the widget.
     *
     * @return array<string, string>
     */
    protected function getViewData(): array
    {
        return [
            'title' => __('Logout'),
            'description' => __('Sei sicuro di voler uscire?'),
        ];
    }
}
