<?php

namespace Modules\FormBuilder\Filament\Resources\CollectionLangResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Modules\FormBuilder\Filament\Resources\CollectionLangResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;

class CreateCollection extends LangBaseCreateRecord
{
    protected static string $resource = CollectionLangResource::class;
}
