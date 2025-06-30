# Stati degli Appuntamenti - Sistema di Gestione

Il sistema di gestione degli stati degli appuntamenti è implementato utilizzando il pattern **State Machine** con la libreria `spatie/laravel-model-states`.

## Panoramica

Il sistema segue il pattern **BaseTransition** già utilizzato con successo per gli stati degli utenti, garantendo:

- ✅ **Notifiche automatiche** a paziente e dottore per ogni cambio di stato
- ✅ **Tracciabilità completa** di tutte le transizioni  
- ✅ **Codice DRY** - le transizioni sono completamente automatiche
- ✅ **Type Safety** con PHPStan Level 9+
- ✅ **Modularità** - ogni stato è una classe separata

## Stati Disponibili

### 1. **Pending** (In attesa di conferma)
- **Stato iniziale** per tutti i nuovi appuntamenti
- **Colore**: Warning (arancione)
- **Icona**: `heroicon-o-clock`
- **Descrizione**: Appuntamento richiesto ma non ancora confermato

### 2. **Confirmed** (Confermato)  
- **Stato**: Appuntamento confermato da entrambe le parti
- **Colore**: Success (verde)
- **Icona**: `heroicon-o-check-circle`
- **Descrizione**: Pronto per essere eseguito alla data/ora programmata

### 3. **InProgress** (In corso)
- **Stato**: Appuntamento attualmente in esecuzione
- **Colore**: Info (blu)
- **Icona**: `heroicon-o-play-circle`
- **Descrizione**: Il paziente è presente e la visita è in corso

### 4. **Completed** (Completato)
- **Stato finale**: Appuntamento completato con successo
- **Colore**: Success (verde)
- **Icona**: `heroicon-o-check-badge`
- **Descrizione**: Servizio medico erogato completamente

### 5. **Cancelled** (Cancellato)
- **Stato finale**: Appuntamento cancellato
- **Colore**: Danger (rosso)
- **Icona**: `heroicon-o-x-circle`
- **Descrizione**: Cancellato da paziente, dottore o amministrazione

### 6. **NoShow** (Paziente assente)
- **Stato finale**: Il paziente non si è presentato
- **Colore**: Warning (arancione)
- **Icona**: `heroicon-o-user-minus`
- **Descrizione**: Paziente assente senza preavviso

### 7. **Rescheduled** (Riprogrammato)
- **Stato temporaneo**: In attesa di nuova programmazione
- **Colore**: Info (blu)
- **Icona**: `heroicon-o-arrow-path`
- **Descrizione**: Richiesta riprogrammazione a nuova data/ora

## Transizioni Consentite

### Diagramma del Flusso

```
Pending → Confirmed
       → Cancelled

Confirmed → InProgress
         → NoShow  
         → Cancelled
         → Rescheduled

InProgress → Completed

Rescheduled → Confirmed
```

### Transizioni Implementate

1. **PendingToConfirmed**: Conferma appuntamento in attesa
2. **PendingToCancelled**: Cancellazione immediata prima della conferma
3. **ConfirmedToInProgress**: Inizio della visita 
4. **ConfirmedToNoShow**: Paziente non presente all'orario
5. **ConfirmedToCancelled**: Cancellazione di appuntamento confermato
6. **ConfirmedToRescheduled**: Richiesta di riprogrammazione
7. **InProgressToCompleted**: Completamento della visita
8. **RescheduledToConfirmed**: Riconferma dopo riprogrammazione

## Pattern BaseTransition

Tutte le transizioni ereditano da `BaseTransition` che implementa automaticamente:

### Funzionalità Automatiche

```php
// Automatico in ogni transizione:
1. Cambio di stato sul modello
2. Salvataggio nel database  
3. Invio notifiche email a paziente e dottore
4. Logging e tracciabilità
5. Generazione slug notifica
```

### Uso delle Transizioni

```php
// Esempio: Conferma un appuntamento
$appointment = Appointment::find(1);

$transition = new PendingToConfirmed($appointment, 'Confermato dal dottore');
$appointment = $transition->handle();

// ✅ Stato cambiato automaticamente
// ✅ Email inviate automaticamente  
// ✅ Log tracciabilità creato
```

### Dati delle Notifiche

Le notifiche includono automaticamente:

- `message`: Messaggio personalizzato della transizione
- `appointment_date`: Data appuntamento (formato dd/mm/yyyy) 
- `appointment_time`: Ora appuntamento (formato HH:mm)
- `doctor_name`: Nome completo del dottore
- `patient_name`: Nome completo del paziente  
- `studio_name`: Nome dello studio medico

## Implementazione nel Modello

### Configurazione negli States

```php
// Nel modello Appointment
use Spatie\ModelStates\HasStates;

class Appointment extends Model 
{
    use HasStates;
    
    protected $casts = [
        'state' => AppointmentState::class,
    ];
}
```

### Configurazione AppointmentState

La classe base `AppointmentState` definisce:

- Tutti gli stati consentiti
- Tutte le transizioni possibili  
- Stato predefinito: `Pending`
- Metodi astratti per label, colore, icona

## Best Practices

### 1. **Validazione Pre-Transizione**
```php
// Sempre verificare se la transizione è possibile
if ($appointment->state->canTransitionTo(Confirmed::class)) {
    $transition = new PendingToConfirmed($appointment, $message);
    $transition->handle();
}
```

### 2. **Messaggi Personalizzati**
```php
// Sempre includere un messaggio significativo
$transition = new ConfirmedToCancelled(
    $appointment, 
    'Cancellato per emergenza medica'
);
```

### 3. **Gestione Errori**
```php
try {
    $transition = new PendingToConfirmed($appointment, $message);
    $appointment = $transition->handle();
} catch (Exception $e) {
    // Log dell'errore e gestione fallback
    Log::error('Errore transizione appuntamento', [
        'appointment_id' => $appointment->id,
        'transition' => PendingToConfirmed::class,
        'error' => $e->getMessage()
    ]);
}
```

## Testing

### Test delle Transizioni

```php
/** @test */
public function it_can_confirm_pending_appointment()
{
    $appointment = Appointment::factory()->create([
        'state' => new Pending($appointment)
    ]);
    
    $transition = new PendingToConfirmed($appointment, 'Test confirmation');
    $result = $transition->handle();
    
    $this->assertInstanceOf(Confirmed::class, $result->state);
    $this->assertEquals('Test confirmation', $transition->message);
}
```

## Personalizzazione

### Override del Comportamento

Per personalizzare una specifica transizione:

```php
class ConfirmedToInProgress extends BaseTransition 
{
    public function handle(): Appointment
    {
        // Logica personalizzata prima della transizione
        $this->checkPatientPresence();
        
        // Chiama il comportamento base
        return parent::handle();
    }
    
    private function checkPatientPresence(): void
    {
        // Logica di verifica presenza paziente
    }
}
```

## Collegamenti

- [States Documentation](states.md)
- [Appointment Model](../Appointment.md)
- [Notification System](../../../Notify/docs/README.md)
- [Spatie Model States Docs](https://spatie.be/docs/laravel-model-states)

---

**Ultima modifica**: Gennaio 2025  
**Versione**: 1.0  
**Autore**: Sistema di gestione SaluteOra 