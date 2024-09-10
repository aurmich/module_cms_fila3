<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\ContactResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Notify\Filament\Resources\ContactResource;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;

class ListContacts extends ListRecords
{
    public TableLayoutEnum $layoutView = TableLayoutEnum::GRID;

    protected static string $resource = ContactResource::class;

<<<<<<< HEAD
=======
    public TableLayoutEnum $layoutView = TableLayoutEnum::GRID;

>>>>>>> 5547ac5 (up)
    protected function getTableHeaderActions(): array
    {
        return [
            TableLayoutToggleTableAction::make(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
