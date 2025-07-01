<?php

namespace Modules\SaluteMo\Filament\Resources\DoctorResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\SaluteMo\Filament\Resources\StudioResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Modules\UI\Filament\Forms\Components\OpeningHoursField;
use Filament\Tables\Actions\Action;

class StudiosRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'studios';
    public static string $resourceClass = StudioResource::class;
    
    public function getTableColumns(): array
    {
        $columns = parent::getTableColumns();

        $action=Action::make('change-schedule')
            ->form([
                OpeningHoursField::make('schedule'),
            ])
            ->fillForm(function($record){
                //dddx($record->state);//Modules\SaluteOra\States\User\Pending
                return [
                    'schedule' => $record->pivot->schedule,
                ];
            })
            ->action(function ($record,$data){
                $record->pivot->update(['schedule'=>$data['schedule']]);
                
            });

        $columns['schedule']=IconColumn::make('schedule')
            //->icon(fn(\stdClass $rowLoop,$state)=>dddx([$rowLoop->index,$state]))
            ->icon('heroicon-o-calendar')
            ->action($action);
        return $columns;
        
    }

}
