<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageContentResource\Pages;

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
use Modules\Cms\Filament\Resources\PageContentResource;

use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;

class ListPageContents extends XotBaseListRecords
{
    use ListRecords\Concerns\Translatable;

    // protected static string $resource = PageContentResource::class;



    /**
     * Definisce le colonne della tabella di elenco contenuti di pagina.
     *
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getListTableColumns(): array
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

    /**
     * Definisce i filtri della tabella.
     *
     * @return array<int, \Filament\Tables\Filters\Filter>
     */
    public function getTableFilters(): array
    {
        return [
        ];
    }

    /**
     * Definisce le azioni disponibili per ciascuna riga della tabella.
     *
     * @return array<string, \Filament\Tables\Actions\Action>
     */
    public function getTableActions(): array
    {
        return [
            'view' => ViewAction::make()
                ->label(''),
            'edit' => EditAction::make()
                ->label(''),
            'delete' => DeleteAction::make()
                ->label('')
                ->requiresConfirmation(),
        ];
    }

    /**
     * Definisce le azioni bulk disponibili per più righe selezionate.
     *
     * @return array<string, \Filament\Tables\Actions\BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
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
}
