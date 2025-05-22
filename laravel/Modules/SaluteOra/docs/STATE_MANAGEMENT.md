# Gestione degli Stati con spatie/laravel-model-states

## Panoramica

Questo documento descrive come utilizzare `spatie/laravel-model-states` per gestire gli stati degli utenti nel modulo SaluteOra.

## Perché usare spatie/laravel-model-states

1. **Gestione strutturata**: Fornisce un modo strutturato per gestire gli stati e le transizioni
2. **Validazione integrata**: Include validazione delle transizioni di stato
3. **Eventi**: Genera eventi quando gli stati cambiano
4. **Flusso di lavoro chiaro**: Definisce chiaramente quali transizioni sono consentite

## Implementazione

### 1. Creazione della classe astratta UserState

Creare una classe astratta che estenda `Spatie\ModelStates\State`:

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
            ->allowTransition(Pending::class, Active::class)
            ->allowTransition(Pending::class, Rejected::class)
            ->allowTransition(Active::class, Suspended::class)
            ->allowTransition([Pending::class, Suspended::class], Active::class)
            ->allowTransition([Active::class, Pending::class], IntegrationRequested::class);
    }
}
```

### 2. Creazione delle classi di stato

Ogni stato è una classe che estende `UserState`:

```php
// Pending.php
namespace Modules\SaluteOra\States\User;

class Pending extends UserState
{
    public function label(): string
    {
        return 'In attesa';
    }
    
    public function color(): string
    {
        return 'warning';
    }
    
    public function icon(): string
    {
        return 'heroicon-o-clock';
    }
}
```

### 3. Aggiornamento del modello User

Aggiornare il modello User per utilizzare la nuova gestione degli stati:

```php
use Modules\SaluteOra\States\User\UserState;
use Spatie\ModelStates\HasStates;

class User extends Authenticatable
{
    use HasStates;
    
    protected $casts = [
        'state' => UserState::class,
    ];
    
    // ...
}
```

### 4. Utilizzo nel codice

```php
// Ottenere lo stato corrente
$state = $user->state;

// Verificare lo stato
if ($user->state->equals(Pending::class)) {
    // ...
}

// Cambiare stato
$user->state->transitionTo(Active::class);
$user->save();

// Verificare se una transizione è consentita
$canActivate = $user->state->canTransitionTo(Active::class);
```

## Best Practice

1. **Incapsulamento**: Incapsulare la logica di transizione in metodi del modello
2. **Eventi**: Utilizzare gli eventi per azioni collaterali
3. **Validazione**: Validare le transizioni prima di eseguirle
4. **Documentazione**: Documentare le transizioni consentite

## Migrazione da Enum

Per migrare da un enum a spatie/laravel-model-states:

1. Creare le classi di stato
2. Aggiornare il modello User
3. Creare una migrazione per aggiornare i dati esistenti
4. Aggiornare il codice per utilizzare la nuova API
