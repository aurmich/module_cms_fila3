<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Modules\Cms\Filament\Resources\PageResource;
<<<<<<< HEAD
<<<<<<< HEAD
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;
=======
>>>>>>> feb96d7 (.)
=======
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;
>>>>>>> f1c9277 (.)

/**
 * Summary of CreatePage.
 */
<<<<<<< HEAD
<<<<<<< HEAD
class CreatePage extends LangBaseCreateRecord
{

    protected static string $resource = PageResource::class;


=======
class CreatePage extends CreateRecord
=======
class CreatePage extends LangBaseCreateRecord
>>>>>>> f1c9277 (.)
{
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
