# Regole Consolidate per Widget Custom - Modulo SaluteMo

## Collegamenti Bidirezionali
- [Documentazione SaluteMo - Widget](./filament/widgets.md)
- [Modulo Xot - XotBaseWidget](../../Xot/docs/filament/widgets/xot-base-widget.md)
- [Modulo Xot - Widget Rules](../../Xot/docs/filament_widget_regole.md)
- [Modulo User - Widget Translation Rules](../../User/docs/widget-translation-rules.md)
- [AppointmentOverviewWidget Design](./appointment-overview-widget-design.md)

## Regole Critiche Consolidate

### 1. Estensione Base Obbligatoria

**SEMPRE estendere XotBaseWidget**, MAI classi Filament direttamente:

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class AppointmentOverviewWidget extends XotBaseWidget
{
    // Implementazione
}
```

### 2. Namespace e Posizionamento

#### Posizionamento Fisico
```
Modules/SaluteMo/app/Filament/Widgets/AppointmentOverviewWidget.php
```

#### Namespace Corretto
```php
// ✅ CORRETTO
namespace Modules\SaluteMo\Filament\Widgets;

// ❌ ERRATO
namespace Modules\SaluteMo\App\Filament\Widgets;
```

### 3. Percorso delle Viste

**Pattern Obbligatorio**:
```php
protected static string $view = 'salutemo::filament.widgets.appointment-overview';
```

**Posizionamento Vista**:
```
Modules/SaluteMo/resources/views/filament/widgets/appointment-overview.blade.php
```

### 4. Proprietà e Configurazione

#### Proprietà Standard XotBaseWidget
```php
class AppointmentOverviewWidget extends XotBaseWidget
{
    public string $title = '';
    public string $icon = '';
    protected int|string|array $columnSpan = 'full';
    
    // Dati del form
    public ?array $data = [];
}
```

#### Traits Integrati Automaticamente
- `InteractsWithForms`: Gestione form
- `InteractsWithPageFilters`: Filtri di pagina
- `InteractsWithActions`: Azioni del widget
- `TransTrait`: Traduzioni

### 5. Metodi Obbligatori

#### getFormSchema() - OBBLIGATORIO
```php
/**
 * Schema del form per il widget.
 *
 * @return array<int|string, \Filament\Forms\Components\Component>
 */
public function getFormSchema(): array
{
    return [
        // Componenti del form se necessari
    ];
}
```

#### getViewData() - Per Passare Dati alla Vista
```php
/**
 * Dati da passare alla vista.
 *
 * @return array<string, mixed>
 */
protected function getViewData(): array
{
    return [
        'appointments' => $this->getAppointmentStats(),
        'states' => $this->getAppointmentStates(),
    ];
}
```

### 6. Struttura Vista Blade

#### Template Base
```blade
{{-- resources/views/filament/widgets/appointment-overview.blade.php --}}
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid grid-cols-3 gap-4 md:grid-cols-6 lg:grid-cols-9">
            @foreach($states as $state)
                <div class="bg-white rounded-lg p-4 shadow">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full" style="background-color: {{ $state['color'] }}20;">
                            <x-heroicon-o-{{ $state['icon'] }} class="w-6 h-6" style="color: {{ $state['color'] }};" />
                        </div>
                    </div>
                    <div class="mt-2">
                        <p class="text-sm font-medium text-gray-600">{{ $state['label'] }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $state['count'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
```

### 7. Traduzioni

#### Nessun ->label() nei Componenti
```php
// ✅ CORRETTO - Le traduzioni sono gestite automaticamente
TextInput::make('field_name')

// ❌ ERRATO
TextInput::make('field_name')->label('Label')
```

#### File di Traduzione
```php
// Modules/SaluteMo/lang/it/widgets.php
return [
    'appointment_overview' => [
        'title' => 'Panoramica Appuntamenti',
        'description' => 'Statistiche degli appuntamenti per stato',
        'states' => [
            'scheduled' => 'Programmati',
            'confirmed' => 'Confermati',
            'completed' => 'Completati',
            // ...
        ],
    ],
];
```

### 8. Gestione Stati e Dati

#### Pattern per Stati Appointment
```php
protected function getAppointmentStates(): array
{
    $states = [];
    $stateMapping = AppointmentState::getStateMapping()->toArray();
    
    foreach ($stateMapping as $name => $stateClass) {
        $appointment = new Appointment();
        $state = new $stateClass($appointment);
        
        $states[] = [
            'name' => $name,
            'label' => $state->label(),
            'icon' => $state->icon(),
            'color' => $state->bgColor(),
            'count' => $this->getCountForState($name),
        ];
    }
    
    return $states;
}
```

### 9. Performance e Caching

#### Caching per Performance
```php
protected function getAppointmentStats(): array
{
    return Cache::remember(
        'appointment-stats-' . auth()->id(),
        now()->addMinutes(5),
        fn () => $this->calculateStats()
    );
}
```

### 10. Responsive Design

#### Grid Responsive
```blade
{{-- 3 colonne su mobile, 6 su tablet, 9 su desktop --}}
<div class="grid grid-cols-3 gap-4 md:grid-cols-6 lg:grid-cols-9">
```

### 11. Best Practices

#### Tipizzazione Rigorosa
- `declare(strict_types=1);` obbligatorio
- Tutti i metodi con tipi di ritorno espliciti
- PHPDoc completi per proprietà e metodi

#### Gestione Errori
```php
protected function getCountForState(string $stateName): int
{
    try {
        return Appointment::where('state', $stateName)->count();
    } catch (\Exception $e) {
        Log::warning("Errore nel conteggio appuntamenti per stato {$stateName}: " . $e->getMessage());
        return 0;
    }
}
```

#### Sicurezza
- Sempre verificare autorizzazioni
- Filtrare dati per utente/tenant corrente
- Sanitizzare input se presenti

### 12. Testing

#### Test Structure
```php
class AppointmentOverviewWidgetTest extends TestCase
{
    /** @test */
    public function it_renders_appointment_states_correctly(): void
    {
        // Test implementation
    }
    
    /** @test */
    public function it_shows_correct_counts_for_each_state(): void
    {
        // Test implementation
    }
}
```

## Pattern per Widget Compatti

### 13. Widget Solo Visualizzazione

#### Quando Usare
- Statistiche e dashboard
- Conteggi e metriche
- Informazioni di sola lettura
- Layout compatti e responsive

#### Implementazione
```php
class CompactStatsWidget extends XotBaseWidget
{
    protected static ?string $pollingInterval = '30s';
    protected int | string | array $columnSpan = 'full';
    
    public function getFormSchema(): array
    {
        return []; // Nessun form necessario
    }
    
    protected function getViewData(): array
    {
        return [
            'stats' => $this->getStats(),
            'lastUpdated' => now()->format('H:i'),
        ];
    }
}
```

## 🚨 REGOLE ARCHITETTURALI CRITICHE

### MAI Estendere Classi Filament Direttamente

**REGOLA ARCHITETTURALE FONDAMENTALE**: MAI estendere direttamente classi Filament, ma SEMPRE e SOLO le classi XotBase corrispondenti:

#### Pattern Corretti
```php
// ✅ CORRETTO - ChartWidget
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
class MyChartWidget extends XotBaseChartWidget

// ✅ CORRETTO - StatsOverviewWidget
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;
class MyStatsWidget extends XotBaseStatsOverviewWidget

// ✅ CORRETTO - Widget generico
use Modules\Xot\Filament\Widgets\XotBaseWidget;
class MyWidget extends XotBaseWidget
```

#### Anti-Pattern da Evitare
```php
// ❌ ERRATO - MAI estendere direttamente Filament
use Filament\Widgets\ChartWidget;
class MyChartWidget extends ChartWidget // ERRORE ARCHITETTURALE!

// ❌ ERRATO - MAI estendere direttamente Filament
use Filament\Widgets\StatsOverviewWidget;
class MyStatsWidget extends StatsOverviewWidget // ERRORE ARCHITETTURALE!
```

**Motivazione**: 
- Le classi XotBase forniscono funzionalità aggiuntive specifiche per Laraxot
- Includono trait comuni (TransTrait, caching, etc.)
- Garantiscono compatibilità con l'architettura del framework
- Permettono override e personalizzazioni centralizzate

**Violazione**: Causa errori architetturali gravi e incompatibilità con il framework Laraxot.

### Classi XotBase Disponibili

#### Widget Base
- `XotBaseWidget` - Widget generico base
- `XotBaseChartWidget` - Per grafici e chart
- `XotBaseStatsOverviewWidget` - Per statistiche overview

#### Verifica Architetturale
**TUTTI i 13 widget in SaluteMo sono già stati corretti e seguono questa regola:**

✅ PatientRegistrationsChartWidget → XotBaseChartWidget
✅ DoctorRegistrationsChartWidget → XotBaseChartWidget
✅ AppointmentCreationChartWidget → XotBaseChartWidget
✅ AppointmentStatesChartWidget → XotBaseChartWidget
✅ UserStatesChartWidget → XotBaseChartWidget
✅ DoctorStatesChartWidget → XotBaseChartWidget
✅ StatsOverview → XotBaseStatsOverviewWidget
✅ DoctorRegistrationTrendWidget → XotBaseChartWidget
✅ PatientRegistrationTrendWidget → XotBaseChartWidget
✅ AppointmentStatusDistributionWidget → XotBaseChartWidget
✅ AppointmentCreationTrendWidget → XotBaseChartWidget
✅ DoctorStatusDistributionWidget → XotBaseChartWidget
✅ UserStatusDistributionWidget → XotBaseChartWidget

### 14. Layout Compatto Responsive

#### Grid System Ottimizzato
```blade
{{-- Layout ultra-compatto per statistiche --}}
<div class="grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-6 lg:grid-cols-9 xl:grid-cols-12">
    @foreach($stats as $stat)
        <div class="bg-white dark:bg-gray-800 rounded-lg p-2 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="text-center">
                {{-- Icona piccola --}}
                <div class="inline-flex items-center justify-center w-8 h-8 rounded-full mb-1" 
                     style="background-color: {{ $stat['color'] }}20;">
                    <x-heroicon-o-{{ $stat['icon'] }} 
                         class="w-4 h-4" 
                         style="color: {{ $stat['color'] }};" />
                </div>
                
                {{-- Conteggio --}}
                <div class="text-lg font-bold text-gray-900 dark:text-white">
                    {{ number_format($stat['count']) }}
                </div>
                
                {{-- Label piccola --}}
                <div class="text-xs text-gray-600 dark:text-gray-400 leading-tight">
                    {{ $stat['label'] }}
                </div>
            </div>
        </div>
    @endforeach
</div>
```

### 15. Caching Intelligente

#### Strategia di Caching per Widget Compatti
```php
protected function getCachedStats(): array
{
    $cacheKey = 'compact-stats-' . auth()->id() . '-' . $this->getCacheVersion();
    
    return Cache::remember($cacheKey, now()->addMinutes(5), function () {
        return $this->calculateStats();
    });
}

protected function getCacheVersion(): string
{
    // Invalida cache quando cambiano i filtri o i dati
    return md5(serialize($this->getFilters()) . $this->getLastDataUpdate());
}
```

## Applicazione Specifica: AppointmentOverviewWidget

### Obiettivo
Creare un widget compatto ed elegante che mostri:
- Tutti gli stati degli appuntamenti
- Conteggio per ogni stato
- Icone e colori distintivi
- Layout responsive (9 elementi per riga su desktop)
- Occupazione minima di spazio

### Implementazione
1. Estendere `XotBaseWidget`
2. Implementare `getFormSchema()` (vuoto se non serve form)
3. Implementare `getViewData()` per passare stati e conteggi
4. Creare vista Blade responsive
5. Aggiungere traduzioni appropriate
6. Implementare caching per performance

### Vantaggi vs StatsOverviewWidget
- ✅ **Spazio Ottimizzato**: Occupa meno spazio verticale
- ✅ **Layout Responsive**: 9 elementi per riga su desktop
- ✅ **Design Personalizzato**: Controllo completo su stile e layout
- ✅ **Performance**: Caching ottimizzato per grandi dataset
- ✅ **Flessibilità**: Facile personalizzazione e estensione

---

*Ultimo aggiornamento: Gennaio 2025*
*Versione: 2.0*
*Compatibilità: Laravel 12.x, Filament 3.x*
