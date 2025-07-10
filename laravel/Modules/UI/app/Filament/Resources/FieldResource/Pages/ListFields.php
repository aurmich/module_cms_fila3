<?php

namespace Modules\UI\Filament\Resources\FieldResource\Pages;

use Filament\Actions;
use Filament\Tables\Columns;
use Filament\Resources\Pages\ListRecords;
use Modules\UI\Filament\Resources\FieldResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;

class ListFields extends LangBaseListRecords
{
    protected static string $resource = FieldResource::class;

    public function getTableColumns(): array
    {
        return [
            Columns\TextColumn::make('name'),
        ];
    }
}
