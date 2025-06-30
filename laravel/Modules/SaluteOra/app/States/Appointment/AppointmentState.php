<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

/**
 * Abstract base class for appointment state management.
 *
 * Defines the state machine configuration and required methods
 * that must be implemented by each concrete state class.
 */
abstract class AppointmentState extends State
{
    /**
     * Configure the allowed state transitions.
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(static::class === self::class ? Pending::class : static::class)
            
            // Pending transitions
            ->allowTransition(Pending::class, Confirmed::class, Transitions\PendingToConfirmed::class)
            ->allowTransition(Pending::class, Cancelled::class, Transitions\PendingToCancelled::class)

            // Confirmed transitions
            ->allowTransition(Confirmed::class, Scheduled::class, Transitions\ConfirmedToScheduled::class)
            ->allowTransition(Confirmed::class, Cancelled::class, Transitions\ConfirmedToCancelled::class)
            ->allowTransition(Confirmed::class, Rescheduled::class, Transitions\ConfirmedToRescheduled::class)

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
    
    /**
     * Get the available statuses for the appointment.
     * 
     * @return array<class-string, string> Array of state classes and their display labels
     */
    public static function getStatuses(): array
    {
        // Create a mock model to pass to state constructors
        $model = new class {
            public function getMorphClass() {
                return 'appointment';
            }
        };
        
        return [
            Pending::class => (new Pending($model))->label(),
            Confirmed::class => (new Confirmed($model))->label(),
            Scheduled::class => (new Scheduled($model))->label(),
            InProgress::class => (new InProgress($model))->label(),
            Completed::class => (new Completed($model))->label(),
            Cancelled::class => (new Cancelled($model))->label(),
            Rejected::class => (new Rejected($model))->label(),
            NoShow::class => (new NoShow($model))->label(),
            Rescheduled::class => (new Rescheduled($model))->label(),
        ];
    }
}
