# Implementazione Corretta di FullCalendarWidget v3.2.4

Questo documento definisce le best practices e il corretto utilizzo del widget FullCalendar nella versione 3.2.4 all'interno del progetto SaluteOra.

## Regole Fondamentali

1. **Utilizzo del metodo `config()` e non `options()`**
2. **Utilizzo dell'API fluente in modo corretto**
3. **Implementazione consistente in tutte le pagine**
4. **Gestione eventi centralizzata**

## Implementazione in Pagine Filament

Quando si implementa FullCalendarWidget in una pagina Filament, utilizzare sempre questo pattern:

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Pages;

use Filament\Widgets\WidgetConfiguration;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\Xot\Filament\Pages\XotBasePage;

class CalendarPage extends XotBasePage
{
    protected function getHeaderWidgets(): array
    {
        return [
            $this->calendarWidget(),
        ];
    }

    protected function calendarWidget(): WidgetConfiguration
    {
        return FullCalendarWidget::make()
            ->config([
                // Configurazioni del calendario
                'headerToolbar' => [
                    'start' => 'prev,next today',
                    'center' => 'title',
                    'end' => 'dayGridMonth,timeGridWeek,timeGridDay',
                ],
                'initialView' => 'timeGridWeek',
                // Altre configurazioni...
            ])
            ->events(function (array $fetchInfo) {
                // Logica per recuperare gli eventi
                return [];
            })
            ->createEventUsing(function (array $data) {
                // Logica per creare un evento
                return $createdEvent;
            })
            ->updateEventUsing(function ($event, array $data) {
                // Logica per aggiornare un evento
                return $updatedEvent;
            })
            ->deleteEventUsing(function ($event) {
                // Logica per eliminare un evento
            });
    }
}
```

## Errori Comuni da Evitare

### 1. Uso di `options()` invece di `config()`

```php
// ERRATO
return FullCalendarWidget::make()
    ->options([
        // configurazioni...
    ]);

// CORRETTO
return FullCalendarWidget::make()
    ->config([
        // configurazioni...
    ]);
```

### 2. Estensione diretta della classe FullCalendarWidget

```php
// ERRATO
class CalendarWidget extends FullCalendarWidget
{
    protected function setUp(): void
    {
        // setup...
    }
}

// CORRETTO (se necessario estendere)
class CalendarWidget extends XotBaseFullCalendarWidget
{
    protected function setUp(): void
    {
        // setup...
    }
}
```

### 3. Utilizzo errato dell'API fluente in `getHeaderWidgets()`

```php
// ERRATO
protected function getHeaderWidgets(): array
{
    return [
        FullCalendarWidget::make()
            ->config([SomeWidgetClass::class]), // Errore: passare una classe a config()
    ];
}

// CORRETTO
protected function getHeaderWidgets(): array
{
    return [
        $this->calendarWidget(), // Riferimento a un metodo che restituisce la configurazione
    ];
}
```

## Esempio Completo di Implementazione

```php
protected function calendarWidget(): WidgetConfiguration
{
    // Ottenere il dottore corrente e lo studio
    $doctor = $this->getCurrentDoctor();
    $studio = Filament::getTenant();
    
    return FullCalendarWidget::make()
        ->config([
            'headerToolbar' => [
                'start' => 'prev,next today',
                'center' => 'title',
                'end' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
            'initialView' => 'timeGridWeek',
            'selectable' => true,
            'editable' => true,
            'dayMaxEvents' => true,
            'contentHeight' => 'auto',
            'slotMinTime' => '07:00:00',
            'slotMaxTime' => '20:00:00',
            'slotDuration' => '00:15:00',
            'locale' => app()->getLocale(),
            'firstDay' => 1, // Lunedì
            'businessHours' => [
                'startTime' => '08:00',
                'endTime' => '19:00',
                'daysOfWeek' => [1, 2, 3, 4, 5], // Lunedì a Venerdì
            ],
            'timezone' => config('app.timezone'),
        ])
        ->events(function (array $fetchInfo) use ($doctor, $studio) {
            // Logica di recupero eventi...
        })
        ->createEventUsing(function (array $data) use ($doctor, $studio) {
            // Logica di creazione eventi...
        })
        ->updateEventUsing(function ($event, array $data) {
            // Logica di aggiornamento eventi...
        })
        ->deleteEventUsing(function ($event) {
            // Logica di eliminazione eventi...
        });
}
```

## Riferimenti alla Documentazione Ufficiale

- [Documentazione FullCalendar](https://fullcalendar.io/docs)
- [Plugin Filament FullCalendar](https://github.com/saade/filament-fullcalendar)
- [Esempi di Implementazione](https://filamentphp.com/plugins/saade-fullcalendar)