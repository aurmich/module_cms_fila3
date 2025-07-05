<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents a rescheduled appointment.
 *
 * The appointment has been moved to a new date/time.
 */
class Rescheduled extends AppointmentState
{
    /** @var string */
    public static $name = 'rescheduled';

    public function label(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.label');
        //return 'Riprogrammato';
    }

    public function color(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.color');
        //return 'info';
    }

    public function bgColor(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.bg_color');
        //return 'info';
    }

    public function icon(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.icon');
        //return 'heroicon-o-arrow-path';
    }

    public function canBeModified(): bool
    {
        return true;
    }

    public function isActive(): bool
    {
        return false;
    }

    public function modalHeading(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_heading');
        //return __('saluteora::states.rescheduled.modal_heading');
    }

    public function modalDescription(): string
    {
        $appointment = $this->getModel();
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_description');
        //return __('saluteora::states.rescheduled.modal_description');
    }
} 