<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Filament\Forms\Components;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SaluteOra\Models\Appointment;
use Filament\Resources\Pages\Page;
use Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;
use Modules\SaluteMo\Filament\Resources\AppointmentResource\Widgets;

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
            Components\Grid::make(2)
                ->schema([
                    // Patient Select with create option
                    Components\Select::make('patient_id')
                        ->label(__('salutemo::appointments.fields.patient'))
                        ->relationship('patient', 'full_name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->createOptionForm([
                            Components\TextInput::make('first_name')
                                ->required()
                                ->maxLength(255),
                            Components\TextInput::make('last_name')
                                ->required()
                                ->maxLength(255),
                            Components\TextInput::make('email')
                                ->email()
                                ->required()
                                ->maxLength(255),
                            Components\TextInput::make('phone')
                                ->tel()
                                ->maxLength(20),
                        ])
                        ->createOptionAction(function (Components\Actions\Action $action) {
                            return $action
                                ->modalHeading(__('salutemo::appointments.actions.create_patient'))
                                ->modalButton(__('salutemo::appointments.actions.create_patient_button'));
                        }),

                    // Doctor Select
                    Components\Select::make('doctor_id')
                        ->label(__('salutemo::appointments.fields.doctor'))
                        ->relationship('doctor', 'full_name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    // Studio Select
                    Components\Select::make('studio_id')
                        ->label(__('salutemo::appointments.fields.studio'))
                        ->relationship('studio', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    // Appointment Type
                    Components\Select::make('type')
                        ->label(__('salutemo::appointments.fields.type'))
                        ->options(\Modules\SaluteOra\Enums\AppointmentTypeEnum::class)
                        ->required()
                        ->default('checkup'),

                    // Status
                    Components\Select::make('status')
                        ->label(__('salutemo::appointments.fields.status'))
                        ->options(\Modules\SaluteOra\Enums\AppointmentStatusEnum::class)
                        ->default('scheduled')
                        ->required(),

                    // Title
                    Components\TextInput::make('title')
                        ->label(__('salutemo::appointments.fields.title'))
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),

                    // Start Time
                    Components\DateTimePicker::make('starts_at')
                        ->label(__('salutemo::appointments.fields.starts_at'))
                        ->required()
                        ->native(false)
                        ->seconds(false)
                        ->columnSpan(1),

                    // End Time
                    Components\DateTimePicker::make('ends_at')
                        ->label(__('salutemo::appointments.fields.ends_at'))
                        ->required()
                        ->native(false)
                        ->seconds(false)
                        ->after('starts_at')
                        ->columnSpan(1),

                    // Emergency Toggle
                    Components\Toggle::make('emergency')
                        ->label(__('salutemo::appointments.fields.emergency'))
                        ->default(false)
                        ->columnSpan(2),

                    // Notes
                    Components\Textarea::make('notes')
                        ->label(__('salutemo::appointments.fields.notes'))
                        ->columnSpan(2)
                        ->columnSpanFull(),
                ]),
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
