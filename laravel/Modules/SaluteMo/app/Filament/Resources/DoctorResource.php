<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Modules\SaluteOra\Models\Doctor;
use Modules\Xot\Filament\Resources\XotBaseResource;
//use Modules\SaluteOra\Filament\Resources\PatientResource as BasePatientResource;

class DoctorResource extends XotBaseResource
{
    protected static ?string $model = Doctor::class;
    protected static bool $isScopedToTenant = false;

    public static function getFormSchema(): array
    {
        //$schema = parent::getFormSchema();

        // Aggiungi qui eventuali campi specifici per SaluteMo
        //return $schema;
        return [];
    }
}