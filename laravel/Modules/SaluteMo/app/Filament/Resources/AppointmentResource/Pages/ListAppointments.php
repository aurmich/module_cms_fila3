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
use Modules\SaluteOra\Models\Appointment;
use Modules\Xot\Filament\Widgets\StateOverviewWidget;
use Modules\UI\Filament\Tables\Columns\IconStateColumn;
use Modules\Media\Filament\Tables\Columns\IconMediaColumn;
use Modules\SaluteOra\States\Appointment\AppointmentState;
use Modules\SaluteMo\Filament\Resources\AppointmentResource;
use Modules\UI\Filament\Tables\Columns\IconStateGroupColumn;
use Modules\UI\Filament\Tables\Columns\IconStateSplitColumn;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\SaluteMo\Filament\Resources\AppointmentResource\Widgets;

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
        /** @phpstan-ignore-next-line */
        return [
            /*
            'id' => TextColumn::make('id')
                ->sortable()
                ->searchable(),
            */
            'invoice'=> IconMediaColumn::make('invoice'),
            'state' => IconStateColumn::make('state'),
            //'states' => IconStateGroupColumn::make('states')->stateClass(AppointmentState::class,Appointment::class),
            //'states' => IconStateSplitColumn::make('states')->stateClass(AppointmentState::class, Appointment::class),


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

    public function getHeaderWidgets(): array
    {
        return [
            //Widgets\AppointmentOverviewWidget::make(['paperino'=>'pluto']),
            StateOverviewWidget::make(['stateClass'=>AppointmentState::class,'model'=>Appointment::class]),
        ];
    }

    
}
