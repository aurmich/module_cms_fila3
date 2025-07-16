<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Modules\UI\Filament\Tables\Columns\IconStateColumn;
use Modules\Media\Filament\Tables\Columns\IconMediaColumn;
use Modules\SaluteOra\States\Appointment\AppointmentState;
use Modules\SaluteMo\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListAppointments extends XotBaseListRecords
{
    protected static string $resource = AppointmentResource::class;

    /**
     * Definisce le colonne della tabella per la visualizzazione degli appuntamenti.
     *
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            /*
            'id' => TextColumn::make('id')
                ->sortable()
                ->searchable(),
            */
            'invoice'=> IconMediaColumn::make('invoice'),
            'state' => IconStateColumn::make('state'),
            'patient.full_name' => TextColumn::make('patient.full_name'),
            'title' => TextColumn::make('title')
                ->sortable()
                ->searchable(),

            'starts_at' => TextColumn::make('starts_at')
                ->dateTime()
                ->sortable(),

            'ends_at' => TextColumn::make('ends_at')
                ->dateTime()
                ->sortable(),

            

            
        ];
    }

    public function getTableFilters(): array
    {
     return [
         ...parent::getTableFilters(),
         SelectFilter::make('state')->options(function(){
             $res=array_keys(AppointmentState::getStateMapping()->toArray());
             $res=array_combine($res,$res);
             return $res;
         }),//->options(UserTypeEnum::class),
     ];
    }

    /**
     * Definisce le azioni nell'header della pagina.
     *
     * @return array<int, \Filament\Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Definisce le azioni per ogni riga della tabella.
     *
     * @return array<int, \Filament\Tables\Actions\Action>
     */
    public function getTableActions(): array
    {
        return [
            ViewAction::make(),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }

    /**
     * Definisce le azioni di massa per la tabella.
     *
     * @return array<int, \Filament\Tables\Actions\BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ];
    }
}
