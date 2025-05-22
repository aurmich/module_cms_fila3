# Gestione degli Stati nel Modulo SaluteOra

## Introduzione
Il modulo SaluteOra utilizza `spatie/laravel-model-states` per gestire gli stati dei modelli. Questo approccio offre una gestione robusta e flessibile degli stati, permettendo transizioni controllate e validazione.

## Struttura degli Stati

### UserState
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
            ->allowTransition(Pending::class, Rejected::class)
            ->allowTransition(Approved::class, Suspended::class);
    }
}
```

### Stati Specifici
```php
namespace Modules\SaluteOra\States;

class Pending extends UserState
{
    public function canTransitionTo(State $newState): bool
    {
        return $newState instanceof Approved || $newState instanceof Rejected;
    }
}

class Approved extends UserState
{
    public function canTransitionTo(State $newState): bool
    {
        return $newState instanceof Suspended;
    }
}
```

## Implementazione nei Modelli

### User Model
```php
namespace Modules\SaluteOra\Models;

use Spatie\ModelStates\HasStates;

class User extends Model
{
    use HasStates;

    protected $casts = [
        'state' => UserState::class,
    ];
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