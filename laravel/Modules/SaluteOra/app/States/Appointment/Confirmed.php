<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents a confirmed appointment.
 *
 * The appointment has been confirmed by both parties.
 */
class Confirmed extends AppointmentState
{
    /** @var string */
    public static $name = 'confirmed';

    public function label(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.label');
        //return static::transClass(self::class,'label');
        //return 'Confermato';
    }

    public function color(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.color');
        //return 'success';
    }

    public function icon(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.icon');
        //return 'heroicon-o-check-circle';
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
        //return 'Accetta appuntamento';
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_heading');
    }
    public function modalDescription(): string
    {
        $appointment = $this->getModel();
        //return 'Sei sicuro di voler l\' appuntamento con '.$appointment->patient->full_name.' ?';
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_description');
    }
}