<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\DoctorResource\Pages;

use Filament\Actions;
use Modules\SaluteOra\Filament\Resources\DoctorResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Filament\Tables\Columns\TextColumn;

class ListDoctors extends XotBaseListRecords
{
    protected static string $resource = DoctorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'email' => TextColumn::make('email')
                ->searchable(),
            'phone' => TextColumn::make('phone'),
            'specialties' => TextColumn::make('specialties.name')
                ->badge(),
        ];
    }
}
