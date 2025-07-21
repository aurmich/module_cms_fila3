<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\SaluteOra\Models\Dentist;
use Modules\SaluteOra\Models\Patient;
use Illuminate\Database\Eloquent\Builder;
use Modules\SaluteOra\Models\Appointment;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SaluteOra\Filament\Resources\PatientResource;
use Modules\SaluteOra\Filament\Resources\AppointmentResource\Pages;

class AppointmentResource extends XotBaseResource
{
    protected static ?string $model = Appointment::class;
    protected static ?string $tenantOwnershipRelationshipName = 'studio';
    //protected static ?string $tenantRelationshipName = 'studio';
    protected static bool $isScopedToTenant = true;

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('patient_id')
                ->relationship('patient', 'full_name')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\Select::make('doctor_id')
                ->relationship('doctor', 'full_name')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\Select::make('studio_id')
                ->relationship('studio', 'name')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\TextInput::make('title')
                ->required(),

            Forms\Components\DateTimePicker::make('starts_at')
                ->required(),

            Forms\Components\DateTimePicker::make('ends_at')
                ->required()
                ->after('starts_at'),

            /*
            'treatment_id' => Forms\Components\Select::make('treatment', 'name')
                ->relationship('treatment', 'name')
                ->searchable()
                ->preload(),
*/
            'status' => Forms\Components\Select::make('status')
                ->options([
                    'scheduled' => 'Programmato',
                    'confirmed' => 'Confermato',
                    'in_progress' => 'In Corso',
                    'completed' => 'Completato',
                    'cancelled' => 'Annullato',
                    'no_show' => 'Non Presentato',
                ])
                ->default('scheduled')
                ->required(),

            'notes' => Forms\Components\Textarea::make('notes')
                ->maxLength(1000)
                ->columnSpanFull(),

            'eligibility_confirmed' => Forms\Components\Toggle::make('eligibility_confirmed')
                ->default(false),
        ];
    }


}
