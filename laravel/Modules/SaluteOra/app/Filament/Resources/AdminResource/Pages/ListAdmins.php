<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\AdminResource\Pages;

use Illuminate\Support\Arr;
use Modules\SaluteOra\Models\Admin;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\States\User\UserState;
use Modules\Xot\Filament\Widgets\StateOverviewWidget;
use Modules\SaluteOra\Filament\Resources\AdminResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\SaluteOra\Filament\Resources\UserResource\Pages\ListUsers;

class ListAdmins extends ListUsers
{
    protected static string $resource = AdminResource::class;

    public function getTableColumns(): array
    {
        $columns= parent::getTableColumns();   
        $columns=Arr::except($columns,['type']);
        return $columns;
    }

    public function getHeaderWidgets(): array
    {
        return [
            StateOverviewWidget::make(['stateClass'=>UserState::class,'model'=>Admin::class]),
        ];
    }
}
