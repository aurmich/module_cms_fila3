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
 * @property TeamContract $currentTeam
 */
trait HasTenants
{
    /**
     * ..
     **/
    public function canAccessTenant(Model $tenant): bool
    {

        return $this->tenants()->whereKey($tenant)->exists();

    }

    public function getTenants(Panel $panel): array|Collection
    {
        return $this->tenants;
    }

    /**
     * Get all of the tenants the user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\Illuminate\Database\Eloquent\Model>
     */
    public function tenants(): BelongsToMany
    {
        $xot = XotData::make();
        /** @var class-string<Model> */
        $tenant_class = $xot->getTenantClass();

        // $this->setConnection('mysql');
        //return $this->belongsToManyX($tenant_class, null, null, 'tenant_id');
        return $this->belongsToManyX($tenant_class);
        // ->as('membership')
    }
}
