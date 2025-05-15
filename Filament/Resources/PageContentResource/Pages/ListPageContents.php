<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageContentResource\Pages;

use Filament\Actions;
<<<<<<< Updated upstream
<<<<<<< HEAD
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
use Modules\Cms\Filament\Resources\PageContentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;

=======
=======
use Filament\Tables\Table;
>>>>>>> Stashed changes
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
use Modules\Cms\Filament\Resources\PageContentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;
<<<<<<< Updated upstream
use Modules\Xot\Filament\Pages\XotBaseListRecords;
>>>>>>> c27ecbf (.)
=======

>>>>>>> Stashed changes

class ListPageContents extends XotBaseListRecords
{
    use ListRecords\Concerns\Translatable;

    // protected static string $resource = PageContentResource::class;

    public function getGridTableColumns(): array
    {
        return [
            Stack::make($this->getListTableColumns()),
        ];
    }

<<<<<<< Updated upstream
<<<<<<< HEAD
    public function getTableComumns(): array
=======
    public function getListTableColumns(): array
>>>>>>> c27ecbf (.)
=======
    public function getTableComumns(): array
>>>>>>> Stashed changes
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

    public function getTableFilters(): array
    {
        return [
        ];
    }

    public function getTableActions(): array
    {
        return [
            ViewAction::make()
                ->label(''),
            EditAction::make()
                ->label(''),
            DeleteAction::make()
                ->label('')
                ->requiresConfirmation(),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            // ->columns($this->getTableColumns())
            ->columns($this->layoutView->getTableColumns())
            ->contentGrid($this->layoutView->getTableContentGrid())
            ->headerActions($this->getTableHeaderActions())

            ->filters($this->getTableFilters())
            ->filtersLayout(FiltersLayout::AboveContent)
            ->persistFiltersInSession()
            ->actions($this->getTableActions())
            ->bulkActions($this->getTableBulkActions())
            ->actionsPosition(ActionsPosition::BeforeColumns)
            ->defaultSort(
                column: 'created_at',
                direction: 'DESC',
            );
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            TableLayoutToggleTableAction::make(),
        ];
    }
}
