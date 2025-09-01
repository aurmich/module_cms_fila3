<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageContentResource\Pages;

use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Modules\Cms\Filament\Resources\PageContentResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;

class ListPageContents extends LangBaseListRecords
{
    // use ListRecords\Concerns\Translatable;

    // protected static string $resource = PageContentResource::class;

    public function getGridTableColumns(): array
    {
        return [
            Stack::make($this->getTableColumns()),
        ];
    }

    public function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->sortable()
                ->searchable(),
            TextColumn::make('slug')
                ->sortable()
                ->searchable(),
        ];
    }

    /*
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
    */

}
