<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Pages;

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
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;

class ListPages extends LangBaseListRecords
{
=======
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Modules\Cms\Filament\Resources\PageResource;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListPages extends XotBaseListRecords
{
    use ListRecords\Concerns\Translatable;
>>>>>>> feb96d7 (.)

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
<<<<<<< HEAD

=======
    public function getGridTableColumns(): array
    {
        return [
            Stack::make($this->getListTableColumns()),
        ];
    }
>>>>>>> feb96d7 (.)

    /**
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getListTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id'),
            'title' => Tables\Columns\TextColumn::make('title')
                ->searchable()
                ->sortable(),
            'lang' => Tables\Columns\TextColumn::make('lang')
                ->searchable()
                ->sortable(),
            'updated_at' => Tables\Columns\TextColumn::make('updated_at')
                ->sortable()
                ->dateTime(),
        ];
    }

<<<<<<< HEAD





    public function tableOLD(Table $table): Table
=======
    public function getTableFilters(): array
    {
        return [
        ];
    }

<<<<<<< HEAD
    public function getTableActions(): array
    {
        return [
            ViewAction::make()
                ->label(''),
            EditAction::make()
                ->label(''),
            DeleteAction::make()
=======
    /**
     * @return array<string, \Filament\Tables\Actions\Action|\Filament\Tables\Actions\ActionGroup>
     */
    public function getTableActions(): array
    {
        return [
            'view'   => ViewAction::make()
                ->label(''),
            'edit'   => EditAction::make()
                ->label(''),
            'delete' => DeleteAction::make()
>>>>>>> origin/dev
                ->label('')
                ->requiresConfirmation(),
        ];
    }

<<<<<<< HEAD
    public function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
=======
    /**
     * @return array<string, \Filament\Tables\Actions\BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
>>>>>>> origin/dev
        ];
    }

    public function table(Table $table): Table
>>>>>>> feb96d7 (.)
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

<<<<<<< HEAD

=======
    
>>>>>>> feb96d7 (.)

    protected function getPreviewModalView(): ?string
    {
        return 'page.show';
    }

    protected function getPreviewModalDataRecordKey(): ?string
    {
        return 'page';
    }
}
