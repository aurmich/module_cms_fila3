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

### Estensione Base
**IMPORTANTE**: Non estendere mai direttamente le classi Filament. Utilizzare sempre le classi base XotBase:

```php
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class MobileActivityWidget extends XotBaseWidget
{
    // Implementazione...
}
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

## Collegamenti Correlati
- [Struttura Filament](./structure.md)
- [Convenzioni di Vista](../views/conventions.md)
- [Convenzioni di Traduzione](../translations/conventions.md)
