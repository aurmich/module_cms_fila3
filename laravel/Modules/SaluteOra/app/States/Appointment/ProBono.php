<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;
use Filament\Forms\Components;

/**
 * Represents a cancelled appointment.
 *
 * The appointment has been cancelled by either party.
 */
class ProBono extends AppointmentState
{
    /** @var string */
    public static $name = 'pro_bono';


    public function modalFormSchema(): array
    {
        return [
            'message'=>Components\Textarea::make('message')
                ->required()
                ->maxLength(255),
            'probono_acceptance' => Components\Checkbox::make('probono_acceptance')
                ->required()
                ->rules(['accepted'])
                ->columnSpanFull(),
        ];
    }
}