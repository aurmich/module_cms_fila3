<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Modules\SaluteOra\Enums\UserType;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Traits\HasFullCalendarConfig;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

/**
 * Widget FullCalendar per pazienti.
 *
 * Permette ai pazienti di visualizzare i propri appuntamenti in modalità sola lettura.
 * Utilizza il trait HasFullCalendarConfig per configurazioni comuni.
 */
class PatientCalendarWidget extends FullCalendarWidget
{
    use HasFullCalendarConfig;

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
     * Verifica se l'utente può visualizzare il widget.
     *
     * @return bool
     */
    public static function canView(): bool
    {
        return auth()->check() && auth()->user()?->type === UserType::PATIENT;
    }

    /**
     * Recupera gli eventi per il calendario.
     *
     * @param array<string, mixed> $fetchInfo
     * @return array<int, array<string, mixed>>
     */
    public function fetchEvents(array $fetchInfo): array
    {
        $cacheKey = $this->getCacheKey($fetchInfo);

        return cache()->remember($cacheKey, 300, function () use ($fetchInfo) {
            return Appointment::query()
                ->where('patient_id', auth()->id())
                ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
                ->with(['doctor', 'studio'])
                ->limit(100)
                ->get()
                ->map(fn($appointment) => $this->transformToEventData($appointment))
                ->toArray();
        });
    }

    /**
     * Schema del form per la creazione/modifica eventi.
     *
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [
            'readonly_info' => Section::make('Informazioni')
                ->schema([
                    Placeholder::make('readonly_info')
                        ->content('I pazienti possono solo visualizzare i propri appuntamenti. Per modifiche, contattare il proprio medico.'),
                ]),
        ];
    }

    /**
     * Configurazione specifica per il widget paziente.
     *
     * @return array<string, mixed>
     */
    public function config(): array
    {
        $baseConfig = parent::config();

        return array_merge($baseConfig, [
            'initialView' => 'timeGridWeek',
            'editable' => false,
            'selectable' => false,
            'eventStartEditable' => false,
            'eventDurationEditable' => false,
            'eventResizableFromStart' => false,
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
        // I pazienti possono solo visualizzare i dettagli
        $this->dispatch('open-appointment-details', [
            'appointmentId' => $info['event']['id'],
            'readonly' => true,
        ]);
    }



    /**
     * Gestisce il drop di eventi.
     * I pazienti non possono spostare appuntamenti.
     *
     * @param array<string, mixed> $info
     * @return bool
     */
    public function onEventDrop(array $event, array $oldEvent, array $relatedEvents, array $delta, ?array $oldResource, ?array $newResource): bool
    {
        // I pazienti non possono spostare appuntamenti
        return false;
    }

    /**
     * Gestisce il resize di eventi.
     * I pazienti non possono ridimensionare appuntamenti.
     *
     * @param array<string, mixed> $info
     * @return bool
     */
    public function onEventResize(array $event, array $oldEvent, array $relatedEvents, array $startDelta, array $endDelta): bool
    {
        // I pazienti non possono ridimensionare appuntamenti
        return false;
    }

    /**
     * Ottiene il titolo del widget.
     *
     * @return string
     */
    protected function getHeading(): string
    {
        return 'I Miei Appuntamenti';
    }

    /**
     * Ottiene la descrizione del widget.
     *
     * @return string|null
     */
    protected function getDescription(): ?string
    {
        return 'Visualizza i tuoi appuntamenti programmati. Per modifiche, contatta il tuo medico.';
    }
}
