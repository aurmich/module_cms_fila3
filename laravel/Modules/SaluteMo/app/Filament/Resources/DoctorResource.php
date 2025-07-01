<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Filament\Forms;
use Modules\SaluteOra\Models\Doctor;
use Modules\Xot\Filament\Resources\XotBaseResource;
//use Modules\SaluteOra\Filament\Resources\PatientResource as BasePatientResource;

class DoctorResource extends XotBaseResource
{
    protected static ?string $model = Doctor::class;
    protected static bool $isScopedToTenant = false;

    public static function getFormSchema(): array
    {
        //$schema = parent::getFormSchema();

        // Aggiungi qui eventuali campi specifici per SaluteMo
        //return $schema;
        return [
        
            'first_name' => Forms\Components\TextInput::make('first_name')
                ->required()
                ->maxLength(255)
                ->autocomplete('given-name')
                ,
            'last_name' => Forms\Components\TextInput::make('last_name')
                ->required()
                ->maxLength(255)
                ->autocomplete('family-name')
                ,
            'email' => Forms\Components\TextInput::make('email')
                ->required()
                ,
        ];
    }
}