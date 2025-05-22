<?php

namespace Modules\SaluteOra\Filament\Resources\MedicalHistoryResource\Pages;

use Modules\SaluteOra\Filament\Resources\MedicalHistoryResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Filament\Actions;

class EditMedicalHistory extends XotBaseEditRecord
{
    protected static string $resource = MedicalHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
