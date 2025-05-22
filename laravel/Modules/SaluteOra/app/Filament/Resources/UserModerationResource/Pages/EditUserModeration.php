<?php

namespace Modules\SaluteOra\Filament\Resources\UserModerationResource\Pages;

use Modules\SaluteOra\Filament\Resources\UserModerationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Filament\Actions;

class EditUserModeration extends XotBaseEditRecord
{
    protected static string $resource = UserModerationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
