<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\DentistResource\Pages;

use Modules\SaluteOra\Filament\Resources\DentistResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListDentists extends XotBaseListRecords
{
    protected static string $resource = DentistResource::class;
}
