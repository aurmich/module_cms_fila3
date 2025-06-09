<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\PatientResource\Pages;

use Carbon\Carbon;
use Filament\Tables;
use Illuminate\Support\Arr;
use Modules\SaluteOra\Models\Patient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Modules\SaluteOra\Filament\Resources\PatientResource;
use Modules\Media\Filament\Tables\Columns\IconMediaColumn;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\SaluteOra\Filament\Resources\UserResource\Pages\ListUsers;

class ListPatients extends ListUsers
{
    protected static string $resource = PatientResource::class;

    public function getTableColumns(): array
    {
        $columns = parent::getTableColumns();
        $columns = Arr::except($columns, ['type']);

        $attachments = Patient::$attachments;

        foreach ($attachments as $attachment) {
            $columns[$attachment] = IconMediaColumn::make($attachment);
        }

        return $columns;
    }



}
