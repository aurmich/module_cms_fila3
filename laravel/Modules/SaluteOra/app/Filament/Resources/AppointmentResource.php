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


            'patient_id' => Forms\Components\Select::make('patient_id')
                ->relationship('patient', 'full_name')
                ->searchable()
                ->preload()
                ->createOptionForm(
                    fn (Forms\Get $get): array => PatientResource::getFormSchema()
                )
                ->required(),


            'doctor_id' => Forms\Components\Select::make('doctor_id')
                ->relationship('doctor', 'full_name')
                ->searchable()
                ->preload()
                ->createOptionForm(
                    fn (Forms\Get $get): array => DoctorResource::getFormSchema()
                )
                ->required(),

            'start_time' => Forms\Components\DateTimePicker::make('start_time')
                ->required(),

            'end_time' => Forms\Components\DateTimePicker::make('end_time')
                ->after('start_time'),
            /*
            'treatment_id' => Forms\Components\Select::make('treatment_id')
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
