<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\DoctorAvailabilityResource\Pages;

use Modules\SaluteOra\Filament\Resources\DoctorAvailabilityResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListDoctorAvailabilities extends XotBaseListRecords
{
    protected static string $resource = DoctorAvailabilityResource::class;
}
