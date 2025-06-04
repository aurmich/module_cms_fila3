# API Routes in SaluteMo

## Convenzioni di Base

### Posizione dei File
Le route API del modulo SaluteMo devono essere definite in:
```
Modules/SaluteMo/routes/api.php
```

### Struttura Versioning
Per il supporto al versioning delle API mobile, utilizzare la seguente struttura:

```php
use Illuminate\Support\Facades\Route;

// API v1 (corrente)
Route::prefix('v1')->group(function () {
    // Route API versione 1...
});

// Future versioni (quando necessarie)
Route::prefix('v2')->group(function () {
    // Route API versione 2...
});
```

## Route per Dispositivi Mobili

### Convenzioni di Naming
- Utilizzare risorse al plurale per collezioni (`doctors`, `appointments`)
- Utilizzare risorse al singolare per elementi specifici (`doctor/{id}`, `appointment/{id}`)
- Utilizzare nomi descrittivi per azioni (`appointments/confirm`, `doctors/available`)

### Struttura a Risorse
```php
// Collezione
Route::get('appointments', [MobileAppointmentController::class, 'index']);
Route::post('appointments', [MobileAppointmentController::class, 'store']);

// Elementi specifici
Route::get('appointments/{id}', [MobileAppointmentController::class, 'show']);
Route::put('appointments/{id}', [MobileAppointmentController::class, 'update']);
Route::delete('appointments/{id}', [MobileAppointmentController::class, 'destroy']);

// Azioni personalizzate
Route::post('appointments/{id}/confirm', [MobileAppointmentController::class, 'confirm']);
Route::post('appointments/{id}/cancel', [MobileAppointmentController::class, 'cancel']);
```

### Resource Controller
Utilizzare i resource controller quando appropriato:

```php
Route::apiResource('appointments', MobileAppointmentController::class);
```

Per resource controller con azioni personalizzate:

```php
Route::apiResource('appointments', MobileAppointmentController::class);
Route::post('appointments/{appointment}/confirm', [MobileAppointmentController::class, 'confirm']);
```

## Middleware e Gruppi

### Middleware di Autenticazione
```php
Route::middleware('auth:sanctum')->group(function () {
    // Route protette...
});
```

### Middleware di Throttling
```php
Route::middleware('throttle:api')->group(function () {
    // Route con limitazioni di frequenza...
});
```

### Gruppi per Contesto
Organizzare le route in gruppi logici:

```php
// Profilo utente
Route::prefix('profile')->group(function () {
    Route::get('/', [MobileProfileController::class, 'show']);
    Route::put('/', [MobileProfileController::class, 'update']);
    Route::get('appointments', [MobileProfileController::class, 'appointments']);
});

// Ricerca e prenotazione
Route::prefix('booking')->group(function () {
    Route::get('doctors', [MobileBookingController::class, 'doctors']);
    Route::get('available-slots', [MobileBookingController::class, 'availableSlots']);
    Route::post('reserve', [MobileBookingController::class, 'reserve']);
});
```

## Gestione Errori e Codici di Stato

### Codici di Stato HTTP
- 200: Successo
- 201: Risorsa creata
- 204: Nessun contenuto (eliminazione)
- 400: Errore nella richiesta
- 401: Non autorizzato
- 403: Vietato
- 404: Risorsa non trovata
- 422: Errore di validazione
- 429: Troppe richieste
- 500: Errore del server

### Formato Risposta Errori
```json
{
  "success": false,
  "message": "Errore di validazione",
  "errors": {
    "campo": ["Il campo è obbligatorio"]
  }
}
```

## Configurazione in RouteServiceProvider

Per una corretta configurazione in `RouteServiceProvider.php`, assicurarsi di estendere `XotBaseRouteServiceProvider` e implementare il metodo `boot()` correttamente:

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    protected string $moduleNamespace = 'Modules\SaluteMo\Http\Controllers';
    protected string $moduleName = 'SaluteMo';
    
    public function boot(): void
    {
        parent::boot();
        
        // Personalizzazioni aggiuntive...
    }
}
```

## Collegamenti Correlati
- [Controller HTTP](../http/controllers.md)
- [Middleware](../http/middleware.md)
- [Service Provider](../providers/xotbase-extensions.md)
