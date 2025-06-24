<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Filament\Panel;
use Modules\Xot\Datas\XotData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Contracts\TeamContract;
use Modules\Xot\Actions\Panel\ApplyTenancyToPanelAction;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// use Modules\User\Models\OwnerRole;

/**
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> a3f7230 (.)
 * Trait HasTenants
 * 
 * Provides tenant functionality for User models implementing multi-tenancy.
 * 
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
 * @property TeamContract $currentTeam
 */
trait HasTenants
{
    /**
<<<<<<< HEAD
<<<<<<< HEAD
     * ..
     **/
    public function canAccessTenant(Model $tenant): bool
    {

        return $this->tenants()->whereKey($tenant)->exists();

    }

    public function getTenants(Panel $panel): array|Collection
    {
        return $this->tenants;
=======
=======
>>>>>>> a3f7230 (.)
     * Check if the user can access a specific tenant.
     *
     * @param \Illuminate\Database\Eloquent\Model $tenant
     * @return bool
     */
    public function canAccessTenant(Model $tenant): bool
    {
        return $this->tenants()->whereKey($tenant)->exists();
    }

    /**
     * Get tenants for the given panel.
     *
     * @param \Filament\Panel $panel
     * @return array<\Illuminate\Database\Eloquent\Model>|\Illuminate\Support\Collection<int, \Illuminate\Database\Eloquent\Model>
     */
    public function getTenants(Panel $panel): array|Collection
    {
        /** @var \Illuminate\Support\Collection<int, \Illuminate\Database\Eloquent\Model> $tenants */
        $tenants = $this->tenants;
        
        return $tenants;
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
    }

    /**
     * Get all of the tenants the user belongs to.
     *
<<<<<<< HEAD
<<<<<<< HEAD
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\Illuminate\Database\Eloquent\Model>
=======
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\Illuminate\Database\Eloquent\Model, \Illuminate\Database\Eloquent\Relations\Pivot>
>>>>>>> aurmich/dev
=======
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\Illuminate\Database\Eloquent\Model, \Illuminate\Database\Eloquent\Relations\Pivot>
>>>>>>> a3f7230 (.)
     */
    public function tenants(): BelongsToMany
    {
        $xot = XotData::make();
<<<<<<< HEAD
<<<<<<< HEAD
        /** @var class-string<Model> */
=======
        /** @var class-string<\Illuminate\Database\Eloquent\Model> */
>>>>>>> aurmich/dev
=======
        /** @var class-string<\Illuminate\Database\Eloquent\Model> */
>>>>>>> a3f7230 (.)
        $tenant_class = $xot->getTenantClass();

        // $this->setConnection('mysql');
        //return $this->belongsToManyX($tenant_class, null, null, 'tenant_id');
        return $this->belongsToManyX($tenant_class);
        // ->as('membership')
    }
}
