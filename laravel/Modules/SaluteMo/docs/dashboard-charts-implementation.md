# Dashboard Charts Implementation - SaluteMo

## Panoramica

Questo documento descrive l'implementazione dettagliata di 6 widget grafici per la Dashboard del modulo SaluteMo. I widget forniranno insights visivi sui dati del sistema sanitario mobile.

## Widget da Implementare

### 1. Patient Registrations Line Chart
**Nome Widget**: `PatientRegistrationsChartWidget`
**Tipo**: Line Chart
**Posizione**: Header Widgets
**Dati**: Numero di pazienti registrati negli ultimi 30 giorni
**Query**: `Patient::where('created_at', '>=', now()->subDays(30))->groupBy('date')->count()`
**Colore**: Blu (#3B82F6)
**Interattività**: Tooltip con data e numero registrazioni

### 2. User States Bar Chart
**Nome Widget**: `UserStatesChartWidget`
**Tipo**: Bar Chart
**Posizione**: Header Widgets
**Dati**: Distribuzione degli stati degli utenti (Active, Pending, IntegrationRequested)
**Query**: `User::selectRaw('state, COUNT(*) as count')->groupBy('state')->get()`
**Colori**: Verde (Active), Giallo (Pending), Grigio (IntegrationRequested)
**Interattività**: Click per filtrare per stato

### 3. Doctor Registrations Line Chart
**Nome Widget**: `DoctorRegistrationsChartWidget`
**Tipo**: Line Chart
**Posizione**: Footer Widgets
**Dati**: Numero di dottori registrati negli ultimi 30 giorni
**Query**: `Doctor::where('created_at', '>=', now()->subDays(30))->groupBy('date')->count()`
**Colore**: Verde (#10B981)
**Interattività**: Tooltip con data e numero registrazioni

### 4. Doctor States Bar Chart
**Nome Widget**: `DoctorStatesChartWidget`
**Tipo**: Bar Chart
**Posizione**: Footer Widgets
**Dati**: Distribuzione degli stati dei dottori (Active, Pending, IntegrationRequested)
**Query**: `Doctor::selectRaw('state, COUNT(*) as count')->groupBy('state')->get()`
**Colori**: Verde (Active), Giallo (Pending), Grigio (IntegrationRequested)
**Interattività**: Click per filtrare per stato

### 5. Appointment Creation Line Chart
**Nome Widget**: `AppointmentCreationChartWidget`
**Tipo**: Line Chart
**Posizione**: Footer Widgets
**Dati**: Numero di appuntamenti creati negli ultimi 30 giorni
**Query**: `Appointment::where('created_at', '>=', now()->subDays(30))->groupBy('date')->count()`
**Colore**: Viola (#8B5CF6)
**Interattività**: Tooltip con data e numero appuntamenti

### 6. Appointment States Bar Chart
**Nome Widget**: `AppointmentStatesChartWidget`
**Tipo**: Bar Chart
**Posizione**: Footer Widgets
**Dati**: Distribuzione degli stati degli appuntamenti
**Query**: `Appointment::selectRaw('state, COUNT(*) as count')->groupBy('state')->get()`
**Colori**: Blu (Scheduled), Verde (Confirmed), Grigio (Completed), Rosso (Cancelled), Arancione (No-Show)
**Interattività**: Click per filtrare per stato

## Struttura Tecnica

### Estensione Base
Tutti i widget estenderanno `XotBaseChartWidget` del modulo Xot:

**⚠️ REGOLA CRITICA FONDAMENTALE**: SEMPRE estendere classi XotBase, MAI direttamente Filament!

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget; // ⚠️ SEMPRE XotBase
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\User;

class PatientRegistrationsChartWidget extends XotBaseChartWidget // ⚠️ SEMPRE XotBase
{
    protected static ?string $heading = null;
    protected static ?int $sort = 1;
    protected static bool $isLazy = true; // ⚠️ SEMPRE bool, mai ?bool
    protected static ?string $pollingInterval = '300s'; // 5 minuti

    public function getHeading(): ?string // ⚠️ SEMPRE public, mai protected
    {
        return __('salutemo::widgets.patient_registrations_chart.title');
    }

    protected function getData(): array
    {
        $data = Trend::model(Patient::class)
            ->between(
                start: now()->subDays(30),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => __('salutemo::widgets.patient_registrations_chart.label'),
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date->format('d/m')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
```

### Pattern per Widget a Barre
```php
class UserStatesChartWidget extends XotBaseChartWidget // ⚠️ SEMPRE XotBase
{
    protected static ?string $heading = null;
    protected static ?int $sort = 2;
    protected static bool $isLazy = true; // ⚠️ SEMPRE bool, mai ?bool

    public function getHeading(): ?string // ⚠️ SEMPRE public, mai protected
    {
        return __('salutemo::widgets.user_states_chart.title');
    }

    protected function getData(): array
    {
        $states = User::selectRaw('state, COUNT(*) as count')
            ->groupBy('state')
            ->get()
            ->keyBy('state');

        $colors = [
            'active' => 'rgb(34, 197, 94)',
            'pending' => 'rgb(234, 179, 8)',
            'integration_requested' => 'rgb(107, 114, 128)',
        ];

        return [
            'datasets' => [
                [
                    'label' => __('salutemo::widgets.user_states_chart.label'),
                    'data' => $states->pluck('count')->toArray(),
                    'backgroundColor' => $states->keys()->map(fn($state) => $colors[$state] ?? 'rgb(156, 163, 175)')->toArray(),
                    'borderColor' => $states->keys()->map(fn($state) => $colors[$state] ?? 'rgb(156, 163, 175)')->toArray(),
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $states->keys()->map(fn($state) => __('salutemo::fields.state.options.' . $state))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
```

## File da Creare

### Widget Classes
```
Modules/SaluteMo/app/Filament/Widgets/
├── PatientRegistrationsChartWidget.php
├── UserStatesChartWidget.php
├── DoctorRegistrationsChartWidget.php
├── DoctorStatesChartWidget.php
├── AppointmentCreationChartWidget.php
└── AppointmentStatesChartWidget.php
```

### Traduzioni
```php
// Modules/SaluteMo/lang/it/widgets.php
return [
    'patient_registrations_chart' => [
        'title' => 'Registrazioni Pazienti',
        'label' => 'Pazienti Registrati',
        'description' => 'Trend delle registrazioni pazienti negli ultimi 30 giorni',
    ],
    'user_states_chart' => [
        'title' => 'Stati Utenti',
        'label' => 'Numero Utenti',
        'description' => 'Distribuzione degli stati degli utenti nel sistema',
    ],
    'doctor_registrations_chart' => [
        'title' => 'Registrazioni Medici',
        'label' => 'Medici Registrati',
        'description' => 'Trend delle registrazioni medici negli ultimi 30 giorni',
    ],
    'doctor_states_chart' => [
        'title' => 'Stati Medici',
        'label' => 'Numero Medici',
        'description' => 'Distribuzione degli stati dei medici nel sistema',
    ],
    'appointment_creation_chart' => [
        'title' => 'Creazione Appuntamenti',
        'label' => 'Appuntamenti Creati',
        'description' => 'Trend della creazione appuntamenti negli ultimi 30 giorni',
    ],
    'appointment_states_chart' => [
        'title' => 'Stati Appuntamenti',
        'label' => 'Numero Appuntamenti',
        'description' => 'Distribuzione degli stati degli appuntamenti nel sistema',
    ],
];
```

## Aggiornamento Dashboard.php

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBaseDashboard;
use Modules\SaluteMo\Filament\Widgets\PatientRegistrationsChartWidget;
use Modules\SaluteMo\Filament\Widgets\UserStatesChartWidget;
use Modules\SaluteMo\Filament\Widgets\DoctorRegistrationsChartWidget;
use Modules\SaluteMo\Filament\Widgets\DoctorStatesChartWidget;
use Modules\SaluteMo\Filament\Widgets\AppointmentCreationChartWidget;
use Modules\SaluteMo\Filament\Widgets\AppointmentStatesChartWidget;

class Dashboard extends XotBaseDashboard
{
    protected static ?int $navigationSort = 1;

    /**
     * Widget da visualizzare nell'header della dashboard.
     *
     * @return array<class-string>
     */
    protected function getHeaderWidgets(): array
    {
        return [
            PatientRegistrationsChartWidget::class,
            UserStatesChartWidget::class,
        ];
    }

    /**
     * Widget da visualizzare nel footer della dashboard.
     *
     * @return array<class-string>
     */
    protected function getFooterWidgets(): array
    {
        return [
            DoctorRegistrationsChartWidget::class,
            DoctorStatesChartWidget::class,
            AppointmentCreationChartWidget::class,
            AppointmentStatesChartWidget::class,
        ];
    }
}
```

## Regole Critiche di Implementazione

### ⚠️ Tipi di Proprietà - REGOLA CRITICA
**MAI modificare i tipi delle proprietà ereditate da Filament Widgets!**

```php
// ❌ SBAGLIATO
protected static ?bool $isLazy = true;  // Dovrebbe essere bool
protected function getHeading(): ?string  // Dovrebbe essere public

// ✅ CORRETTO
protected static bool $isLazy = true;  // Tipo esatto della classe base
public function getHeading(): ?string  // Visibilità corretta
```

### ⚠️ Checklist Obbligatoria
Prima di implementare qualsiasi widget:
- [ ] **CRITICO**: Verificare che estenda la classe XotBase corretta
- [ ] **CRITICO**: Usare `Modules\Xot\Filament\Widgets\XotBaseChartWidget` (non `Filament\Widgets\ChartWidget`)
- [ ] Verificare i tipi delle proprietà nella classe base Filament
- [ ] Usare esattamente gli stessi tipi (bool, non ?bool)
- [ ] Mantenere la stessa visibilità dei metodi (public/protected)
- [ ] Implementare try-catch per error handling
- [ ] Aggiungere fallback graceful senza logging
- [ ] **CRITICO**: Con Trend, usare `\Carbon\Carbon::parse($value->date)` per le date

## Considerazioni di Performance

### Caching
- **Cache Key**: `salutemo:dashboard:chart:{widget_name}:{period}`
- **TTL**: 300 secondi (5 minuti)
- **Invalidation**: Alla creazione/modifica di record correlati

### Query Optimization
- **Indexes**: Verificare presenza di indici su `created_at`, `state`, `type`
- **Eager Loading**: Non necessario per query di aggregazione
- **Chunking**: Non necessario per dataset limitati a 30 giorni

### Lazy Loading
- **Widget Lazy**: Tutti i widget saranno lazy-loaded
- **Polling**: Aggiornamento automatico ogni 5 minuti
- **Error Handling**: Gestione graceful degli errori con try-catch

## Sicurezza e Privacy

### Data Protection
- **Aggregazione**: Mostrare solo dati aggregati, mai dati personali
- **Permissions**: Verificare permessi utente per accesso ai dati
- **Tenant Isolation**: Dati filtrati per tenant se applicabile

### Access Control
- **Role-based**: Widget visibili solo a utenti autorizzati
- **Data Masking**: Mascherare dati sensibili nei tooltip

## Testing Strategy

### Unit Tests
- **Widget Classes**: Test per ogni widget individualmente
- **Data Methods**: Test per metodi `getData()`
- **Translation Keys**: Verifica presenza traduzioni

### Integration Tests
- **Dashboard Integration**: Test completo dashboard con widget
- **Performance Tests**: Verifica tempi di caricamento
- **Cache Tests**: Verifica funzionamento cache

## Collegamenti

- [Dashboard Widgets Implementation Plan](./dashboard-widgets-implementation-plan.md)
- [Widget Rules Consolidated](./widget-rules-consolidated.md)
- [Filament Integration](./filament-integration.md)
- [Chart Module Documentation](../../Chart/docs/README.md)

---

**Ultimo aggiornamento**: Gennaio 2025
**Versione**: 1.0
**Autore**: AI Assistant
**Stato**: Pronto per Implementazione 