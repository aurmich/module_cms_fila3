<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\ModelStates\State;
use Filament\Forms\Components;
use Spatie\ModelStates\StateConfig;
use Filament\Forms\Components\Textarea;
use Modules\SaluteOra\Models\Appointment;
use Modules\Xot\Filament\Traits\TransTrait;
//use Filament\Support\Contracts\HasLabel;

/**
 * Classe astratta base per la gestione degli stati dell'utente.
 *
 * Questa classe definisce le transizioni di stato consentite e i metodi astratti
 * che devono essere implementati da ogni stato concreto.
 */
abstract class UserState extends State
{
    use TransTrait;
    

    /**
     * Configura le transizioni di stato consentite.
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            // Pending transitions
            ->allowTransition(Pending::class, Active::class, Transitions\PendingToActive::class)
            ->allowTransition(Pending::class, Rejected::class, Transitions\PendingToRejected::class)
            ->allowTransition(Pending::class, IntegrationRequested::class, Transitions\PendingToIntegrationRequested::class)

            // Active transitions
            ->allowTransition(Active::class, Suspended::class, Transitions\ActiveToSuspended::class)
            ->allowTransition(Active::class, Inactive::class, Transitions\ActiveToInactive::class)
            ->allowTransition(Active::class, IntegrationRequested::class, Transitions\ActiveToIntegrationRequested::class)

            // IntegrationRequested transitions
            ->allowTransition(IntegrationRequested::class, Active::class, Transitions\IntegrationRequestedToActive::class)
            ->allowTransition(IntegrationRequested::class, Rejected::class, Transitions\IntegrationRequestedToRejected::class)
            ->allowTransition(IntegrationRequested::class, IntegrationCompleted::class, Transitions\IntegrationRequestedToIntegrationCompleted::class)

            // IntegrationCompleted transitions
            ->allowTransition(IntegrationCompleted::class, Active::class, Transitions\IntegrationCompletedToActive::class)
            ->allowTransition(IntegrationCompleted::class, Rejected::class, Transitions\IntegrationCompletedToRejected::class)
            ->allowTransition(IntegrationCompleted::class, IntegrationRequested::class, Transitions\IntegrationCompletedToIntegrationRequested::class)

            // Rejected transitions
            ->allowTransition(Rejected::class, Pending::class, Transitions\RejectedToPending::class)

            // Suspended transitions
            ->allowTransition(Suspended::class, Active::class, Transitions\SuspendedToActive::class)
            ->allowTransition(Suspended::class, Inactive::class, Transitions\SuspendedToInactive::class)

            // Inactive transitions
            ->allowTransition(Inactive::class, Active::class, Transitions\InactiveToActive::class)

            // Register all states
            ->registerState(Pending::class)
            ->registerState(Active::class)
            ->registerState(Inactive::class)
            ->registerState(Rejected::class)
            ->registerState(Suspended::class)
            ->registerState(IntegrationRequested::class)
            ->registerState(IntegrationCompleted::class);
    }


    public static function getName(): string
    {
        /** @phpstan-ignore-next-line */
        return static::$name ?? Str::of(class_basename(static::class))->snake()->toString();
    }

    public function label(): string
    {
        return static::transClass(__CLASS__,'states.'.static::getName().'.label');
        //return 'Annullato';
    }

    public function color(): string
    {
        
        return static::transClass(__CLASS__,'states.'.static::getName().'.color');
        
    }

    public function bgColor(): string
    {
        return static::transClass(__CLASS__,'states.'.static::getName().'.bg_color');
        //return 'info';
    }

    public function icon(): string
    {
        return static::transClass(__CLASS__,'states.'.static::getName().'.icon');
        //return 'heroicon-o-x-circle';
    }

    public function modalHeading(): string
    {
        return static::transClass(__CLASS__,'states.'.static::getName().'.modal_heading');
        //return 'Annulla Appuntamento';
    }

    public function modalDescription(): string
    {
        $appointment = $this->getModel();
        return static::transClass(__CLASS__,'states.'.static::getName().'.modal_description');
        //return 'Sei sicuro di voler annullare questo appuntamento?';
    }

    public function modalFormSchema(): array
    {
        return [
            'message'=>Components\Textarea::make('message')
                ->required()
                ->maxLength(255),
     
        ];
    }

    public function modalFillForm(array $arguments,array $data): array
    {
        return $data;
    }

    public function modalAction(array $arguments, array $data):void
    {
        $this->processStateAction($arguments,$data);
    }

    public function processStateAction(array $arguments,array $data): void
    {
        $message=Arr::get($data,'message');
        $appointmentId = $arguments['appointment'];
        $appointment = Appointment::firstWhere('id',$appointmentId);
        $stateClass=static::class;
        $appointment?->state->transitionTo($stateClass,$message);
        // Per ora implementazione di debug
        //$this->dispatch('notify', [
        //    'type' => 'info',
        //    'message' => 'Funzionalità eliminazione in sviluppo',
        //]);
        /*
        $this->invalidateCache();
        $this->loadAppointments();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => __('saluteora::widgets.doctor_appointments.messages.appointment_confirmed'),
        ]);
        */
    }
}
