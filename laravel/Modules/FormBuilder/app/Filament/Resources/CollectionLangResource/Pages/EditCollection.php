<?php

namespace Modules\FormBuilder\Filament\Resources\CollectionLangResource\Pages;

use Modules\FormBuilder\Filament\Resources\CollectionLangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Lang\Filament\Resources\Pages\LangBaseEditRecord;

class EditCollection extends LangBaseEditRecord
{
    protected static string $resource = CollectionLangResource::class;

   
}
