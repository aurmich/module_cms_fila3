<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Providers;

use Filament\Forms\Components\Component;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
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

        // Merge auth configuration
        $this->mergeConfigFrom(
            __DIR__.'/../../config/auth.php', 'auth'
        );
        
        // Registra gli observer dei modelli
        $this->bootObservers();
    }
    
    /**
     * Registra gli observer per i modelli del modulo.
     */
    protected function bootObservers(): void
    {
        \Modules\SaluteOra\Models\Studio::observe(\Modules\SaluteOra\Observers\StudioObserver::class);
    }

    /*
     * Registra gli stati per i modelli.
     */
    /*
    protected function registerStates(): void
    {
        State::resolveStateUsing(
            User::class,
            'state',
            'Modules\\SaluteOra\\States\\User'
        );
    }
    */
    
    public function register(): void
    {
        parent::register();
        
        
    }
    
   
}
