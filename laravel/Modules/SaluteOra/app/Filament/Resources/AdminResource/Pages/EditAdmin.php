<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\AdminResource\Pages;

use Modules\SaluteOra\Models\Admin;
use Modules\SaluteOra\Filament\Resources\AdminResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\SaluteOra\Filament\Resources\UserResource\Pages\EditUser;

/**
 * @property Admin $record
 */
class EditAdmin extends EditUser
{
    protected static string $resource = AdminResource::class;

    public function afterSave(): void
    {
       $record=$this->record;
       $record->assignModule('salutemo');
    }
}
