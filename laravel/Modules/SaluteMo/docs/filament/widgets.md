# Widget in SaluteMo

## Struttura e Convenzioni

### Posizione dei Widget
Tutti i widget Filament devono essere collocati in:
```
Modules/SaluteMo/app/Filament/Widgets/
```

### Namespace Corretto
```php
namespace Modules\SaluteMo\Filament\Widgets;
```

### Estensione Base - REGOLA CRITICA
**CRITICO**: NON estendere MAI direttamente le classi Filament. Utilizzare SEMPRE le classi XotBase:

```php
// ✅ CORRETTO - SEMPRE USARE
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class ChartWidgetExample extends XotBaseChartWidget
{
    // CRITICO: getHeading() deve essere public
    public function getHeading(): ?string
    {
        return __('salutemo::widgets.widget_name.title');
    }
}
```

**REGOLA FONDAMENTALE**: 
- Se prima estendevi `\Filament\Widgets\ChartWidget`
- Ora estendi `\Modules\Xot\Filament\Widgets\XotBaseChartWidget`
- Preserva sempre la struttura e il nome della classe originale
- Aggiungi sempre il prefisso `XotBase`

### Esempi di Estensione Corretta
```php
// ChartWidget
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
class WidgetName extends XotBaseChartWidget

// Widget generico
use Modules\Xot\Filament\Widgets\XotBaseWidget;
class WidgetName extends XotBaseWidget

// StatsOverviewWidget
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;
class WidgetName extends XotBaseStatsOverviewWidget
```

## Convenzione Percorso delle Viste

### Struttura Corretta
Tutti i widget Filament devono seguire questo pattern per le viste:
```php
protected static string $view = 'salutemo::filament.widgets.nome-vista';
```

### Punti Chiave
1. Includere sempre `filament` nel percorso della vista
2. Le viste dei widget devono essere in `resources/views/filament/widgets/`
3. Usare kebab-case per i nomi dei file delle viste
4. Mai usare `widgets` senza il prefisso `filament`

### Esempio Corretto
```php
// Corretto
protected static string $view = 'salutemo::filament.widgets.mobile-activity';

// Errato
protected static string $view = 'salutemo::widgets.mobile-activity';
```

### Posizione File Vista
I file delle viste dei widget devono essere collocati in:
```
Modules/SaluteMo/resources/views/filament/widgets/
```

### Convenzione di Denominazione
- Convertire il nome della classe in kebab-case
- Rimuovere il suffisso 'Widget' se presente
- Esempio: `MobileActivityWidget` → `mobile-activity`

## ChartWidget - Regole Critiche

### Metodo getHeading() - PUBBLICO OBBLIGATORIO
**CRITICO**: Il metodo `getHeading()` nei ChartWidget deve essere `public`, non `protected`:

```php
// ✅ CORRETTO
public function getHeading(): ?string
{
    return __('salutemo::widgets.widget_name.title');
}

// ❌ ERRATO - Causa errore di access level
protected function getHeading(): ?string
{
    return __('salutemo::widgets.widget_name.title');
}
```

### Proprietà $isLazy - BOOL OBBLIGATORIO
**CRITICO**: La proprietà `$isLazy` deve essere `bool`, non `?bool`:

```php
// ✅ CORRETTO
protected static bool $isLazy = true;

// ❌ ERRATO - Causa errore di tipo
protected static ?bool $isLazy = true;
```

### Struttura Standard ChartWidget
```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Illuminate\Support\Facades\Cache;

class ExampleChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = null;
    protected static ?int $sort = 1;
    protected static bool $isLazy = true;  // CRITICO: bool, non ?bool
    protected static ?string $pollingInterval = '5m';

    // CRITICO: public, non protected
    public function getHeading(): ?string
    {
        return __('salutemo::widgets.example_chart.title');
    }

    protected function getData(): array
    {
        // Implementazione dati
    }

    protected function getType(): string
    {
        return 'line'; // o 'bar', 'doughnut', etc.
    }

    protected function getOptions(): array
    {
        // Configurazione grafico
    }

    protected function getHeight(): ?string
    {
        return '300px';
    }

    public static function canView(): bool
    {
        return true;
    }
}
```

## Traduzione nei Widget

### Schema dei File di Traduzione
I file di traduzione per i widget devono essere collocati in:
```
Modules/SaluteMo/lang/<locale>/widgets.php
```

### Struttura delle Chiavi di Traduzione
```php
return [
    'widget_name' => [
        'title' => 'Titolo Widget',
        'steps' => [
            'step_name' => 'Etichetta Step',
        ],
        'fields' => [
            'field_name' => 'Etichetta Campo',
        ],
        'messages' => [
            'message_key' => 'Testo messaggio',
        ],
    ],
];
```

### Utilizzo Corretto nei Widget
1. **MAI** usare `->label()` o `->placeholder()`
2. **MAI** usare funzioni `__()` o `trans()` direttamente nei componenti form
3. Definire tutte le etichette, placeholder e messaggi nel file di traduzione
4. Utilizzare la notazione a punti per referenziare le traduzioni nel codice del widget

### Esempio
```php
// Nel file di traduzione
'mobile_user_widget' => [
    'title' => 'Utenti Mobile',
    'fields' => [
        'device' => 'Dispositivo',
    ],
],

// Nel widget
TextInput::make('device')
    ->required()
    // NON usare ->label() perché gestito dal LangServiceProvider
```

## Widget per Calendario (FilamentFullCalendar)

### Estensione Base
Creare una classe widget dedicata che estende `FullCalendarWidget` ma rispetta le convenzioni del modulo:

```php
namespace Modules\SaluteMo\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Filament\Widgets\WidgetConfiguration;

class MobileAppointmentCalendarWidget extends XotBaseWidget
{
    // Implementazione...
    
    protected function calendarWidget(): \Filament\Widgets\WidgetConfiguration
    {
        return FullCalendarWidget::make()
            ->config([
                'headerToolbar' => [
                    'start' => 'prev,next today',
                    'center' => 'title',
                    'end' => 'dayGridMonth,timeGridWeek,timeGridDay',
                ],
                // Altre configurazioni...
            ])
            ->events(function (array $fetchInfo) {
                // Logica per il recupero degli eventi
            });
    }
}
```

**ATTENZIONE**: Mai utilizzare `options()` invece di `config()` con FilamentFullCalendar.

### Implementazione Calendar in SaluteMo

```php
namespace Modules\SaluteMo\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Filament\Widgets\WidgetConfiguration;

class MobileAppointmentWidget extends FullCalendarWidget
{
    public static function canView(): bool
    {
        return auth()->user()->can('view_mobile_appointments');
    }
    
    public function getViewData(): array
    {
        return [
            'appointments' => $this->getAppointments(),
        ];
    }
    
    public function fetchEvents(array $fetchInfo): array
    {
        // Implementazione per il recupero degli appuntamenti mobile
    }
}
```

## Checklist Prevenzione Errori

### Prima di Salvare un Widget
**CRITICO**: Verificare sempre questi punti per evitare errori di tipo e access level:

- [ ] `getHeading()` è `public`, non `protected`
- [ ] `$isLazy` è `bool`, non `?bool`
- [ ] `$sort` è `?int`, non `int`
- [ ] `$heading` è `?string`, non `string`
- [ ] `$pollingInterval` è `?string`, non `string`
- [ ] Tutti gli import sono corretti
- [ ] Namespace è corretto
- [ ] Estensione è `ChartWidget` per grafici
- [ ] Metodi `getData()`, `getType()`, `getOptions()` sono `protected`
- [ ] Metodo `canView()` è `public static`

### Errori Comuni da Evitare
```php
// ❌ ERRORE: Access level
protected function getHeading(): ?string

// ❌ ERRORE: Type mismatch
protected static ?bool $isLazy = true;

// ❌ ERRORE: Type mismatch
protected static int $sort = 1;

// ✅ CORRETTO
public function getHeading(): ?string
protected static bool $isLazy = true;
protected static ?int $sort = 1;
```

## Collegamenti Correlati
- [Struttura Filament](./structure.md)
- [Convenzioni di Vista](../views/conventions.md)
- [Convenzioni di Traduzione](../translations/conventions.md)
