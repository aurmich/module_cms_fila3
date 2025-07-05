<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents an appointment currently in progress.
 *
 * The appointment session has started and is actively taking place.
 */
class InProgress extends AppointmentState
{
    /** @var string */
    public static $name = 'in_progress';

    public function label(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.label');
        //return 'In corso';
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
        //return 'heroicon-o-play-circle';
    }

    public function canBeModified(): bool
    {
        return true;
    }

    public function isActive(): bool
    {
        return true;
    }

    public function modalHeading(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_heading');
        //return __('saluteora::states.in_progress.modal_heading');
    }

    public function modalDescription(): string
    {
        $appointment = $this->getModel();
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_description');
        //return __('saluteora::states.in_progress.modal_description');
    }
}