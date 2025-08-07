# Implementazione Widget Dashboard SaluteMo

## Panoramica

Questo documento descrive l'implementazione di widget statistici e grafici per la dashboard del modulo SaluteMo. I widget forniranno una visione completa delle metriche chiave del sistema sanitario mobile.

## Widget Pianificati

### 1. Grafico a Linee - Iscrizioni Pazienti
**Nome Widget**: `PatientRegistrationsChartWidget`
**Tipo**: Line Chart
**Dati**: Numero di pazienti iscritti nel tempo (ultimi 30 giorni)
**Posizione**: Header Widgets

### 2. Grafico a Barre - Stati Utenti
**Nome Widget**: `UserStatesChartWidget`
**Tipo**: Bar Chart
**Dati**: Distribuzione degli stati degli utenti (attivo, inattivo, sospeso, ecc.)
**Posizione**: Header Widgets

### 3. Grafico a Linee - Registrazioni Medici
**Nome Widget**: `DoctorRegistrationsChartWidget`
**Tipo**: Line Chart
**Dati**: Numero di medici registrati nel tempo (ultimi 30 giorni)
**Posizione**: Footer Widgets

### 4. Grafico a Barre - Stati Medici
**Nome Widget**: `DoctorStatesChartWidget`
**Tipo**: Bar Chart
**Dati**: Distribuzione degli stati dei medici (attivo, inattivo, verificato, ecc.)
**Posizione**: Footer Widgets

### 5. Grafico a Linee - Creazione Appuntamenti
**Nome Widget**: `AppointmentCreationChartWidget`
**Tipo**: Line Chart
**Dati**: Numero di appuntamenti creati nel tempo (ultimi 30 giorni)
**Posizione**: Footer Widgets

### 6. Grafico a Barre - Stati Appuntamenti
**Nome Widget**: `AppointmentStatesChartWidget`
**Tipo**: Bar Chart
**Dati**: Distribuzione degli stati degli appuntamenti (confermato, in attesa, completato, cancellato, ecc.)
**Posizione**: Footer Widgets

## Struttura dei Widget

### Convenzioni di Nomenclatura
- **Classe Widget**: `[Entity][Metric]ChartWidget`
- **Vista**: `salutemo::filament.widgets.[entity]-[metric]-chart`
- **Traduzioni**: `widgets.[entity]_[metric]_chart`

### Estensione Base
Tutti i widget devono estendere `XotBaseWidget`:
```php
use Modules\Xot\Filament\Widgets\XotBaseWidget;
```

### Posizione File
```
Modules/SaluteMo/app/Filament/Widgets/
├── PatientRegistrationsChartWidget.php
├── UserStatesChartWidget.php
├── DoctorRegistrationsChartWidget.php
├── DoctorStatesChartWidget.php
├── AppointmentCreationChartWidget.php
└── AppointmentStatesChartWidget.php
```

### Viste
```
Modules/SaluteMo/resources/views/filament/widgets/
├── patient-registrations-chart.blade.php
├── user-states-chart.blade.php
├── doctor-registrations-chart.blade.php
├── doctor-states-chart.blade.php
├── appointment-creation-chart.blade.php
└── appointment-states-chart.blade.php
```

## Implementazione Tecnica

### 1. Query dei Dati
Ogni widget implementerà metodi per recuperare i dati:
- `getPatientRegistrationsData()`: Dati iscrizioni pazienti
- `getUserStatesData()`: Distribuzione stati utenti
- `getDoctorRegistrationsData()`: Dati iscrizioni medici
- `getDoctorStatesData()`: Distribuzione stati medici
- `getAppointmentCreationData()`: Dati creazione appuntamenti
- `getAppointmentStatesData()`: Distribuzione stati appuntamenti

### 2. Configurazione Grafici
Utilizzo di Filament Charts con configurazioni ottimizzate:
- **Colori**: Palette coerente con il tema SaluteMo
- **Responsive**: Adattamento automatico alle dimensioni dello schermo
- **Interattività**: Tooltip e zoom per i grafici a linee
- **Accessibilità**: Supporto per screen reader

### 3. Caching
Implementazione di cache per ottimizzare le performance:
- **Cache Duration**: 15 minuti per dati dinamici
- **Cache Keys**: Specifici per ogni widget e periodo
- **Cache Invalidation**: Alla creazione/modifica di record correlati

## Traduzioni

### Struttura File di Traduzione
```php
// Modules/SaluteMo/lang/it/widgets.php
return [
    'patient_registrations_chart' => [
        'title' => 'Iscrizioni Pazienti',
        'description' => 'Andamento delle iscrizioni dei pazienti negli ultimi 30 giorni',
        'labels' => [
            'registrations' => 'Iscrizioni',
            'date' => 'Data',
        ],
    ],
    'user_states_chart' => [
        'title' => 'Stati Utenti',
        'description' => 'Distribuzione degli stati degli utenti registrati',
        'labels' => [
            'active' => 'Attivo',
            'inactive' => 'Inattivo',
            'suspended' => 'Sospeso',
        ],
    ],
    // ... altri widget
];
```

### Lingue Supportate
- **Italiano** (`it`): Lingua principale
- **Inglese** (`en`): Traduzione completa
- **Tedesco** (`de`): Traduzione completa

## Integrazione Dashboard

### Modifica Dashboard.php
```php
protected function getHeaderWidgets(): array
{
    return [
        \Modules\SaluteMo\Filament\Widgets\PatientRegistrationsChartWidget::class,
        \Modules\SaluteMo\Filament\Widgets\UserStatesChartWidget::class,
    ];
}

protected function getFooterWidgets(): array
{
    return [
        \Modules\SaluteMo\Filament\Widgets\DoctorRegistrationsChartWidget::class,
        \Modules\SaluteMo\Filament\Widgets\DoctorStatesChartWidget::class,
        \Modules\SaluteMo\Filament\Widgets\AppointmentCreationChartWidget::class,
        \Modules\SaluteMo\Filament\Widgets\AppointmentStatesChartWidget::class,
    ];
}
```

## Considerazioni Performance

### Caching
- **Cache Key**: `salutemo:dashboard:chart:{widget_name}:{period}`
- **Cache Duration**: 5 minuti per dati dinamici
- **Cache Invalidation**: Alla creazione/modifica di record correlati

### Lazy Loading
- **Widget Loading**: Tutti i widget sono configurati come `$isLazy = true`
- **Polling**: Intervallo di 5 minuti per aggiornamenti automatici
- **Error Handling**: Fallback graceful senza logging inutile

## Gestione Filtri Dashboard

### ⚠️ Problema Risolto: Filtri Non Disponibili

**PROBLEMA**: I widget non riuscivano ad accedere ai filtri della dashboard nonostante l'architettura corretta.

**CAUSA**: Le viste Blade della dashboard erano commentate, impedendo il passaggio dei filtri ai widget.

**SOLUZIONE**: 
1. Decommentare le viste in `Modules\Xot\resources\views\filament\pages\dashboard.blade.php`
2. Usare `getFilters()` invece di `$this->filters` nei widget
3. Implementare fallback appropriati

### Implementazione Corretta dei Filtri

```php
// Dashboard - Definizione filtri
public function getFiltersFormSchema(): array
{
    return [
        DatePicker::make('startDate')
            ->maxDate(fn (Get $get) => $get('endDate') ?: now()),
        DatePicker::make('endDate')
            ->minDate(fn (Get $get) => $get('startDate') ?: now())
            ->maxDate(now()),
    ];
}

// Widget - Utilizzo filtri
protected function getData(): array
{
    $filters = $this->getFilters();
    
    $startDate = !empty($filters['startDate']) ? 
        Carbon::parse($filters['startDate']) : now()->subDays(30);
    $endDate = !empty($filters['endDate']) ? 
        Carbon::parse($filters['endDate']) : now();
        
    // ... resto del codice
}
```

### Vista Dashboard Corretta

```blade
<x-filament-panels::page class="fi-dashboard-page">
    @if (method_exists($this, 'filtersForm'))
        {{ $this->filtersForm }}
    @endif

    <x-filament-widgets::widgets 
        :columns="$this->getColumns()" 
        :data="[...property_exists($this, 'filters') ? ['filters' => $this->filters] : [], ...$this->getWidgetData()]" 
        :widgets="$this->getVisibleWidgets()" 
    />
</x-filament-panels::page>
```

### ⚠️ Regole Critiche per i Filtri

1. **MAI commentare le viste** che passano i filtri ai widget
2. **SEMPRE usare `getFilters()`** invece di `$this->filters`
3. **SEMPRE implementare fallback** per quando i filtri non sono disponibili
4. **SEMPRE gestire gli errori** senza logging inutile

Per maggiori dettagli, consultare [Dashboard Filters Fix](./dashboard-filters-fix.md).

## Regole Critiche di Implementazione

### 1. Query Ottimizzate
- Utilizzo di indici appropriati sui campi `created_at` e `state`
- Eager loading per relazioni necessarie
- Limitazione dei risultati per grafici a linee (max 30 punti)

### 2. Caching Strategico
- Cache dei risultati delle query per 15 minuti
- Cache separata per ogni widget e periodo temporale
- Invalidation automatica alla modifica dei dati

### 3. Lazy Loading
- Caricamento asincrono dei widget
- Skeleton loader durante il caricamento
- Gestione degli errori con fallback

## Testing

### Test Unitari
- Test per ogni metodo di recupero dati
- Verifica della correttezza dei calcoli
- Test del caching

### Test di Integrazione
- Test del rendering dei widget
- Verifica delle traduzioni
- Test della responsività

### Test di Performance
- Benchmark dei tempi di caricamento
- Test con dataset di grandi dimensioni
- Verifica dell'efficienza del caching

## Sicurezza

### 1. Autorizzazione
- Verifica dei permessi per ogni widget
- Controllo dell'accesso ai dati sensibili
- Logging delle azioni amministrative

### 2. Sanitizzazione Dati
- Escape dei dati visualizzati nei grafici
- Validazione dei parametri di query
- Protezione da SQL injection

## Monitoraggio

### 1. Logging
- Log delle performance dei widget
- Tracciamento degli errori
- Metriche di utilizzo

### 2. Alerting
- Notifiche per errori critici
- Alert per performance degradate
- Monitoraggio della disponibilità

## Roadmap

### Fase 1: Widget Base
- Implementazione dei 6 widget principali
- Configurazione base delle traduzioni
- Test di base

### Fase 2: Ottimizzazioni
- Implementazione del caching
- Ottimizzazione delle query
- Miglioramento delle performance

### Fase 3: Funzionalità Avanzate
- Filtri temporali interattivi
- Esportazione dati
- Personalizzazione layout

## Collegamenti Correlati
- [Convenzioni Widget](./widgets.md)
- [Struttura Dashboard](./dashboard-conventions.md)
- [Best Practices Filament](./best-practices.md)
- [Convenzioni Traduzioni](../translations/conventions.md) 