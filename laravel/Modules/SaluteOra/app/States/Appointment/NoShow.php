<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents an appointment where patient didn't show up.
 *
 * The patient failed to attend the scheduled appointment.
 */
class NoShow extends AppointmentState
{
    /** @var string */
    public static $name = 'no_show';

    public function label(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.label');
        //return 'Assente';
    }

    public function color(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.color');
        //return 'warning';
    }

    public function icon(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.icon');
        //return 'heroicon-o-user-minus';
    }

    public function canBeModified(): bool
    {
        return false;
    }

    public function isActive(): bool
    {
        return false;
    }

    public function isCancelled(): bool
    {
        return true;
    }

    public function modalHeading(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_heading');
        //return __('saluteora::states.no_show.modal_heading');
    }

    public function modalDescription(): string
    {
        $appointment = $this->getModel();
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_description');
        //return __('saluteora::states.no_show.modal_description');
    }
}