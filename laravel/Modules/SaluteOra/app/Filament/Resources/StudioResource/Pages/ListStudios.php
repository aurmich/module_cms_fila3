<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\StudioResource\Pages;

use Filament\Tables;
use Modules\SaluteOra\Filament\Resources\StudioResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListStudios extends XotBaseListRecords
{
    protected static string $resource = StudioResource::class;

    /**
     * Get the table columns.
     *
     * @return array<string, Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->sortable(),
                
            'name' => Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
                
            'phone' => Tables\Columns\TextColumn::make('phone')
                ->searchable(),
                
            'email' => Tables\Columns\TextColumn::make('email')
                ->searchable(),
                
            'website' => Tables\Columns\TextColumn::make('website'),
                
            'registration_number' => Tables\Columns\TextColumn::make('registration_number'),
                
            'vat_number' => Tables\Columns\TextColumn::make('vat_number'),
                
            'active' => Tables\Columns\IconColumn::make('active')
                ->boolean(),
                
            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }
}
