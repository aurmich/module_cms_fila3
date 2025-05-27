<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\Pages;

use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewLocation extends XotBaseViewRecord
{
    protected static string $resource = LocationResource::class;

    protected function getInfolistSchema(): array
    {
        return [
            \Filament\Infolists\Components\Section::make('Informazioni Location')
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('name')
                        ->label('Nome'),
                    \Filament\Infolists\Components\TextEntry::make('address')
                        ->label('Indirizzo'),
                    \Filament\Infolists\Components\TextEntry::make('city')
                        ->label('Città'),
                    \Filament\Infolists\Components\TextEntry::make('postal_code')
                        ->label('CAP'),
                    \Filament\Infolists\Components\TextEntry::make('country')
                        ->label('Paese'),
                ])
                ->columns(2),
        ];
    }
}
