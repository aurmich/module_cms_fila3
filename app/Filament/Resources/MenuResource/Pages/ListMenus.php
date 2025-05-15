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
     * @return array<Tables\Columns\Column>
     */
<<<<<<< Updated upstream
<<<<<<< HEAD
    public function getTableColumns(): array
=======
    public function getListTableColumns(): array
>>>>>>> c27ecbf (.)
=======
    public function getTableColumns(): array
>>>>>>> Stashed changes
    {
        return [
            Tables\Columns\TextColumn::make('title'),
        ];
    }
}
