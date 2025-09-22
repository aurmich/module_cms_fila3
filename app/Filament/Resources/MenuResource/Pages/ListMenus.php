<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\MenuResource\Pages;

<<<<<<< HEAD
use Filament\Actions\CreateAction;
use Filament\Tables;
=======
use Filament\Tables;
use Filament\Actions\CreateAction;
>>>>>>> bc33217 (.)
use Filament\Tables\Columns\TextColumn;
use Modules\Cms\Filament\Resources\MenuResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

<<<<<<< HEAD
=======

>>>>>>> bc33217 (.)
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
    public function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('title'),
        ];
    }
}
