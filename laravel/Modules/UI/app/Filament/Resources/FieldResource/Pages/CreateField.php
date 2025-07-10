<?php

namespace Modules\UI\Filament\Resources\FieldResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Modules\UI\Filament\Resources\FieldResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;

class CreateField extends LangBaseCreateRecord
{
    protected static string $resource = FieldResource::class;
}
