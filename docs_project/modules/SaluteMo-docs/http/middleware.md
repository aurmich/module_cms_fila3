# Middleware nel Modulo SaluteMo

## Posizione e Namespace

### Struttura Corretta
Tutti i middleware devono essere posizionati nella directory:
```
Modules/SaluteMo/app/Http/Middleware/
```

### Namespace Corretto
```php
namespace Modules\SaluteMo\Http\Middleware;
```

### Errori Comuni
- ❌ `Modules/SaluteMo/Http/Middleware/` - Posizione errata
- ✅ `Modules/SaluteMo/app/Http/Middleware/` - Posizione corretta

- ❌ `namespace Modules\SaluteMo\App\Http\Middleware;` - Namespace errato
- ✅ `namespace Modules\SaluteMo\Http\Middleware;` - Namespace corretto

## Middleware per App Mobile

### Middleware Specifici
Per l'app mobile, si consigliano i seguenti middleware:

1. **ValidateMobileToken**: Verifica il token di autenticazione dell'app mobile
2. **CheckMobileVersion**: Controlla che la versione dell'app sia supportata
3. **MobileActivityTracker**: Tiene traccia dell'attività dell'utente mobile
4. **MobileApiThrottle**: Limita le richieste API per prevenire abusi

### Implementazione di ValidateMobileToken

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateMobileToken
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Logica di validazione del token mobile
        if (!$this->isValidToken($request->bearerToken())) {
            return response()->json([
                'success' => false,
                'message' => 'Token non valido o scaduto'
            ], 401);
        }

        return $next($request);
    }

    /**
     * Verifica la validità del token.
     */
    private function isValidToken(?string $token): bool
    {
        // Implementazione della validazione
        // ...
    }
}
```

### Implementazione di CheckMobileVersion

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMobileVersion
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $appVersion = $request->header('X-App-Version');
        
        if (!$appVersion) {
            return response()->json([
                'success' => false,
                'message' => 'Versione dell\'app non specificata'
            ], 400);
        }

        // Controllo di compatibilità della versione
        if (!$this->isVersionSupported($appVersion)) {
            return response()->json([
                'success' => false,
                'message' => 'Questa versione dell\'app non è più supportata. Si prega di aggiornare.',
                'update_required' => true,
                'store_url' => config('salutemo.app_store_url')
            ], 426); // Upgrade Required
        }

        return $next($request);
    }

    /**
     * Verifica se la versione è supportata.
     */
    private function isVersionSupported(string $version): bool
    {
        // Implementazione del controllo versione
        // ...
    }
}
```

## Registrazione dei Middleware

### Middleware Globali
Per registrare middleware globali per tutte le richieste all'API mobile:

```php
// In SaluteMoServiceProvider.php
protected function registerMiddleware(): void
{
    $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
    $kernel->pushMiddleware(\Modules\SaluteMo\Http\Middleware\MobileActivityTracker::class);
}
```

### Middleware per Gruppi di Route
Per applicare middleware a gruppi specifici di route:

```php
// In RouteServiceProvider.php
Route::prefix('api/v1')
    ->middleware([
        'api',
        \Modules\SaluteMo\Http\Middleware\ValidateMobileToken::class,
        \Modules\SaluteMo\Http\Middleware\CheckMobileVersion::class,
    ])
    ->namespace($this->moduleNamespace)
    ->group(module_path('SaluteMo', '/routes/api.php'));
```

### Middleware con Alias
Per utilizzare gli alias dei middleware:

```php
// In SaluteMoServiceProvider.php
protected function registerRouteMiddleware(): void
{
    $router = $this->app->make(\Illuminate\Routing\Router::class);
    
    $router->aliasMiddleware('mobile.auth', \Modules\SaluteMo\Http\Middleware\ValidateMobileToken::class);
    $router->aliasMiddleware('mobile.version', \Modules\SaluteMo\Http\Middleware\CheckMobileVersion::class);
    $router->aliasMiddleware('mobile.track', \Modules\SaluteMo\Http\Middleware\MobileActivityTracker::class);
    $router->aliasMiddleware('mobile.throttle', \Modules\SaluteMo\Http\Middleware\MobileApiThrottle::class);
}
```

## Best Practices

### Middleware Single-Purpose
Ogni middleware dovrebbe avere un'unica responsabilità ben definita.

### Gestione Errori
Utilizzare risposte JSON standardizzate per gli errori:

```php
return response()->json([
    'success' => false,
    'message' => 'Messaggio di errore',
    'errors' => $dettagliErrori // Opzionale
], $statusCode);
```

### Documentazione
Documentare chiaramente ogni middleware con commenti DocBlock:

```php
/**
 * Middleware che verifica la validità del token dell'app mobile.
 * 
 * Questo middleware controlla che il token Bearer fornito nell'header
 * della richiesta sia valido e non scaduto. In caso negativo, viene
 * restituita una risposta di errore 401.
 */
class ValidateMobileToken
{
    // ...
}
```

## Collegamenti Correlati
- [Controllers](./controllers.md)
- [API Routes](../routes/api-routes.md)
- [Service Provider](../providers/xotbase-extensions.md)
