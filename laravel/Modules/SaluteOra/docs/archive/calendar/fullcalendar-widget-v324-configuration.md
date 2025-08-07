# Configurazione FullCalendarWidget per v3.2.4

## Panoramica

Questo documento descrive la corretta implementazione del FullCalendarWidget utilizzando la versione 3.2.4 del pacchetto `saade/filament-fullcalendar` nel contesto del progetto SaluteOra. Segue le linee guida del progetto per garantire una corretta implementazione e manutenibilità del codice.

## Implementazione Corretta

### Inizializzazione del Widget

Per la versione 3.2.4, il widget deve essere configurato con i metodi di costruzione fluent e **non** con il metodo `config()` che causava errori:

```php
protected function calendarWidget(): \Filament\Widgets\WidgetConfiguration
{
    $doctor = $this->getCurrentDoctor();
    $studio = Filament::getTenant();

    return FullCalendarWidget::make()
        ->events(function (array $fetchInfo) use ($doctor, $studio) {
            // Implementazione eventi
        })
        ->createAction(
            // Implementazione createAction
        )
        ->editAction(
            // Implementazione editAction
        )
        ->deleteAction(
            // Implementazione deleteAction
        )
        ->headerToolbar([
            'start' => 'prev,next today',
            'center' => 'title',
            'end' => 'dayGridMonth,timeGridWeek,timeGridDay',
        ])
        ->initialView('timeGridWeek')
        ->selectable(true)
        ->editable(true)
        ->dayMaxEvents(true)
        ->contentHeight('auto')
        ->slotMinTime('07:00:00')
        ->slotMaxTime('20:00:00')
        ->slotDuration('00:15:00')
        ->locale(app()->getLocale())
        ->firstDay(1) // Lunedì
        ->businessHours([
            'startTime' => '08:00',
            'endTime' => '19:00',
            'daysOfWeek' => [1, 2, 3, 4, 5], // Lunedì a Venerdì
        ]);
}
```

### Eventi e Azioni

```php
// Implementazione corretta per il metodo events()
->events(function (array $fetchInfo) use ($doctor, $studio) {
    // Preparare le date
    $start = Carbon::parse($fetchInfo['start']);
    $end = Carbon::parse($fetchInfo['end']);

    // Query per gli appuntamenti
    return Appointment::query()
        ->where('doctor_id', $doctor->id)
        ->where('studio_id', $studio->id)
        ->whereBetween('start_time', [$start, $end])
        ->get()
        ->map(function (Appointment $appointment) {
            // Implementazione della mappatura
        })->toArray();
})
```

### createAction

```php
->createAction(
    CreateAction::make()
        ->mountUsing(function (Form $form) use ($doctor, $studio) {
            $form->fill([
                'doctor_id' => $doctor->id,
                'studio_id' => $studio->id,
                // Altri valori predefiniti
            ]);
        })
        ->action(function (array $data): void {
            // Logica di creazione
        })
        ->form([
            // Definizione dei campi del form
        ])
)
```

### editAction

```php
->editAction(
    EditAction::make()
        ->mountUsing(function (Appointment $appointment, Form $form): void {
            $form->fill([
                // Dati dell'appuntamento
            ]);
        })
        ->action(function (Appointment $appointment, array $data): void {
            // Logica di aggiornamento
        })
        ->form([
            // Definizione dei campi del form
        ])
)
```

### deleteAction

```php
->deleteAction(
    DeleteAction::make()
        ->action(function (Appointment $appointment): void {
            // Logica di eliminazione
        })
)
```

## Anti-Pattern da Evitare

### ❌ Configurazione tramite config()

```php
// ERRATO: Non utilizzare il metodo config() in questa versione
return FullCalendarWidget::make()
    ->config([
        'headerToolbar' => [...],
        'initialView' => 'timeGridWeek',
        // Altre configurazioni
    ])
```

### ❌ Doppia definizione di events()

```php
// ERRATO: Non definire events() due volte 
return FullCalendarWidget::make()
    ->events(function (array $fetchInfo) {
        // Prima definizione
    })
    ->config([
        // Configurazione
    ])
    ->events(function (array $fetchInfo) {
        // Seconda definizione - causerà errori
    })
```

## Integrazione con Single Table Inheritance

Quando si implementa il FullCalendarWidget con il pattern STI per i dottori, seguire sempre questi principi:

1. Ottenere il dottore corrente direttamente dall'autenticazione:

```php
protected function getCurrentDoctor()
{
    // L'utente corrente è già un dottore con type='doctor' nella tabella users
    return Filament::auth()->user();
}
```

2. Filtrare gli appuntamenti utilizzando l'ID del dottore direttamente:

```php
->where('doctor_id', $doctor->id)
```

## Risorse e Dipendenze

- Versione pacchetto: `saade/filament-fullcalendar:^3.2.4`
- Documentazione ufficiale: [Filament FullCalendar](https://github.com/saade/filament-fullcalendar)
- Issue di riferimento: #420 "Errore nella configurazione FullCalendarWidget"
