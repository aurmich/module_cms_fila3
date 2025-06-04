# Struttura HTTP in SaluteMo

## Convenzione Fondamentale
Tutte le classi relative a HTTP devono essere collocate nella directory `app/Http/` all'interno del modulo, seguendo gli standard di autoloading PSR-4.

### Struttura Corretta
```
Modules/
  SaluteMo/
    app/
      Http/
        Controllers/     # Classi controller
        Middleware/      # Middleware HTTP
        Requests/        # Classi Form request
        Resources/       # Risorse API
```

### Errori Comuni
- ❌ `Modules/SaluteMo/Http/Controllers/` - Errato
- ✅ `Modules/SaluteMo/app/Http/Controllers/` - Corretto

## Convenzioni per API Mobile

### Versioning
Le API per dispositivi mobili devono essere versionati nel seguente modo:

```php
// In RouteServiceProvider.php
Route::prefix('api/v1')
    ->middleware('api')
    ->namespace($this->moduleNamespace)
    ->group(module_path('SaluteMo', '/routes/api.php'));
```

### Response Format
Tutte le risposte API devono seguire questo formato standard:

```php
return response()->json([
    'success' => true,
    'data' => $data,
    'message' => $message
], $statusCode);
```

### Gestione Errori
Utilizzare sempre i codici di stato HTTP appropriati:

```php
return response()->json([
    'success' => false,
    'message' => 'Errore di validazione',
    'errors' => $validator->errors()
], 422);
```

## Convenzioni di Naming

### Controllers
- Nome singolare o plurale in base alla risorsa
- Suffisso `Controller` obbligatorio
- Esempio: `DoctorController` o `AppointmentsController`

### Middleware
- Nome descrittivo della funzionalità
- Esempio: `CheckMobileVersion`, `ValidateMobileToken`

### Requests
- Nome descrittivo dell'azione
- Suffisso `Request` obbligatorio
- Esempio: `StoreDoctorRequest`, `UpdateAppointmentRequest`

### Resources
- Nome singolare o plurale in base alla risorsa
- Suffisso `Resource` obbligatorio
- Esempio: `DoctorResource`, `AppointmentsCollection`

## Motivazioni
1. Segue la struttura standard di Laravel
2. Mantiene consistenza con PSR-4 autoloading
3. Previene problemi di autoloading e namespace
4. Rende il codice più manutenibile

## Verifica
Dopo la migrazione dei file, verificare:
1. Tutti i namespace sono corretti
2. Le rotte puntano alle posizioni corrette dei controller
3. Tutti i test passano

## Collegamenti Correlati
- [Convenzioni dei Namespace](./namespace-conventions.md)
- [Controllers](../http/controllers.md)
- [Middleware](../http/middleware.md)
