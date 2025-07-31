<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Modules\FormBuilder\Models\FormSubmission;

/**
 * Widget per mostrare le submission recenti.
 * 
 * Mostra:
 * - Ultime submission ricevute
 * - Form associati
 * - Data e ora submission
 * - Stato submission
 * 
 * @see \Modules\FormBuilder\docs\filament\widgets\recent-submissions-widget.md Documentazione
 */
class RecentSubmissionsWidget extends BaseWidget
{
    protected static ?string $heading = 'Submission Recenti';
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

                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Data Submission')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('data_count')
                    ->label('Campi Compilati')
                    ->getStateUsing(fn (FormSubmission $record): int => count($record->data))
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Stato')
                    ->colors([
                        'success' => 'completed',
                        'warning' => 'pending',
                        'danger' => 'failed',
                    ]),
            ])
            ->defaultSort('submitted_at', 'desc')
            ->paginated(false);
    }

    protected function getTableQuery(): Builder
    {
        return FormSubmission::query()
            ->with('form')
            ->latest('submitted_at')
            ->limit(10);
    }
}
