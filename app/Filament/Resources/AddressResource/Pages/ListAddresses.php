<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\AddressResource\Pages;

use Filament\Actions;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Geo\Filament\Resources\AddressResource;


class ListAddresses extends XotBaseListRecords
{
    protected static string $resource = AddressResource::class;

    /**
     * @return array<\Filament\Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}