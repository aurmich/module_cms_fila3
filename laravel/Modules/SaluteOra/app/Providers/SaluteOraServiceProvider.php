<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Providers;

use Filament\Forms\Components\Component;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\SaluteOra\Filament\Widgets\SaluteOraRegistrationWizard;
use Modules\SaluteOra\Models\SaluteOra;
use Modules\SaluteOra\Models\Document;
use Modules\SaluteOra\Models\Anamnesis;
use Modules\SaluteOra\Filament\Resources\SaluteOraResource;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Modules\SaluteOra\Providers\Filament\AdminPanelProvider;
use Modules\SaluteOra\Console\Commands\CheckDirectoryStructure;
use Modules\SaluteOra\Models\User;
use Spatie\ModelStates\State;

class SaluteOraServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'SaluteOra';
    protected $moduleName = 'SaluteOra';
    protected $moduleNameLower = 'saluteora';

    public function boot(): void
    {
        parent::boot();

        // Registra il panel Filament
        $this->app->register(AdminPanelProvider::class);


    }

    /**
     * Registra gli stati per i modelli.
     */
    protected function registerStates(): void
    {
        State::resolveStateUsing(
            User::class,
            'state',
            'Modules\\SaluteOra\\States\\User'
        );
    }

    public function register(): void
    {
        parent::register();
        $this->app->register(RouteServiceProvider::class);

        // Registra le icone SVG personalizzate
        FilamentIcon::register([
            'saluteora-doctor' => asset('modules/SaluteOra/resources/svg/doctor.svg'),
            'saluteora-patient' => asset('modules/SaluteOra/resources/svg/patient.svg'),
            'saluteora-users' => asset('modules/SaluteOra/resources/svg/users.svg'),
        ]);
    }
}
