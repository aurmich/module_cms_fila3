<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets\Patient;

use Exception;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\SaluteOra\Enums\AppointmentType;
use Modules\SaluteOra\Enums\DentistSpecialization;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Spatie\Permission\Traits\HasRoles;

/**
 * Widget per la ricerca e prenotazione del dentista.
 * ATTENZIONE: Non usare ->label(), ->placeholder(), __() nei form component.
 * La localizzazione è gestita centralmente tramite LangServiceProvider e file di lingua.
 * Le chiavi dei campi devono corrispondere ai file di lingua del modulo.
 * Vedi anche: ../../../../Xot/docs/filament_widget_regole.md
 */
class FindDoctorAndAppointmentWidget extends XotBaseWidget
{
    //use HasRoles;

    /**
     * The sort order of the widget in the sidebar.
     *
     * @var int
     */
    protected static ?int $sort = 1;

    /**
     * The number of columns the widget should span.
     *
     * @var int|string|array
     */
    protected int|string|array $columnSpan = 'full';

    /**
     * The widget's form data.
     *
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    /**
     * Available time slots for the selected date.
     *
     * @var array<string, string>
     */
    public array $availableSlots = [];

    /**
     * Whether the widget is currently loading data.
     *
     * @var bool
     */
    public bool $isLoading = false;

    /**
     * Widget title.
     *
     * @var string
     */
    public string $title = 'find_doctor_widget.title';

    /**
     * The view that should be used to render the widget.
     *
     * @var string
     */
    protected static string $view = 'saluteora::filament.widgets.find-doctor-and-appointment';

    /**
     * Widget icon.
     *
     * @var string
     */
    public string $icon = 'heroicon-o-user-plus';

    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * Get the form schema for the widget.
     *
     * @return array<int|string, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            Wizard::make([
                ...$this->getSearchStep(),
                ...$this->getDateTimeStep(),
                ...$this->getConfirmationStep(),
            ])
            ->submitAction(
                \Filament\Forms\Components\Actions\Action::make('submit')
                    ->submit('save')
            )
        ];
    }

    /**
     * Get the search step schema.
     *
     * @return array<int, \Filament\Forms\Components\Component>
     */
    protected function getSearchStep(): array
    {
        return [
            Wizard\Step::make('search')
                ->schema([
                    Fieldset::make('dentist_search')
                        ->schema([
                            Select::make('specialization')
                                ->options(DentistSpecialization::class)
                                ->searchable()
                                ->required(),
                            TextInput::make('location')
                                ->required(),
                            Select::make('appointment_type')
                                ->options(AppointmentType::class)
                                ->required()
                                ->default(AppointmentType::CHECKUP->value),
                        ]),
                ])
        ];
    }

    /**
     * Get the date/time step schema.
     *
     * @return array<int, \Filament\Forms\Components\Component>
     */
    protected function getDateTimeStep(): array
    {
        return [
            Wizard\Step::make('date_time')
                ->schema([
                    Fieldset::make('appointment_details')
                        ->schema([
                            DatePicker::make('date')
                                ->required()
                                ->minDate(now())
                                ->live()
                                ->afterStateUpdated(fn (callable $set) => $set('time', null)),
                            Select::make('time')
                                ->options($this->availableSlots)
                                ->required()
                                ->disabled(fn (callable $get) => !$get('date')),
                            $this->getLoadingState()
                        ]),
                ])
        ];
    }

    /**
     * Get the confirmation step schema.
     *
     * @return array<int, \Filament\Forms\Components\Component>
     */
    protected function getConfirmationStep(): array
    {
        return [
            Wizard\Step::make('confirmation')
                ->schema([
                    Placeholder::make('confirmation_message')
                        ->content(fn (callable $get) => $this->getConfirmationContent($get)),
                ])
        ];
    }

    protected function getLoadingState()
    {
        if ($this->isLoading) {
            return Placeholder::make('loading')
                ->content('find_doctor_widget.messages.loading_available_slots')
                ->columnSpanFull();
        }

        return null;
    }

    public function loadAvailableSlots(): void
    {
        if (empty($this->data['appointment_date'])) {
            return;
        }

        $this->isLoading = true;

        // Simulate API call to fetch available slots
        $this->availableSlots = [
            '09:00' => '09:00 - 09:30',
            '10:00' => '10:00 - 10:30',
            '11:00' => '11:00 - 11:30',
            '14:00' => '14:00 - 14:30',
            '15:00' => '15:00 - 15:30',
        ];

        $this->isLoading = false;
    }

    /**
     * Handle form submission.
     */
    public function submit(): void
    {
        try {
            $data = $this->form->getState();
            $appointment = $this->createAppointment($data);
            $this->sendConfirmation($appointment);

            Notification::make()
                ->title('find_doctor_widget.messages.appointment_booked_successfully')
                ->success()
                ->send();

            $this->form->fill();
            $this->availableSlots = [];

        } catch (Exception $e) {
            Log::error('Error booking appointment: ' . $e->getMessage());

            Notification::make()
                ->title('find_doctor_widget.messages.error_booking_appointment')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    /**
     * Create a new appointment.
     */
    protected function createAppointment(array $data): array
    {
        return [
            'id' => uniqid('appt_', true),
            'reference' => 'APT-' . strtoupper(uniqid()),
            'date' => $data['appointment_date'] ?? null,
            'time' => $data['appointment_time'] ?? null,
            'type' => $data['appointment_type'] ?? null,
            'specialization' => $data['specialization'] ?? null,
            'location' => $data['location'] ?? null,
            'status' => 'scheduled',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Send confirmation for the booked appointment.
     */
    protected function sendConfirmation(array $appointment): void
    {
        // Implementation for sending confirmation
        // This could send an email, SMS, or notification to the patient
    }

    /**
     * Determine if the widget should be visible to the current user.
     *
     * @return bool
     */
    public static function canView(): bool
    {
        if (!Auth::check()) {
            return false;
        }

        /** @var \Modules\Xot\Models\User $user */
        $user = Auth::user();

        return $user->hasRole('patient');
    }
}
