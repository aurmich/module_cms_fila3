<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\TreatmentResource\Pages;

use Modules\SaluteOra\Filament\Resources\TreatmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListTreatments extends XotBaseListRecords
{
    protected static string $resource = TreatmentResource::class;
}
