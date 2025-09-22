<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Cms\Filament\Resources\PageResource;
<<<<<<< HEAD
use Modules\Lang\Filament\Resources\Pages\LangBaseEditRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditPage extends LangBaseEditRecord
{
    protected static string $resource = PageResource::class;
=======
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\Lang\Filament\Resources\Pages\LangBaseEditRecord;

class EditPage extends LangBaseEditRecord
{


    protected static string $resource = PageResource::class;


>>>>>>> bc33217 (.)
}
