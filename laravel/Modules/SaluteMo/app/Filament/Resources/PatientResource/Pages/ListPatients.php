<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\PatientResource\Pages;

use Modules\SaluteMo\Filament\Resources\PatientResource;
use Modules\SaluteOra\Filament\Resources\PatientResource\Pages\ListPatients as BaseListPatients;

class ListPatients extends BaseListPatients
{
    protected static string $resource = PatientResource::class;
}
