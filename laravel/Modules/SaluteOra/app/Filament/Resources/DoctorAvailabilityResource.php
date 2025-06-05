<?php

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Modules\Xot\Enums\DayOfWeek;
use Modules\SaluteOra\Models\DoctorAvailability;
use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorAvailabilityResource extends XotBaseResource
{
    protected static ?string $model = DoctorAvailability::class;

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('day')
                ->options(DayOfWeek::toArray())
                ->required()
                ->label('Giorno')
                ->columnSpan(1),

            Forms\Components\TimePicker::make('start_time')
                ->required()
                ->label('Orario Inizio')
                ->columnSpan(1),

            Forms\Components\TimePicker::make('end_time')
                ->required()
                ->label('Orario Fine')
                ->columnSpan(1),

            Forms\Components\Toggle::make('is_available')
                ->label('Disponibile')
                ->default(true)
                ->columnSpan(1),
        ];
    }
}
