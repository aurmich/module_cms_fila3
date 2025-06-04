# Pattern State in SaluteMo

## Struttura delle Classi

### Estensione Base
Ogni classe di transizione di stato deve estendere `Spatie\ModelStates\Transition`:

```php
use Spatie\ModelStates\Transition;
use Illuminate\Database\Eloquent\Model;

class PendingToConfirmed extends Transition
{
    // Implementazione...
}
```

### Firma del Costruttore
```php
public function __construct(Model $model, ?string $message = '')
{
    // Implementazione...
}
```

### Metodo Required
```php
public function handle(): Model
{
    // Logica di transizione dello stato
    // Deve sempre restituire il modello aggiornato
}
```

## Posizione dei File

### Struttura della Directory
```
app/States/{ModelName}/Transitions/
```

### Convenzione di Naming
```
{FromState}To{ToState}.php
```

### Namespace
```php
namespace Modules\SaluteMo\States\{ModelName}\Transitions;
```

## Regole di Implementazione

1. **Transizioni Atomiche**: Ogni transizione deve essere focalizzata su una singola responsabilità
2. **Type Hints**: Utilizzare type hints per tutti i parametri
3. **Parametro Message Opzionale**: Il parametro `message` deve essere opzionale con un valore di default vuoto
4. **Restituzione del Modello**: Il metodo `handle()` deve sempre restituire il modello aggiornato
5. **Documentazione**: Documentare transizioni complesse con PHPDoc

## Gestione degli Errori

### Best Practices
- Loggare tutti i fallimenti di transizione
- Fornire messaggi di errore significativi
- Utilizzare tipi di eccezione appropriati per diversi fallimenti

```php
public function handle(): Model
{
    try {
        // Logica di transizione
        
        return $this->model->fresh();
    } catch (Exception $e) {
        Log::error('Errore nella transizione da Pending a Confirmed', [
            'model_id' => $this->model->id,
            'error' => $e->getMessage()
        ]);
        
        throw new TransitionException('Impossibile confermare l\'appuntamento: ' . $e->getMessage());
    }
}
```

## Testing

### Approcci Consigliati
- Testare sia le transizioni riuscite che quelle fallite
- Verificare tutti gli effetti collaterali
- Testare con e senza parametri opzionali

```php
public function test_can_transition_from_pending_to_confirmed(): void
{
    $appointment = Appointment::factory()->create(['status' => AppointmentStatus::PENDING]);
    
    $appointment = $appointment->status->transition(AppointmentStatus::CONFIRMED);
    
    $this->assertEquals(AppointmentStatus::CONFIRMED, $appointment->status);
    // Verificare anche gli effetti collaterali...
}

public function test_cannot_transition_when_conditions_not_met(): void
{
    $this->expectException(TransitionException::class);
    
    $appointment = Appointment::factory()->create([
        'status' => AppointmentStatus::PENDING,
        'doctor_id' => null, // Condizione che impedisce la transizione
    ]);
    
    $appointment->status->transition(AppointmentStatus::CONFIRMED);
}
```

## Esempio Completo di Transizione di Stato

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\States\MobileAppointment\Transitions;

use Spatie\ModelStates\Transition;
use Illuminate\Database\Eloquent\Model;
use Modules\SaluteMo\Models\MobileAppointment;
use Modules\SaluteMo\States\MobileAppointment\AppointmentState;
use Modules\SaluteMo\States\MobileAppointment\States\Pending;
use Modules\SaluteMo\States\MobileAppointment\States\Confirmed;

class PendingToConfirmed extends Transition
{
    private MobileAppointment $appointment;

    public function __construct(Model $appointment, ?string $message = '')
    {
        parent::__construct($appointment);
        $this->appointment = $appointment;
    }

    public function handle(): Model
    {
        // Logica di business per la conferma
        $this->appointment->confirmed_at = now();
        $this->appointment->confirmation_message = $message ?: 'Appuntamento confermato';
        $this->appointment->save();

        // Eventuali azioni aggiuntive
        event(new AppointmentConfirmed($this->appointment));

        return $this->appointment;
    }
}
```

## Collegamenti Correlati
- [Best Practices dei Modelli](../models/best-practices.md)
- [Pattern di Notifiche](./notification-pattern.md)
- [Testing](../testing/state-transitions.md)
