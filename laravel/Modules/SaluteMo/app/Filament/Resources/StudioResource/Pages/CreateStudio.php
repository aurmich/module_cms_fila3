<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\StudioResource\Pages;

use Modules\SaluteMo\Filament\Resources\StudioResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateStudio extends XotBaseCreateRecord
{
    protected static string $resource = StudioResource::class;
}