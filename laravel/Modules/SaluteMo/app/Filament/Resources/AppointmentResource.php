<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Filament\Forms\Components;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SaluteOra\Models\Appointment;

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
            Components\Section::make()
                ->schema([
                    Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),

                    Components\DateTimePicker::make('start_time')
                        ->required()
                        ->native(false),

                    Components\DateTimePicker::make('end_time')
                        ->required()
                        ->native(false)
                        ->after('start_time'),

                    Components\Select::make('status')
                        ->options([
                            'scheduled' => 'scheduled',
                            'confirmed' => 'confirmed',
                            'cancelled' => 'cancelled',
                            'completed' => 'completed',
                            'no_show' => 'no_show',
                        ])
                        ->default('scheduled')
                        ->required(),
                ])
                ->columns(1),

            Components\Section::make()
                ->schema([
                    Components\Textarea::make('notes')
                        ->columnSpanFull(),

                    Components\Toggle::make('is_emergency')
                        ->default(false),
                ]),
        ];
    }
}
