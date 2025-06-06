<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\PatientResource\Pages;

use Filament\Tables;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Filament\Resources\PatientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\SaluteOra\Filament\Resources\UserResource\Pages\ListUsers;

class ListPatients extends ListUsers
{
    protected static string $resource = PatientResource::class;

    public function getTableColumns(): array
    {
        $columns = parent::getTableColumns();   
        $columns = Arr::except($columns, ['type']);
        return $columns;
    }

  
        
}
