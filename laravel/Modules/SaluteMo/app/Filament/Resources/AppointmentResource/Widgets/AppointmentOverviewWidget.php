<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Widgets;

use Webmozart\Assert\Assert;
use Illuminate\Support\Facades\Cache;
use Modules\SaluteOra\Models\Appointment;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Widget per la panoramica degli appuntamenti per stato.
 * Mostra statistiche compatte degli appuntamenti raggruppati per stato.
 */
class AppointmentOverviewWidget extends XotBaseWidget
{
    /**
     * Vista del widget.
     */
    protected static string $view = 'salutemo::filament.widgets.appointment-overview';
    
    /**
     * Titolo del widget.
     */
    public string $title = '';
    
    /**
     * Occupa tutta la larghezza disponibile.
     */
    protected int|string|array $columnSpan = 'full';
    
    /**
     * Intervallo di polling disabilitato per performance.
     */
    protected static ?string $pollingInterval = null;

    /**
     * Schema del form (vuoto per questo widget).
     *
     * @return array<int|string, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }
    
    /**
     * Dati da passare alla vista.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'states' => $this->getAppointmentStates(),
            'title' => $this->getWidgetTitle(),
        ];
    }
    
    /**
     * Ottiene il titolo del widget dalle traduzioni.
     */
    protected function getWidgetTitle(): string
    {
        return __('salutemo::widgets.appointment_overview.title');
    }
    
    /**
     * Ottiene gli stati degli appuntamenti con statistiche.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function getAppointmentStates(): array
    {
        $res= Cache::remember(
            'appointment-states-' . auth()->id(),
            now()->addMinutes(5),
            fn () => $this->calculateAppointmentStates()
        );

        Assert::isArray($res);
        return $res;
    }
    
    /**
     * Calcola le statistiche degli stati degli appuntamenti.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function calculateAppointmentStates(): array
    {
        $states = [];
        $stateMapping = AppointmentState::getStateMapping()->toArray();
        
        foreach ($stateMapping as $name => $stateClass) {
            try {
                $appointment = new Appointment();
                $state = new $stateClass($appointment);
                Assert::isInstanceOf($state, AppointmentState::class);                
                $states[] = [
                    'name' => $name,
                    'label' => $state->label(),
                    'icon' => $this->cleanIconName($state->icon()),
                    'color' => $state->bgColor(),
                    'count' => $this->getCountForState($name),
                ];
            } catch (\Exception $e) {
                // Fallback silenzioso per errori non critici
                continue;
            }
        }
        
        return $states;
    }
    
    /**
     * Ottiene il conteggio degli appuntamenti per uno stato specifico.
     * IMPORTANTE: Mostra TUTTI gli appuntamenti, non filtrati per utente.
     * Questo è un widget di panoramica generale per dashboard amministrativa.
     */
    protected function getCountForState(string $stateName): int
    {
        return Appointment::where('state', $stateName)->count();
    }
    
    /**
     * Pulisce il nome dell'icona rimuovendo prefissi non necessari.
     */
    protected function cleanIconName(string $iconName): string
    {
        // Rimuove prefissi comuni come 'heroicon-o-' se presenti
        return str_replace(['heroicon-o-', 'heroicon-s-'], '', $iconName);
    }
}
