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
use Modules\SaluteOra\States\Appointment\Pending;
use Modules\SaluteOra\States\Appointment\Rejected;
use Filament\Actions\Concerns\InteractsWithActions;
use Modules\SaluteOra\States\Appointment\Confirmed;
use Modules\SaluteOra\Filament\Resources\ReportResource;
use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Widget per gestire gli appuntamenti del dottore.
 * 
 * Mostra gli appuntamenti in stato pending per il dottore loggato
 * con azioni per confermare o rifiutare gli appuntamenti.
 */
class DoctorAppointmentsWidget extends XotBaseWidget implements HasActions
{
    use InteractsWithActions;
    public string $state;
    public string $doctor_id;
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
        

        $cacheKey = $this->getCacheKey();
        
        /** @phpstan-ignore-next-line */        
        $this->appointments = Cache::remember($cacheKey, 300, function ()  {
            return Appointment::query()
                ->with(['patient', 'doctor', 'studio'])
                ->where('doctor_id', $this->doctor_id)
                //->whereState('state', Pending::class)
                ->where('state', $this->state)
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
            $this->state,
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

   public function getActionByState(string $stateClass,string $name): Action
   {
    $appointment = new Appointment(); // senza salvarlo nel db
    $state = new $stateClass($appointment);
    //Assert::isInstanceOf($state,StateContract::class);
    Assert::implementsInterface($state,StateContract::class);
    $startStateClass=AppointmentState::getStateMapping()->get($this->state);
    $startState=new $startStateClass($appointment);
    Assert::isInstanceOf($startState,State::class);
    
    
   
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
        })
        ->visible($startState->canTransitionTo($stateClass))
        ;
        
            
   }

   public function reportAction(): Action
{
    return Action::make('report')
        ->iconButton()
        ->size(ActionSize::ExtraLarge)
        ->tooltip('Crea Referto')
        ->icon('heroicon-o-document-text')
        ->color('warning')
        ->requiresConfirmation()
        ->modalWidth('100%')
        ->form(ReportResource::getFormSchema())
        ->action(function (array $arguments) {
            dd('Test action called', $arguments);
        });
}

   public function createReportAction(): Action
   {
    return Action::make('create-report')
    ->iconButton()
    //->button()
    ->size(ActionSize::ExtraLarge)
    ->tooltip('Crea Referto')
    ->icon('heroicon-o-document-text')
    ->color('warning')
    ->requiresConfirmation()
    ->modalHeading('sssssssssss')
    ->modalDescription('sddddddddddddddddd')
    ->form([
        Textarea::make('message')
            ->required()
            ->maxLength(255),
    ])->fillForm(function (array $data,$arguments) {
        dddx(['data'=>$data,'arguments'=>$arguments]);
    })
    ->action(function (array $data,$arguments) {
        dddx(['data'=>$data,'arguments'=>$arguments]);
    })
    ->visible(true)
    ;
   }


    public function confirmAction(): Action
    {
        return $this->getActionByState(Confirmed::class,__FUNCTION__);
       
    }

    public function rejectAction(): Action
    {
        return $this->getActionByState(Rejected::class,__FUNCTION__);
       
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
