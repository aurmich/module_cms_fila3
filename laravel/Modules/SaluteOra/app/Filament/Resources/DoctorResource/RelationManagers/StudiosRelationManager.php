<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\DoctorResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Illuminate\Support\Facades\DB;

class StudiosRelationManager extends XotBaseRelationManager
{
    /**
     * Relazione: mostra gli studi associati a un dottore (molti-a-molti).
     */
    protected static string $relationship = 'studios';
    protected static ?string $inverseRelationship = 'doctors';

    /**
     * Get the form schema.
     */
    public function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            'phone' => Forms\Components\TextInput::make('phone')
                ->tel()
                ->maxLength(30),

            'email' => Forms\Components\TextInput::make('email')
                ->email()
                ->maxLength(100),

            'website' => Forms\Components\TextInput::make('website')
                ->url()
                ->maxLength(255),

            'registration_number' => Forms\Components\TextInput::make('registration_number')
                ->maxLength(50),

            'vat_number' => Forms\Components\TextInput::make('vat_number')
                ->maxLength(30),

            'active' => Forms\Components\Toggle::make('active')
                ->default(true),
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
            'name' => Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),

            'email' => Tables\Columns\TextColumn::make('email')
                ->searchable(),

            'phone' => Tables\Columns\TextColumn::make('phone')
                ->searchable(),

            'website' => Tables\Columns\TextColumn::make('website')
                ->url(fn (\Modules\SaluteOra\Models\Studio $record): ?string => $record->website)
                ->openUrlInNewTab(),

            'registration_number' => Tables\Columns\TextColumn::make('registration_number'),

            'vat_number' => Tables\Columns\TextColumn::make('vat_number'),

            'active' => Tables\Columns\IconColumn::make('active')
                ->boolean(),

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
            'active' => Tables\Filters\TernaryFilter::make('active'),
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
                ->preloadRecordSelect(false)
                ->recordSelect(
                    fn (Forms\Components\Select $select) => $select
                        ->searchable()
                        ->getSearchResultsUsing(
                            function (string $search): array {
                                // Query sugli studi con la connessione corretta (salute_ora)
                                return \Modules\SaluteOra\Models\Studio::on('salute_ora')
                                    ->where(function (Builder $query) use ($search) {
                                        $query->where('name', 'like', "%{$search}%")
                                            ->orWhere('address', 'like', "%{$search}%");
                                    })
                                    // Escludiamo manualmente gli studi già associati
                                    ->whereNotIn('id', $this->getOwnerRecord()->studios->modelKeys())
                                    ->limit(10)
                                    ->get()
                                    ->mapWithKeys(
                                        function ($studio) {
                                            return [$studio->getKey() => "{$studio->name} ({$studio->address})"];
                                        }
                                    )
                                    ->toArray();
                            }
                        )
                )
        ];
    }
}
