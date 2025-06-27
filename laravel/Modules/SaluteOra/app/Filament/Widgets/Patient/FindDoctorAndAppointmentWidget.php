<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets\Patient;

use Exception;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Modules\Geo\Models\Cap;
use Filament\Actions\Action;
use Filament\Widgets\Widget;
use Illuminate\Support\View;
use Modules\Geo\Models\Comune;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Modules\SaluteOra\Models\Studio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Session;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Support\Facade\FilamentView;
use Filament\Forms\Components\Wizard\Step;
use Livewire\Component as LivewireComponent;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\UI\Filament\Forms\Components\RadioCollection;
use Modules\UI\Filament\Forms\Components\InlineDatePicker;

class FindDoctorAndAppointmentWidget extends XotBaseWidget
{
    /**
     * La vista del widget (richiesta da XotBaseWidget, ma sovrascritta dai form).
     */
    protected static string $view = 'pub_theme::filament.widgets.patient.find-doctor-and-appointment-widget';

    /**
     * Filtri attivi per il widget.
     *
     * @var array|null
     */
    public ?array $filters = null;

   

   
    /**
     * Mount the component.
     *
     * @return void
     */
    public function mount(): void
    {
        
        $this->form->fill();
    }

    /**
     * Get the form schema for the widget.
     *
     * @return array<int|string, mixed>
     */
    public function getFormSchema(): array
    {
        return [
            Forms\Components\Wizard::make()
                //->startOnStep($this->getStartStep())
                ->steps([
                    //$this->getStepByName('test_step'),
                    $this->getStepByName('search_step')
                        ->icon('heroicon-o-map-pin'),
                    $this->getStepByName('studio_step')
                        ->icon('heroicon-o-building-office'),
                    $this->getStepByName('date_step')
                        ->icon('heroicon-o-calendar'),
                    $this->getStepByName('availability_step')
                        ->icon('heroicon-o-user-circle'),
                    $this->getStepByName('confirm_step')
                        ->icon('heroicon-o-check-circle')
                ])
                ->submitAction(
                    Action::make('submit')
                        ->label(__('saluteora::widgets.find_doctor_and_appointment.submit'))
                        ->action(fn() => $this->submit())
                )
        ];
    }
    
    /**
     * Determinare con quale step iniziare.
     *
     * @return int
     */
    protected function getWizardStartOnStep(): int
    {
        return 0; // Prima pagina
    }

    protected function getTestStepSchema(): array
    {
        return [
            'test' =>  RadioCollection::make('studio_id')
                ->label('Studio')      
                ->options(fn() => Studio::all()) // La tua collection
                ->itemView('pub_theme::filament.forms.components.studio-item') // La tua blade personalizzata
                ->valueKey('id') // Campo da usare come valore (default: 'id'),
        ];
    }


    


    /**
     * Get the search step form schema.
     *
     * @return array<string, \Filament\Forms\Components\Select>
     */
    protected function getSearchStepSchema(): array
    {
        return [
            'region' => Select::make('region')
                ->options(function () {
                    return Comune::select('regione')
                    ->distinct()
                    ->orderBy('regione->nome')
                    ->get()
                    ->pluck('regione.nome','regione.codice')
                    ->toArray();
                })
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(function (Set $set){
                    $set('province', null);
                    $set('cap', null);
                }),
            'province' => Select::make('province')
                ->options(function (Get $get) {
                    $region = $get('region');
                    if (!$region) {
                        return [];
                    }
                    return Comune::query()
                        ->where('regione->codice', $region)
                        ->select('provincia')
                        ->distinct()
                        ->orderBy('provincia->nome')
                        ->get()
                        ->pluck('provincia.nome', 'provincia.codice')
                        ->toArray();
                })
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(fn (Set $set) => $set('cap', null)),
            'cap' => Select::make('cap')
                ->options(function (Get $get) {
                    $region = $get('region');
                    if (!$region) {
                        return [];
                    }
                    $province = $get('province');
                    if (!$province) {
                        return [];
                    }
                    return Comune::query()
                        ->where('regione->codice', $region)
                        ->where('provincia->codice', $province)
                        ->select('cap')
                        ->distinct()
                        ->orderBy('cap')
                        ->get()
                        ->pluck('cap.0', 'cap.0')
                        ->toArray();
                })
                ->searchable()
                ->required()
                ->live()
                ->disabled(fn (Get $get) => !$get('region') || !$get('province')),
        ];
    }

    protected function getStudioStepSchema(): array
    {
        
        return [
            /*
            \Modules\SaluteOra\Filament\Forms\Components\StudioSelectorButtons::make('studio_selection')
                ->sectionTitle(__('saluteora::widgets.find_doctor_and_appointment.studio_list.title'))
                ->studios(fn($get) => Studio::ofCap($get('cap'))->get()) // Empty Eloquent collection
                ->populatesStudioField('studio_id')
                ->populatesDoctorField('doctor_id')
                ->emptyStateTitle(__('saluteora::widgets.find_doctor_and_appointment.studio_list.empty_state.title'))
                ->emptyStateDescription(__('saluteora::widgets.find_doctor_and_appointment.studio_list.empty_state.description'))
                ->required()
                ->columnSpanFull(),
                
            Hidden::make('studio_id')->required(),
            Hidden::make('doctor_id')->required(),
            */
            RadioCollection::make('studio_id')
                ->label('Studio')      
                ->options(fn($get) => Studio::ofCap($get('cap'))->get()) // La tua collection
                ->itemView('pub_theme::filament.forms.components.studio-item') // La tua blade personalizzata
                //->emptyView('pub_theme::filament.forms.components.studio-empty') // La tua blade personalizzata
                ->valueKey('id') // Campo da usare come valore (default: 'id'),
                ,
        ];
    }

    

    

   

    /**
     * Metodo Livewire per selezionare uno studio.
     *
     * @param int $studioId
     * @return void
     */
    public function selectStudio(int $studioId): void
    {
        $studio = \Modules\SaluteOra\Models\Studio::find($studioId);
        if ($studio) {
            $this->data['selected_studio'] = $studioId;
            $this->data['selected_studio_name'] = $studio->name;
        }
    }

    protected function getDateStepSchema(): array
    {
        return [
            'appointment_date' => InlineDatePicker::make('appointment_date')
                ->enabledDates(['2025-06-05','2025-06-21'])
            ,
        ];
    }

    /**
     * Ottiene le date non disponibili per gli appuntamenti
     *
     * @return array<string> Date formattate nel formato Y-m-d
     */
    protected function getDisabledDates(): array
    {
        return [
            '2025-06-01', // Domenica
            '2025-06-02', // Festa della Repubblica  
            '2025-06-08', // Domenica
            '2025-06-15', // Domenica
            '2025-06-22', // Domenica
            '2025-06-29', // Domenica
        ];
    }

    /**
     * Aggiorna gli slot orari disponibili in base alla data selezionata
     *
     * @param \Filament\Forms\Set $set
     * @param string|null $appointmentDate
     * @return void
     */
    public function updateAvailableTimeSlots(Set $set, ?string $appointmentDate): void
    {
        if (!$appointmentDate) {
            $set('appointment_time', null);
            return;
        }
        
        // Reset appointment time when date changes
        $set('appointment_time', null);
        
        // Log the date change for debug
        Log::info('Appointment date updated', [
            'date' => $appointmentDate,
            'is_weekend' => in_array(date('w', strtotime($appointmentDate)), [0, 6]),
            'is_monday' => date('w', strtotime($appointmentDate)) == 1,
        ]);
    }

    protected function getTimeStepSchema(): array
    {
        return [
            'appointment_time' => Select::make('appointment_time')
                ->label('saluteora::fields.appointment_time')
                ->options([
                    '09:00' => '09:00',
                    '09:30' => '09:30',
                    '10:00' => '10:00',
                    '10:30' => '10:30',
                    '11:00' => '11:00',
                    '11:30' => '11:30',
                    '12:00' => '12:00',
                    '15:00' => '15:00',
                    '15:30' => '15:30',
                    '16:00' => '16:00',
                    '16:30' => '16:30',
                    '17:00' => '17:00',
                    '17:30' => '17:30',
                    '18:00' => '18:00',
                ])
                ->required(),
        ];
    }

    /**
     * Get the availability step form schema.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    protected function getAvailabilityStepSchema(): array
    {
        return [
            
        ];
    }

    /**
     * Get available time slots for a specific doctor on a specific date.
     *
     * @param int $doctorId
     * @param string $appointmentDate
     * @return array<string, string>
     */
    protected function getAvailableTimeSlotsForDoctor(int $doctorId, string $appointmentDate): array
    {
        try {
            // TODO: Implement real availability check with database
            // For now, return example time slots
            
            $isWeekend = in_array(date('w', strtotime($appointmentDate)), [0, 6]);
            $isMonday = date('w', strtotime($appointmentDate)) == 1;
            
            if ($isWeekend) {
                // Limited hours on weekends
                return [
                    '09:00' => '09:00',
                    '10:00' => '10:00',
                    '11:00' => '11:00',
                ];
            }
            
            if ($isMonday) {
                // Different schedule on Mondays
                return [
                    '10:00' => '10:00',
                    '11:00' => '11:00',
                    '15:00' => '15:00',
                    '16:00' => '16:00',
                    '17:00' => '17:00',
                ];
            }
            
            // Regular weekday schedule
            return [
                '09:00' => '09:00',
                '09:30' => '09:30',
                '10:00' => '10:00',
                '10:30' => '10:30',
                '11:00' => '11:00',
                '11:30' => '11:30',
                '15:00' => '15:00',
                '15:30' => '15:30',
                '16:00' => '16:00',
                '16:30' => '16:30',
                '17:00' => '17:00',
                '17:30' => '17:30',
            ];
            
        } catch (\Exception $e) {
            Log::error('Error getting available time slots', [
                'doctor_id' => $doctorId,
                'appointment_date' => $appointmentDate,
                'error' => $e->getMessage()
            ]);
            
            return [];
        }
    }

    /**
     * Get the confirmation step form schema.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    protected function getConfirmStepSchema(): array
    {
        return [
            Forms\Components\Section::make(__('saluteora::widgets.find_doctor_and_appointment.confirm_step.title'))
                ->description(__('saluteora::widgets.find_doctor_and_appointment.confirm_step.description'))
                ->schema([
                    Forms\Components\TextInput::make('studio_name')
                        ->label(__('saluteora::widgets.find_doctor_and_appointment.fields.studio.label'))
                        ->default(function (Get $get) {
                            $studioId = $get('studio_id');
                            if (!$studioId) return null;
                            
                            $studio = \Modules\SaluteOra\Models\Studio::find($studioId);
                            return $studio ? $studio->name : null;
                        })
                        ->readOnly(),
                        
                    Forms\Components\TextInput::make('appointment_date')
                        ->label(__('saluteora::widgets.find_doctor_and_appointment.fields.appointment_date.label'))
                        ->readOnly(),
                        
                    Forms\Components\TextInput::make('appointment_time')
                        ->label(__('saluteora::widgets.find_doctor_and_appointment.fields.appointment_time.label'))
                        ->readOnly(),
                        
                    Textarea::make('notes')
                        ->label(__('saluteora::widgets.find_doctor_and_appointment.fields.notes.label'))
                        ->placeholder(__('saluteora::widgets.find_doctor_and_appointment.fields.notes.placeholder'))
                        ->rows(3)
                        ->columnSpan('full'),
                ]),
        ];
    }

    /**
     * Handle form submission.
     *
     * @return void
     */
    public function submit(): void
    {
        try {
            if (!request()->hasValidSignature()) {
                throw new \Exception('Invalid request signature');
            }

            // Get form data
            $data = $this->form->getState();

            // Log the booking attempt
            Log::info('New appointment booking', [
                'user_id' => Auth::id(),
                'data' => $data
            ]);

            // TODO: Implement actual booking logic here

            // Show success notification
            Notification::make()
                ->success()
                ->title(trans('saluteora::notifications.booking_success'))
                ->send();

            // Reset form
            $this->form->fill();

        } catch (\Exception $e) {
            Log::error('Booking error: ' . $e->getMessage());

            Notification::make()
                ->danger()
                ->title(trans('saluteora::notifications.booking_error'))
                ->body($e->getMessage())
                ->send();
        }
    }

    /**
     * Get the CSRF token for the current request.
     *
     * @return string
     */
    public function getCsrfToken(): string
    {
        return Session::token();
    }

   
}
