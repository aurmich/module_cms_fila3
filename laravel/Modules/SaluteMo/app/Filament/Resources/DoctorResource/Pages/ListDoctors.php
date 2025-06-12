<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\DoctorResource\Pages;

use Modules\SaluteMo\Filament\Resources\DoctorResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\SaluteOra\Filament\Resources\DoctorResource\Pages\ListDoctors as BaseListDoctors;

class ListDoctors extends BaseListDoctors
{
    protected static string $resource = DoctorResource::class;
}
