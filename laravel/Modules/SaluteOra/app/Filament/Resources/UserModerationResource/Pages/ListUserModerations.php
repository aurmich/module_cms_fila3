<?php

namespace Modules\SaluteOra\Filament\Resources\UserModerationResource\Pages;

use Modules\SaluteOra\Filament\Resources\UserModerationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Filament\Actions;

class ListUserModerations extends XotBaseListRecords
{
    protected static string $resource = UserModerationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
