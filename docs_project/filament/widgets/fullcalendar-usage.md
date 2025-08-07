# Saade FilamentFullCalendar Widget v3.2.4

## API corretta per configurare il widget FullCalendar

La configurazione di Saade Filament FullCalendar v3.2.4 **deve sempre utilizzare il metodo `config()`** e **mai** il metodo `options()`:

```php
// CORRETTO ✅
FullCalendarWidget::make()
    ->config([
        'headerToolbar' => [
            'start' => 'prev,next today',
            'center' => 'title',
            'end' => 'dayGridMonth,timeGridWeek,timeGridDay',
        ],
        // altre opzioni...
    ]);

// ERRATO ❌ - NON UTILIZZARE MAI!
FullCalendarWidget::make()
    ->options([
        // configurazioni
    ]);
```

## Implementazione corretta nel progetto SaluteOra

### Classe Widget dedicata (approccio raccomandato)

Il metodo raccomandato è creare una classe widget dedicata che estende `FullCalendarWidget`:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Illuminate\Support\Carbon;

class DoctorAvailabilityCalendarWidget extends FullCalendarWidget
{
    protected User $doctor;
    protected $studio;

    public function __construct(User $doctor, $studio)
    {
        parent::__construct();
        $this->doctor = $doctor;
        $this->studio = $studio;
    }

    /**
     * FullCalendar richiamerà questa funzione ogni volta che necessita di nuovi dati sugli eventi.
     * Questo viene attivato quando l'utente clicca prev/next o cambia vista nel calendario.
     */
    public function fetchEvents(array $fetchInfo): array
    {
        $start = Carbon::parse($fetchInfo['start']);
        $end = Carbon::parse($fetchInfo['end']);
        
        return Appointment::query()
            ->where('doctor_id', $this->doctor->id)
            ->where('studio_id', $this->studio->id)
            ->whereBetween('start_time', [$start, $end])
            ->get()
            ->map(function (Appointment $appointment) {
                // Mappatura degli appuntamenti in eventi del calendario
                // ...
            })
            ->toArray();
    }

    protected function getViewData(): array
    {
        return [
            'config' => $this->getConfig(),
            // Altri dati necessari
        ];
    }
}
```

### Utilizzo diretto in DoctorAvailabilityCalendar (approccio alternativo)

Se si utilizza direttamente nella Page:

```php
protected function calendarWidget(): \Filament\Widgets\WidgetConfiguration
{
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
            // Altre configurazioni...
        ])
        ->events(function (array $fetchInfo) use ($doctor, $studio) {
            // Logica per il recupero degli eventi
        })
        ->createEventUsing(function (array $data) {
            // Creazione eventi
        })
        ->updateEventUsing(function ($event, array $data) {
            // Aggiornamento eventi
        })
        ->deleteEventUsing(function ($event) {
            // Eliminazione eventi
        });
}
```

## Metodi di configurazione disponibili

| Metodo | Descrizione | Default | Documentazione |
|--------|-------------|---------|----------------|
| `config(array $config)` | Configurazione principale del calendario | `[]` | [Docs](https://fullcalendar.io/docs) |
| `schedulerLicenseKey(string $key)` | Chiave di licenza per FullCalendar Premium | `null` | [Docs](https://fullcalendar.io/docs/premium) |
| `selectable(bool $selectable)` | Consente di selezionare giorni/slot | `false` | [Docs](https://fullcalendar.io/docs/selectable) |
| `editable(bool $editable)` | Consente di trascinare/ridimensionare eventi | `false` | [Docs](https://fullcalendar.io/docs/editable) |
| `timezone(string $timezone)` | Fuso orario per le date | `config('app.timezone')` | [Docs](https://fullcalendar.io/docs/timeZone) |
| `locale(string $locale)` | Lingua per testi e date | `config('app.locale')` | [Docs](https://fullcalendar.io/docs/locale) |
| `plugins(array $plugins, bool $merge)` | Plugin da abilitare | `['dayGrid', 'timeGrid']` | [Docs](https://fullcalendar.io/docs/plugin-index) |

## Operazioni CRUD sugli eventi

### Eventi

```php
->events(function (array $fetchInfo) {
    // $fetchInfo contiene 'start' e 'end' come stringhe ISO 8601
    // Restituisce un array di eventi
    return [
        [
            'id' => 1,
            'title' => 'Appuntamento',
            'start' => '2025-06-01T10:00:00',
            'end' => '2025-06-01T11:00:00',
            'backgroundColor' => '#3490dc',
            'borderColor' => '#3490dc',
            'textColor' => '#ffffff',
            'extendedProps' => [
                // Dati personalizzati
            ],
        ],
    ];
})
```

### Creazione eventi

```php
->createEventUsing(function (array $data) {
    // $data contiene start, end, allDay
    // Crea un nuovo record nel database
    // Ritorna l'evento creato
})
```

### Aggiornamento eventi

```php
->updateEventUsing(function ($event, array $data) {
    // $event è l'oggetto evento
    // $data contiene start, end, allDay
    // Aggiorna il record nel database
    // Ritorna l'evento aggiornato
})
```

### Eliminazione eventi

```php
->deleteEventUsing(function ($event) {
    // $event è l'oggetto evento
    // Elimina il record dal database
})
```

## Import corretti

```php
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Filament\Widgets\WidgetConfiguration;
```

## Integrazione con modelli esistenti

Quando si integra con modelli esistenti, è importante mappare correttamente i campi:

```php
->events(function (array $fetchInfo) {
    return YourModel::query()
        // Filtri per date
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'start' => $item->start_date->toDateTimeString(),
                'end' => $item->end_date->toDateTimeString(),
                // Altri campi...
            ];
        })
        ->toArray();
})
```

## Risorse ufficiali

- [Plugin su Filament](https://filamentphp.com/plugins/saade-fullcalendar)
- [Repository GitHub](https://github.com/saade/filament-fullcalendar)
- [Documentazione FullCalendar](https://fullcalendar.io/docs)

## Errori comuni da evitare

1. **Mai utilizzare `options()` invece di `config()`** - causa errore `Call to undefined method Filament\Widgets\WidgetConfiguration::options()`
2. **Verifica il tipo di ritorno** - il metodo `calendarWidget()` deve restituire `\Filament\Widgets\WidgetConfiguration`
3. **Controlla gli import** - assicurati di importare `FullCalendarWidget` e `WidgetConfiguration`
4. **Non dimenticare il namespace completo** - utilizza sempre il namespace completo nelle importazioni
