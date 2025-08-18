# Azioni del Calendario Paziente

## FetchEventsAction

L'azione `FetchEventsAction` è responsabile del recupero degli eventi del calendario per un paziente specifico.

### Caratteristiche Principali

- **Caching**: Implementa caching degli eventi per 5 minuti per migliorare le performance
- **Paginazione**: Limita il numero di eventi a 100 per query
- **Eager Loading**: Carica relazioni (doctor, studio, type) in una singola query
- **Range Date**: Filtra gli eventi per intervallo di date
- **Formattazione**: Formatta titoli e tooltip in italiano
- **Colori**: Utilizza schema colori standardizzato per stati e tipi
- **Sicurezza**: Impedisce modifiche dirette da parte dei pazienti

### Utilizzo

```php
$action = new FetchEventsAction();
$events = $action->execute(
    patientId: 123,
    startDate: '2024-03-01',
    endDate: '2024-03-31'
);
```

### Struttura EventData

Gli eventi restituiti sono formattati secondo lo standard FullCalendar:

```php
EventData::make()
    ->id($appointment->id)
    ->title('Visita - Dr. Rossi')
    ->start('2024-03-15 09:00:00')
    ->end('2024-03-15 10:00:00')
    ->backgroundColor('#3498db')
    ->borderColor('#2ecc71')
    ->textColor('#ffffff')
    ->extendedProps([
        'doctor_name' => 'Dr. Rossi',
        'studio_name' => 'Studio Roma',
        'status' => 'scheduled',
        'type' => 'check_up',
        'tooltip' => 'Appuntamento Check-up con Dr. Rossi presso Studio Roma',
        'can_edit' => false,
    ]);
```

### Schema Colori

#### Stati Appuntamento
- Programmato: `#3498db` (Blu)
- Confermato: `#2ecc71` (Verde)
- Cancellato: `#e74c3c` (Rosso)
- In Corso: `#f1c40f` (Giallo)
- Completato: `#27ae60` (Verde Scuro)
- Non Presentato: `#c0392b` (Rosso Scuro)
- Riprogrammato: `#9b59b6` (Viola)
- In Attesa: `#95a5a6` (Grigio)

#### Tipi Appuntamento
I colori per i tipi di appuntamento sono configurabili tramite `config/fullcalendar.php`:

```php
'colors' => [
    'appointment_types' => [
        'check_up' => '#3498db',
        'cleaning' => '#2ecc71',
        'treatment' => '#e74c3c',
        // ...
    ],
],
```

### Performance

- Utilizza caching con chiave basata su ID paziente e range date
- Implementa eager loading per ridurre query N+1
- Limita numero massimo di eventi per query
- Filtra per range date per ridurre dataset

### Sicurezza

- Verifica ID paziente per accesso eventi
- Non espone dati sensibili in extendedProps
- Disabilita modifica eventi per pazienti
- Utilizza enum per stati e tipi validi

### Collegamenti

- [Documentazione FullCalendar](fullcalendar_implementation_guide.md)
- [Best Practices Calendar](../fullcalendar-best-practices.md)
- [Configurazione Calendar](../fullcalendar_configuration.md)
- [Widget Calendar](../fullcalendar_widget_implementation.mdc) 
