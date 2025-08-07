# Sistema di Prenotazione con FullCalendar

## Panoramica

Il sistema di prenotazione implementa un calendario interattivo utilizzando FullCalendar, una libreria JavaScript ampiamente utilizzata e supportata per la gestione di eventi e appuntamenti. La scelta di FullCalendar è stata fatta considerando:

- Standard de facto per i calendari web
- Ampia comunità e supporto
- Funzionalità complete per la gestione degli eventi
- Personalizzazione avanzata
- Performance ottimizzate
- Supporto per dispositivi mobili

## Architettura

### Componenti Principali

1. **FetchEventsAction**
   - Gestisce il recupero degli eventi dal database
   - Formatta gli eventi per FullCalendar
   - Implementa la logica di business per la visualizzazione

2. **Calendar Component**
   - Implementa l'interfaccia utente del calendario
   - Gestisce le interazioni utente
   - Visualizza gli slot disponibili

3. **Booking System**
   - Gestisce la logica di prenotazione
   - Verifica la disponibilità degli slot
   - Conferma le prenotazioni

## Flusso di Prenotazione

1. **Selezione Studio**
   - L'utente seleziona lo studio dentistico
   - Il sistema carica gli orari e le disponibilità dello studio

2. **Visualizzazione Calendario**
   - Il calendario mostra i giorni disponibili
   - I giorni non disponibili sono disabilitati
   - Gli slot già prenotati sono evidenziati

3. **Selezione Data e Ora**
   - L'utente clicca su un giorno disponibile
   - Appaiono gli slot orari disponibili
   - L'utente seleziona lo slot desiderato

4. **Conferma Prenotazione**
   - L'utente conferma la prenotazione
   - Il sistema verifica la disponibilità
   - La prenotazione viene registrata

## Implementazione FullCalendar

### Configurazione Base

```javascript
const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'it',
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    selectable: true,
    selectMirror: true,
    dayMaxEvents: true,
    events: '/api/events',
    select: function(info) {
        // Gestione selezione data
    },
    eventClick: function(info) {
        // Gestione click su evento
    }
});
```

### Personalizzazione Eventi

```php
private function transformAppointment(Appointment $appointment): array
{
    return [
        'id' => $appointment->id,
        'title' => $this->formatEventTitle($appointment),
        'start' => $appointment->start_time,
        'end' => $appointment->end_time,
        'backgroundColor' => $this->getEventColor($appointment),
        'borderColor' => $this->getEventColor($appointment),
        'textColor' => $this->getContrastColor($color),
        'extendedProps' => [
            'type' => $appointment->type,
            'status' => $appointment->status,
            'doctor_name' => $appointment->doctor->full_name,
            'studio_name' => $appointment->studio->name
        ]
    ];
}
```

## Gestione degli Slot

### Disponibilità

- Gli slot disponibili sono calcolati in base a:
  - Orari di apertura dello studio
  - Appuntamenti già prenotati
  - Disponibilità dei dottori
  - Tipi di servizi offerti

### Validazione

- Verifica della disponibilità in tempo reale
- Controllo dei conflitti
- Validazione delle regole di prenotazione

## Sicurezza

- Autenticazione richiesta per le prenotazioni
- Validazione lato server
- Protezione contro prenotazioni multiple
- Rate limiting per le richieste API

## Performance

- Caricamento lazy degli eventi
- Caching delle disponibilità
- Ottimizzazione delle query
- Limitazione del numero di eventi caricati

## Manutenzione

### Best Practices

1. **Aggiornamenti**
   - Mantenere FullCalendar aggiornato
   - Testare le nuove versioni in ambiente di sviluppo
   - Documentare le modifiche alla configurazione

2. **Debugging**
   - Utilizzare i tool di sviluppo di FullCalendar
   - Monitorare le performance
   - Logging appropriato

3. **Backup**
   - Backup regolare delle prenotazioni
   - Piano di recovery in caso di errori

## Conclusioni

L'utilizzo di FullCalendar offre un'ottima base per il sistema di prenotazione, fornendo:

- Interfaccia utente professionale
- Funzionalità complete
- Supporto a lungo termine
- Facilità di manutenzione
- Scalabilità

La scelta di utilizzare FullCalendar invece di una soluzione custom è giustificata dalla sua maturità, supporto e funzionalità complete, che permettono di concentrarsi sulla logica di business specifica invece che sull'implementazione delle funzionalità base del calendario. 

## Implementazione FullCalendar in Filament

### Configurazione del Widget

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\Appointment;

class CalendarWidget extends FullCalendarWidget
{
    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'dayGridWeek,dayGridDay',
                'center' => 'title',
                'right' => 'prev,next today',
            ],
            'selectable' => true,
            'selectMirror' => true,
            'dayMaxEvents' => true,
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Appointment::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(fn (Appointment $appointment) => [
                'id' => $appointment->id,
                'title' => $appointment->title,
                'start' => $appointment->starts_at,
                'end' => $appointment->ends_at,
                'backgroundColor' => $this->getEventColor($appointment),
                'borderColor' => $this->getEventColor($appointment),
            ])
            ->toArray();
    }

    protected function getEventColor(Appointment $appointment): string
    {
        return match($appointment->status) {
            'available' => '#10B981', // verde
            'booked' => '#EF4444',    // rosso
            default => '#6B7280',     // grigio
        };
    }
}
```

### Gestione della Selezione Data

Per mostrare la lista degli orari disponibili invece del modal predefinito, dobbiamo sovrascrivere il comportamento di selezione:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;

class CalendarWidget extends FullCalendarWidget
{
    protected function getSelectAction(): Action
    {
        return Action::make('select')
            ->label('Seleziona Orario')
            ->form([
                Grid::make()
                    ->schema([
                        Select::make('time_slot')
                            ->label('Orari Disponibili')
                            ->options(function (array $arguments) {
                                return $this->getAvailableTimeSlots($arguments['start']);
                            })
                            ->required()
                            ->searchable()
                    ])
            ])
            ->action(function (array $data, array $arguments) {
                $this->handleTimeSlotSelection($data['time_slot'], $arguments['start']);
            });
    }

    protected function getAvailableTimeSlots(string $date): array
    {
        // Recupera gli orari disponibili per la data selezionata
        $availableSlots = $this->getAvailableSlotsForDate($date);
        
        return collect($availableSlots)
            ->mapWithKeys(fn ($slot) => [
                $slot->id => $slot->formatted_time
            ])
            ->toArray();
    }

    protected function handleTimeSlotSelection(string $timeSlotId, string $date): void
    {
        // Gestisce la selezione dello slot orario
        $this->bookAppointment($timeSlotId, $date);
        
        // Notifica l'utente del successo
        $this->notify('success', 'Appuntamento prenotato con successo!');
        
        // Ricarica il calendario
        $this->refreshCalendar();
    }
}
```

### Personalizzazione della Vista

Per personalizzare ulteriormente la visualizzazione degli slot disponibili, possiamo utilizzare i render hooks di FullCalendar:

```php
public function eventDidMount(): string
{
    return <<<JS
        function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
            // Aggiunge tooltip con informazioni aggiuntive
            el.setAttribute("x-tooltip", "tooltip");
            el.setAttribute("x-data", "{ tooltip: '"+event.title+"' }");
            
            // Personalizza lo stile in base allo stato
            if (event.extendedProps.status === 'available') {
                el.classList.add('cursor-pointer');
                el.classList.add('hover:bg-green-100');
            }
        }
    JS;
}
```

### Gestione degli Slot Disponibili

```php
protected function getAvailableSlotsForDate(string $date): Collection
{
    // Recupera gli orari di apertura dello studio
    $studioHours = $this->getStudioHours();
    
    // Recupera gli appuntamenti già prenotati
    $bookedSlots = $this->getBookedSlots($date);
    
    // Genera tutti gli slot possibili
    $allSlots = $this->generateTimeSlots($studioHours);
    
    // Filtra gli slot disponibili
    return $allSlots->filter(function ($slot) use ($bookedSlots) {
        return !$bookedSlots->contains('time', $slot->time);
    });
}

protected function generateTimeSlots(array $studioHours): Collection
{
    $slots = collect();
    
    foreach ($studioHours as $hour) {
        $start = Carbon::parse($hour['start']);
        $end = Carbon::parse($hour['end']);
        
        while ($start->copy()->addMinutes(30)->lte($end)) {
            $slots->push((object)[
                'id' => $start->format('H:i'),
                'time' => $start->format('H:i'),
                'formatted_time' => $start->format('H:i')
            ]);
            
            $start->addMinutes(30);
        }
    }
    
    return $slots;
}
```

### Best Practices per la Gestione degli Slot

1. **Validazione**
   - Verifica sempre la disponibilità in tempo reale
   - Implementa controlli di concorrenza per evitare doppie prenotazioni
   - Valida gli slot rispetto alle regole di business

2. **Performance**
   - Implementa caching per gli slot disponibili
   - Limita il numero di slot caricati per periodo
   - Ottimizza le query al database

3. **UX**
   - Fornisci feedback immediato all'utente
   - Mostra chiaramente gli slot disponibili/non disponibili
   - Implementa tooltip informativi
   - Permetti la ricerca degli slot

4. **Sicurezza**
   - Verifica i permessi dell'utente
   - Valida tutti gli input
   - Implementa rate limiting
   - Proteggi contro le prenotazioni multiple
