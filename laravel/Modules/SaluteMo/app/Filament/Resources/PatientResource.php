<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Modules\SaluteOra\Filament\Resources\PatientResource as BasePatientResource;
use Modules\SaluteMo\Models\Patient;

class PatientResource extends BasePatientResource
{
    protected static ?string $model = Patient::class;

    public static function getFormSchema(): array
    {
        $schema = parent::getFormSchema();

        // Aggiungi qui eventuali campi specifici per SaluteMo
        return $schema;
    }
}