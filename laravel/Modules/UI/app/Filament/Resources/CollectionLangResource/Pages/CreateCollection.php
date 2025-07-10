<?php

namespace Modules\UI\Filament\Resources\CollectionLangResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Modules\UI\Filament\Resources\CollectionLangResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;

class CreateCollection extends LangBaseCreateRecord
{
    protected static string $resource = CollectionLangResource::class;
}
