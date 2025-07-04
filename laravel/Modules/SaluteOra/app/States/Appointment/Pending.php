<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents an appointment that is pending confirmation.
 *
 * This is the default state for newly requested appointments.
 */
class Pending extends AppointmentState
{
    /** @var string */
    public static $name = 'pending';

    public function label(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.label');
        //return 'In attesa';
    }

    public function color(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.color');
        //return 'warning';
    }

    public function icon(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.icon');
        //return 'heroicon-o-clock';
    }

    public function canBeModified(): bool
    {
        return true;
    }

    public function isActive(): bool
    {
        return false;
    }

    public function isPending(): bool
    {
        return true;
    }
    
    public function modalHeading(): string
    {
        return static::transClass(__CLASS__, 'states.'.static::$name.'.modal_heading');
        //return 'Appuntamento in Attesa';
    }

    public function modalDescription(): string
    {
        $appointment = $this->getModel();
        return static::transClass(__CLASS__, 'states.'.static::$name.'.modal_description');
        //return 'Questo appuntamento è in attesa di conferma.';
    }
} 