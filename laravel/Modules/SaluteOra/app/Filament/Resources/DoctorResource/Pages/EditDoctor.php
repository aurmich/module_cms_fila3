<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\DoctorResource\Pages;

use Filament\Actions;
use Modules\SaluteOra\Filament\Resources\DoctorResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\SaluteOra\Filament\Resources\UserResource\Pages\EditUser;

class EditDoctor extends EditUser
{
    protected static string $resource = DoctorResource::class;

   
}
