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