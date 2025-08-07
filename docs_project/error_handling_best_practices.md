# Best Practices per la Gestione degli Errori

## Introduzione

La gestione degli errori è un aspetto fondamentale di qualsiasi applicazione robusta. In questo modulo, seguiamo un insieme di best practices per garantire che gli errori siano gestiti in modo coerente, informativo e sicuro.

## Tipi di Eccezioni

### Eccezioni di Laravel

Laravel fornisce diverse eccezioni predefinite che dovrebbero essere utilizzate nei contesti appropriati:

- `Illuminate\Database\Eloquent\ModelNotFoundException`: Quando un modello non viene trovato
- `Illuminate\Validation\ValidationException`: Per errori di validazione
- `Illuminate\Auth\Access\AuthorizationException`: Per errori di autorizzazione
- `Illuminate\Database\QueryException`: Per errori di query al database
- `Illuminate\Http\Exceptions\HttpResponseException`: Per errori HTTP personalizzati

### Eccezioni Personalizzate

Per questo modulo, definiamo eccezioni personalizzate per gestire errori specifici del dominio:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Exceptions;

use Exception;

class DoctorRegistrationException extends Exception
{
    public function __construct(string $message = "Errore durante la registrazione del dottore", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
```

## Gestione delle Eccezioni di Validazione

### Utilizzo Corretto di ValidationException

```php
use Illuminate\Validation\ValidationException;

// Corretto ✅
throw ValidationException::withMessages([
    'email' => ['Un dottore con questa email è già registrato.'],
]);
```

### Utilizzo del Validator

```php
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

// Corretto ✅
$validator = Validator::make($data, [
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:8',
]);

if ($validator->fails()) {
    throw new ValidationException($validator);
}
```

### Errori Comuni da Evitare

```php
// ❌ ERRATO
throw new ValidationException(
    validator([], [])->errors()->add('email', 'Un dottore con questa email è già registrato.')
);

// ✅ CORRETTO
throw ValidationException::withMessages([
    'email' => ['Un dottore con questa email è già registrato.'],
]);
```

## Gestione delle Eccezioni nei Controller

### Utilizzo del Trait ValidatesRequests

```php
use Illuminate\Foundation\Validation\ValidatesRequests;

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

### Gestione Manuale delle Eccezioni

```php
public function store(Request $request)
{
    try {
        $doctor = $this->registerAction->execute($request->all());
        
        return redirect()->route('doctors.index')
            ->with('success', 'Dottore registrato con successo.');
    } catch (ValidationException $e) {
        return back()->withErrors($e->errors())
            ->withInput();
    } catch (DoctorRegistrationException $e) {
        return back()->with('error', $e->getMessage())
            ->withInput();
    } catch (\Exception $e) {
        report($e); // Registra l'eccezione
        
        return back()->with('error', 'Si è verificato un errore durante la registrazione.')
            ->withInput();
    }
}
```

## Gestione delle Eccezioni in Filament

### Utilizzo delle Notifiche di Filament

```php
use Filament\Notifications\Notification;

public function register()
{
    try {
        $doctor = $this->registerAction->execute($this->form->getState());
        
        Notification::make()
            ->title('Registrazione completata')
            ->body('Il dottore è stato registrato con successo.')
            ->success()
            ->send();
            
        return redirect()->route('doctors.index');
    } catch (ValidationException $e) {
        foreach ($e->errors() as $field => $messages) {
            $this->addError($field, $messages[0]);
        }
        
        Notification::make()
            ->title('Errore di validazione')
            ->body('Controlla i campi del form e riprova.')
            ->danger()
            ->send();
            
        return null;
    } catch (\Exception $e) {
        report($e); // Registra l'eccezione
        
        Notification::make()
            ->title('Errore')
            ->body('Si è verificato un errore durante la registrazione.')
            ->danger()
            ->send();
            
        return null;
    }
}
```

## Gestione delle Eccezioni nelle Actions

### Try-Catch nelle Actions

```php
public function execute(array $data): Doctor
{
    try {
        // Verifica se esiste già un utente con questa email
        $existingUser = Doctor::where('email', $data['email'])->first();
        
        if ($existingUser) {
            throw ValidationException::withMessages([
                'email' => ['Un dottore con questa email è già registrato.'],
            ]);
        }
        
        // Creazione del dottore
        $doctor = Doctor::create($data);
        
        // ...
        
        return $doctor;
    } catch (QueryException $e) {
        throw new DoctorRegistrationException('Errore di database durante la registrazione: ' . $e->getMessage(), 0, $e);
    } catch (\Exception $e) {
        if (!($e instanceof ValidationException)) {
            throw new DoctorRegistrationException('Errore durante la registrazione: ' . $e->getMessage(), 0, $e);
        }
        
        throw $e;
    }
}
```

### Transazioni per Garantire l'Atomicità

```php
use Illuminate\Support\Facades\DB;

public function execute(array $data): Doctor
{
    return DB::transaction(function () use ($data) {
        // Verifica se esiste già un utente con questa email
        $existingUser = Doctor::where('email', $data['email'])->first();
        
        if ($existingUser) {
            throw ValidationException::withMessages([
                'email' => ['Un dottore con questa email è già registrato.'],
            ]);
        }
        
        // Creazione del dottore
        $doctor = Doctor::create($data);
        
        // ...
        
        return $doctor;
    });
}
```

## Gestione Robusta degli Enum

### Verifica dell'Esistenza della Classe Enum

```php
private function getDoctorRegistrationStatus(): string
{
    if (!class_exists(DoctorRegistrationStatus::class)) {
        return 'pending_moderation';
    }

    try {
        $cases = DoctorRegistrationStatus::cases();
        foreach ($cases as $case) {
            if (strtolower($case->name) === 'pending_moderation') {
                return $case->value;
            }
        }
        return 'pending_moderation';
    } catch (\Exception $e) {
        return 'pending_moderation';
    }
}
```

### Utilizzo di tryFrom invece di from

```php
// ❌ ERRATO
$status = DoctorRegistrationStatus::from($statusString);

// ✅ CORRETTO
$status = DoctorRegistrationStatus::tryFrom($statusString) ?? DoctorRegistrationStatus::PENDING_MODERATION;
```

## Logging degli Errori

### Utilizzo del Facade Log

```php
use Illuminate\Support\Facades\Log;

try {
    // Operazione che potrebbe generare un errore
} catch (\Exception $e) {
    Log::error('Errore durante la registrazione del dottore', [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
        'data' => $data,
    ]);
    
    throw $e;
}
```

### Utilizzo del Helper report

```php
try {
    // Operazione che potrebbe generare un errore
} catch (\Exception $e) {
    report($e); // Registra l'eccezione utilizzando il sistema di reporting di Laravel
    
    throw $e;
}
```

## Gestione degli Errori nei Template Blade

### Utilizzo di @error

```blade
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
```

### Utilizzo di $errors

```blade
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

## Gestione degli Errori nelle API

### Utilizzo di Response JSON

```php
public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);
        
        $doctor = $this->registerAction->execute($validated);
        
        return response()->json([
            'success' => true,
            'data' => $doctor,
            'message' => 'Dottore registrato con successo.',
        ], 201);
    } catch (ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors' => $e->errors(),
            'message' => 'Errore di validazione.',
        ], 422);
    } catch (\Exception $e) {
        report($e); // Registra l'eccezione
        
        return response()->json([
            'success' => false,
            'message' => 'Si è verificato un errore durante la registrazione.',
        ], 500);
    }
}
```

### Utilizzo di API Resources

```php
public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);
        
        $doctor = $this->registerAction->execute($validated);
        
        return new DoctorResource($doctor);
    } catch (ValidationException $e) {
        throw $e; // Laravel gestirà automaticamente questa eccezione
    } catch (\Exception $e) {
        report($e); // Registra l'eccezione
        
        return response()->json([
            'success' => false,
            'message' => 'Si è verificato un errore durante la registrazione.',
        ], 500);
    }
}
```

## Errori Comuni e Come Evitarli

### 1. Mancanza di Try-Catch

```php
// ❌ ERRATO
public function execute(array $data): Doctor
{
    $doctor = Doctor::create($data);
    
    DoctorRegistrationWorkflow::create([
        'doctor_id' => $doctor->id,
        // ...
    ]);
    
    return $doctor;
}

// ✅ CORRETTO
public function execute(array $data): Doctor
{
    try {
        return DB::transaction(function () use ($data) {
            $doctor = Doctor::create($data);
            
            DoctorRegistrationWorkflow::create([
                'doctor_id' => $doctor->id,
                // ...
            ]);
            
            return $doctor;
        });
    } catch (\Exception $e) {
        throw new DoctorRegistrationException('Errore durante la registrazione: ' . $e->getMessage(), 0, $e);
    }
}
```

### 2. Messaggi di Errore Generici

```php
// ❌ ERRATO
catch (\Exception $e) {
    return back()->with('error', 'Errore.');
}

// ✅ CORRETTO
catch (\Exception $e) {
    report($e); // Registra l'eccezione
    
    return back()->with('error', 'Si è verificato un errore durante la registrazione. Il team di supporto è stato notificato.');
}
```

### 3. Mancanza di Logging

```php
// ❌ ERRATO
catch (\Exception $e) {
    return back()->with('error', 'Si è verificato un errore durante la registrazione.');
}

// ✅ CORRETTO
catch (\Exception $e) {
    Log::error('Errore durante la registrazione del dottore', [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
        'data' => $request->all(),
    ]);
    
    return back()->with('error', 'Si è verificato un errore durante la registrazione. Il team di supporto è stato notificato.');
}
```

### 4. Utilizzo Errato di ValidationException

```php
// ❌ ERRATO
throw new ValidationException([
    'email' => ['Un dottore con questa email è già registrato.'],
]);

// ✅ CORRETTO
throw ValidationException::withMessages([
    'email' => ['Un dottore con questa email è già registrato.'],
]);
```

### 5. Mancanza di Gestione degli Errori di Enum

```php
// ❌ ERRATO
$status = DoctorRegistrationStatus::from($statusString);

// ✅ CORRETTO
try {
    $status = DoctorRegistrationStatus::from($statusString);
} catch (\ValueError $e) {
    $status = DoctorRegistrationStatus::PENDING_MODERATION;
    Log::warning('Valore di stato non valido', [
        'status' => $statusString,
        'default' => $status->value,
    ]);
}

// Oppure, ancora meglio:
$status = DoctorRegistrationStatus::tryFrom($statusString) ?? DoctorRegistrationStatus::PENDING_MODERATION;
```

## Conclusione

La gestione degli errori è un aspetto fondamentale di qualsiasi applicazione robusta. Seguendo le best practices descritte in questo documento, puoi garantire che gli errori siano gestiti in modo coerente, informativo e sicuro, migliorando l'esperienza utente e facilitando il debug e la manutenzione dell'applicazione.
