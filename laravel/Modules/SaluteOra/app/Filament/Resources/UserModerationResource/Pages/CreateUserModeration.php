<?php

namespace Modules\SaluteOra\Filament\Resources\UserModerationResource\Pages;

use Modules\SaluteOra\Filament\Resources\UserModerationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateUserModeration extends XotBaseCreateRecord
{
    protected static string $resource = UserModerationResource::class;
}
