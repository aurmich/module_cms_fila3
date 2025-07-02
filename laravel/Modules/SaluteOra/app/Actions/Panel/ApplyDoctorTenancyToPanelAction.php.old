<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Actions\Panel;

use Filament\Panel;
use Modules\SaluteOra\Http\Middleware\DoctorTenancyMiddleware;
use Modules\User\Filament\Pages\Tenancy\EditTenantProfile;
use Modules\User\Filament\Pages\Tenancy\RegisterTenant;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Applies tenancy to a Filament panel only for doctor users.
 * Uses a dedicated middleware to selectively apply tenancy rules.
 */
class ApplyDoctorTenancyToPanelAction
{
    use QueueableAction;

    /**
     * Executes the action to conditionally apply tenancy based on user type.
     *
     * @param Panel $panel The Filament panel instance
     * @return Panel The configured panel with doctor-specific tenancy
     */
    public function execute(Panel $panel): Panel
    {
        // Get tenant class from configuration
        $tenantClass = XotData::make()->getTenantClass();
        
        // Add our doctor tenancy middleware that will check user type
        // before applying tenancy requirements
        $panel->middleware([
            DoctorTenancyMiddleware::class,
        ]);
        
        // Setup the tenant configuration
        // The middleware will handle conditional application for doctors only
        $panel->tenant($tenantClass, 'slug', 'tenants')
              ->tenantRegistration(RegisterTenant::class)
              ->tenantProfile(EditTenantProfile::class);
        
        return $panel;
    }
}
