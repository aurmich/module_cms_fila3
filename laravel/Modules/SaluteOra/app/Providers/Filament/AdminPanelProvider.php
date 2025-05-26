<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Illuminate\Auth\Middleware\Authenticate as MiddlewareAuthenticate;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Auth;
use Modules\SaluteOra\Enums\UserType;
use Modules\SaluteOra\Filament\Widgets\AdminCalendarWidget;
use Modules\SaluteOra\Filament\Widgets\DoctorCalendarWidget;
use Modules\SaluteOra\Filament\Widgets\PatientCalendarWidget;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

/**
 * Provider per il pannello admin di SaluteOra.
 * Configura il pannello Filament con plugin FullCalendar ottimizzato
 * per applicazioni sanitarie multi-tenant con supporto STI.
 */
class AdminPanelProvider extends XotBasePanelProvider
{
    /**
     * Nome del modulo.
     */
    protected string $module = 'SaluteOra';

    /**
     * Configura il pannello Filament.
     */
    public function panel(Panel $panel): Panel
    {
        // Configurazione pannello base
        $panel = parent::panel($panel);

        // Aggiungi configurazioni specifiche per il modulo SaluteOra
        $this->configurePanel($panel);

        return $panel;
    }

    /**
     * Configura le specifiche del pannello SaluteOra.
     */
    protected function configurePanel(Panel $panel): void
    {
        // Configura plugin FullCalendar
        $this->configureFullCalendar($panel);


        // Registra i widget specifici per ruolo utente
        //$this->registerRoleBasedWidgets($panel);
    }

    /**
     * Configura il plugin FullCalendar con le impostazioni specifiche.
     */
    protected function configureFullCalendar(Panel $panel): void
    {
        $calendarPlugin = FilamentFullCalendarPlugin::make()
            ->selectable(true)
            ->editable(true)
            ->timezone(config('fullcalendar.localization.timezone', 'Europe/Rome'))
            ->locale(config('fullcalendar.localization.locale', 'it'))
            ->plugins([
                'dayGrid',
                'timeGrid',
                'list',
                'interaction',
                'multiMonth',
                //'scrollGrid',//premium
            ]);

        // Aggiungi licenza scheduler solo se presente e valida
        $licenseKey = config('fullcalendar.scheduler_license_key');
        if ($licenseKey && is_string($licenseKey) && !empty(trim($licenseKey))) {
            $calendarPlugin->schedulerLicenseKey($licenseKey);
        }

        $panel->plugin($calendarPlugin);
    }


    /**
     * Registra i widget in base al ruolo dell'utente.
     */
    protected function registerRoleBasedWidgets(Panel $panel): void
    {
        $widgets = [
            // Widget di base per tutti gli utenti autenticati
            PatientCalendarWidget::class,
        ];

        // Aggiungi widget in base al tipo di utente
        if ($this->isUserAuthenticated()) {
            $userType = $this->getAuthenticatedUserType();

            // Widget aggiuntivi per dottori
            if ($userType === UserType::DOCTOR) {
                $widgets[] = DoctorCalendarWidget::class;
            }

            // Widget aggiuntivi per amministratori
            if ($userType === UserType::ADMIN) {
                $widgets[] = AdminCalendarWidget::class;
            }
        }

        $panel->widgets($widgets);
    }

    /**
     * Verifica se l'utente è autenticato.
     */
    protected function isUserAuthenticated(): bool
    {
        return Auth::check();
    }

    /**
     * Ottiene il tipo di utente autenticato.
     *
     * @return UserType::*|null
     */
    protected function getAuthenticatedUserType(): ?string
    {
        $user = Auth::user();
        return $user && property_exists($user, 'type') ? $user->type : null;
    }


}
