<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\SectionResource\Pages;

use Filament\Actions;
use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Actions\DeleteBulkAction;
use Modules\Cms\Filament\Resources\SectionResource;

use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;

class ListSections extends LangBaseListRecords
{

    protected static string $resource = SectionResource::class;

    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')
                ->sortable()
                ->searchable(),
            'slug' => TextColumn::make('slug')
                ->sortable()
                ->searchable(),
        ];
    }


}
