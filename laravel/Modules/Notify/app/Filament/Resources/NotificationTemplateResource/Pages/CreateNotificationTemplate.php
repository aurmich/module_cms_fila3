<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Notify\Filament\Resources\NotificationTemplateResource;


class CreateNotificationTemplate extends XotBaseCreateRecord
{
    protected static string $resource = NotificationTemplateResource::class;
}