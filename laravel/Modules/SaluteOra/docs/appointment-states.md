# Stati degli Appuntamenti - SaluteOra

## Panoramica

Il sistema di gestione degli stati degli appuntamenti utilizza il pattern State Machine di Spatie per gestire il ciclo di vita degli appuntamenti medici.

## Stati Implementati

### 1. Pending (In attesa)
- **Stato di default** per nuovi appuntamenti
- Il paziente ha prenotato ma deve ancora confermare
- **Transizioni possibili**: Confirmed, Cancelled
- **Colore**: gray
- **Icona**: heroicon-o-question-mark-circle

### 2. Confirmed (Confermato)
- Paziente ha confermato la richiesta di appuntamento
- **Transizioni possibili**: Scheduled, Cancelled, Rescheduled
- **Colore**: success
- **Icona**: heroicon-o-check-circle

### 3. Scheduled (Programmato)
- Appuntamento confermato e inserito nel calendario
- **Transizioni possibili**: InProgress, Cancelled, NoShow, Rescheduled
- **Colore**: info
- **Icona**: heroicon-o-calendar

### 4. InProgress (In corso)
- Visita medica attualmente in corso
- **Transizioni possibili**: Completed, Cancelled
- **Colore**: info (aggiornato da warning)
- **Icona**: heroicon-o-play-circle (aggiornato)

### 5. Completed (Completato)
- Appuntamento completato con successo
- **Stato finale** - nessuna transizione
- **Colore**: success
- **Icona**: heroicon-o-check-badge

### 6. Cancelled (Annullato)
- Appuntamento annullato da una delle parti
- **Stato finale** - nessuna transizione
- **Colore**: danger
- **Icona**: heroicon-o-x-circle

### 7. Rejected (Respinto)
- Appuntamento respinto dal personale medico
- **Stato finale** - nessuna transizione
- **Colore**: danger
- **Icona**: heroicon-o-x-mark (aggiornato)
- **Label**: "Respinto" (aggiornato da "Rifiutato")

### 8. NoShow (Assente)
- Paziente non si è presentato senza preavviso
- **Stato finale** - nessuna transizione
- **Colore**: warning (aggiornato da danger)
- **Icona**: heroicon-o-user-minus (aggiornato)

### 9. Rescheduled (Riprogrammato)
- Appuntamento spostato a nuova data/ora
- **Transizioni possibili**: Confirmed
- **Colore**: info
- **Icona**: heroicon-o-arrow-path

## Flusso degli Stati

```
Pending → Confirmed → Scheduled → InProgress → Completed
   ↓          ↓          ↓
Cancelled   Cancelled   NoShow
             ↓          ↓
          Rescheduled   Cancelled
             ↓
          Confirmed
```

## Correzioni Implementate

### Rimossi Stati Non Pertinenti
- ❌ **IntegrationRequested**: Non applicabile agli appuntamenti
- ❌ **IntegrationCompleted**: Non applicabile agli appuntamenti

### Miglioramenti Visuali
- 🎨 **InProgress**: Icona cambiata da `clock` a `play-circle`
- 🎨 **Rejected**: Icona cambiata da `no-symbol` a `x-mark`
- 🎨 **NoShow**: Icona cambiata da `exclamation-circle` a `user-minus`
- 🎨 **NoShow**: Colore cambiato da `danger` a `warning`

### Miglioramenti Traduzioni
- 📝 **Rejected**: Label migliorata da "Rifiutato" a "Respinto"
- 📝 **InProgress**: Label ottimizzata

## Architettura Tecnica

### Classe Base
```php
abstract class AppointmentState extends State
{
    abstract public function label(): string;
    abstract public function color(): string;
    abstract public function icon(): string;
}
```

### Pattern BaseTransition
Il modulo implementa un pattern **BaseTransition** che automatizza:

```php
class BaseTransition extends Transition
{
    public function __construct(public Appointment $appointment, public ?string $message='') {}
    
    public function handle(): Appointment
    {
        $this->sendNotification();
        // Auto-discovery del nuovo stato dal nome della classe
        $class = static::class;
        $newStateClass = Str::of($class)->afterLast('To')->prepend('Modules\\SaluteOra\\States\\Appointment\\\\')->toString();
        
        $this->appointment->state = new $newStateClass($this->appointment);
        $this->appointment->save();
        
        return $this->appointment;
    }
}
```

### Transizioni Implementate

#### Da Pending
- `PendingToConfirmed`
- `PendingToCancelled`

#### Da Confirmed
- `ConfirmedToScheduled`
- `ConfirmedToCancelled`
- `ConfirmedToRescheduled`

#### Da Scheduled
- `ScheduledToInProgress`
- `ScheduledToCancelled`
- `ScheduledToNoShow`
- `ScheduledToRescheduled`

#### Da InProgress
- `InProgressToCompleted`

#### Da Rescheduled
- `RescheduledToConfirmed`

## Utilizzo

### Configurazione States
```php
public static function config(): StateConfig
{
    return parent::config()
        ->default(Pending::class)
        
        // Pending transitions
        ->allowTransition(Pending::class, Confirmed::class, 
            Transitions\PendingToConfirmed::class)
        ->allowTransition(Pending::class, Cancelled::class, 
            Transitions\PendingToCancelled::class)
        
        // ... altre transizioni
}
```

### Ottenere Stati Disponibili
```php
$statuses = AppointmentState::getStatuses();
// Restituisce array con label localizzate automaticamente
```

### Transizioni
```php
// Esempio di transizione
$appointment->state->transitionTo(Confirmed::class);
```

## Best Practices

### Sviluppo
1. **Usare BaseTransition**: Per tutte le nuove transizioni
2. **Nome Classes Descrittivi**: `FromStateToToState`
3. **Label Localizzate**: Sempre in italiano comprensibile
4. **Icone Semantiche**: Che rappresentano chiaramente lo stato
5. **Colori Consistenti**: Seguire la palette definita

### Business Logic
1. **Stati Finali**: Completed, Cancelled, Rejected, NoShow
2. **Stati Attivi**: Pending, Confirmed, Scheduled, InProgress
3. **Stati Modificabili**: Rescheduled può tornare a Confirmed

### UX
1. **Feedback Visivo**: Colori e icone immediate
2. **Traduzioni Chiare**: Comprensibili per utenti finali
3. **Transizioni Logiche**: Flusso naturale del processo

## Troubleshooting

### Errori Comuni
- **Stato non riconosciuto**: Verificare registrazione in `config()`
- **Transizione non permessa**: Controllare `allowTransition()`
- **Labels mancanti**: Implementare metodo `label()` negli stati

### Debug
```php
// Verificare stato corrente
dd($appointment->state::class);

// Verificare transizioni disponibili
dd($appointment->state->transitionableStates());
```

## Collegamenti

### File Correlati
- `app/States/Appointment/AppointmentState.php`
- `app/States/Appointment/Transitions/BaseTransition.php`
- `app/Models/Appointment.php`

### Documentazione Correlata
- [Pattern BaseTransition](patterns/base-transition.md)
- [Widget Development](patterns/widget-development.md)
- [LangServiceProvider](langserviceprovider-labels.md)

*Ultimo aggiornamento: Gennaio 2025*
*Versione: 2.0 - Correzioni IntegrationStates* 