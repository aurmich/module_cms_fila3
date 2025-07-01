<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Studio;
//use Modules\SaluteOra\Traits\HasFullCalendarConfig;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use function Safe\strtotime;

/**
 * Widget FullCalendar per amministratori.
 *
 * Permette agli admin di visualizzare tutti gli appuntamenti del sistema
 * con vista globale, filtri avanzati e funzionalità CRUD complete.
 * Utilizza il trait HasFullCalendarConfig per configurazioni comuni.
 */
class AdminCalendarWidget extends FullCalendarWidget
{
    //use HasFullCalendarConfig;
    
    /**
     * Riferimento alla data corrente del calendario.
     *
     * @var string
     */
    public string $currentDate;

    /**
     * Modello associato al widget.
     *
     * @var Model|string|null
     */
    public Model|string|null $model = Appointment::class;

    /**
     * Ordinamento del widget nella dashboard.
     *
     * @var int|null
     */
    protected static ?int $sort = 1;

    /**
     * Altezza massima del widget.
     *
     * @var string|null
     */
    protected static ?string $maxHeight = '600px';
    
    /**
     * Inizializza il widget impostando la data corrente.
     *
     * @return void
     */
    public function mount(): void
    {
        parent::mount();
        $this->currentDate = now()->format('Y-m-d');
    }
    
    /**
     * Naviga al mese successivo.
     *
     * @return void
     */
    public function nextMonth(): void
    {
        // Calcola il primo giorno del mese successivo
        $this->currentDate = now()
            ->setDate(
                (int) date('Y', strtotime($this->currentDate)),
                (int) date('m', strtotime($this->currentDate)),
                1
            )
            ->addMonth()
            ->format('Y-m-d');
            
        $this->dispatch('refetchEvents');
    }

    /**
     * Naviga al mese precedente.
     *
     * @return void
     */
    public function prevMonth(): void
    {
        // Calcola il primo giorno del mese precedente
        $this->currentDate = now()
            ->setDate(
                (int) date('Y', strtotime($this->currentDate)),
                (int) date('m', strtotime($this->currentDate)),
                1
            )
            ->subMonth()
            ->format('Y-m-d');
            
        $this->dispatch('refetchEvents');
    }

    /**
     * Naviga alla data odierna.
     *
     * @return void
     */
    public function today(): void
    {
        $this->currentDate = now()->format('Y-m-d');
        $this->dispatch('refetchEvents');
    }

    /**
     * Filtri attivi per il widget.
     *
     * @var array<string, mixed>
     */
    public array $filters = [
        'studio_id' => null,
        'status' => null,
        'type' => null,
        'emergency_only' => false,
    ];

    /**
     * Verifica se l'utente può visualizzare il widget.
     *
     * @return bool
     */
    public static function canView(): bool
    {
        return Auth::check() && Auth::user()?->type === UserTypeEnum::ADMIN->value;
    }

    /**
     * Recupera gli eventi del calendario.
     *
     * @param array<string, mixed> $fetchInfo
     * @return array<int, array<string, mixed>>
     */
    public function fetchEvents(array $fetchInfo): array
    {
        $start = date('Y-m-d H:i:s', strtotime($fetchInfo['start']));
        $end = date('Y-m-d H:i:s', strtotime($fetchInfo['end']));

        // Query base per gli appuntamenti
        $appointments = $this->getAppointmentsQuery()
            ->whereBetween('start_time', [$start, $end])
            ->get();

        $events = [];
        foreach ($appointments as $appointment) {
            $events[] = $this->formatAppointmentAsEvent($appointment);
        }

        return $events;
    }

    /**
     * Applica i filtri alla query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    protected function applyFilters($query): void
    {
        if ($this->filters['studio_id']) {
            $query->where('studio_id', $this->filters['studio_id']);
        }

        if ($this->filters['status']) {
            $query->where('status', $this->filters['status']);
        }

        if ($this->filters['type']) {
            $query->where('type', $this->filters['type']);
        }

        if ($this->filters['emergency_only']) {
            $query->emergency();
        }
    }

    /**
     * Ottiene lo schema del form per i filtri.
     *
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [
            'appointment_details' => Section::make('Dettagli Appuntamento')
                ->schema([
                    Select::make('studio_id')
                        ->relationship('studio', 'name')
                        ->searchable()
                        ->required(),
                    Select::make('doctor_id')
                        ->relationship('doctor', 'full_name')
                        ->searchable()
                        ->required(),
                    Select::make('patient_id')
                        ->relationship('patient', 'full_name')
                        ->searchable()
                        ->required(),
                    'type' => Select::make('type')
                        ->label('Tipo')
                        ->options(AppointmentTypeEnum::class)
                        ->searchable()
                        ->required(),
                    DateTimePicker::make('start_time')
                        ->required(),
                    DateTimePicker::make('end_time')
                        ->required(),
                    'status' => Select::make('status')
                        ->label('Stato')
                        ->options(AppointmentStatusEnum::class)
                        ->searchable()
                        ->default(AppointmentStatusEnum::SCHEDULED->value),
                    Textarea::make('notes')
                        ->rows(3),
                    Toggle::make('emergency'),
                ]),
        ];
    }

    /**
     * Configurazione specifica per il widget admin.
     *
     * @return array<string, mixed>
     */
    public function config(): array
    {
        $baseConfig = parent::config();

        return array_merge($baseConfig, [
            'initialView' => 'dayGridMonth',
            'editable' => true,
            'selectable' => true,
            'eventStartEditable' => true,
            'eventDurationEditable' => true,
            'eventResizableFromStart' => true,
        ]);
    }

    /**
     * Gestisce il click su un evento.
     *
     * @param array<string, mixed> $info
     * @return void
     */
    public function onEventClick(array $info): void
    {
        $appointmentId = $info['event']['id'] ?? null;

        if (!$appointmentId) {
            return;
        }

        $appointment = Appointment::find($appointmentId);

        if (!$appointment) {
            return;
        }

        $this->dispatch('open-appointment-modal', [
            'appointmentId' => $appointmentId,
            'mode' => 'edit',
        ]);
    }

    /**
     * Gestisce la selezione di un range di date.
     *
     * @param string $start
     * @param string|null $end
     * @param bool $allDay
     * @param array<string, mixed>|null $view
     * @param array<string, mixed>|null $resource
     * @return void
     */
    public function onDateSelect(string $start, ?string $end, bool $allDay, ?array $view, ?array $resource): void
    {
        $this->dispatch('open-appointment-modal', [
            'start' => $start,
            'end' => $end,
            'allDay' => $allDay,
            'mode' => 'create',
        ]);
    }

    /**
     * Gestisce il drag&drop di un evento.
     *
     * @param array<string, mixed> $event
     * @param array<string, mixed> $oldEvent
     * @param array<string, mixed> $relatedEvents
     * @param array<string, mixed> $delta
     * @param array<string, mixed>|null $oldResource
     * @param array<string, mixed>|null $newResource
     * @return bool
     */
    public function onEventDrop(array $event, array $oldEvent, array $relatedEvents, array $delta, ?array $oldResource, ?array $newResource): bool
    {
        $appointmentId = $event['id'] ?? null;

        if (!$appointmentId) {
            return false;
        }

        $appointment = Appointment::find($appointmentId);

        if (!$appointment) {
            return false;
        }

        $appointment->update([
            'start_time' => $event['start'],
            'end_time' => $event['end'],
        ]);

        $this->invalidateCache();

        return true;
    }

    /**
     * Gestisce il resize di un evento.
     *
     * @param array<string, mixed> $event
     * @param array<string, mixed> $oldEvent
     * @param array<string, mixed> $relatedEvents
     * @param array<string, mixed> $startDelta
     * @param array<string, mixed> $endDelta
     * @return bool
     */
    public function onEventResize(array $event, array $oldEvent, array $relatedEvents, array $startDelta, array $endDelta): bool
    {
        $appointmentId = $event['id'] ?? null;

        if (!$appointmentId) {
            return false;
        }

        $appointment = Appointment::find($appointmentId);

        if (!$appointment) {
            return false;
        }

        $appointment->update([
            'end_time' => $event['end'],
        ]);

        $this->invalidateCache();

        return true;
    }

    /**
     * Formatta un appuntamento come evento calendario.
     *
     * @param \Modules\SaluteOra\Models\Appointment $appointment
     * @return array<string, mixed>
     */
    protected function formatAppointmentAsEvent($appointment): array
    {
        return [
            'id' => (string) $appointment->id,
            'title' => $this->getEventTitle($appointment),
            'start' => $appointment->start_time->toISOString(),
            'end' => $appointment->end_time->toISOString(),
            'extendedProps' => [
                'patient_name' => $appointment->patient->full_name ?? 'N/A',
                'doctor_name' => $appointment->doctor->full_name ?? 'N/A', 
                'studio_name' => $appointment->studio->name ?? 'N/A',
                'emergency' => $appointment->emergency ?? false,
            ],
        ];
    }

    /**
     * Ottiene le statistiche per il widget.
     *
     * @return array<string, mixed>
     */
    public function getStats(): array
    {
        $today = now()->startOfDay();
        $endOfWeek = now()->endOfWeek();

        return [
            'today_appointments' => Appointment::whereDate('start_time', $today)->count(),
            'week_appointments' => Appointment::whereBetween('start_time', [$today, $endOfWeek])->count(),
            'pending_appointments' => Appointment::where('status', AppointmentStatusEnum::PENDING->value)->count(),
            'emergency_appointments' => Appointment::emergency()->whereDate('start_time', '>=', $today)->count(),
            'total_studios' => Studio::where('active', true)->count(),
        ];
    }

    /**
     * Ottiene il titolo del widget.
     *
     * @return string
     */
    protected function getHeading(): string
    {
        return 'Calendario Globale - Amministrazione';
    }

    /**
     * Ottiene la descrizione del widget.
     *
     * @return string|null
     */
    protected function getDescription(): ?string
    {
        $stats = $this->getStats();

        return sprintf(
            'Vista globale: %d appuntamenti oggi, %d questa settimana, %d emergenze attive',
            $stats['today_appointments'],
            $stats['week_appointments'],
            $stats['emergency_appointments']
        );
    }

    /**
     * Ottiene le azioni del widget.
     *
     * @return array<int, mixed>
     */
    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('export')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(fn () => $this->exportCalendarData()),

            \Filament\Actions\Action::make('refresh')
                ->icon('heroicon-o-arrow-path')
                ->action(fn () => $this->refreshCalendar()),
        ];
    }

    /**
     * Esporta i dati del calendario.
     *
     * @return void
     */
    protected function exportCalendarData(): void
    {
        $this->dispatch('export-calendar-data', [
            'filters' => $this->filters,
        ]);
    }

    /**
     * Aggiorna il calendario.
     *
     * @return void
     */
    protected function refreshCalendar(): void
    {
        $this->invalidateEventsCache();
        $this->dispatch('refresh-calendar');
    }
}
