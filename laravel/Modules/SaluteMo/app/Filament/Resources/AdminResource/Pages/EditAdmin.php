<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\AdminResource\Pages;

use Modules\SaluteOra\Filament\Resources\AdminResource\Pages\EditAdmin as BaseEditAdmin;
use Modules\SaluteMo\Filament\Resources\AdminResource;

class EditAdmin extends BaseEditAdmin
{
    protected static string $resource = AdminResource::class;
}
