<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\DoctorResource\Pages;

use Modules\SaluteMo\Filament\Resources\DoctorResource;
use Modules\SaluteOra\Filament\Resources\DoctorResource\Pages\EditDoctor as BaseEditDoctor;

class EditDoctor extends BaseEditDoctor
{
    protected static string $resource = DoctorResource::class;
}
