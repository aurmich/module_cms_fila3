<?php

namespace Modules\SaluteOra\Filament\Resources\UserResource\Pages;

use Modules\SaluteOra\Filament\Resources\UserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Filament\Infolists;

class ViewUser extends XotBaseViewRecord
{
    protected static string $resource = UserResource::class;

    public function getInfolistSchema(): array
    {
        return [
            'name' => Infolists\Components\TextEntry::make('name'),
            'email' => Infolists\Components\TextEntry::make('email'),
            'type' => Infolists\Components\TextEntry::make('type'),
            'state' => Infolists\Components\TextEntry::make('state'),
            'created_at' => Infolists\Components\TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => Infolists\Components\TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
