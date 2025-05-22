<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\TreatmentResource\Pages;

use Modules\SaluteOra\Filament\Resources\TreatmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateTreatment extends XotBaseCreateRecord
{
    protected static string $resource = TreatmentResource::class;
}
