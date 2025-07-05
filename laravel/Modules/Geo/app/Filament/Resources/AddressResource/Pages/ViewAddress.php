<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\AddressResource\Pages;

use Filament\Actions;
use Filament\Infolists\Infolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\Geo\Filament\Resources\AddressResource;


class ViewAddress extends XotBaseViewRecord
{
    protected static string $resource = AddressResource::class;

    

    public function getInfolistSchema(): array
    {
        return [];
    }
}