<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteOra\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListAppointments extends XotBaseListRecords
{
    protected static string $resource = AppointmentResource::class;
}
