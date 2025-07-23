<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Filament\Actions\Action;
use Filament\Forms\Components;
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
use Illuminate\Support\Facades\Gate;

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
        
        /** @phpstan-ignore assign.propertyType */        
        $this->appointments = Cache::remember($cacheKey, 300, function ()  {
            return Appointment::query()
                ->with(['patient', 'doctor', 'studio'])
                ->where('doctor_id', $this->doctor_id)
                //->whereState('state', Pending::class)
                ->whereIn('state', $this->states)
                ->orderBy('starts_at', 'asc')
                ->limit(100)
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
            //
        ];
    }

    

    public function canTransitionTo(int $appointmentId,string $stateClass): bool
    {
        $appointment = Appointment::firstWhere('id',$appointmentId);
        if(null == $appointment){
            return false;
        }
        $startState=$appointment->state;
        if(!$startState->canTransitionTo($stateClass)){
            return false;
        }
        $policy=Str::of(class_basename($stateClass))->camel()->toString();
        if(!Gate::allows($policy, $appointment)){
            return false;
        }
        

        return true;
    }

   

   public function transitionAction(): Action
   {
        return Action::make('transition')
            ->iconButton()
            //->button()
            ->size(ActionSize::ExtraLarge)
            ->tooltip(fn($arguments,$data)=>$this->getState(arguments:$arguments)->label())
            ->icon(fn($arguments,$data)=>$this->getState(arguments:$arguments)->icon())
            ->color(fn($arguments,$data)=>$this->getState(arguments:$arguments)->color())
            ->requiresConfirmation()
            ->modalHeading(fn($arguments,$data)=>$this->getState(arguments:$arguments)->modalHeading())
            ->modalDescription(fn($arguments,$data)=>$this->getState(arguments:$arguments)->modalDescription())
            ->form(fn($arguments,$data)=>$this->getState(arguments:$arguments)->modalFormSchema())
            ->fillForm(fn($arguments,$data)=>$this->getState(arguments:$arguments)->modalFillForm($arguments,$data))
            ->action(function($arguments,$data){
                $this->getState(arguments:$arguments)->modalAction($arguments,$data);
                $this->invalidateCache();
                $this->loadAppointments();
                $this->dispatch('notify', [
                    'type' => 'success',
                    'message' => __('saluteora::widgets.doctor_appointments.messages.appointment_confirmed'),
                ]);
            })
            //->visible(fn($arguments,$data)=>$this->getState(arguments:$arguments)->canTransitionTo($arguments['stateClass']))
            ;
   }

   public function getState(array $arguments): AppointmentState
   {
        $cacheKey=sprintf('state_%s',implode('_',$arguments));
        $cacheKey=(Str::of($cacheKey)->slug()->toString());
            $state=Cache::remember($cacheKey, 300, function () use($arguments)  {
            $stateClass=Arr::get($arguments,'stateClass');
            $appointmentId=Arr::get($arguments,'appointment');
            $appointment=Appointment::firstWhere('id',$appointmentId);
            $state=new $stateClass($appointment);

            return $state;
        });
        Assert::isInstanceOf($state,AppointmentState::class);
        return $state;
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
            $view='pub_theme::appointment.modal_content';
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
