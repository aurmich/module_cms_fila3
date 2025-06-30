# Gestione degli Stati nel Modulo SaluteOra

## Introduzione
Il modulo SaluteOra utilizza `spatie/laravel-model-states` per gestire gli stati dei modelli. Questo approccio offre una gestione robusta e flessibile degli stati, permettendo transizioni controllate e validazione.

## Stati Disponibili

Gli stati dell'utente nel sistema SaluteOra sono:

1. **Pending** - Stato iniziale dell'utente in attesa di approvazione
2. **Active** - Utente attivo nel sistema
3. **Inactive** - Utente inattivo
4. **Rejected** - Utente respinto
5. **Suspended** - Utente sospeso
6. **IntegrationRequested** - Utente per cui è richiesta un'integrazione di dati
7. **IntegrationCompleted** - Utente che ha completato l'integrazione richiesta (NUOVO)

## Struttura degli Stati

### UserState (Classe Base)
```php
namespace Modules\SaluteOra\States\User;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class UserState extends State
{
    abstract public function label(): string;
    abstract public function color(): string;
    abstract public function icon(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            // Pending transitions
            ->allowTransition(Pending::class, Active::class, Transitions\PendingToActive::class)
            ->allowTransition(Pending::class, Rejected::class, Transitions\PendingToRejected::class)
            ->allowTransition(Pending::class, IntegrationRequested::class, Transitions\PendingToIntegrationRequested::class)

            // Active transitions
            ->allowTransition(Active::class, Suspended::class, Transitions\ActiveToSuspended::class)
            ->allowTransition(Active::class, Inactive::class, Transitions\ActiveToInactive::class)
            ->allowTransition(Active::class, IntegrationRequested::class, Transitions\ActiveToIntegrationRequested::class)

            // IntegrationRequested transitions
            ->allowTransition(IntegrationRequested::class, Active::class, Transitions\IntegrationRequestedToActive::class)
            ->allowTransition(IntegrationRequested::class, Rejected::class, Transitions\IntegrationRequestedToRejected::class)
            ->allowTransition(IntegrationRequested::class, IntegrationCompleted::class, Transitions\IntegrationRequestedToIntegrationCompleted::class)

            // IntegrationCompleted transitions
            ->allowTransition(IntegrationCompleted::class, Active::class, Transitions\IntegrationCompletedToActive::class)
            ->allowTransition(IntegrationCompleted::class, Rejected::class, Transitions\IntegrationCompletedToRejected::class)
            ->allowTransition(IntegrationCompleted::class, IntegrationRequested::class, Transitions\IntegrationCompletedToIntegrationRequested::class)

            // Other transitions
            ->allowTransition(Rejected::class, Pending::class, Transitions\RejectedToPending::class)
            ->allowTransition(Suspended::class, Active::class, Transitions\SuspendedToActive::class)
            ->allowTransition(Suspended::class, Inactive::class, Transitions\SuspendedToInactive::class)
            ->allowTransition(Inactive::class, Active::class, Transitions\InactiveToActive::class)

            // Register all states
            ->registerState(Pending::class)
            ->registerState(Active::class)
            ->registerState(Inactive::class)
            ->registerState(Rejected::class)
            ->registerState(Suspended::class)
            ->registerState(IntegrationRequested::class)
            ->registerState(IntegrationCompleted::class);
    }
}
```

### Stato IntegrationCompleted (NUOVO)
```php
namespace Modules\SaluteOra\States\User;

/**
 * Stato che rappresenta un utente che ha completato l'integrazione dei dati richiesti.
 * 
 * In questo stato l'utente ha fornito tutte le informazioni richieste
 * e può essere attivato nel sistema.
 */
class IntegrationCompleted extends UserState
{
    public static $name = 'integration_completed';
    
    public function label(): string
    {
        return 'Integrazione completata';
    }
    
    public function color(): string
    {
        return 'success';
    }
    
    public function icon(): string
    {
        return 'heroicon-o-check-circle';
    }
}
```

### Stato IntegrationRequested (Esistente)
```php
namespace Modules\SaluteOra\States\User;

/**
 * Stato che rappresenta un utente per il quale è richiesta un'integrazione.
 * 
 * In questo stato l'utente ha completato la registrazione ma sono richieste
 * ulteriori informazioni prima di poter attivare l'account.
 */
class IntegrationRequested extends UserState
{
    public static $name = 'integration_requested';
    
    public function label(): string
    {
        return 'Integrazione richiesta';
    }
    
    public function color(): string
    {
        return 'info';
    }
    
    public function icon(): string
    {
        return 'heroicon-o-document-text';
    }
}
```

## Flusso di Integrazione

Il nuovo flusso di integrazione segue questi passaggi:

1. **Pending** → **IntegrationRequested**: Quando servono dati aggiuntivi
2. **IntegrationRequested** → **IntegrationCompleted**: Quando l'utente fornisce i dati
3. **IntegrationCompleted** → **Active**: Quando l'amministratore approva

### Diagramma del Flusso
```
Pending
├── → Active (approvazione diretta)
├── → Rejected (respinto)
└── → IntegrationRequested (servono dati aggiuntivi)
    ├── → IntegrationCompleted (dati forniti)
    │   ├── → Active (approvazione finale)
    │   ├── → Rejected (respinto dopo verifica)
    │   └── → IntegrationRequested (servono ulteriori dati)
    ├── → Active (approvazione diretta)
    └── → Rejected (respinto)
```

## Implementazione nei Modelli

### User Model
```php
namespace Modules\SaluteOra\Models;

use Spatie\ModelStates\HasStates;
use Modules\SaluteOra\States\User\UserState;

class User extends BaseModel
{
    use HasStates;

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'state' => UserState::class,
        ]);
    }
}
```

## Transizioni

### Nuova Transizione: IntegrationRequestedToIntegrationCompleted
```php
namespace Modules\SaluteOra\States\User\Transitions;

use Spatie\ModelStates\Transition;
use Modules\SaluteOra\States\User\IntegrationRequested;
use Modules\SaluteOra\States\User\IntegrationCompleted;
use Modules\SaluteOra\Models\User;

class IntegrationRequestedToIntegrationCompleted extends Transition
{
    public function __construct(public User $user, public ?string $message = '') {}

    public function handle(): User
    {
        // Verifica che tutti i dati richiesti siano stati forniti
        if (!$this->user->hasCompletedIntegration()) {
            throw new \Exception('Integrazione non completata');
        }

        $this->user->state = new IntegrationCompleted($this->user);
        $this->user->save();
        
        return $this->user;
    }
}
```

## Eventi e Transizioni

### Definizione Eventi
```php
class UserStateChanged
{
    public function __construct(
        public User $user,
        public UserState $oldState,
        public UserState $newState
    ) {}
}
```

### Gestione Transizioni
```php
class Pending extends UserState
{
    public function transitionTo(State $newState): void
    {
        if (!$this->canTransitionTo($newState)) {
            throw new InvalidStateTransition($this, $newState);
        }

        event(new UserStateChanged(
            $this->model,
            $this,
            $newState
        ));

        parent::transitionTo($newState);
    }
}
```

## Best Practices

1. **Validazione delle Transizioni**
   - Implementare sempre `canTransitionTo`
   - Validare le condizioni di business
   - Lanciare eccezioni appropriate

2. **Eventi**
   - Emettere eventi per ogni transizione
   - Documentare gli eventi
   - Gestire gli eventi in modo asincrono quando possibile

3. **Testing**
   - Testare tutte le transizioni possibili
   - Verificare la validazione
   - Testare gli eventi

4. **Documentazione**
   - Documentare tutti gli stati possibili
   - Documentare le transizioni consentite
   - Mantenere aggiornata la documentazione

## Esempi di Utilizzo

### Transizione di Stato
```php
$user->state->transitionTo(Approved::class);
```

### Verifica Transizione
```php
if ($user->state->canTransitionTo(Suspended::class)) {
    $user->state->transitionTo(Suspended::class);
}
```

### Eventi
```php
Event::listen(UserStateChanged::class, function (UserStateChanged $event) {
    // Logica di gestione evento
});
```

## Note Importanti

1. Non usare mai enum standard per gli stati
2. Implementare sempre la validazione delle transizioni
3. Gestire correttamente gli eventi
4. Mantenere la documentazione aggiornata
5. Testare tutte le transizioni possibili

## 🛠️ Migrazione dei Namespace degli Stati

Quando si spostano, rinominano o riorganizzano le classi di stato, **è necessario aggiornare anche i valori della colonna `state` nel database**. Se il database contiene ancora i vecchi namespace, Spatie Model States non troverà la classe e genererà un errore simile a:

```
Undefined array key "Vecchio\\Namespace\\Pending"
```

### Come risolvere

1. **Identifica i vecchi namespace**
   - Esempio: `Modules\\SaluteOra\\States\\Pending` → `Modules\\SaluteOra\\States\\User\\Pending`
2. **Esegui una query di update** (Esempio per MySQL):

```sql
UPDATE users
SET state = REPLACE(state, 'Modules\\SaluteOra\\States\\Pending', 'Modules\\SaluteOra\\States\\User\\Pending')
WHERE state = 'Modules\\SaluteOra\\States\\Pending';

UPDATE users
SET state = REPLACE(state, 'Modules\\SaluteOra\\States\\Active', 'Modules\\SaluteOra\\States\\User\\Active')
WHERE state = 'Modules\\SaluteOra\\States\\Active';
-- Ripeti per tutti gli altri stati
```

3. **Verifica che tutte le classi di stato esistano nel nuovo namespace**.
4. **Testa la login e tutte le transizioni di stato**.

### Checklist
- [ ] Aggiornati i valori della colonna `state` nel database
- [ ] Tutte le classi di stato esistono nel nuovo namespace
- [ ] Testate tutte le transizioni di stato
- [ ] Aggiornata la documentazione 

## 🔍 Troubleshooting

### Errori Comuni

1. **Undefined array key**
   - Causa: Il valore dello stato nel database non corrisponde a nessuna classe di stato esistente
   - Soluzione: 
     - Verificare che tutte le classi di stato esistano
     - Controllare i namespace nel database
     - Eseguire la migrazione dei namespace se necessario

2. **InvalidStateTransition**
   - Causa: Tentativo di transizione non consentita
   - Soluzione:
     - Verificare le regole di transizione in `canTransitionTo`
     - Controllare le condizioni di business
     - Aggiornare le regole se necessario

3. **Class not found**
   - Causa: Namespace errato o classe mancante
   - Soluzione:
     - Verificare i namespace delle classi
     - Controllare l'autoloading
     - Aggiornare il composer.json se necessario

### Debugging

1. **Log delle Transizioni**
   ```php
   Log::info('Transizione di stato', [
       'user_id' => $user->id,
       'old_state' => $user->state,
       'new_state' => $newState
   ]);
   ```

2. **Verifica Stati nel Database**
   ```sql
   SELECT DISTINCT state FROM users;
   ```

3. **Test delle Transizioni**
   ```php
   $user = User::find(1);
   try {
       $user->state->transitionTo(Approved::class);
   } catch (\Exception $e) {
       Log::error('Errore transizione', [
           'error' => $e->getMessage(),
           'user_id' => $user->id
       ]);
   }
   ```

### Best Practices per il Debugging

1. **Logging**
   - Implementare logging dettagliato per le transizioni
   - Registrare tutti gli errori
   - Mantenere traccia delle transizioni fallite

2. **Validazione**
   - Verificare sempre i dati prima della transizione
   - Implementare controlli di sicurezza
   - Gestire le eccezioni in modo appropriato

3. **Testing**
   - Testare tutti gli scenari possibili
   - Verificare le transizioni invalide
   - Testare gli eventi e i listener

4. **Documentazione**
   - Mantenere aggiornata la documentazione degli stati
   - Documentare le transizioni consentite
   - Registrare le modifiche e le correzioni 

## Pattern BaseTransition (DRY + KISS)

⭐ **IMPORTANTE**: Tutte le transizioni nel modulo SaluteOra seguono il pattern **BaseTransition**, un capolavoro di design che implementa DRY e KISS.

### Filosofia
- **99% delle transizioni** sono completamente vuote (solo `//---`)
- **Auto-discovery** dello stato target dal nome della classe
- **Notifiche automatiche** generate automaticamente
- **Zero duplicazione** di codice

### Implementazione Tipica
```php
class IntegrationCompletedToRejected extends BaseTransition
{
    //---  (Funziona automaticamente!)
}
```

### Come Funziona l'Auto-Discovery
```
IntegrationCompletedToActive → Modules\SaluteOra\States\User\Active
PendingToIntegrationRequested → Modules\SaluteOra\States\User\IntegrationRequested
```

### Transizioni con Logica Custom (Rare)
Solo quando servono dati aggiuntivi per le notifiche:
```php
class PendingToActive extends BaseTransition
{
    public function getNotificationData(): array {
        $password = Str::random(10);
        $this->user->update(['password' => $password]);
        return ['message' => $this->message, 'password' => $password];
    }
}
```

➡️ **Documentazione completa**: [Pattern BaseTransition](base-transition-pattern.md)

## 🏥 **Stati degli Appuntamenti** (NUOVO - Gennaio 2025)

Il modulo SaluteOra ora implementa un sistema completo di gestione degli stati per gli appuntamenti medici, utilizzando lo stesso eccellente **Pattern BaseTransition**.

### Stati Disponibili

1. **Pending** - Appuntamento in attesa di conferma (stato iniziale)
2. **Confirmed** - Appuntamento confermato e programmato  
3. **InProgress** - Appuntamento attualmente in corso
4. **Completed** - Appuntamento completato con successo
5. **Cancelled** - Appuntamento cancellato
6. **NoShow** - Paziente non presente all'appuntamento
7. **Rescheduled** - Appuntamento riprogrammato

### Transizioni Implementate

Tutte le transizioni seguono il **Pattern BaseTransition** con **notifiche automatiche** a paziente e dottore:

```php
// Esempi di transizioni (tutte automatiche!)
class PendingToConfirmed extends BaseTransition { //--- }
class ConfirmedToInProgress extends BaseTransition { //--- }
class InProgressToCompleted extends BaseTransition { //--- }
class ConfirmedToCancelled extends BaseTransition { //--- }
class ConfirmedToNoShow extends BaseTransition { //--- }
class ConfirmedToRescheduled extends BaseTransition { //--- }
class RescheduledToConfirmed extends BaseTransition { //--- }
```

### Utilizzo Appuntamenti

```php
// Conferma un appuntamento con notifiche automatiche
$appointment = Appointment::find(1);
$transition = new PendingToConfirmed($appointment, 'Confermato dal dottore');
$appointment = $transition->handle();

// ✅ Stato cambiato automaticamente
// ✅ Email inviate a paziente e dottore  
// ✅ Log tracciabilità creato
```

### Notifiche Automatiche per Appuntamenti

Le notifiche includono automaticamente:
- `appointment_date`: Data (dd/mm/yyyy)
- `appointment_time`: Ora (HH:mm)  
- `doctor_name`: Nome completo dottore
- `patient_name`: Nome completo paziente
- `studio_name`: Nome dello studio
- `message`: Messaggio personalizzato

📋 **Documentazione completa**: [Appointment States](appointment-states.md) 