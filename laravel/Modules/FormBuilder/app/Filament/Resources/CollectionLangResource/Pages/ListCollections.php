<?php

namespace Modules\FormBuilder\Filament\Resources\CollectionLangResource\Pages;

use Modules\FormBuilder\Filament\Resources\CollectionLangResource;
use Filament\Actions;
use Filament\Tables\Columns;
use Filament\Resources\Pages\ListRecords;
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;

class ListCollections extends LangBaseListRecords
{
    protected static string $resource = CollectionLangResource::class;

    public function getTableColumns(): array
    {
        return [
            Columns\TextColumn::make('name')
                    ->forceSearchCaseInsensitive()
                    ->label(__('Collections Name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
            Columns\TextColumn::make('values-list')
                    ->badge()
                    ->separator(',')
                    ->label(__('Collections Values'))
                    ->searchable(['values'])
                    ->toggleable(),
        ];
    }
}
