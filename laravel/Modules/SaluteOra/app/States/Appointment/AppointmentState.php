<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;
use Modules\Xot\Contracts\StateContract;
use Modules\Xot\Filament\Traits\TransTrait;

/**
 * Abstract base class for appointment state management.
 *
 * Defines the state machine configuration and required methods
 * that must be implemented by each concrete state class.
 */
abstract class AppointmentState extends State implements StateContract
{
    use TransTrait;
    /**
     * Configure the allowed state transitions.
     */
    public static function config(): StateConfig
    {
        return parent::config()
            //->default(static::class === self::class ? Pending::class : static::class)
            ->default(Pending::class)
            // Pending transitions
            ->allowTransition(Pending::class, Confirmed::class, Transitions\PendingToConfirmed::class)
            //->allowTransition(Pending::class, Cancelled::class, Transitions\PendingToCancelled::class)
            ->allowTransition(Pending::class, Rejected::class, Transitions\PendingToRejected::class)

            // Confirmed transitions
            //->allowTransition(Confirmed::class, Scheduled::class, Transitions\ConfirmedToScheduled::class)
            //->allowTransition(Confirmed::class, Cancelled::class, Transitions\ConfirmedToCancelled::class)
            //->allowTransition(Confirmed::class, Rescheduled::class, Transitions\ConfirmedToRescheduled::class)
            ->allowTransition(Confirmed::class, Rejected::class, Transitions\ConfirmedToRejected::class)

            // Rejected transitions
            //->allowTransition(Rejected::class, Confirmed::class, Transitions\RejectedToConfirmed::class)

            // Scheduled transitions
            ->allowTransition(Scheduled::class, InProgress::class, Transitions\ScheduledToInProgress::class)
            ->allowTransition(Scheduled::class, Cancelled::class, Transitions\ScheduledToCancelled::class)
            ->allowTransition(Scheduled::class, NoShow::class, Transitions\ScheduledToNoShow::class)
            ->allowTransition(Scheduled::class, Rescheduled::class, Transitions\ScheduledToRescheduled::class)

            // InProgress transitions
            ->allowTransition(InProgress::class, Completed::class, Transitions\InProgressToCompleted::class)
            
            // Rescheduled transitions
            ->allowTransition(Rescheduled::class, Confirmed::class, Transitions\RescheduledToConfirmed::class);
    }
    
    abstract public function label(): string;
    abstract public function color(): string;
    abstract public function icon(): string;
    abstract public function modalHeading(): string;
    abstract public function modalDescription(): string;
}
