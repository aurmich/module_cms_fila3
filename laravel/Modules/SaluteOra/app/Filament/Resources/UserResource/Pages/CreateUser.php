<?php

namespace Modules\SaluteOra\Filament\Resources\UserResource\Pages;

use Modules\SaluteOra\Filament\Resources\UserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateUser extends XotBaseCreateRecord
{
    protected static string $resource = UserResource::class;
}
