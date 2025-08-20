<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\PatientResource\Pages;

use Carbon\Carbon;
use Filament\Tables;
use Illuminate\Support\Arr;
use Modules\SaluteOra\Models\Patient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Modules\SaluteOra\States\User\UserState;
use Modules\Xot\Filament\Widgets\StateOverviewWidget;
use Modules\SaluteOra\Filament\Resources\PatientResource;
use Modules\Media\Filament\Tables\Columns\IconMediaColumn;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Media\Filament\Tables\Columns\CloudFrontIconMediaColumn;
use Modules\SaluteOra\Filament\Resources\UserResource\Pages\ListUsers;

class ListPatients extends ListUsers
{
    protected static string $resource = PatientResource::class;

    public function getTableColumns(): array
    {
        $columns = parent::getTableColumns();
        $columns = Arr::except($columns, ['type']);
        $columns['age_range'] = Tables\Columns\TextColumn::make('age_range');
        $columns['nationality'] = Tables\Columns\TextColumn::make('nationality');
        $columns['country_code'] = Tables\Columns\TextColumn::make('country_code');
        $columns['years_in_italy'] = Tables\Columns\TextColumn::make('years_in_italy');
        $columns['family_members'] = Tables\Columns\TextColumn::make('family_members');
        $columns['children_count'] = Tables\Columns\TextColumn::make('children_count');
        $attachments = Patient::getAttachments();

        foreach ($attachments as $attachment) {
            $columns[$attachment] = CloudFrontIconMediaColumn::make($attachment);
            // $columns[$attachment] = IconMediaColumn::make($attachment);
        }
        
        return $columns;
    }

    public function getHeaderWidgets(): array
    {
        /** @phpstan-ignore-next-line */
        return [
            
            'stateOverviewWidget'=>StateOverviewWidget::make(['stateClass'=>UserState::class,'model'=>Patient::class]),
        ];
    }

}
