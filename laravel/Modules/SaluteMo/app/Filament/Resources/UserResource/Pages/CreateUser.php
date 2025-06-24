<?php

namespace Modules\SaluteMo\Filament\Resources\UserResource\Pages;

use Modules\SaluteOra\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
