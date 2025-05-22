<?php

namespace Modules\SaluteOra\Filament\Resources\MedicalHistoryResource\Pages;

use Modules\SaluteOra\Filament\Resources\MedicalHistoryResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMedicalHistories extends XotBaseListRecords
{
    protected static string $resource = MedicalHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
