<?php

namespace Modules\SaluteOra\Filament\Resources\UserResource\Pages;

use Modules\SaluteOra\Filament\Resources\UserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditUser extends XotBaseEditRecord
{
    protected static string $resource = UserResource::class;
}
