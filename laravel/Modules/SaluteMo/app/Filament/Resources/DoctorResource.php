<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Filament\Forms;
use Modules\SaluteOra\Models\Doctor;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SaluteOra\Filament\Resources\DoctorResource as BaseDoctorResource;

class DoctorResource extends BaseDoctorResource
{
    protected static ?string $model = Doctor::class;
    protected static bool $isScopedToTenant = false;

   
}