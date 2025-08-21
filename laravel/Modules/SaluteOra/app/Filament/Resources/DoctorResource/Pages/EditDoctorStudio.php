<?php

namespace Modules\SaluteOra\Filament\Resources\DoctorResource\Pages;

use Modules\SaluteOra\Filament\Resources\PatientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\SaluteOra\Filament\Resources\DoctorResource;

class EditDoctorStudio extends XotBaseEditRecord
{
    protected static string $resource = DoctorResource::class;

    public function getFormSchema(): array{
        return static::$resource::getStudioStepSchema();
    }
}
