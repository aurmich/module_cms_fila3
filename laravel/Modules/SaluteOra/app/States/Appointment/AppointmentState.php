<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Illuminate\Support\Arr;
use Spatie\ModelStates\State;
use Filament\Forms\Components;
use Spatie\ModelStates\StateConfig;
use Modules\Xot\Contracts\StateContract;
use Modules\SaluteOra\Models\Appointment;
use Modules\Xot\Filament\Traits\TransTrait;

/**
 * Abstract base class for appointment state management.
 *
 * Defines the state machine configuration and required methods
 * that must be implemented by each concrete state class.
 * 
 * @property string $value Il valore dello stato nel database
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
                ->default(Pending::class)
                
                // Pending transitions (In entrata)
                ->allowTransition(Pending::class, Confirmed::class, Transitions\PendingToConfirmed::class)
                ->allowTransition(Pending::class, Rejected::class, Transitions\PendingToRejected::class)
                
                // Confirmed transitions (Accettati)
                ->allowTransition(Confirmed::class, ReportPending::class, Transitions\ConfirmedToReportPending::class)
                ->allowTransition(Confirmed::class, Cancelled::class, Transitions\ConfirmedToCancelled::class)
                ->allowTransition(Confirmed::class, NoShow::class, Transitions\ConfirmedToNoShow::class)
                
                // NoShow transitions (gestione interna del conteggio)
                ->allowTransition(NoShow::class, Banned::class, Transitions\NoShowToBanned::class)
                
                // Completed transitions (Conclusi)
                //->allowTransition(Completed::class, RefundPending::class, Transitions\CompletedToRefundPending::class)
                //->allowTransition(Completed::class, ProBono::class, Transitions\CompletedToProBono::class)
                ->allowTransition(ReportCompleted::class, RefundPending::class, Transitions\ReportCompletedToRefundPending::class)
                ->allowTransition(ReportCompleted::class, ProBono::class, Transitions\ReportCompletedToProBono::class)
                
                // Report transitions
                ->allowTransition(ReportPending::class, ReportPending::class/*, Transitions\ReportPendingToReportCompleted::class*/)
                
                ->allowTransition(ReportPending::class, ReportCompleted::class, Transitions\ReportPendingToReportCompleted::class)
                
                // ReportCompleted transitions
                //->allowTransition(ReportCompleted::class, Completed::class, Transitions\ReportCompletedToCompleted::class)
                //->allowTransition(ReportCompleted::class, RefundPending::class, Transitions\ReportCompletedToRefundPending::class)
                //->allowTransition(ReportCompleted::class, ProBono::class, Transitions\ReportCompletedToProBono::class)
                
                // Refund transitions
                ->allowTransition(RefundPending::class, RefundAccepted::class, Transitions\RefundPendingToRefundAccepted::class)
                ->allowTransition(RefundPending::class, RefundToIntegrate::class, Transitions\RefundPendingToRefundToIntegrate::class)
                ->allowTransition(RefundPending::class, RefundCompleted::class, Transitions\RefundPendingToRefundCompleted::class)
                
                ->allowTransition(RefundAccepted::class, RefundCompleted::class, Transitions\RefundAcceptedToRefundCompleted::class)
                ->allowTransition(RefundToIntegrate::class, RefundCompleted::class, Transitions\RefundToIntegrateToRefundCompleted::class);
        
    }
    /*
    abstract public function label(): string;
    abstract public function color(): string;
    abstract public function bgColor(): string;
    
    abstract public function icon(): string;
    abstract public function modalHeading(): string;
    abstract public function modalDescription(): string;
    */

    public function label(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.label');
        //return 'Annullato';
    }

    public function color(): string
    {
        
        return static::transClass(__CLASS__,'states.'.static::$name.'.color');
        
    }

    public function bgColor(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.bg_color');
        //return 'info';
    }

    public function icon(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.icon');
        //return 'heroicon-o-x-circle';
    }

    public function modalHeading(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_heading');
        //return 'Annulla Appuntamento';
    }

    public function modalDescription(): string
    {
        $appointment = $this->getModel();
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_description');
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

    public function modalAction(array $arguments, array $data)
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
