<?php

namespace Modules\SaluteOra\Filament\Resources\PatientResource\Pages;

use Modules\SaluteOra\Filament\Resources\PatientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditPatientPrivacy extends XotBaseEditRecord
{
    protected static string $resource = PatientResource::class;

    public function getFormSchema(): array{
        return PatientResource::getPrivacyStepSchema();
    }
}
