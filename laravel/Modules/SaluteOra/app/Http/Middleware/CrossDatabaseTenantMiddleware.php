<?php

declare(strict_types=1);

namespace Modules\SaluteOra\app\Http\Middleware;

use Filament\Facades\Filament;
use Filament\Http\Middleware\IdentifyTenant;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;

class CrossDatabaseTenantMiddleware extends IdentifyTenant
{
    /**
     * Estende il middleware IdentifyTenant di Filament per gestire correttamente
     * le relazioni cross-database per il tenant.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next, string ...$tenantModels): mixed
    {
        // Se non esiste un pannello configurato per il tenancy, passa al middleware successivo
        if (! Filament::hasTenancy()) {
            return $next($request);
        }

        $tenant = $this->resolveTenant($request);

        // Se non è stato trovato alcun tenant, redireziona alla pagina di errore
        if ($tenant === null) {
            return redirect()->route('filament.saluteora::admin.pages.dashboard')
                ->with('error', 'Tenant non valido o non autorizzato.');
        }

        // Registra il tenant con Filament
        Filament::setTenant($tenant);

        // Applica lo scope di tenant alle query
        $this->registerTenantScope($tenant);

        return $next($request);
    }

    /**
     * Registra uno scope personalizzato per gestire correttamente le query cross-database
     * 
     * @param Model $tenant Il tenant corrente
     * @return void
     */
    protected function registerTenantScope(Model $tenant): void
    {
        $tenantIdColumn = $tenant->getKeyName();
        $tenantId = $tenant->getKey();
        $tenantModel = get_class($tenant);

        // Crea uno scope personalizzato che gestisce correttamente le tabelle cross-database
        $scope = new class($tenantModel, $tenantIdColumn, $tenantId) implements Scope {
            protected string $tenantModel;
            protected string $tenantIdColumn;
            protected string|int $tenantId;

            public function __construct(string $tenantModel, string $tenantIdColumn, string|int $tenantId)
            {
                $this->tenantModel = $tenantModel;
                $this->tenantIdColumn = $tenantIdColumn;
                $this->tenantId = $tenantId;
            }

            public function apply(Builder $builder, Model $model): void
            {
                $relationshipName = $this->getOwnershipRelationship($model);
                
                if (empty($relationshipName) || !method_exists($model, $relationshipName)) {
                    return;
                }

                // Ottieni il nome della connessione del modello tenant
                $tenantInstance = app($this->tenantModel);
                $tenantConnection = $tenantInstance->getConnectionName();

                // Ottieni il nome della tabella del tenant con il prefisso del database
                $tenantTable = $tenantConnection . '.studios';

                // Costruisci la subquery con la connessione esplicita
                $builder->whereExists(function ($query) use ($model, $relationshipName, $tenantTable) {
                    $query->select(DB::raw(1))
                        ->from(DB::raw($tenantTable))
                        ->join(
                            'saluteora_data.doctor_studio',
                            $tenantTable . '.id', 
                            '=', 
                            'saluteora_data.doctor_studio.studio_id'
                        )
                        ->whereColumn(
                            $model->qualifyColumn('id'),
                            '=',
                            'saluteora_data.doctor_studio.user_id'
                        )
                        ->where($tenantTable . '.id', '=', $this->tenantId);
                });
            }

            protected function getOwnershipRelationship(Model $model): ?string
            {
                $resource = Filament::getResourceForModel($model::class);
                
                if ($resource === null) {
                    return null;
                }
                
                if (property_exists($resource, 'tenantOwnershipRelationshipName')) {
                    return $resource::$tenantOwnershipRelationshipName;
                }
                
                return (string) str($this->tenantModel)
                    ->classBasename()
                    ->pluralStudly()
                    ->camel();
            }
        };

        Filament::getCurrentPanel()->registerEloquentScope($scope);
    }

    /**
     * Risolve il tenant dalla richiesta
     * 
     * @param \Illuminate\Http\Request $request
     * @return Model|null
     */
    protected function resolveTenant($request): ?Model
    {
        $panel = Filament::getCurrentPanel();
        $tenantId = $request->route($panel->getTenantRouteKeyName());

        if (blank($tenantId)) {
            return null;
        }

        $tenantModel = $panel->getTenantModel();

        try {
            $tenant = $tenantModel::where($panel->getTenantSlugAttribute(), $tenantId)
                ->firstOrFail();
        } catch (ModelNotFoundException) {
            return null;
        }

        return $tenant;
    }
}
