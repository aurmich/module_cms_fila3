<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Models\DoctorStudio;
use Modules\SaluteOra\Traits\HasFullCalendarConfig;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

/**
 * Widget per la gestione delle disponibilità dei dottori.
 *
 * Permette ai dottori di visualizzare e gestire le proprie disponibilità
 * settimanali nel contesto multi-tenant dello studio corrente.
 * Utilizza il trait HasFullCalendarConfig per configurazioni comuni.
 */
class DoctorAvailabilitiesWidget extends FullCalendarWidget
{
    use HasFullCalendarConfig;

    /**
     * Modello associato al widget.
     *
     * @var Model|string|null
     */
    public Model|string|null $model = DoctorStudio::class;

    /**
     * Ordinamento del widget nella dashboard.
     *
     * @var int|null
     */
    protected static ?int $sort = 2;

    /**
     * Altezza massima del widget.
     *
     * @var string|null
     */
    protected static ?string $maxHeight = '600px';

    /**
     * Verifica se l'utente può visualizzare il widget.
     *
     * @return bool
     */
    public static function canView(): bool
    {
        if (!Auth::check() || Auth::user()?->type !== UserTypeEnum::DOCTOR->value) {
            return false;
        }
        return Filament::getTenant() !== null;
    }

    /**
     * Recupera gli eventi di disponibilità per il calendario.
     *
     * @param array<string, mixed> $fetchInfo
     * @return array<int, array<string, mixed>>
     */
    public function fetchEvents(array $fetchInfo): array
    {
        $cacheKey = $this->getCacheKey($fetchInfo);

        return cache()->remember($cacheKey, 300, function () use ($fetchInfo) {
            $doctorStudio = $this->getDoctorStudioPivot();

            if (!$doctorStudio || !$doctorStudio->schedule) {
                return [];
            }

            return $this->generateAvailabilitySlots(
                $doctorStudio->schedule,
                $fetchInfo
            );
        });
    }

    /**
     * Schema del form per la creazione/modifica slot di disponibilità.
     *
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [
            'availability_details' => Section::make('Dettagli Disponibilità')
                ->schema([
                    'day_of_week' => Select::make('day_of_week')
                        ->options([
                            'monday' => 'Lunedì',
                            'tuesday' => 'Martedì',
                            'wednesday' => 'Mercoledì',
                            'thursday' => 'Giovedì',
                            'friday' => 'Venerdì',
                            'saturday' => 'Sabato',
                            'sunday' => 'Domenica',
                        ])
                        ->required(),
                    'period' => Select::make('period')
                        ->options([
                            'morning' => 'Mattina',
                            'afternoon' => 'Pomeriggio',
                            'evening' => 'Sera',
                        ])
                        ->required(),
                    'start_time' => TimePicker::make('start_time')
                        ->required()
                        ->seconds(false),
                    'end_time' => TimePicker::make('end_time')
                        ->required()
                        ->seconds(false),
                    'effective_date' => DatePicker::make('effective_date')
                        ->label('Data di Validità')
                        ->helperText('Da quando è valida questa disponibilità'),
                ]),
        ];
    }

    /**
     * Configurazione specifica per il widget disponibilità.
     *
     * @return array<string, mixed>
     */
    public function config(): array
    {
        $baseConfig = parent::config();

        return array_merge($baseConfig, [
            'initialView' => 'timeGridWeek',
            'editable' => true,
            'selectable' => true,
            'selectConstraint' => 'businessHours',
            'eventBackgroundColor' => '#10b981', // Verde per disponibilità
            'eventBorderColor' => '#059669',
            'eventTextColor' => '#ffffff',
            'events' => [],
        ]);
    }

    /**
     * Gestisce la selezione di un range di tempo per creare disponibilità.
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
        if ($allDay) {
            return; // Non gestiamo eventi di tutta la giornata
        }

        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);

        // Determina il giorno della settimana e il periodo
        $dayOfWeek = strtolower($startDate->format('l'));
        $period = $this->determinePeriod($startDate);

        $this->createAvailabilitySlot([
            'day_of_week' => $dayOfWeek,
            'period' => $period,
            'start_time' => $startDate->format('H:i'),
            'end_time' => $endDate->format('H:i'),
            'effective_date' => $startDate->format('Y-m-d'),
        ]);
    }

    /**
     * Gestisce il click su un evento di disponibilità.
     *
     * @param array<string, mixed> $info
     * @return void
     */
    public function onEventClick(array $info): void
    {
        $eventData = $info['event'] ?? [];
        
        if (!isset($eventData['extendedProps']['availability_id'])) {
            return;
        }

        $this->dispatch('open-availability-modal', [
            'availabilityId' => $eventData['extendedProps']['availability_id'],
            'mode' => 'edit',
        ]);
    }

    /**
     * Ottiene il pivot DoctorStudio corrente.
     *
     * @return DoctorStudio|null
     */
    protected function getDoctorStudioPivot(): ?DoctorStudio
    {
        $user = Auth::user();
        $studio = Filament::getTenant();

        if (!$user || !$studio) {
            return null;
        }

        return DoctorStudio::where([
            'user_id' => $user->id,
            'studio_id' => $studio->id,
        ])->first();
    }

    /**
     * Genera gli slot di disponibilità per il calendario.
     *
     * @param array<string, mixed> $schedule
     * @param array<string, mixed> $fetchInfo
     * @return array<int, array<string, mixed>>
     */
    protected function generateAvailabilitySlots(array $schedule, array $fetchInfo): array
    {
        $events = [];
        $start = Carbon::parse($fetchInfo['start']);
        $end = Carbon::parse($fetchInfo['end']);

        for ($date = $start->copy(); $date <= $end; $date->addDay()) {
            $dayKey = strtolower($date->format('l'));

            if (!isset($schedule[$dayKey])) {
                continue;
            }

            $daySchedule = $schedule[$dayKey];

            foreach ($daySchedule as $period => $timeRange) {
                if (empty($timeRange)) {
                    continue;
                }

                $event = $this->createAvailabilityEvent($date, $period, $timeRange);
                if ($event) {
                    $events[] = $event;
                }
            }
        }

        return $events;
    }

    /**
     * Crea un evento di disponibilità per il calendario.
     *
     * @param Carbon $date
     * @param string $period
     * @param string $timeRange
     * @return array<string, mixed>|null
     */
    protected function createAvailabilityEvent(Carbon $date, string $period, string $timeRange): ?array
    {
        if (!preg_match('/^(\d{2}:\d{2})-(\d{2}:\d{2})$/', $timeRange, $matches)) {
            return null;
        }

        [$_, $startTime, $endTime] = $matches;

        $startDateTime = $date->copy()->setTimeFromTimeString($startTime);
        $endDateTime = $date->copy()->setTimeFromTimeString($endTime);

        $title = match ($period) {
            'morning' => 'Disponibile - Mattina',
            'afternoon' => 'Disponibile - Pomeriggio',
            'evening' => 'Disponibile - Sera',
            default => 'Disponibile',
        };

        return [
            'id' => "availability_{$date->format('Y-m-d')}_{$period}",
            'title' => $title,
            'start' => $startDateTime->toDateTimeString(),
            'end' => $endDateTime->toDateTimeString(),
            'backgroundColor' => '#10b981',
            'borderColor' => '#059669',
            'textColor' => '#ffffff',
            'extendedProps' => [
                'type' => 'availability',
                'day_of_week' => strtolower($date->format('l')),
                'period' => $period,
                'availability_id' => "availability_{$date->format('Y-m-d')}_{$period}",
                'editable' => true,
            ],
        ];
    }

    /**
     * Crea un nuovo slot di disponibilità.
     *
     * @param array<string, mixed> $data
     * @return void
     */
    protected function createAvailabilitySlot(array $data): void
    {
        $doctorStudio = $this->getDoctorStudioPivot();

        if (!$doctorStudio) {
            Notification::make()
                ->title('Errore')
                ->body('Impossibile trovare l\'associazione dottore-studio')
                ->danger()
                ->send();
            return;
        }

        $schedule = $doctorStudio->schedule ?? [];
        $timeRange = "{$data['start_time']}-{$data['end_time']}";

        // Aggiorna lo schedule
        $schedule[$data['day_of_week']][$data['period']] = $timeRange;

        $doctorStudio->update(['schedule' => $schedule]);

        $this->invalidateCache();

        Notification::make()
            ->title('Disponibilità aggiunta')
            ->body("Disponibilità aggiunta per {$this->formatDayName($data['day_of_week'])} - {$data['period']}")
            ->success()
            ->send();
    }

    /**
     * Determina il periodo basato sull'ora.
     *
     * @param Carbon $time
     * @return string
     */
    protected function determinePeriod(Carbon $time): string
    {
        $hour = $time->hour;

        if ($hour < 12) {
            return 'morning';
        } elseif ($hour < 17) {
            return 'afternoon';
        } else {
            return 'evening';
        }
    }

    /**
     * Formatta il nome del giorno.
     *
     * @param string $dayKey
     * @return string
     */
    protected function formatDayName(string $dayKey): string
    {
        $days = [
            'monday' => 'Lunedì',
            'tuesday' => 'Martedì',
            'wednesday' => 'Mercoledì',
            'thursday' => 'Giovedì',
            'friday' => 'Venerdì',
            'saturday' => 'Sabato',
            'sunday' => 'Domenica',
        ];

        return $days[$dayKey] ?? ucfirst($dayKey);
    }

    /**
     * Ottiene il titolo del widget.
     *
     * @return string
     */
    protected function getHeading(): string
    {
        $tenant = Filament::getTenant();
        return "Disponibilità - {$tenant?->name}";
    }

    /**
     * Ottiene la descrizione del widget.
     *
     * @return string|null
     */
    protected function getDescription(): ?string
    {
        return 'Gestisci le tue disponibilità settimanali. Seleziona un range di tempo per aggiungere nuove disponibilità.';
    }
} 