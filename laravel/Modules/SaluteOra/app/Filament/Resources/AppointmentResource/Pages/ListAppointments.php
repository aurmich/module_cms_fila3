<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\AppointmentResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Modules\SaluteOra\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListAppointments extends XotBaseListRecords
{
    protected static string $resource = AppointmentResource::class;

    /**
     * Define the table columns for the appointments list.
     *
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'title' => TextColumn::make('title')
                ->searchable()
                ->sortable(),

            'patient' => TextColumn::make('patient.name')
                ->searchable()
                ->sortable(),

            'doctor' => TextColumn::make('doctor.name')
                ->searchable()
                ->sortable(),

            'studio' => TextColumn::make('studio.name')
                ->searchable()
                ->sortable(),

            'starts_at' => TextColumn::make('starts_at')
                ->dateTime('d/m/Y H:i')
                ->sortable(),

            'ends_at' => TextColumn::make('ends_at')
                ->dateTime('d/m/Y H:i')
                ->sortable(),

            'type' => BadgeColumn::make('type')
                ->colors([
                    'primary' => 'consultation',
                    'success' => 'treatment',
                    'danger' => 'emergency',
                ]),

            'status' => BadgeColumn::make('status')
                ->colors([
                    'secondary' => 'scheduled',
                    'warning' => 'confirmed',
                    'success' => 'completed',
                    'danger' => 'cancelled',
                    'primary' => 'no_show',
                ]),

            'emergency' => IconColumn::make('emergency')
                ->boolean()
                ->trueIcon('heroicon-o-exclamation-triangle')
                ->falseIcon('heroicon-o-check-circle')
                ->trueColor('danger')
                ->falseColor('success')
                ->sortable(),

            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
