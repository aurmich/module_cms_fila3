<?php

namespace Modules\SaluteOra\Filament\Resources\UserResource\Pages;

use Modules\SaluteOra\Filament\Resources\UserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\User\Filament\Resources\UserResource\Pages\BaseEditUser;

class EditUser extends BaseEditUser
{
    protected static string $resource = UserResource::class;
}
