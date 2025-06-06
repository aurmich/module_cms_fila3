<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\AdminResource\Pages;

use Modules\SaluteOra\Filament\Resources\AdminResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\SaluteOra\Filament\Resources\UserResource\Pages\CreateUser;

class CreateAdmin extends CreateUser
{
    protected static string $resource = AdminResource::class;
}
