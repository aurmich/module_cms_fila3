# Sistema di Sicurezza

## Introduzione

Questo documento descrive le misure di sicurezza implementate nel tema "One", inclusi i protocolli, le configurazioni e le best practices per la protezione dell'applicazione.

## Configurazione Sicurezza

### Middleware
```php
// app/Http/Middleware/SecurityHeaders.php
class SecurityHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Content-Security-Policy', "default-src 'self'");
        
        return $response;
    }
}
```

### Configurazione CORS
```php
// config/cors.php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [env('APP_URL')],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
```

## Autenticazione

### Configurazione JWT
```php
// config/jwt.php
return [
    'secret' => env('JWT_SECRET'),
    'keys' => [
        'public' => env('JWT_PUBLIC_KEY'),
        'private' => env('JWT_PRIVATE_KEY'),
    ],
    'ttl' => env('JWT_TTL', 60),
    'refresh_ttl' => env('JWT_REFRESH_TTL', 20160),
    'algo' => env('JWT_ALGO', 'HS256'),
    'required_claims' => ['iss', 'iat', 'exp', 'nbf', 'sub', 'jti'],
    'blacklist_enabled' => env('JWT_BLACKLIST_ENABLED', true),
];
```

### Validazione Password
```php
// app/Rules/Password.php
class Password implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $value);
    }

    public function message()
    {
        return 'La password deve contenere almeno 8 caratteri, una lettera maiuscola, una minuscola, un numero e un carattere speciale.';
    }
}
```

## Protezione Dati

### Crittografia
```php
// app/Services/EncryptionService.php
class EncryptionService
{
    public function encrypt($data)
    {
        return encrypt($data);
    }

    public function decrypt($encryptedData)
    {
        return decrypt($encryptedData);
    }
}
```

### Sanitizzazione Input
```php
// app/Services/SanitizationService.php
class SanitizationService
{
    public function sanitize($input)
    {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    public function sanitizeArray($array)
    {
        return array_map([$this, 'sanitize'], $array);
    }
}
```

## Protezione API

### Rate Limiting
```php
// app/Providers/RouteServiceProvider.php
protected function configureRateLimiting()
{
    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
    });
}
```

### Validazione Token
```php
// app/Http/Middleware/VerifyApiToken.php
class VerifyApiToken
{
    public function handle($request, Closure $next)
    {
        if (!$request->hasHeader('X-API-TOKEN')) {
            return response()->json(['error' => 'Token mancante'], 401);
        }

        if ($request->header('X-API-TOKEN') !== env('API_TOKEN')) {
            return response()->json(['error' => 'Token non valido'], 401);
        }

        return $next($request);
    }
}
```

## Protezione Frontend

### CSP Configuration
```javascript
// resources/js/security.js
export const cspConfig = {
    'default-src': ["'self'"],
    'script-src': ["'self'", "'unsafe-inline'", 'https://*.google-analytics.com'],
    'style-src': ["'self'", "'unsafe-inline'"],
    'img-src': ["'self'", 'data:', 'https://*.google-analytics.com'],
    'connect-src': ["'self'", 'https://*.google-analytics.com'],
    'font-src': ["'self'"],
    'object-src': ["'none'"],
    'media-src': ["'self'"],
    'frame-src': ["'none'"],
};
```

### XSS Protection
```javascript
// resources/js/xss.js
export const sanitizeInput = (input) => {
    const div = document.createElement('div');
    div.textContent = input;
    return div.innerHTML;
};

export const validateInput = (input, pattern) => {
    return pattern.test(input);
};
```

## Best Practices

### Sicurezza
- Utilizzare HTTPS
- Implementare 2FA
- Gestire sessioni
- Proteggere API
- Monitorare accessi

### Dati
- Crittografare sensibili
- Sanitizzare input
- Validare output
- Gestire backup
- Proteggere log

### Codice
- Aggiornare dipendenze
- Scansionare vulnerabilità
- Revisionare codice
- Documentare procedure
- Formare team

## Metriche di Successo

### Sicurezza
- Vulnerabilità risolte
- Tempo di risposta
- Copertura test
- Compliance
- Incidenti

### Performance
- Impatto sicurezza
- Tempo di scansione
- Falsi positivi
- Automazione
- Documentazione

## Collegamenti

- [Sistema di Design](../design_system.md)
- [Componenti](../components.md)
- [Guida allo Stile](../style_guide.md)
- [Best Practices](../best_practices.md) 
