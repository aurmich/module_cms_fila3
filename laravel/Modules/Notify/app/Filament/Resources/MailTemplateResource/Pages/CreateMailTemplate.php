<?php

namespace Modules\Notify\Filament\Resources\MailTemplateResource\Pages;

use Filament\Actions;
use Modules\Notify\Filament\Resources\MailTemplateResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;

class CreateMailTemplate extends LangBaseCreateRecord
{
    protected static string $resource = MailTemplateResource::class;
}
