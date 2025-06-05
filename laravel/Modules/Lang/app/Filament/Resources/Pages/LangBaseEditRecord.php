<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\Pages;
use Filament\Actions;
use Modules\Cms\Filament\Resources\SectionResource;
use Filament\Resources\Pages\EditRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

abstract class LangBaseEditRecord extends XotBaseEditRecord
{
    protected static string $resource;// = SectionResource::class;
    use EditRecord\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            ...parent::getHeaderActions(),
            // ...
        ];
    }
}
