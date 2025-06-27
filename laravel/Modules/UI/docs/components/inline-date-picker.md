# InlineDatePicker Component

## Panoramica Fenomenologica

L'InlineDatePicker è un componente di selezione date che implementa una **filosofia multi-dimensionale** dell'esperienza temporale. Non è semplicemente un calendario, ma un'**interfaccia quantistica** che permette all'utente di navigare attraverso il continuum spazio-temporale con controllo democratico e design minimalista.

## Principi Filosofici Applicati

### 🧘 **Fenomenologia dell'Esperienza Temporale**
- **Presente Fenomenologico**: Il mese visualizzato rappresenta l'esperienza immediata dell'utente
- **Intenzionalità Temporale**: Ogni interazione ha significato nel contesto del tempo
- **Corporeità Digitale**: L'interfaccia diventa estensione della percezione temporale

### ⚛️ **Meccanica Quantistica delle Date**
- **Superposizione**: Le date esistono in stato di potenzialità fino alla selezione
- **Entanglement Temporale**: La navigazione collega passato, presente e futuro
- **Collasso della Funzione d'Onda**: La selezione cristallizza una data specifica

### 🏛️ **Governance Democratica del Tempo**
- **Trasparenza**: Tutti i controlli sono visibili e accessibili
- **Accountability**: Ogni azione di navigazione è tracciabile
- **Inclusività**: Design accessibile per tutti gli utenti
- **Neutralità Tecnologica**: Nessun bias nelle funzionalità temporali

### 🎨 **Estetica della Semplicità**
- **Minimalismo Spirituale**: Eliminazione di elementi non essenziali
- **Gestalt Design**: Percezione unificata del calendario come entità coesa
- **Teoria del Colore**: Significati veicolati attraverso scelte cromatiche

## Architettura Tecnica

### Componente PHP: `InlineDatePicker.php`

```php
<?php

declare(strict_types=1);

namespace Modules\\UI\\Filament\\Forms\\Components;

use Filament\\Forms\\Components\\DatePicker;
use Carbon\\Carbon;

/**
 * InlineDatePicker - Calendario inline con navigazione temporale avanzata
 * 
 * Implementa principi di:
 * - Fenomenologia: Esperienza diretta dell'interazione temporale
 * - Meccanica Quantistica: Date in superposizione fino alla selezione
 * - Democrazia Temporale: Controllo utente su ogni aspetto della navigazione
 */
class InlineDatePicker extends DatePicker
{
    // Architettura completa...
}
```

## API Completa e Funzionalità

### Metodi di Configurazione

#### `enabledDates(array|Closure $dates): static`
Definisce le date selezionabili secondo il **principio di scarsità controllata**.

```php
// Array statico di date
InlineDatePicker::make('appointment_date')
    ->enabledDates(['2025-06-05', '2025-06-21', '2025-07-10']);

// Closure dinamica per logica complessa
InlineDatePicker::make('appointment_date')
    ->enabledDates(function () {
        return Appointment::where('available', true)
            ->pluck('date')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->toArray();
    });
```

#### `highlightColor(string $color): static`
Applica la **teoria del colore** per comunicazione visiva.

```php
// Colori semantici predefiniti
InlineDatePicker::make('emergency_date')
    ->highlightColor('bg-red-600 text-white'); // Emergenza

InlineDatePicker::make('routine_date')
    ->highlightColor('bg-green-600 text-white'); // Routine

InlineDatePicker::make('priority_date')
    ->highlightColor('bg-amber-600 text-white'); // Priorità

// Colori personalizzati con gradienti
InlineDatePicker::make('vip_date')
    ->highlightColor('bg-gradient-to-r from-purple-600 to-blue-600 text-white');
```

#### `compactMode(bool $compact = true): static`
Attiva il **design responsivo** per spazi ridotti.

```php
// In sidebar o widget stretti
InlineDatePicker::make('quick_date')
    ->compactMode()
    ->showNavigation(false); // Nasconde i controlli per massima compattezza

// Modalità estesa per dashboard
InlineDatePicker::make('main_calendar')
    ->compactMode(false)
    ->showNavigation(true);
```

#### `showNavigation(bool $show = true): static`
Controlla la **democrazia temporale** tramite controlli di navigazione.

```php
// Navigazione completa (default)
InlineDatePicker::make('flexible_date')
    ->showNavigation(true);

// Solo visualizzazione (modalità read-only temporale)
InlineDatePicker::make('readonly_date')
    ->showNavigation(false);
```

### Navigazione Temporale Avanzata - NUOVO 🚀

#### Implementazione Fenomenologica della Navigazione

La nuova funzionalità di navigazione tra i mesi implementa una **architettura quantistica** del movimento temporale, ispirata dal design di `/var/www/html/base_saluteora/laravel/Themes/One/docs/html/calendar.html`. 

**Principi Filosofici della Navigazione:**
- **Cronologia**: Sequenza ordinata degli eventi temporali
- **Sincronicità**: Coordinazione dell'esperienza temporale
- **Persistenza**: Mantenimento dello stato durante la navigazione
- **Democraticità**: Controllo utente completo sul flusso temporale

#### Controlli UI - Design Quantistico

I controlli di navigazione implementano l'**iconografia universale** del movimento temporale:

```html
<!-- Pulsante Mese Precedente -->
<!-- Viaggio verso il passato: accesso alla dimensione temporale precedente -->
<button 
    type=\"button\" 
    @click=\"navigateToMonth('prev')\"
    class=\"absolute -left-1.5 -top-1 flex items-center justify-center p-1.5 
           text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 
           focus:ring-offset-2 focus:ring-indigo-500 rounded-md transition-colors duration-200\"
    aria-label=\"Mese precedente\"
    x-tooltip=\"'Vai al mese precedente'\"
>
    <span class=\"sr-only\">Mese precedente</span>
    <!-- Iconografia Quantistica: Chevron Left come simbolo del movimento temporale -->
    <svg class=\"size-5\" viewBox=\"0 0 20 20\" fill=\"currentColor\" aria-hidden=\"true\">
        <path fill-rule=\"evenodd\" d=\"M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z\" clip-rule=\"evenodd\" />
    </svg>
</button>
```

#### JavaScript Alpine.js - Pattern Observer

```javascript
x-data=\"{
    selectedDate: @js($currentValue),
    enabledDates: @js($enabledDates),
    currentMonth: @js($currentViewMonth->format('Y-m')),
    
    // Navigazione temporale con easing quantistico
    navigateToMonth(direction) {
        const currentDate = new Date(this.currentMonth + '-01');
        
        if (direction === 'prev') {
            currentDate.setMonth(currentDate.getMonth() - 1);
        } else if (direction === 'next') {
            currentDate.setMonth(currentDate.getMonth() + 1);
        }
        
        const newMonth = currentDate.getFullYear() + '-' + 
            String(currentDate.getMonth() + 1).padStart(2, '0');
        
        this.currentMonth = newMonth;
        
        // Bridge Pattern: Comunicazione JavaScript→PHP
        $wire.call('setCurrentViewMonth', newMonth);
    }
}\"
```

#### Metodi PHP per Navigazione Temporale

Il componente espone nuovi metodi per il controllo programmatico della navigazione:

```php
// Metodo Livewire per comunicazione JavaScript→PHP
public function setCurrentViewMonth(string $monthString): void
{
    // Parsing sicuro e gestione errori temporali
    // Implementa fallback al presente fenomenologico
}

// Navigazione diretta (metodi helper)
$picker->setDisplayDate(Carbon::parse('2025-07-01'));
$picker->previousMonth(); // Vai al mese precedente
$picker->nextMonth();     // Vai al mese successivo

// Controllo stato navigazione
$currentMonth = $picker->getCurrentViewMonth(); // Carbon instance
$hasPrev = $picker->hasPreviousMonth();         // bool
$hasNext = $picker->hasNextMonth();             // bool
```

#### Gestione Stato Avanzata

La navigazione mantiene lo stato attraverso:

```php
/**
 * Dati esposti alla vista per controllo completo
 */
public function getViewData(): array
{
    return [
        // Controllo temporale per navigazione
        'currentViewMonth' => $this->displayDate,
        'previousMonth' => $this->displayDate->copy()->subMonth(),
        'nextMonth' => $this->displayDate->copy()->addMonth(),
        
        // Metadati per sincronizzazione JavaScript
        'monthYearLabel' => $this->displayDate->translatedFormat('F Y'),
        'componentId' => $this->getId(),
        'statePath' => $this->getStatePath(),
        
        // ... altri dati
    ];
}
```

### Integrazione con Form Wizard

#### Pattern Wizard Multi-Step

```php
use Filament\\Forms\\Components\\Wizard;
use Modules\\UI\\Filament\\Forms\\Components\\InlineDatePicker;

public function getFormSchema(): array
{
    return [
        Wizard::make([
            Wizard\\Step::make('date_selection')
                ->label('Selezione Data')
                ->schema([
                    InlineDatePicker::make('appointment_date')
                        ->label('Data Appuntamento')
                        ->enabledDates(function () {
                            return $this->getAvailableDates();
                        })
                        ->highlightColor('bg-blue-600 text-white')
                        ->required()
                        ->live() // Reattività per step successivi
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Logica per aggiornare step successivi
                            $this->updateAvailableTimeSlots($state, $set);
                        }),
                ]),
                
            Wizard\\Step::make('time_selection')
                ->label('Selezione Orario')
                ->schema([
                    // Campi dipendenti dalla data selezionata
                ]),
        ])
    ];
}
```

## Esempi di Utilizzo Avanzato

### 1. Calendario Appuntamenti Medici

```php
// Nel Widget o Risorsa Filament
InlineDatePicker::make('visit_date')
    ->label('Data Visita')
    ->enabledDates(function () {
        // Solo giorni lavorativi con disponibilità
        return Doctor::find($this->doctor_id)
            ->getAvailableDates()
            ->filter(fn($date) => !$date->isWeekend())
            ->map(fn($date) => $date->format('Y-m-d'))
            ->toArray();
    })
    ->highlightColor('bg-green-600 text-white')
    ->compactMode(false)
    ->showNavigation(true)
    ->required();
```

### 2. Calendario Eventi Ricorrenti

```php
InlineDatePicker::make('recurring_event_date')
    ->label('Data Evento Ricorrente')
    ->enabledDates(function () {
        // Pattern ricorrenti: ogni lunedì e mercoledì
        $dates = collect();
        $start = now()->startOfMonth();
        $end = now()->addMonths(3)->endOfMonth();
        
        while ($start->lte($end)) {
            if ($start->isMonday() || $start->isWednesday()) {
                $dates->push($start->format('Y-m-d'));
            }
            $start->addDay();
        }
        
        return $dates->toArray();
    })
    ->highlightColor('bg-purple-600 text-white');
```

### 3. Calendario con Restrizioni Dinamiche

```php
InlineDatePicker::make('project_deadline')
    ->label('Scadenza Progetto')
    ->enabledDates(function () {
        // Solo date future con almeno 7 giorni di preavviso
        return collect(range(7, 90))
            ->map(fn($days) => now()->addDays($days)->format('Y-m-d'))
            ->filter(function ($date) {
                // Escludi festività
                $carbon = Carbon::parse($date);
                return !in_array($carbon->format('m-d'), [
                    '01-01', '12-25', '12-26', // Festività
                ]);
            })
            ->toArray();
    })
    ->highlightColor('bg-amber-600 text-white');
```

## Accessibilità e Inclusività

### Supporto Screen Reader

```html
<!-- Ogni elemento ha labels appropriati -->
<button 
    aria-label=\"Seleziona {{ $day['date']->translatedFormat('d F Y') }}\"
    @if($isSelected) aria-pressed=\"true\" @endif
>
    <time datetime=\"{{ $dateString }}\">{{ $day['day'] }}</time>
</button>
```

### Navigazione da Tastiera

- **Tab**: Navigazione tra controlli
- **Space/Enter**: Selezione data
- **Arrow Keys**: Navigazione tra date (implementazione futura)
- **Escape**: Chiudi eventuali modal

### Supporto Internazionale

```php
// Localizzazione automatica
'monthYearLabel' => $currentViewMonth->translatedFormat('F Y'),
'monthName' => $currentViewMonth->translatedFormat('F'),

// Configurazione locale
'locale' => app()->getLocale(),
'timezone' => config('app.timezone'),
```

## Performance e Ottimizzazioni

### Caching Intelligente

```php
public function getEnabledDates(): Collection
{
    return cache()->remember(
        \"enabled_dates_{$this->getId()}_{$this->displayDate->format('Y-m')}\",
        now()->addMinutes(15),
        fn() => $this->calculateEnabledDates()
    );
}
```

### Lazy Loading

```php
// Le date vengono calcolate solo quando necessario
protected $enabledDates = null;

public function enabledDates(array|Closure $dates): static
{
    $this->enabledDates = $dates; // Non eseguito immediatamente
    return $this;
}
```

### Debouncing Navigation

```javascript
// Evita chiamate eccessive durante navigazione rapida
navigateToMonth: debounce(function(direction) {
    // Logica di navigazione
}, 250)
```

## Testing e Quality Assurance

### Unit Tests

```php
<?php

declare(strict_types=1);

namespace Modules\\UI\\Tests\\Unit\\Components;

use Tests\\TestCase;
use Modules\\UI\\Filament\\Forms\\Components\\InlineDatePicker;

class InlineDatePickerTest extends TestCase
{
    /** @test */
    public function it_can_set_enabled_dates(): void
    {
        $picker = InlineDatePicker::make('test')
            ->enabledDates(['2025-06-05', '2025-06-21']);
            
        $this->assertTrue($picker->isDateEnabled('2025-06-05'));
        $this->assertFalse($picker->isDateEnabled('2025-06-10'));
    }
    
    /** @test */
    public function it_can_navigate_between_months(): void
    {
        $picker = InlineDatePicker::make('test');
        $initialMonth = $picker->getCurrentViewMonth();
        
        $picker->setCurrentViewMonth('2025-07');
        
        $this->assertEquals('2025-07', $picker->getCurrentViewMonth()->format('Y-m'));
    }
}
```

### Integration Tests

```php
/** @test */
public function it_integrates_with_livewire_forms(): void
{
    $component = Livewire::test(FormWithDatePicker::class)
        ->set('data.appointment_date', '2025-06-05')
        ->assertHasNoErrors()
        ->assertSee('2025-06-05');
}
```

## Troubleshooting e Debug

### Debug Mode

```php
@if(config('app.debug'))
    <div class=\"mt-4 p-3 bg-gray-100 dark:bg-gray-800 rounded text-xs\">
        <div class=\"font-semibold text-gray-700 dark:text-gray-300\">Debug Info:</div>
        <div class=\"text-gray-600 dark:text-gray-400\">
            Selected: <span x-text=\"selectedDate\"></span><br>
            Enabled Dates: <span x-text=\"enabledDates.length\"></span><br>
            Current Month: <span x-text=\"currentMonth\"></span><br>
            Compact Mode: {{ $compactMode ? 'true' : 'false' }}<br>
            Show Navigation: {{ $showNavigation ? 'true' : 'false' }}
        </div>
    </div>
@endif
```

### Logging Avanzato

```php
public function setCurrentViewMonth(string $monthString): void
{
    try {
        $parsedMonth = Carbon::createFromFormat('Y-m', $monthString)->startOfMonth();
        $this->displayDate = $parsedMonth;
        
    } catch (\\Throwable $e) {
        // Log per debugging temporale
        if (config('app.debug')) {
            logger()->warning('InlineDatePicker: Invalid month format', [
                'input' => $monthString,
                'error' => $e->getMessage(),
                'component' => static::class,
                'user_id' => auth()->id(),
                'timestamp' => now()->toISOString(),
            ]);
        }
        
        $this->displayDate = Carbon::now()->startOfMonth();
    }
}
```

## Roadmap e Sviluppi Futuri

### Versione 2.0 - Quantum Calendar
- **Selezione Multi-Data**: Date multiple simultanee
- **Range Selection**: Selezione intervalli temporali
- **Time Integration**: Integrazione con selettori orario
- **Recurring Patterns**: Pattern ricorrenti avanzati

### Versione 3.0 - AI-Powered Temporal Intelligence
- **Smart Suggestions**: Suggerimenti AI per date ottimali
- **Pattern Recognition**: Riconoscimento pattern utente
- **Predictive Availability**: Previsione disponibilità

### Versione 4.0 - Universal Temporal Interface
- **Multiple Calendars**: Supporto calendari diversi (Gregoriano, Lunare, etc.)
- **Timezone Handling**: Gestione fusi orari avanzata
- **External Sync**: Sincronizzazione con Google Calendar, Outlook

## Best Practice e Convenzioni

### 1. **Naming Semantic**
- Date proprietà: `appointment_date`, `deadline_date`, `birth_date`
- Evitare nomi generici: `date`, `day`, `time`

### 2. **Validation Logic**
```php
// Sempre validare date abilitate lato server
public function rules(): array
{
    return [
        'appointment_date' => [
            'required',
            'date',
            function ($attribute, $value, $fail) {
                if (!$this->isDateEnabled($value)) {
                    $fail('La data selezionata non è disponibile.');
                }
            },
        ],
    ];
}
```

### 3. **Error Handling**
```php
// Gestione graceful degli errori
try {
    $enabledDates = $this->getEnabledDates();
} catch (\\Throwable $e) {
    // Fallback a tutte le date abilitate
    $enabledDates = collect();
    
    report($e); // Log per monitoring
}
```

### 4. **Security Considerations**
```php
// Autorizzazione per date specifiche
public function getEnabledDates(): Collection
{
    return collect($this->baseDates)
        ->filter(function ($date) {
            // Controllo permessi per ogni data
            return auth()->user()->canAccessDate($date);
        });
}
```

## Integrazione Ecosistema Laraxot

### Service Provider Registration

```php
// In ModuleServiceProvider
public function boot(): void
{
    // Registrazione componente globale
    Blade::component('inline-date-picker', InlineDatePicker::class);
    
    // Livewire component
    Livewire::component('ui::inline-date-picker', InlineDatePicker::class);
}
```

### Filament Plugin Integration

```php
// In FilamentServiceProvider
public function register(): void
{
    FilamentAsset::register([
        Css::make('inline-date-picker', __DIR__.'/../resources/css/inline-date-picker.css'),
        Js::make('inline-date-picker', __DIR__.'/../resources/js/inline-date-picker.js'),
    ], 'ui');
}
```

---

**Ultimo aggiornamento**: Dicembre 2024  
**Versione**: 2.0 con Navigazione Temporale Avanzata  
**Compatibilità**: Laraxot SaluteOra, Filament 3.x, Alpine.js 3.x  
**Filosofia**: Fenomenologia Quantistica applicata al Design Temporale 