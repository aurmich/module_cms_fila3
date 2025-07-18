<?php

namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Filament\Actions;
use Filament\Forms\Components;
use Filament\Resources\Pages\EditRecord;
use Modules\SaluteMo\Filament\Resources\ReportResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\SaluteMo\Filament\Resources\AppointmentResource;

class EditAppointmentReport extends XotBaseEditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function getFormSchema(): array
    {
        return [
            // ...
            Components\Section::make('report')
            ->relationship('report')
                ->schema(ReportResource::getFormSchema())
                
        ];
    }
}
