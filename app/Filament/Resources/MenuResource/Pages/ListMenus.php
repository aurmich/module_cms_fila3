<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\MenuResource\Pages;

use Filament\Tables;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Modules\Cms\Filament\Resources\MenuResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;


class ListMenus extends XotBaseListRecords
{
    // protected static string $resource = MenuResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    /**
     * Get list table columns.
     *
<<<<<<< HEAD
     * @return array<Tables\Columns\Column>
=======
<<<<<<< HEAD
     * @return array<Tables\Columns\Column>
=======
     * @return array<string, \Filament\Tables\Columns\Column>
>>>>>>> origin/dev
>>>>>>> feb96d7 (.)
     */
    public function getListTableColumns(): array
    {
        return [
<<<<<<< HEAD
            Tables\Columns\TextColumn::make('title'),
=======
<<<<<<< HEAD
            Tables\Columns\TextColumn::make('title'),
=======
            'title' => Tables\Columns\TextColumn::make('title'),
>>>>>>> origin/dev
>>>>>>> feb96d7 (.)
        ];
    }
}
