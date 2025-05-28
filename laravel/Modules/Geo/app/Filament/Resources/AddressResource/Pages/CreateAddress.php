<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\AddressResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Geo\Filament\Resources\AddressResource;


class CreateAddress extends XotBaseCreateRecord
{
    protected static string $resource = AddressResource::class;
}