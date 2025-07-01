<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\StudioResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Modules\SaluteOra\Models\Doctor;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Modules\SaluteMo\Filament\Resources\DoctorResource;
use Modules\UI\Filament\Forms\Components\OpeningHoursField;
use Modules\SaluteMo\Filament\Resources\DoctorResource\Pages\ListDoctors;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class DoctorsRelationManager extends XotBaseRelationManager
{
    /**
     * Relazione: mostra i dottori associati a uno studio (molti-a-molti).
     */
    protected static string $relationship = 'doctors';
    protected static ?string $inverseRelationship = 'studios';
    public static string $resourceClass = DoctorResource::class;

    /**
     * Get the form schema.
     */
    public function getFormSchema(): array
    {
        return static::$resourceClass::getFormSchema();
    }

    /**
     * Get the table columns.
     *
     * @return array<string, Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {

        //return app(ListDoctors::class)->getTableColumns();
        $columns = parent::getTableColumns();
        /*
        $action=Action::make('change-schedule')
        ->form([
            OpeningHoursField::make('schedule'),
        ])
        ->fillForm(function($record){
            //dddx($record->state);//Modules\SaluteOra\States\User\Pending
            
            return [
                'schedule' => $record->pivot?->schedule ?? [],
            ];
        })
        ->action(function ($record,$data){
            $record->pivot->update(['schedule'=>$data['schedule']]);
            
        });
        

        $columns['schedule']=IconColumn::make('schedule')
        //->icon(fn(\stdClass $rowLoop,$state)=>dddx([$rowLoop->index,$state]))
        ->icon('heroicon-o-calendar')
        ->action($action);
        */
        return $columns;
    }

    /**
     * Get the table filters.
     *
     * @return array<string, Tables\Filters\Filter>
     */
    public function getTableFilters(): array
    {
        return [
            /*
            'status' => Tables\Filters\SelectFilter::make('status')
                ->options([
                    'pending' => 'Pending',
                    'active' => 'Active',
                    'suspended' => 'Suspended',
                ]),
                */
            /*
            'specialization' => Tables\Filters\SelectFilter::make('specialization')
                ->options(function () {
                    return $this->getOwnerRecord()->doctors()
                        ->distinct('specialization')
                        ->pluck('specialization', 'specialization')
                        ->toArray();
                }),
            */
        ];
    }

    /**
     * Configura le azioni di intestazione della tabella.
     *
     * IMPORTANTE: In una relazione cross-database, è necessario gestire manualmente
     * le query per evitare problemi con i database multipli. Per dettagli vedere:
     * docs/filament/cross-database-relations.md
     *
     * @return array<string, Tables\Actions\Action>
     */
    public function getTableHeaderActions(): array
    {
        return [
            Tables\Actions\AttachAction::make()
                ->preloadRecordSelect(false) // Importante: non precaricare tutti i record
                // Soluzione per database cross-database compatibile con Filament 3
                ->recordSelect(
                    fn (Forms\Components\Select $select) => $select
                    ->searchable()
                    ->getSearchResultsUsing(
                        function (string $search):array {
                        // Query sui dottori con la connessione corretta (user database)
                        return Doctor::where(function (Builder $query) use ($search) {
                                $query->where('name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%");
                            })
                            // Escludiamo manualmente i dottori già associati invece di usare JOIN
                            ->whereNotIn('id', $this->getOwnerRecord()->doctors->modelKeys())
                            ->limit(10)
                            ->get()
                            ->mapWithKeys(
                                function (Doctor $doctor) {
                                    return [$doctor->getKey() => "{$doctor->full_name} <{$doctor->email}>"];
                                }
                            )
                            ->toArray();
                        }
                    )

                )



        ];
    }
}
