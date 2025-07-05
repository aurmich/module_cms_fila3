<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents a rejected appointment.
 *
 * The appointment has been rejected by the medical staff.
 */
class Rejected extends AppointmentState
{
    /** @var string */
    public static $name = 'rejected';

    public function label(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.label');
        //return 'Respinto';
    }

    public function color(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.color');
        //return 'danger';
    }

    public function bgColor(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.bg_color');
        //return 'info';
    }

    public function icon(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.icon');
        //return 'heroicon-o-x-mark';
    }

    public function canBeModified(): bool
    {
        return false;
    }

    public function isActive(): bool
    {
        return false;
    }

    public function isRejected(): bool
    {
        return true;
    }

    public function modalHeading(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_heading');
        //return 'Rifiuta appuntamento';
    }

    public function modalDescription(): string
    {
        $appointment = $this->getModel();
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_description');
        //return 'Sei sicuro di voler rifiutare l\'appuntamento con '. $appointment->patient?->full_name.' ?';
    }
}
