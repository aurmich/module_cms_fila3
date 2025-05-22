<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\Pages;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Modules\Cms\Filament\Resources\SectionResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

abstract class LangBaseListRecords extends XotBaseListRecords
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource;// = SectionResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            ...parent::getHeaderActions(),
        ];
    }
}
