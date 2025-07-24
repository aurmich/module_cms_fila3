<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\AdminResource\Pages;

use Modules\SaluteOra\Filament\Resources\AdminResource\Pages\ListAdmins as BaseListAdmins;
use Modules\SaluteMo\Filament\Resources\AdminResource;

class ListAdmins extends BaseListAdmins
{
    protected static string $resource = AdminResource::class;
}
