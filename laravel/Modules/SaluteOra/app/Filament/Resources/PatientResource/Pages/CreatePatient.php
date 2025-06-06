<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\PatientResource\Pages;

use Modules\SaluteOra\Filament\Resources\PatientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\SaluteOra\Filament\Resources\UserResource\Pages\CreateUser;

class CreatePatient extends CreateUser
{
    protected static string $resource = PatientResource::class;
}
