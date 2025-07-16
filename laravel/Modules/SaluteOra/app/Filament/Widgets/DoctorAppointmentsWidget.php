<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Illuminate\Support\Arr;
use Livewire\Attributes\On;
use Filament\Actions\Action;
use Webmozart\Assert\Assert;
use Spatie\ModelStates\State;
use Filament\Facades\Filament;
use Illuminate\Support\HtmlString;
use Modules\SaluteOra\Models\Report;
use Illuminate\Support\Facades\Cache;
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Contracts\StateContract;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Models\Appointment;
use Filament\Actions\Contracts\HasActions;
use Illuminate\Database\Eloquent\Collection;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\Media\Actions\SaveAttachmentsAction;
use Modules\SaluteOra\States\Appointment\Pending;
use Modules\SaluteOra\States\Appointment\Rejected;
use Filament\Actions\Concerns\InteractsWithActions;
use Modules\SaluteOra\States\Appointment\Confirmed;
use Modules\Media\Actions\GetAttachmentsSchemaAction;
use Modules\SaluteOra\States\Appointment\ReportPending;
use Modules\SaluteOra\Filament\Resources\ReportResource;
use Modules\SaluteOra\States\Appointment\AppointmentState;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Modules\SaluteOra\States\Appointment as StateAppointment;

/**
 * Widget per gestire gli appuntamenti del dottore.
 * 
 * Mostra gli appuntamenti in stato pending per il dottore loggato
 * con azioni per confermare o rifiutare gli appuntamenti.
 */
class DoctorAppointmentsWidget extends XotBaseWidget implements HasActions
{
    use InteractsWithActions;
    //public string $state;
    public string $doctor_id;
    public array $states = [];
    public array $all_states = [];

    /**
     * Vista del widget.
     */
    protected static string $view = 'pub_theme::filament.widgets.doctor-appointments-widget';

    /**
     * Schema del form per il widget.
     * 
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        // Questo widget non ha form, restituisce array vuoto
        return [];
    }

    /**
     * Ordinamento del widget.
     */
    protected static ?int $sort = 2;

    /**
     * Altezza massima del widget.
     */
    protected static ?string $maxHeight = '400px';

    /**
     * Appuntamenti caricati.
     *
     * @var Collection<int, Appointment>
     */
    public Collection $appointments;

    /**
     * Monta il widget.
     */
    public function mount(): void
    {
        $all_states=AppointmentState::getStateMapping()->toArray();
        $this->all_states=$all_states;
        //$this->states=['delete']; //testing
        $this->loadAppointments();
    }

    /**
     * Controlla se l'utente può visualizzare il widget.
     */
    public static function canView(): bool
    {
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        // Solo i dottori possono vedere questo widget
        if ($user->type !== UserTypeEnum::DOCTOR) {
            return false;
        }

       

        return true;
    }

    /**
     * Carica gli appuntamenti pending per il dottore corrente.
     */
    private function loadAppointments(): void
    {
        
        $this->invalidateCache();
        $cacheKey = $this->getCacheKey();
        
        /** @phpstan-ignore-next-line */        
        $this->appointments = Cache::remember($cacheKey, 300, function ()  {
            return Appointment::query()
                ->with(['patient', 'doctor', 'studio'])
                ->where('doctor_id', $this->doctor_id)
                //->whereState('state', Pending::class)
                ->whereIn('state', $this->states)
                ->orderBy('starts_at', 'asc')
                ->limit(10)
                ->get();
        });
    }

    /**
     * Genera la chiave di cache per gli appuntamenti.
     */
    private function getCacheKey(): string
    {
       
        $key= sprintf(
            'doctor_appointments_%s_%s',
            $this->doctor_id ?? 0,
            implode('_',$this->states),
        );
        return $key;
    }

    

    /**
     * Trova un appuntamento per ID verificando che appartenga al dottore corrente.
     */
    private function findAppointment(int $appointmentId): ?Appointment
    {
        return $this->appointments->firstWhere('id', $appointmentId);
    }

    /**
     * Invalida la cache degli appuntamenti.
     */
    private function invalidateCache(): void
    {
        Cache::forget($this->getCacheKey());
    }

    /**
     * Refresh del widget quando ci sono cambiamenti.
     */
    #[On('appointment-updated')]
    public function refresh(): void
    {
        $this->invalidateCache();
        $this->loadAppointments();
    }



    /**
     * Azioni disponibili per il widget.
     * 
     * @return array<Action>
     */
    protected function getActions(): array
    {
        return [
            $this->deleteAction(),
        ];
    }

    /**
     * Azione per eliminare un appuntamento.
     */
    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->label('Elimina')
            ->icon('heroicon-o-trash')
            ->color('danger')
            ->requiresConfirmation()
            ->modalHeading('Elimina Appuntamento')
            ->modalDescription('Sei sicuro di voler eliminare questo appuntamento?')
            ->action(function (array $data) {
                // Per ora implementazione di debug
                $this->dispatch('notify', [
                    'type' => 'info',
                    'message' => 'Funzionalità eliminazione in sviluppo',
                ]);
            });
    }

    public function canTransitionTo(int $appointmentId,string $stateClass): bool
    {
        $appointment = Appointment::firstWhere('id',$appointmentId);
        //$startStateClass=AppointmentState::getStateMapping()->get($this->states[0]);
        //$startState=new $startStateClass($appointment);
        $startState=$appointment->state;
        return $startState->canTransitionTo($stateClass);
    }

    public function transitionAction()
    {
        //return $this->getActionByState($stateClass,$stateClass::$name.'1');
    }

    public function processStateAction(string $stateClass,array $arguments,array $data): void
    {
        $message=Arr::get($data,'message');
        $appointmentId = $arguments['appointment'];
        $appointment = Appointment::firstWhere('id',$appointmentId);
        $appointment?->state->transitionTo($stateClass,$message);
        // Per ora implementazione di debug
        //$this->dispatch('notify', [
        //    'type' => 'info',
        //    'message' => 'Funzionalità eliminazione in sviluppo',
        //]);
        $this->invalidateCache();
        $this->loadAppointments();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => __('saluteora::widgets.doctor_appointments.messages.appointment_confirmed'),
        ]);
    }

    public function getActionByState(string $stateClass,string $name): Action
    {
        
    $appointment = new Appointment(); // senza salvarlo nel db
    $state = new $stateClass($appointment);
    /*
    //Assert::isInstanceOf($state,StateContract::class);
    Assert::implementsInterface($state,StateContract::class);
    $startStateClass=AppointmentState::getStateMapping()->get($this->state);
    $startState=new $startStateClass($appointment);
    Assert::isInstanceOf($startState,State::class);
    */
    
   
    return Action::make($name)
        ->iconButton()
        //->button()
        ->size(ActionSize::ExtraLarge)
        ->tooltip($state->label())
        ->icon($state->icon())
        ->color($state->color())
        ->requiresConfirmation()
        ->modalHeading($state->modalHeading())
        ->modalDescription($state->modalDescription())
        ->form([
            Textarea::make('message')
                ->required()
                ->maxLength(255),
        ])
        ->action(function (array $data,$arguments) use($stateClass){
            $this->processStateAction($stateClass,$arguments,$data);
        })
        //->visible($startState->canTransitionTo($stateClass))
        ;
        
            
   }

   public function reportAction(): Action
    {
        $appointment = new Appointment(); // senza salvarlo nel db
        $state = new ReportPending($appointment);
        //Assert::isInstanceOf($state,StateContract::class);
        Assert::implementsInterface($state,StateContract::class);
        $startStateClass=AppointmentState::getStateMapping()->get($this->state);
        $startState=new $startStateClass($appointment);
        Assert::isInstanceOf($startState,State::class);

        return Action::make('report')
            ->iconButton()
            ->size(ActionSize::ExtraLarge)
            ->modalHeading(static::trans('actions.report.modal_heading'))
            ->modalDescription(static::trans('actions.report.modal_description'))
            //->tooltip('Crea Referto')
            ->icon(static::trans('actions.report.icon'))
            ->modalIcon(static::trans('actions.report.modal_icon'))
            ->color('info')
            //->requiresConfirmation()
            ->modalWidth('100%')
            ->form(ReportResource::getFormSchema())
            ->action(function (array $arguments,array $data) {
                dd(['arguments'=>$arguments,'data'=>$data]);
            })
            //->visible($startState->canTransitionTo($state::class))
            ->visible(true)
        ;
    }

   


    public function confirmAction(): Action
    {
        return $this->getActionByState(StateAppointment\Confirmed::class,__FUNCTION__);
    }

    public function rejectAction(): Action
    {
        return $this->getActionByState(StateAppointment\Rejected::class,__FUNCTION__);
    }

    public function cancelledAction(): Action
    {
        return $this->getActionByState(StateAppointment\Cancelled::class,__FUNCTION__);
    }

    public function noShowAction(): Action
    {
        return $this->getActionByState(StateAppointment\NoShow::class,__FUNCTION__);
    }

    public function reportCompletedAction(): Action
    {
        return $this->getActionByState(StateAppointment\ReportCompleted::class,__FUNCTION__);
    }

    public function completedAction(): Action
    {
        return $this->getActionByState(StateAppointment\Completed::class,__FUNCTION__);
    }

    public function proBonoAction(): Action
    {
        return $this->getActionByState(StateAppointment\ProBono::class,__FUNCTION__);
    }

    public function refundPendingAction(): Action
    {
        $attachments=['invoice'];
        $disk='local';
        return $this->getActionByState(StateAppointment\RefundPending::class,__FUNCTION__)
        ->form(function() use($attachments,$disk){
            $schema=app(GetAttachmentsSchemaAction::class)->execute($attachments,$disk);
            return $schema;
        })->action(function (array $data,array $arguments) use($attachments,$disk) {
            $processData=$data;
            $appointmentId = $arguments['appointment'];
            $appointment = Appointment::firstWhere('id',$appointmentId);
            $processData['appointment_id']=$appointmentId;
            $processData['patient_id']=$appointment->patient_id;
            $processData['doctor_id']=$appointment->doctor_id;
            $where=['appointment_id'=>$appointmentId];
            $report=Report::firstOrCreate($where);
            $report->update($processData);
            app(SaveAttachmentsAction::class)->execute($report,$attachments,$data,$disk);
            app(SaveAttachmentsAction::class)->execute($appointment,$attachments,$data,$disk);

            //$this->processStateAction($stateClass,$arguments,$data);
            
        });
    }

    public function refundAcceptedAction(): Action
    {
        return $this->getActionByState(StateAppointment\RefundAccepted::class,__FUNCTION__);
    }

    public function refundToIntegrateAction(): Action
    {
        return $this->getActionByState(StateAppointment\RefundToIntegrate::class,__FUNCTION__);
    }

    public function refundCompletedAction(): Action
    {
        return $this->getActionByState(StateAppointment\RefundCompleted::class,__FUNCTION__);
    }


    public function reportPendingAction(): Action
    {
        $stateClass=StateAppointment\ReportPending::class;
        return $this->getActionByState($stateClass,__FUNCTION__)
        ->modalWidth('100%')
        ->form(ReportResource::getFormSchema())
        ->fillForm(function (array $data,$arguments) {
            $appointmentId = $arguments['appointment'];
            $where=['appointment_id'=>$appointmentId];
            $report=Report::firstOrCreate($where);
            return $report->attributesToArray();
            
        })
        ->action(function (array $data,$arguments) use($stateClass){
            $processData=$data;
            $appointmentId = $arguments['appointment'];
            $appointment = Appointment::firstWhere('id',$appointmentId);
            $processData['appointment_id']=$appointmentId;
            $processData['patient_id']=$appointment->patient_id;
            $processData['doctor_id']=$appointment->doctor_id;
            $where=['appointment_id'=>$appointmentId];
            $report=Report::firstOrCreate($where);
            $report->update($processData);


            $this->processStateAction($stateClass,$arguments,$data);
        });
    }

   

    public function infoAction(): Action
    {
    return Action::make('info')
        ->iconButton()
        //->label('Mostra Info')
        ->size(ActionSize::ExtraLarge)
        ->icon('heroicon-o-information-circle')
        ->color('info')
        ->modalHeading('Dettagli appuntamento')
        ->modalContent(function (array $data,$arguments) {
            $appointmentId = $arguments['appointment'];
            $appointment = Appointment::firstWhere('id',$appointmentId);
            $view='pub_theme::appointment.card';
            $view_params=[
                'appointment' => $appointment,
            ];
            return view($view,$view_params);
            //return  new HtmlString($arguments['appointment']);
        })
        ->modalSubmitAction(false) // ⛔️ nasconde il bottone di conferma
        ->modalCancelActionLabel('Chiudi'); // ✅ personalizzi il bottone di chiusura
    }
}
