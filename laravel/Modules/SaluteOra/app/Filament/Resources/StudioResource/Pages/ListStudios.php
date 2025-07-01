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
            'active' => Tables\Columns\IconColumn::make('active')
                ->boolean(),
            'full_address' => Tables\Columns\TextColumn::make('full_address')
                ->searchable()
                ->default(function($record){
                    $address = $record?->address()->first();
                    if($address==null){
                        return null;
                    }
                    $locality=$address->getLocality();
                    if($locality==null){
                        return null;
                    }
                    return $address->street_address.' '.$address->street_number.' '.implode('',$locality['cap']).' '.$locality['nome'].' ('.$locality['provincia']['nome'].') - '.$locality['regione']['nome'];
                }),
                
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
                
            
            
            
        ];
    }
}
