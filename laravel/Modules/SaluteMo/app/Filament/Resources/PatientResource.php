<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Modules\SaluteOra\Models\Patient;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SaluteOra\Filament\Resources\UserResource;
use Modules\SaluteOra\Filament\Resources\PatientResource as BasePatientResource;

class PatientResource extends BasePatientResource
{
    protected static ?string $model = Patient::class;
    protected static bool $isScopedToTenant = false;

    /*
    public static function getFormSchema(): array
    {
        $schema = BasePatientResource::getFormSchema();
        
        return $schema;
    }
        */
        
}