<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\DoctorResource\Pages;

use Modules\SaluteOra\Filament\Resources\DoctorResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateDoctor extends XotBaseCreateRecord
{
    protected static string $resource = DoctorResource::class;
}
