<?php

declare(strict_types=1);

namespace Modules\Xot\States;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\ModelStates\State;
use Filament\Forms\Components;
use Spatie\ModelStates\StateConfig;
use Illuminate\Database\Eloquent\Model;

use Modules\Xot\Contracts\StateContract;
use Modules\Xot\Filament\Traits\TransTrait;

/**
 * Abstract base class for appointment state management.
 *
 * Defines the state machine configuration and required methods
 * that must be implemented by each concrete state class.
 * @property string $name Il nome dello stato
 * @property string $value Il valore dello stato nel database
 */
abstract class XotBaseState extends State implements StateContract
{
    use TransTrait;
    public static string $name;
    /*
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
                ->allowTransition(ReportPending::class, ReportPending::class)
                
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
    */
    public static function getName(): string
    {
        /** @phpstan-ignore-next-line */
        return static::$name ?? Str::of(class_basename(static::class))->snake()->toString();
    }

    public function label(): string
    {
        
        return static::transClass(static::class,'states.'.static::getName().'.label');
        //return 'Annullato';
    }

    public function color(): string
    {
        
        return static::transClass(static::class,'states.'.static::getName().'.color');
        
    }

    public function bgColor(): string
    {
        return static::transClass(static::class,'states.'.static::getName().'.bg_color');
        //return 'info';
    }

    public function icon(): string
    {
        return static::transClass(static::class,'states.'.static::getName().'.icon');
        //return 'heroicon-o-x-circle';
    }

    public function modalHeading(): string
    {
        return static::transClass(static::class,'states.'.static::getName().'.modal_heading');
        //return 'Annulla Appuntamento';
    }

    public function modalDescription(): string
    {
        $appointment = $this->getModel();
        return static::transClass(static::class,'states.'.static::getName().'.modal_description');
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

    public function modalFillFormByRecord(Model $record): array
    {
        return [];
    }

    public function modalAction(array $arguments, array $data):void
    {
        $this->processStateAction($arguments,$data);
    }

    public function processStateAction(array $arguments,array $data): void
    {
        $message=Arr::get($data,'message');
        $stateClass=static::class;
        /*
        
        $appointmentId = $arguments['appointment'];
        $appointment = Appointment::firstWhere('id',$appointmentId);
        
        $appointment?->state->transitionTo($stateClass,$message);
        */
        $record=$this->getModel();
        /** @phpstan-ignore-next-line */
        $record->state->transitionTo($stateClass,$message);
    }


    public function modalActionByRecord(Model $record, array $data): void
    {
        $this->processStateActionByRecord($record,$data);
    }

    public function processStateActionByRecord(Model $record,array $data): void
    {
        $message=Arr::get($data,'message');
        $stateClass=static::class;
        /*
        
        $appointmentId = $arguments['appointment'];
        $appointment = Appointment::firstWhere('id',$appointmentId);
        
        $appointment?->state->transitionTo($stateClass,$message);
        */
        /** @phpstan-ignore-next-line */
        $record->state->transitionTo($stateClass,$message);
    }
}
