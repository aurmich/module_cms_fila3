<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Providers;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;

class TenancyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureFilamentTenancy();
    }

    /**
     * Configura il funzionamento del multi-tenancy in Filament per gestire correttamente
     * le relazioni cross-database.
     */
    protected function configureFilamentTenancy(): void
    {
        // Estendi il comportamento del builder di query per supportare correttamente le relazioni cross-database
        Builder::macro('applyingCrossDatabaseTenantScope', function (Studio $tenant) {
            /** @var Builder $this */
            
            // Applica lo scope solo per il modello Doctor
            $model = $this->getModel();
            if ($model instanceof Doctor) {
                $tenantConnection = $tenant->getConnectionName();
                $tenantTable = $tenantConnection . '.studios';
                $pivotTable = 'saluteora_data.doctor_studio';
                
                return $this->whereExists(function ($query) use ($model, $tenant, $tenantTable, $pivotTable) {
                    $query->select(DB::raw(1))
                        ->from(DB::raw($tenantTable))
                        ->join(
                            $pivotTable,
                            $tenantTable . '.id',
                            '=',
                            $pivotTable . '.studio_id'
                        )
                        ->whereColumn(
                            $model->qualifyColumn('id'),
                            '=',
                            $pivotTable . '.user_id'
                        )
                        ->where($tenantTable . '.id', '=', $tenant->getKey());
                });
            }
            
            return $this;
        });
        
        // Registra un listener per il pannello Filament per intercettare il caricamento del tenant
        Filament::serving(function () {
            $panel = Filament::getCurrentPanel();
            
            if (!$panel->hasTenancy()) {
                return;
            }
            
            $tenant = Filament::getTenant();
            
            if ($tenant instanceof Studio) {
                // Registra uno scope eloquent globale per il pannello che utilizza la nostra macro
                $panel->registerEloquentScope(function (Builder $builder) use ($tenant) {
                    return $builder->applyingCrossDatabaseTenantScope($tenant);
                });
            }
        });
    }
}
