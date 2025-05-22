<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\PatientResource\Pages;

use Modules\SaluteOra\Filament\Resources\PatientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;


class EditPatient extends XotBaseEditRecord
{
    protected static string $resource = PatientResource::class;
}
