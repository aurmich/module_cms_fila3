<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets\Patient;

use Exception;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Modules\Geo\Models\Cap;
use Modules\Geo\Models\Comune;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Modules\Xot\Traits\HasCsrfToken;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components as Form;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form as FormBuilder;
use Illuminate\Support\Facades\Session;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Coolsam\Flatpickr\Forms\Components\Flatpickr;
use Modules\SaluteOra\Enums\DentistSpecializationEnum;

class FindDoctorAndAppointmentWidget extends XotBaseWidget
{
    //use HasCsrfToken;

    protected static ?string $heading = 'saluteora::widgets.find_doctor_and_appointment.heading';
    protected static ?int $sort = 1;
    protected static string $view = 'saluteora::filament.widgets.find-doctor-and-appointment';

    public ?array $data = [
        'region' => null,
        'province' => null,
        'city' => null,
        'cap' => null,
        'specialization' => null,
        'appointment_date' => null,
        'test_field' => null,
        'appointment_type' => null,
        'appointment_time' => null,
        'notes' => null,
    ];

    /**
     * Get the form schema for the widget.
     *
     * @return array<string, \Filament\Forms\Components\Wizard>
     */
    public function getFormSchema(): array
    {
        return [
            'wizard' => Wizard::make([
                Wizard\Step::make('search')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema($this->getSearchStep()),

                Wizard\Step::make('date')
                    ->icon('heroicon-o-calendar')
                    ->schema($this->getDateStep()),

                Wizard\Step::make('time')
                    ->icon('heroicon-o-clock')
                    ->schema($this->getTimeStep()),

                Wizard\Step::make('confirm')
                    ->icon('heroicon-o-document-check')
                    ->schema($this->getConfirmStep()),
            ])
            /*
            ->submitAction(view('filament.buttons.submit-button', [
                'label' => __('saluteora::actions.book_appointment'),
            ]))
                */
        ];
    }

    /**
     * Get the search step form schema.
     *
     * @return array<string, \Filament\Forms\Components\Select>
     */
    protected function getSearchStep(): array
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
                })
                ,
            'province' => Select::make('province')
                ->options(function (Get $get) {
                    $region = $get('region');
                    if (!$region) {
                        return [];
                    }
                    $res= Comune::query()
                        ->where('regione->codice', $region)
                        ->select('provincia')
                        ->distinct()
                        ->orderBy('provincia->nome')
                        ->get()
                        ->pluck('provincia.nome', 'provincia.codice')
                        ->toArray();
                    return $res;
                })
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(fn (Set $set) => $set('cap', null))
                ,

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
                    $res=Comune::query()
                        ->where('regione->codice', $region)
                        ->where('provincia->codice', $province)
                        ->select('cap')
                        ->distinct()
                        ->orderBy('cap')
                        ->get()
                        ->pluck('cap.0', 'cap.0')
                        ->toArray();

                    return $res;
                })
                ->searchable()
                ->required()
                ->live()
                ->disabled(fn (Get $get) => !$get('region') || !$get('province')),
        ];
    }

    protected function getDateStep(): array
    {
        return [
            'appointment_date' => DatePicker::make('appointment_date')
            ->disabledDates(['2025-06-05','2025-06-21'])

                ->native(false),
            /*
            'test_field' => Flatpickr::make('test_field')
                //->allowInput()
                ->inline(true)
                ->format('Y-m-d')
                ->altFormat('d/m/Y')
                ->disabledDates(['2025-06-05','2025-06-21'])

                ,
            /*
            'appointment_type' => Select::make('appointment_type')
                ->label('saluteora::fields.appointment_type')
                ->options(AppointmentTypeEnum::class)
                ->live()
                ->afterStateUpdated(function (Set $set) {
                    // Reinizializza le disponibilità quando cambia il tipo di appuntamento
                    if ($this->data['appointment_date']) {
                        $this->updateAvailableTimeSlots($set, $this->data['appointment_date']);
                    }
                })
                ->required(),
            */
        ];
    }

    /**
     * Ottiene le date non disponibili per gli appuntamenti
     *
     * @return array<string> Date formattate nel formato Y-m-d
     */
    protected function getDisabledDates(): array
    {
        // Ottieni giorni non lavorativi (weekend o festivi)
        $disabledDates = [];

        // Disabilita le domeniche per i prossimi 3 mesi
        $startDate = now();
        $endDate = now()->addMonths(3);

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Disabilita le domeniche (0 = domenica in Carbon)
            if ($date->dayOfWeek === 0) {
                $disabledDates[] = $date->format('Y-m-d');
            }

            // Qui puoi aggiungere anche le festività nazionali o altri giorni di chiusura
        }

        return $disabledDates;
    }

    /**
     * Aggiorna gli slot orari disponibili in base alla data selezionata
     *
     * @param \Filament\Forms\Set $set
     * @param string|null $appointmentDate
     * @return void
     */
    protected function updateAvailableTimeSlots(Set $set, ?string $appointmentDate): void
    {
        // Logica per aggiornare gli slot orari disponibili in base alla data e al tipo di appuntamento
        // Qui implementerai la logica per recuperare gli slot orari disponibili
    }

    protected function getTimeStep(): array
    {
        return [
            'appointment_time' => Select::make('appointment_time')
                ->label('saluteora::fields.appointment_time')
                ->options([
                    '09:00' => '09:00',
                    '10:00' => '10:00',
                    '11:00' => '11:00',
                    '14:00' => '14:00',
                    '15:00' => '15:00',
                    '16:00' => '16:00',
                ])
                ->required(),
        ];
    }

    /**
     * Get the confirmation step form schema.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    protected function getConfirmStep(): array
    {
        return [
            'confirmation_message' => Placeholder::make('confirmation')
                ->label('saluteora::messages.confirm_booking')
                ->content('saluteora::messages.booking_summary'),

            'notes' => Textarea::make('notes')
                ->label('saluteora::fields.notes')
                ->placeholder('saluteora::placeholders.optional_notes'),
        ];
    }


    /**
     * Handle form submission.
     */
    public function submit(): void
    {
        try {
            // Validate CSRF token
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
