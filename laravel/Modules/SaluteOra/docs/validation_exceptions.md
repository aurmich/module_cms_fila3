# Gestione delle Eccezioni di Validazione

## Introduzione

Questo documento descrive le best practices per la gestione delle eccezioni di validazione in questo modulo, con particolare attenzione alla classe `ValidationException` di Laravel.

## Utilizzo Corretto di ValidationException

### Metodo 1: Utilizzo di ValidationException::withMessages()

Il modo più semplice e robusto per lanciare un'eccezione di validazione è utilizzare il metodo statico `withMessages()`:

```php
use Illuminate\Validation\ValidationException;

// Corretto ✅
$error = ValidationException::withMessages([
    'email' => ['L\'email inserita non è valida.'],
    'password' => ['La password deve contenere almeno 8 caratteri.'],
]);
throw $error;
```

### Metodo 2: Utilizzo del Validator

Se hai bisogno di una validazione più complessa, puoi utilizzare il `Validator` di Laravel:

```php
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

// Corretto ✅
$validator = Validator::make($data, [
    'email' => 'required|email',
    'password' => 'required|min:8',
]);

if ($validator->fails()) {
    throw new ValidationException($validator);
}
```

## Errori Comuni da Evitare

### Errore 1: Chiamare errors()->add() su MessageBag

```php
// ERRATO ❌
throw new ValidationException(
    validator([], [])->errors()->add('email', 'Un dottore con questa email è già registrato.')
);
```

Questo codice genera l'errore: `Call to undefined method Illuminate\Support\MessageBag::errors()`

Il problema è che `validator([], [])->errors()` restituisce un oggetto `MessageBag`, che non ha un metodo `add()` che restituisce un oggetto utilizzabile dal costruttore di `ValidationException`.

### Errore 2: Passare un array direttamente al costruttore

```php
// ERRATO ❌
throw new ValidationException([
    'email' => ['Un dottore con questa email è già registrato.'],
]);
```

Il costruttore di `ValidationException` si aspetta un oggetto `Validator`, non un array di messaggi.

### Errore 3: Utilizzare make() senza fails()

```php
// ERRATO ❌
$validator = Validator::make($data, [
    'email' => 'required|email',
]);

throw new ValidationException($validator); // Il validator potrebbe non aver fallito
```

È necessario verificare che il validator abbia effettivamente fallito prima di lanciare l'eccezione.

## Gestione delle Eccezioni nelle Actions

Nelle classi Action, è importante gestire correttamente le eccezioni di validazione:

```php
namespace Modules\Patient\Actions\Doctor;

use Illuminate\Validation\ValidationException;
use Modules\Patient\Models\Doctor;

class RegisterAction
{
    public function execute(array $data)
    {
        // Verifica se esiste già un utente con questa email
        $existingUser = Doctor::where('email', $data['email'])->first();
        
        if ($existingUser) {
            // Corretto ✅
            throw ValidationException::withMessages([
                'email' => ['Un dottore con questa email è già registrato.'],
            ]);
        }
        
        // Procedi con la registrazione...
    }
}
```

## Gestione delle Eccezioni nei Controller

Nei controller, puoi utilizzare il trait `ValidatesRequests` per semplificare la validazione:

```php
namespace Modules\Patient\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class DoctorController extends Controller
{
    use ValidatesRequests;
    
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);
        
        // Il metodo validate() lancia automaticamente ValidationException se la validazione fallisce
        
        // Procedi con la creazione...
    }
}
```

## Gestione delle Eccezioni in Filament

In Filament, le eccezioni di validazione vengono gestite automaticamente dai form. Tuttavia, se hai bisogno di lanciare un'eccezione di validazione manualmente:

```php
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

// In un'azione Filament
public function register()
{
    try {
        // Logica di registrazione...
    } catch (ValidationException $e) {
        // Ottieni i messaggi di errore
        $errors = $e->errors();
        
        // Mostra una notifica con il primo errore
        Notification::make()
            ->title('Errore di validazione')
            ->body(reset($errors)[0] ?? 'Si è verificato un errore.')
            ->danger()
            ->send();
            
        // Imposta gli errori nel form
        foreach ($errors as $field => $messages) {
            $this->addError($field, $messages[0]);
        }
        
        return;
    }
    
    // Successo...
}
```

## Conclusione

La gestione corretta delle eccezioni di validazione è fondamentale per garantire un'esperienza utente fluida e per fornire feedback chiari in caso di errori. Utilizzando i metodi descritti in questo documento, puoi evitare errori comuni e implementare una validazione robusta nelle tue applicazioni.
