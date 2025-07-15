<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents a completed appointment.
 *
 * The appointment has been successfully conducted and finished.
 * This is a final state with no further transitions.
 */
class ReportCompleted extends AppointmentState
{
    /** @var string */
    public static $name = 'report_completed';

    public function label(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.label');
        //return 'Completato';
    }

    public function color(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.color');
        //return 'success';
    }

    public function bgColor(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.bg_color');
        //return 'info';
    }

    public function icon(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.icon');
        //return 'heroicon-o-check-badge';
    }

    public function canBeModified(): bool
    {
        return false;
    }

    public function isActive(): bool
    {
        return false;
    }

    public function isCompleted(): bool
    {
        return true;
    }

    public function modalHeading(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_heading');
        //return __('saluteora::states.completed.modal_heading');
    }

    public function modalDescription(): string
    {
        $appointment = $this->getModel();
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_description');
        //return __('saluteora::states.completed.modal_description');
    }
}