<?php

namespace Modules\UI\Filament\Resources\FieldOptionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Modules\UI\Filament\Resources\FieldOptionResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;

class CreateFieldOption extends LangBaseCreateRecord
{
    protected static string $resource = FieldOptionResource::class;
}
