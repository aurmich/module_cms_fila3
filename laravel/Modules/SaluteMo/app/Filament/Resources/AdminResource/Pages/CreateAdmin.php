<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\AdminResource\Pages;

use Modules\SaluteOra\Filament\Resources\AdminResource\Pages\CreateAdmin as BaseCreateAdmin;
use Modules\SaluteMo\Filament\Resources\AdminResource;

class CreateAdmin extends BaseCreateAdmin
{
    protected static string $resource = AdminResource::class;
}
