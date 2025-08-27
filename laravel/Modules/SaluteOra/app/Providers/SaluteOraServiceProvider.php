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
use Modules\SaluteOra\Console\Commands\PopulateDatabaseCommand;
use Modules\SaluteOra\Models\User;
use Spatie\ModelStates\State;

class SaluteOraServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'SaluteOra';
    protected string $moduleName = 'SaluteOra';
   
    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        parent::boot();
        
        // Registra i comandi console
        if ($this->app->runningInConsole()) {
            $this->commands([
                PopulateDatabaseCommand::class,
            ]);
        }
    }
}
