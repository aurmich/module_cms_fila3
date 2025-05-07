<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Cms\Filament\Resources\PageResource;
<<<<<<< HEAD
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\Lang\Filament\Resources\Pages\LangBaseEditRecord;

class EditPage extends LangBaseEditRecord
{


    protected static string $resource = PageResource::class;


=======

class EditPage extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            // Actions\DeleteAction::make(),
        ];
    }
>>>>>>> feb96d7 (.)
}
