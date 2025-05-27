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
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Geo\Models\Region;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\City;
use Modules\Geo\Models\Cap;
use Modules\SaluteOra\Enums\AppointmentType;
use Modules\SaluteOra\Enums\DentistSpecialization;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Spatie\Permission\Traits\HasRoles;

/**
 * Widget per la ricerca e prenotazione del dentista.
 *
 * Policy e principi seguiti:
 * - Clean Code: ogni step in una funzione separata. Vedi SaluteOra/docs/clean-code.md, wizard-clean-code.md
 * - DRY: logica centralizzata. Vedi SaluteOra/docs/filosofia-politica-zen.md
 * - KISS: semplificazione e responsabilità singola
 * - NESSUN uso di ->label(), placeholder(), __()
 * - Traduzioni solo tramite file lang del modulo
 * - Enum per select statiche
 * - PSR-12, strict_types, niente protected $casts/dates
 * - Collegamenti: Xot/docs/filosofia.md, Xot/docs/clean-code.md
 */
class FindDoctorAndAppointmentWidget extends XotBaseWidget implements HasForms
{
    use InteractsWithForms;

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
        $this->form = Form::make($this)
            ->schema($this->getFormSchema())
            ->statePath('data');
    }

    /**
     * Get the form schema for the widget.
     *
     * @return array<string, \Filament\Forms\Components\Component>
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

    protected function getSearchStep(): array
    {
        return [
            Wizard\Step::make('search')
                ->schema([
                    Fieldset::make('dentist_search')
                        ->schema([
                            Select::make('region')
                                ->options(fn () => Region::all()->pluck('name', 'id'))
                                ->searchable()
                                ->required()
                                ->live()
                                ->afterStateUpdated(fn (Set $set) => $set('province', null)),
                            
                            Select::make('province')
                                ->options(fn (Get $get) => Province::where('region_id', $get('region'))->pluck('name', 'id'))
                                ->searchable()
                                ->required()
                                ->live()
                                ->afterStateUpdated(fn (Set $set) => $set('city', null))
                                ->visible(fn (Get $get) => filled($get('region'))),
                            
                            Select::make('city')
                                ->options(fn (Get $get) => City::where('province_id', $get('province'))->pluck('name', 'id'))
                                ->searchable()
                                ->required()
                                ->live()
                                ->afterStateUpdated(fn (Set $set) => $set('cap', null))
                                ->visible(fn (Get $get) => filled($get('province'))),
                            
                            Select::make('cap')
                                ->options(fn (Get $get) => Cap::where('city_id', $get('city'))->pluck('code', 'id'))
                                ->searchable()
                                ->required()
                                ->visible(fn (Get $get) => filled($get('city'))),
                        ]),
                ])
        ];
    }

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
                                ->afterStateUpdated(fn (Set $set) => $set('time', null)),
                            Select::make('time')
                                ->options($this->availableSlots)
                                ->required()
                                ->disabled(fn (Get $get) => !$get('date')),
                            $this->getLoadingState()
                        ]),
                ])
        ];
    }

    protected function getConfirmationStep(): array
    {
        return [
            Wizard\Step::make('confirmation')
                ->schema([
                    Placeholder::make('confirmation_message')
                        ->content(fn (Get $get) => $this->getConfirmationContent($get)),
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

    protected function createAppointment(array $data): array
    {
        // TODO: Implement appointment creation
        return [];
    }

    protected function sendConfirmation(array $appointment): void
    {
        // TODO: Implement confirmation sending
    }

    public static function canView(): bool
    {
        return true;
    }

    protected function getConfirmationContent(callable $get): string
    {
        // TODO: Implement confirmation content
        return '';
    }
}
