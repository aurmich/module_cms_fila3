<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages;



use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Notify\Filament\Resources\NotificationTemplateResource;

class ListNotificationTemplates extends XotBaseListRecords
{
    protected static string $resource = NotificationTemplateResource::class;

    public function getTableColumns(): array
    {
        return [];
    }
} 