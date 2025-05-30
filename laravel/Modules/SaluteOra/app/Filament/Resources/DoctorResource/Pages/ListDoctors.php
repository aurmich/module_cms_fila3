<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\DoctorResource\Pages;

use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Facades\FilamentView;
use Modules\SaluteOra\Filament\Resources\DoctorResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListDoctors extends XotBaseListRecords
{
    protected static string $resource = DoctorResource::class;
    
   
    

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
