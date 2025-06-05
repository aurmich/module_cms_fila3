<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\StudioResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\SaluteOra\Models\Doctor;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class DoctorsRelationManager extends XotBaseRelationManager
{
    /**
     * Relazione: mostra i dottori associati a uno studio (molti-a-molti).
     */
    protected static string $relationship = 'doctors';
    protected static ?string $inverseRelationship = 'studios';

    /**
     * Get the form schema.
     */
    public function getFormSchema(): array
    {
        return [
            'first_name' => Forms\Components\TextInput::make('first_name')
                ->required()
                ->maxLength(255),

            'last_name' => Forms\Components\TextInput::make('last_name')
                ->required()
                ->maxLength(255),

            'email' => Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),

            'phone' => Forms\Components\TextInput::make('phone')
                ->tel()
                ->maxLength(30),

            'specialization' => Forms\Components\TextInput::make('specialization')
                ->maxLength(255),

            'registration_number' => Forms\Components\TextInput::make('registration_number')
                ->maxLength(50),
        ];
    }

    /**
     * Get the table columns.
     *
     * @return array<string, Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'first_name' => Tables\Columns\TextColumn::make('first_name')
                ->searchable()
                ->sortable(),

            'last_name' => Tables\Columns\TextColumn::make('last_name')
                ->searchable()
                ->sortable(),

            'email' => Tables\Columns\TextColumn::make('email')
                ->searchable(),

            'phone' => Tables\Columns\TextColumn::make('phone'),

            'specialization' => Tables\Columns\TextColumn::make('specialization')
                ->searchable(),

            'registration_number' => Tables\Columns\TextColumn::make('registration_number'),

            'status' => Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'warning' => 'pending',
                    'success' => 'active',
                    'danger' => 'suspended',
                ]),

            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }

    /**
     * Get the table filters.
     *
     * @return array<string, Tables\Filters\Filter>
     */
    public function getTableFilters(): array
    {
        return [
            'status' => Tables\Filters\SelectFilter::make('status')
                ->options([
                    'pending' => 'Pending',
                    'active' => 'Active',
                    'suspended' => 'Suspended',
                ]),
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
