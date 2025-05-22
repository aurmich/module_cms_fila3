<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\PatientResource\Pages;

use Modules\SaluteOra\Filament\Resources\PatientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;


class CreatePatient extends XotBaseCreateRecord
{
    protected static string $resource = PatientResource::class;
}
