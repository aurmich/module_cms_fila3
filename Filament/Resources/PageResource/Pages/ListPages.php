<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Pages;

<<<<<<< Updated upstream
<<<<<<< HEAD
use Filament\Tables;
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
use Modules\Cms\Filament\Resources\PageResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;
=======
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
=======
>>>>>>> Stashed changes
use Filament\Tables;
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
use Modules\Cms\Filament\Resources\PageResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;
<<<<<<< Updated upstream
use Modules\Xot\Filament\Pages\XotBaseListRecords;
>>>>>>> c27ecbf (.)
=======
>>>>>>> Stashed changes

class ListPages extends XotBaseListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = PageResource::class;

    /*
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    ListPreviewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->filters([])
            ->bulkActions([]);
    }
    */
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
            TextColumn::make('title')
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
            Actions\LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }

    

    protected function getPreviewModalView(): ?string
    {
        return 'page.show';
    }

    protected function getPreviewModalDataRecordKey(): ?string
    {
        return 'page';
    }
}
