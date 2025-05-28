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

    /**
     * @return array<\Filament\Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function getInfolistSchema(): array
    {
        return AddressResource::getInfolistSchema();
    }
}