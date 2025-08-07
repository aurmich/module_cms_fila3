# AppointmentStatesOverviewWidget

## Panoramica

Il `AppointmentStatesOverviewWidget` è un widget Filament specializzato per visualizzare una panoramica compatta ed elegante degli stati degli appuntamenti. Estende `XotBaseWidget` e fornisce una vista d'insieme immediata di quanti appuntamenti sono in ciascuno stato, con design ottimizzato per occupare meno spazio rispetto ai widget StatsOverviewWidget standard.

## Caratteristiche Principali

- **Design Compatto**: Occupa meno spazio verticale rispetto ai widget StatsOverviewWidget
- **Estensione XotBaseWidget**: Segue le convenzioni Laraxot per consistenza architetturale
- **Overview Generale**: Mostra **tutti** gli appuntamenti per stato (non filtrati per dottore/paziente)
- **Stati Dinamici**: Utilizza il sistema Spatie Model States per ottenere tutti gli stati disponibili
- **Responsive**: Layout ottimizzato per dispositivi desktop e mobile (9 elementi per riga)
- **Caching**: Implementa caching intelligente per ottimizzare le prestazioni

## Architettura

### Estensione Base
```php
class AppointmentStatesOverviewWidget extends XotBaseWidget
```

### Template
- **Vista principale**: `salutemo::filament.widgets.appointment-overview`
- **Layout**: Grid responsive con 9 elementi per riga su schermi grandi

## Implementazione

### 1. Classe Widget

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\States\Appointment\AppointmentState;
use Illuminate\Support\Facades\Cache;

/**
 * Widget panoramica stati appuntamenti.
 * 
 * Visualizza una panoramica compatta degli stati degli appuntamenti
 * con design ottimizzato per occupare meno spazio verticale.
 * Mostra TUTTI gli appuntamenti per stato (overview generale).
 */
class AppointmentStatesOverviewWidget extends XotBaseWidget
{
    protected static string $view = 'salutemo::filament.widgets.appointment-overview';
    protected static ?string $heading = 'Stati Appuntamenti';
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '30s';

    /**
     * Verifica se l'utente può visualizzare il widget.
     * 
     * @return bool
     */
    public static function canView(): bool
    {
        if (!auth()->check()) {
            return false;
        }
        
        $user = auth()->user();
        
        // Solo dottori e admin possono vedere gli stati
        return in_array($user->type, ['doctor', 'admin']);
    }

    /**
     * Dati per la view.
     * 
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'states' => $this->getStatesData(),
            'total' => $this->getTotalAppointments(),
        ];
    }

    /**
     * Ottiene i dati degli stati con conteggi.
     * 
     * @return array<string, array<string, mixed>>
     */
    private function getStatesData(): array
    {
        $cacheKey = $this->getCacheKey();
        
        return Cache::remember($cacheKey, 300, function () {
            $states = [];
            $stateMapping = AppointmentState::getStateMapping()->toArray();
            
            foreach ($stateMapping as $name => $stateClass) {
                $count = $this->getAppointmentsCountByState($name);
                
                if ($count > 0) { // Mostra solo stati con appuntamenti
                    $appointment = new Appointment(); // Istanza temporanea per ottenere metodi
                    $state = new $stateClass($appointment);
                    
                    $states[$name] = [
                        'label' => $state->label(),
                        'count' => $count,
                        'color' => $state->color(),
                        'icon' => $state->icon(),
                        'bg_color' => $this->getBackgroundColor($state->color()),
                        'text_color' => $this->getTextColor($state->color()),
                    ];
                }
            }
            
            return $states;
        });
    }

    /**
     * Ottiene il conteggio degli appuntamenti per stato.
     * IMPORTANTE: Mostra TUTTI gli appuntamenti, non filtrati per dottore/paziente.
     * 
     * @param string $stateName
     * @return int
     */
    private function getAppointmentsCountByState(string $stateName): int
    {
        try {
            // Overview generale: mostra tutti gli appuntamenti per stato
            return Appointment::where('state', $stateName)->count();
        } catch (\Exception $e) {
            // Fallback appropriato senza logging inutile
            return 0;
        }
    }

    /**
     * Ottiene il totale degli appuntamenti.
     * 
     * @return int
     */
    private function getTotalAppointments(): int
    {
        try {
            return Appointment::count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Ottiene il colore di sfondo per lo stato.
     * 
     * @param string $color
     * @return string
     */
    private function getBackgroundColor(string $color): string
    {
        return match($color) {
            'success' => 'bg-success-50',
            'danger' => 'bg-danger-50',
            'warning' => 'bg-warning-50',
            'info' => 'bg-info-50',
            'primary' => 'bg-primary-50',
            default => 'bg-gray-50',
        };
    }

    /**
     * Ottiene il colore del testo per lo stato.
     * 
     * @param string $color
     * @return string
     */
    private function getTextColor(string $color): string
    {
        return match($color) {
            'success' => 'text-success-700',
            'danger' => 'text-danger-700',
            'warning' => 'text-warning-700',
            'info' => 'text-info-700',
            'primary' => 'text-primary-700',
            default => 'text-gray-700',
        };
    }

    /**
     * Ottiene la chiave di cache per il widget.
     * 
     * @return string
     */
    private function getCacheKey(): string
    {
        return "appointment_states_widget_" . auth()->id();
    }

    /**
     * Schema del form (richiesto da XotBaseWidget).
     * 
     * @return array
     */
    public function getFormSchema(): array
    {
        // Widget senza form, restituisce array vuoto
        return [];
    }

    /**
     * Invalida la cache del widget.
     * 
     * @return void
     */
    public function invalidateCache(): void
    {
        Cache::forget($this->getCacheKey());
    }
}
```

### 2. Template Blade

```blade
{{-- resources/views/filament/widgets/appointment-overview.blade.php --}}
<x-filament::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('salutemo::widgets.appointment_overview.title') }}
        </x-slot>

        <x-slot name="description">
            {{ __('salutemo::widgets.appointment_overview.description') }}
        </x-slot>

        <div class="space-y-4">
            {{-- Total Overview --}}
            <div class="bg-gray-50 p-4 rounded-lg text-center">
                <p class="text-sm text-gray-600">{{ __('salutemo::widgets.appointment_overview.total') }}</p>
                <p class="text-3xl font-bold text-gray-800">{{ $total }}</p>
            </div>

            {{-- States Grid - 9 elementi per riga --}}
            <div class="grid grid-cols-3 gap-2 sm:grid-cols-6 md:grid-cols-9 lg:grid-cols-9 xl:grid-cols-9">
                @foreach($states as $stateName => $stateData)
                    <div class="{{ $stateData['bg_color'] }} p-3 rounded-lg text-center hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-center mb-2">
                            <x-filament::icon 
                                :name="$stateData['icon']" 
                                class="w-5 h-5 {{ $stateData['text_color'] }}"
                            />
                        </div>
                        
                        <p class="text-lg font-bold {{ $stateData['text_color'] }}">
                            {{ $stateData['count'] }}
                        </p>
                        
                        <p class="text-xs {{ $stateData['text_color'] }} opacity-75">
                            {{ $stateData['label'] }}
                        </p>
                    </div>
                @endforeach
            </div>

            {{-- Empty State --}}
            @if(empty($states))
                <div class="text-center py-8">
                    <x-filament::icon 
                        name="heroicon-o-calendar" 
                        class="w-12 h-12 text-gray-400 mx-auto mb-4"
                    />
                    <p class="text-gray-500">{{ __('salutemo::widgets.appointment_overview.no_appointments') }}</p>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament::widget>
```

### 3. Traduzioni

```php
// lang/it/widgets.php
return [
    'appointment_overview' => [
        'title' => 'Stati Appuntamenti',
        'description' => 'Panoramica generale di tutti gli appuntamenti per stato',
        'total' => 'Totale Appuntamenti',
        'no_appointments' => 'Nessun appuntamento trovato',
    ],
    // ... altre traduzioni esistenti
];
```

## Vantaggi del Design

### 1. Spazio Ottimizzato
- **Layout Grid Responsive**: Si adatta automaticamente alla larghezza disponibile
- **9 Elementi per Riga**: Ottimizzato per i 17 stati degli appuntamenti
- **Card Compatte**: Ogni stato occupa meno spazio verticale rispetto alle Stat cards
- **Informazioni Essenziali**: Mostra solo i dati più importanti (conteggio, etichetta, icona)

### 2. Performance
- **Caching Intelligente**: Cache di 5 minuti per ridurre query database
- **Query Ottimizzate**: Conteggi aggregati invece di caricare tutti i record
- **Lazy Loading**: Carica solo gli stati con appuntamenti

### 3. UX Migliorata
- **Feedback Visivo**: Colori e icone per identificazione rapida
- **Hover Effects**: Interazioni sottili per feedback utente
- **Empty State**: Messaggio chiaro quando non ci sono appuntamenti

## Logica di Business

### Overview Generale vs Filtri Specifici

**Questo widget mostra TUTTI gli appuntamenti per stato** perché:

1. **Scopo**: Fornire una panoramica generale del sistema
2. **Utenti**: Admin e dottori che vogliono vedere l'overview completo
3. **Contesto**: Dashboard generale, non specifica per un dottore

**Per filtri specifici per dottore, usare widget separati** come:
- `DoctorAppointmentsWidget` - Per appuntamenti specifici del dottore
- `PatientAppointmentsWidget` - Per appuntamenti specifici del paziente

## Integrazione

### 1. Registrazione Widget

```php
// In AppointmentResource
protected function getHeaderWidgets(): array
{
    return [
        AppointmentStatesOverviewWidget::class,
        // ... altri widget
    ];
}
```

### 2. Configurazione Cache

```php
// config/cache.php
'stores' => [
    'redis' => [
        'driver' => 'redis',
        'connection' => 'cache',
    ],
],
```

## Best Practices

### 1. Estensione XotBaseWidget
- ✅ **CORRETTO**: Estende `XotBaseWidget` per consistenza
- ❌ **ERRATO**: Estendere direttamente `Widget`

### 2. Gestione Stati
- ✅ **CORRETTO**: Utilizzare `AppointmentState::getStateMapping()`
- ❌ **ERRATO**: Hardcodare gli stati

### 3. Overview Generale
- ✅ **CORRETTO**: Mostrare tutti gli appuntamenti senza filtri
- ❌ **ERRATO**: Filtrare per dottore/paziente in widget di overview

### 4. Caching
- ✅ **CORRETTO**: Cache con chiave specifica per utente
- ❌ **ERRATO**: Cache globale che non considera il contesto

## Troubleshooting

### 1. Widget Non Visualizzato
- Verificare `canView()` restituisce `true`
- Controllare che l'utente abbia i permessi necessari
- Verificare che il widget sia registrato nel Resource

### 2. Stati Mancanti
- Verificare che gli stati siano definiti in `AppointmentState::getStateMapping()`
- Controllare che esistano appuntamenti per quello stato
- Verificare che non ci siano errori nel caricamento degli stati

### 3. Performance Lente
- Verificare che il caching sia abilitato
- Controllare le query database con `DB::enableQueryLog()`
- Ottimizzare gli indici del database

## Note di Sviluppo

- Il widget è progettato per essere **agnostico** rispetto al modulo specifico
- Può essere facilmente adattato per altri moduli con stati simili
- Il design è **responsive** e si adatta a diverse dimensioni di schermo
- La cache viene **invalidata automaticamente** quando necessario
- **Mostra sempre tutti gli appuntamenti** per fornire overview generale 