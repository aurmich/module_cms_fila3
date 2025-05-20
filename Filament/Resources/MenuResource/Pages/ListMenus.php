<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\MenuResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Tables;
use Modules\Cms\Filament\Resources\MenuResource;
use Modules\Xot\Filament\Pages\XotBaseListRecords;

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
<<<<<<< HEAD
<<<<<<< Updated upstream
    public function getTableComumns(): array
=======
 public function getTableComumns(): array
>>>>>>> Stashed changes
=======
    public function getTableComumns(): array
>>>>>>> 9e8bf98 (.)
    {
        return [
            Tables\Columns\TextColumn::make('title'),
        ];
    }
}
