# Best Practices per la Gestione degli Stati

## Principi Fondamentali

1. **Usa SEMPRE spatie/laravel-model-states**
   - Mai usare enum standard
   - Mai usare stringhe o interi
   - Mai usare altri pacchetti per la gestione degli stati

2. **Struttura delle Classi**
   - Ogni stato deve essere una classe separata
   - Ogni stato deve estendere la classe base dello stato
   - Ogni stato deve implementare `canTransitionTo`

3. **Validazione**
   - Validare sempre le transizioni
   - Implementare logica di business nelle transizioni
   - Lanciare eccezioni appropriate

4. **Eventi**
   - Emettere eventi per ogni transizione
   - Documentare gli eventi
   - Gestire gli eventi in modo asincrono

## Struttura delle Directory

```
Modules/SaluteOra/
├── States/
│   ├── UserState.php
│   ├── Pending.php
│   ├── Approved.php
│   └── Rejected.php
├── Events/
│   └── UserStateChanged.php
└── Exceptions/
    └── InvalidStateTransition.php
```

## Implementazione Corretta

### Classe Base dello Stato
```php
namespace Modules\SaluteOra\States;

use Spatie\ModelStates\State;

class UserState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Approved::class)
            ->allowTransition(Pending::class, Rejected::class);
    }
}
```

### Stato Specifico
```php
namespace Modules\SaluteOra\States;

class Pending extends UserState
{
    public function canTransitionTo(State $newState): bool
    {
        if (!parent::canTransitionTo($newState)) {
            return false;
        }

        // Logica di business specifica
        return $this->model->hasValidData();
    }

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

## Testing

### Test delle Transizioni
```php
namespace Modules\SaluteOra\Tests\States;

use Tests\TestCase;
use Modules\SaluteOra\States\Pending;
use Modules\SaluteOra\States\Approved;

class UserStateTest extends TestCase
{
    public function test_can_transition_from_pending_to_approved()
    {
        $user = User::factory()->create(['state' => Pending::class]);
        
        $this->assertTrue($user->state->canTransitionTo(Approved::class));
    }

    public function test_cannot_transition_with_invalid_data()
    {
        $user = User::factory()->create([
            'state' => Pending::class,
            'data' => null
        ]);
        
        $this->assertFalse($user->state->canTransitionTo(Approved::class));
    }
}
```

## Common Pitfalls

1. **Errore**: Usare enum standard
   ```php
   // ❌ NON FARE QUESTO
   enum UserState
   {
       case PENDING;
       case APPROVED;
   }
   ```

   ```php
   // ✅ FARE QUESTO
   class UserState extends State
   {
       public static function config(): StateConfig
       {
           return parent::config()
               ->default(Pending::class);
       }
   }
   ```

2. **Errore**: Non validare le transizioni
   ```php
   // ❌ NON FARE QUESTO
   class Pending extends UserState
   {
       public function canTransitionTo(State $newState): bool
       {
           return true; // Troppo permissivo
       }
   }
   ```

   ```php
   // ✅ FARE QUESTO
   class Pending extends UserState
   {
       public function canTransitionTo(State $newState): bool
       {
           if (!parent::canTransitionTo($newState)) {
               return false;
           }
           
           return $this->model->hasValidData();
       }
   }
   ```

3. **Errore**: Non gestire gli eventi
   ```php
   // ❌ NON FARE QUESTO
   class Pending extends UserState
   {
       public function transitionTo(State $newState): void
       {
           parent::transitionTo($newState);
       }
   }
   ```

   ```php
   // ✅ FARE QUESTO
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

## Checklist di Implementazione

- [ ] Creare la classe base dello stato
- [ ] Implementare gli stati specifici
- [ ] Definire le transizioni consentite
- [ ] Implementare la validazione
- [ ] Gestire gli eventi
- [ ] Scrivere i test
- [ ] Documentare gli stati e le transizioni
- [ ] Aggiornare la documentazione 

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

## 🔍 Debugging e Troubleshooting

### Best Practices per il Debugging

1. **Logging Dettagliato**
   ```php
   Log::info('Tentativo di transizione', [
       'user_id' => $user->id,
       'current_state' => get_class($user->state),
       'target_state' => $newState,
       'model_data' => $user->toArray()
   ]);
   ```

2. **Validazione Robusta**
   ```php
   public function canTransitionTo(State $newState): bool
   {
       try {
           if (!parent::canTransitionTo($newState)) {
               Log::warning('Transizione non consentita dalla configurazione', [
                   'from' => get_class($this),
                   'to' => get_class($newState)
               ]);
               return false;
           }

           if (!$this->model->hasValidData()) {
               Log::warning('Dati non validi per la transizione', [
                   'user_id' => $this->model->id,
                   'validation_errors' => $this->model->getErrors()
               ]);
               return false;
           }

           return true;
       } catch (\Exception $e) {
           Log::error('Errore durante la validazione della transizione', [
               'error' => $e->getMessage(),
               'trace' => $e->getTraceAsString()
           ]);
           return false;
       }
   }
   ```

3. **Gestione Eventi**
   ```php
   Event::listen(UserStateChanged::class, function (UserStateChanged $event) {
       try {
           Log::info('Transizione di stato completata', [
               'user_id' => $event->user->id,
               'old_state' => get_class($event->oldState),
               'new_state' => get_class($event->newState)
           ]);
       } catch (\Exception $e) {
           Log::error('Errore durante la gestione dell\'evento', [
               'error' => $e->getMessage()
           ]);
       }
   });
   ```

### Troubleshooting Guide

1. **Verifica Stati nel Database**
   ```sql
   -- Lista tutti gli stati unici
   SELECT DISTINCT state FROM users;
   
   -- Conta gli utenti per stato
   SELECT state, COUNT(*) as count 
   FROM users 
   GROUP BY state;
   
   -- Trova utenti con stati potenzialmente invalidi
   SELECT id, state 
   FROM users 
   WHERE state NOT LIKE 'Modules\\SaluteOra\\States%';
   ```

2. **Verifica Classi di Stato**
   ```php
   // Lista tutte le classi di stato disponibili
   $stateClasses = collect(File::allFiles(app_path('States')))
       ->map(function ($item) {
           return 'Modules\\SaluteOra\\States\\' . str_replace(
               ['/', '.php'],
               ['\\', ''],
               $item->getRelativePathname()
           );
       })
       ->filter(function ($class) {
           return class_exists($class) && is_subclass_of($class, State::class);
       });
   ```

3. **Test di Integrazione**
   ```php
   public function test_state_transition_flow()
   {
       $user = User::factory()->create(['state' => Pending::class]);
       
       // Test transizione valida
       $this->assertTrue($user->state->canTransitionTo(Approved::class));
       $user->state->transitionTo(Approved::class);
       $this->assertInstanceOf(Approved::class, $user->fresh()->state);
       
       // Test transizione invalida
       $this->assertFalse($user->state->canTransitionTo(Pending::class));
       $this->expectException(InvalidStateTransition::class);
       $user->state->transitionTo(Pending::class);
   }
   ```

### Checklist di Debugging

- [ ] Verificare i log per errori o warning
- [ ] Controllare gli stati nel database
- [ ] Verificare l'esistenza di tutte le classi di stato
- [ ] Testare le transizioni in ambiente di sviluppo
- [ ] Monitorare gli eventi e i listener
- [ ] Verificare la validazione dei dati
- [ ] Controllare i namespace nel database
- [ ] Testare le transizioni in tutti gli scenari possibili 