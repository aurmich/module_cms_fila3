<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Modules\SaluteOra\Models\Admin;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SaluteOra\Filament\Resources\AdminResource as BaseAdminResource;

class AdminResource extends BaseAdminResource
{
    protected static ?string $model = Admin::class;
    protected static bool $isScopedToTenant = false;

    
}
