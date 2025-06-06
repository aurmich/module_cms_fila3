<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\PatientResource\Pages;

use Modules\SaluteOra\Filament\Resources\PatientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\SaluteOra\Filament\Resources\UserResource\Pages\EditUser;

class EditPatient extends EditUser
{
    protected static string $resource = PatientResource::class;
}
