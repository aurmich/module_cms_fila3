<?php

namespace Modules\FormBuilder\Filament\Resources\FieldResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Modules\FormBuilder\Filament\Resources\FieldResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;

class CreateField extends LangBaseCreateRecord
{
    protected static string $resource = FieldResource::class;
}
