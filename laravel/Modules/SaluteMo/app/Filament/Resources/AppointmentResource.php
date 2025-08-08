<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Filament\Forms\Components;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SaluteOra\Models\Appointment;
use Filament\Resources\Pages\Page;
use Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;
use Modules\SaluteMo\Filament\Resources\AppointmentResource\Widgets;
use Modules\UI\Filament\Forms\Components\SelectState;

/**
 * Resource per la gestione degli appuntamenti medici.
 * 
 * Estende XotBaseResource per ereditare le funzionalità di base
 * e personalizzare la gestione degli appuntamenti.
 */
class AppointmentResource extends XotBaseResource
{
    /**
     * @var string|null Il modello associato alla risorsa
     */
    protected static ?string $model = Appointment::class;

    /**
     * Restituisce lo schema del form per la creazione e modifica degli appuntamenti.
     *
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            
                    // Patient Select with create option
                    Components\Select::make('patient_id')
                        ->relationship('patient', 'full_name')
                        ->searchable()
                        ->preload()
                        ->required()
                        /*
                        ->createOptionForm(PatientResource::getPersonalDataStepSchema())
                        ->createOptionAction(function (Components\Actions\Action $action) {
                            return $action
                                ->modalHeading(static::trans('actions.create_patient.modal.heading'))
                                ->modalButton(static::trans('actions.create_patient.modal.button'));
                        })
                        */,

                    // Doctor Select
                    Components\Select::make('doctor_id')
                        ->relationship('doctor', 'full_name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    // Studio Select
                    Components\Select::make('studio_id')
                        ->relationship('studio', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    /*
                    // Appointment Type
                    Components\Select::make('type')
                        ->options(\Modules\SaluteOra\Enums\AppointmentTypeEnum::class)
                        ->required()
                        ->default('checkup'),

                    // Status
                    Components\Select::make('status')
                        ->options(\Modules\SaluteOra\Enums\AppointmentStatusEnum::class)
                        ->default('scheduled')
                        ->required(),
                    */
                    // Title
                    Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),

                    // Start Time
                    Components\DateTimePicker::make('starts_at')
                        ->required()
                        ->native(false)
                        ->seconds(false)
                        ->columnSpan(1),

                    // End Time
                    Components\DateTimePicker::make('ends_at')
                        ->required()
                        ->native(false)
                        ->seconds(false)
                        ->after('starts_at')
                        ->columnSpan(1),
                    /*
                    // Emergency Toggle
                    Components\Toggle::make('emergency')
                        ->default(false)
                        ->columnSpan(2),
                    */
                    // Notes
                    Components\Textarea::make('notes')
                        ->columnSpan(2)
                        ->columnSpanFull(),

                    SelectState::make('state'),
              
        ];
    }


    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            // ...
            Pages\EditAppointment::class,
            Pages\EditAppointmentReport::class,
        ]);
    }

    public static function getPages(): array
    {
        return [
            ...parent::getPages(),
            'edit-report' => Pages\EditAppointmentReport::route('/{record}/edit/report'),
            
        ];
    }


    
}
