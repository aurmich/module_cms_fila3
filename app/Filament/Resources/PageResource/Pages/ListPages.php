<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Pages;

use Filament\Tables;
use Modules\Cms\Filament\Resources\PageResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;

class ListPages extends LangBaseListRecords
{
    protected static string $resource = PageResource::class;

    /**
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id'),
            'title' => Tables\Columns\TextColumn::make('title')
                ->searchable()
                ->sortable(),
            'lang' => Tables\Columns\TextColumn::make('lang')
                ->searchable()
                ->sortable(),
            'updated_at' => Tables\Columns\TextColumn::make('updated_at')
                ->sortable()
                ->dateTime(),
        ];
    }
}
