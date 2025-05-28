<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\StudioResource\Pages;

use Modules\SaluteOra\Filament\Resources\StudioResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListStudios extends XotBaseListRecords
{
    protected static string $resource = StudioResource::class;
}