<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\StudioResource\Pages;

use Modules\SaluteOra\Filament\Resources\StudioResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditStudio extends XotBaseEditRecord
{
    protected static string $resource = StudioResource::class;
}