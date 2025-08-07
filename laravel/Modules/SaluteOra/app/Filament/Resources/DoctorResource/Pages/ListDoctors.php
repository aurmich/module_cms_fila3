<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\DoctorResource\Pages;

use Filament\Actions;
use Illuminate\Support\Arr;
use Filament\Facades\Filament;
use Modules\SaluteOra\Models\Doctor;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Facades\FilamentView;
use Modules\SaluteOra\States\User\UserState;
use Modules\Xot\Filament\Widgets\StateOverviewWidget;
use Modules\SaluteOra\Filament\Resources\DoctorResource;
use Modules\Media\Filament\Tables\Columns\IconMediaColumn;
use Modules\Xot\Actions\File\DownloadZipByPathsDiskAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Media\Filament\Tables\Columns\CloudFrontIconMediaColumn;
use Modules\SaluteOra\Filament\Resources\UserResource\Pages\ListUsers;

class ListDoctors extends ListUsers
{
    protected static string $resource = DoctorResource::class;

    public function getTableColumns(): array
    {
        $columns= parent::getTableColumns();   
        $columns=Arr::except($columns,['type']);
        
        $attachments = Doctor::getAttachments();

        
        foreach ($attachments as $attachment) {
            $columns[$attachment] = CloudFrontIconMediaColumn::make($attachment);
        }
        /*
        $columns['certifications'] = IconColumn::make('certifications')
        ->icon('heroicon-o-document-text')
        ->tooltip(function($record,$state, $rowLoop){
            return 'Download Zip';
        })->action(function ($record,$state){
            return app(DownloadZipByPathsDiskAction::class)->execute($state,'local');
        });
        */
        return $columns;
    }

    public function getHeaderWidgets(): array
    {
        /**@phpstan-ignore-next-line */
        return [
            //Widgets\AppointmentOverviewWidget::make(['paperino'=>'pluto']),
            StateOverviewWidget::make(['stateClass'=>UserState::class,'model'=>Doctor::class]),
        ];
    }

   
}
