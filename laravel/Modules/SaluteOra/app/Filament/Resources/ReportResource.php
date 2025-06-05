<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\SaluteOra\Filament\Resources\ReportResource\Pages;
use Modules\SaluteOra\Models\Report;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ReportResource extends XotBaseResource
{
    protected static ?string $model = Report::class;

    /**
     * Ottiene lo schema del form per la risorsa Report.
     *
     * @return array<string, Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            'description' => Forms\Components\Textarea::make('description')
                ->maxLength(65535),
            'type' => Forms\Components\Select::make('type')
                ->required()
                ->options([
                    'pdf' => 'PDF',
                    'csv' => 'CSV',
                ]),
            'start_date' => Forms\Components\DateTimePicker::make('start_date')
                ->required(),
            'end_date' => Forms\Components\DateTimePicker::make('end_date')
                ->required(),
            'parameters' => Forms\Components\KeyValue::make('parameters')
                ->keyLabel('Parametro')
                ->valueLabel('Valore'),
            'status' => Forms\Components\Select::make('status')
                ->required()
                ->options([
                    'pending' => 'In attesa',
                    'processing' => 'In elaborazione',
                    'completed' => 'Completato',
                    'error' => 'Errore',
                ]),
            'created_at' => Forms\Components\DateTimePicker::make('created_at')
                ->required(),
            'created_by' => Forms\Components\TextInput::make('created_by')
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * Ottiene le colonne della tabella per la risorsa Report.
     *
     * @return array<string, Tables\Columns\Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->sortable(),
                
            'name' => Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->label('Nome Report'),
                
            'type' => Tables\Columns\TextColumn::make('type')
                ->searchable()
                ->sortable()
                ->label('Tipo Report')
                ->formatStateUsing(fn (string $state): string => match($state) {
                    'paziente_demografico' => 'Analisi Demografica Pazienti',
                    'visite_per_periodo' => 'Statistiche Visite per Periodo',
                    'attivita_odontoiatri' => 'Analisi Attività Odontoiatri',
                    'isee_analisi' => 'Analisi ISEE Pazienti',
                    default => $state,
                }),
                
            'start_date' => Tables\Columns\TextColumn::make('start_date')
                ->dateTime()
                ->sortable()
                ->label('Data Inizio'),
                
            'end_date' => Tables\Columns\TextColumn::make('end_date')
                ->dateTime()
                ->sortable()
                ->label('Data Fine'),
                
            'status' => Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'danger' => 'error',
                    'warning' => 'processing',
                    'success' => 'completed',
                ])
                ->sortable()
                ->label('Stato')
                ->formatStateUsing(fn (string $state): string => match($state) {
                    'pending' => 'In attesa',
                    'processing' => 'In elaborazione',
                    'completed' => 'Completato',
                    'error' => 'Errore',
                    default => $state,
                }),
                
            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->label('Data Creazione'),
                
            'creator.name' => Tables\Columns\TextColumn::make('creator.name')
                ->searchable()
                ->sortable()
                ->label('Creato da'),
        ];
    }

    /**
     * Definisce le azioni per la tabella delle risorse.
     *
     * @return array<Tables\Actions\Action>
     */
    public static function getTableActions(): array
    {
        return [
            Tables\Actions\ViewAction::make(),
            Tables\Actions\Action::make('regenerate')
                ->icon('heroicon-o-refresh'),
        ];
    }
    
    /**
     * Configura l'elenco dei filtri disponibili per la tabella.
     *
     * @return array<Tables\Filters\Filter>
     */
    public static function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('type'),
            Tables\Filters\SelectFilter::make('status'),
            Tables\Filters\Filter::make('created_from'),
            Tables\Filters\Filter::make('created_to'),
        ];
    }
}
