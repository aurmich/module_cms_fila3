<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Modules\FormBuilder\Models\Response;

/**
 * Widget per mostrare le risposte recenti.
 * 
 * Mostra:
 * - Ultime risposte ricevute
 * - Form associati
 * - Data e ora risposta
 * - Stato risposta
 * 
 * @see \Modules\FormBuilder\docs\filament\widgets\recent-submissions-widget.md Documentazione
 */
class RecentSubmissionsWidget extends BaseWidget
{
    protected static ?string $heading = 'Risposte Recenti';
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('form.name')
                    ->label('Form')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data Risposta')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('data_count')
                    ->label('Campi Compilati')
                    ->getStateUsing(fn (Response $record): int => count($record->data ?? []))
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Stato')
                    ->colors([
                        'success' => 'completed',
                        'warning' => 'pending',
                        'danger' => 'failed',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false);
    }

    protected function getTableQuery(): Builder
    {
        return Response::query()
            ->with('form')
            ->latest('created_at')
            ->limit(10);
    }
}