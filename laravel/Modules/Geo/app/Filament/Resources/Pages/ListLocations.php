<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\Pages;

use Filament\Tables;
use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListLocations extends XotBaseListRecords
{
    protected static string $resource = LocationResource::class;

    public function getTableComumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable(),
            Tables\Columns\TextColumn::make('street'),
            Tables\Columns\TextColumn::make('city')
                ->searchable(),
            Tables\Columns\TextColumn::make('state')
                ->searchable(),
            Tables\Columns\TextColumn::make('zip'),
        ];
    }
}
