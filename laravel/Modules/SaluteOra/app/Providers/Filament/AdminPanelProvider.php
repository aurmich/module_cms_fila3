<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Providers\Filament;

use Filament\Panel;
use Illuminate\Http\Request;
use LaraZeus\Bolt\BoltPlugin;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Config;
use Modules\SaluteOra\Enums\UserTypeEnum;

use Filament\Http\Middleware\Authenticate;
use Filament\SpatieLaravelTranslatablePlugin;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Modules\UI\Actions\Panel\ApplyCalendarToPanelAction;
use Modules\Xot\Actions\Panel\ApplyTenancyToPanelAction;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Modules\SaluteOra\Filament\Widgets\AdminCalendarWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Modules\SaluteOra\Filament\Widgets\DoctorCalendarWidget;
use Modules\SaluteOra\Filament\Widgets\PatientCalendarWidget;
use Modules\SaluteOra\Actions\Panel\ApplyDoctorTenancyToPanelAction;
use Illuminate\Auth\Middleware\Authenticate as MiddlewareAuthenticate;

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
        $panel = parent::panel($panel);
       
        // Applica tenancy e calendar
        $panel = app(ApplyTenancyToPanelAction::class)->execute($panel);
        $panel = app(ApplyCalendarToPanelAction::class)->execute($panel);
        /*
        $defaultLocale=Config::string('app.locale');
        
        $spatieLaravelTranslatablePlugin = SpatieLaravelTranslatablePlugin::make();//->defaultLocales([config('app.locale')]);
        $boltPlugin = BoltPlugin::make();

        $plugins = [
            $spatieLaravelTranslatablePlugin,
            $boltPlugin
        ];
        
        $panel->plugins($plugins);
        */
        return $panel;
    }



}
