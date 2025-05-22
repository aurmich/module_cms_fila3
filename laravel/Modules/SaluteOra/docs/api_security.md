# Sicurezza delle API

## Collegamenti correlati
- [Indice documentazione](/laravel/Modules/Patient/docs/INDEX.md)
- [Documentazione API](/laravel/Modules/Patient/docs/api.md)
- [Gestione degli errori](/laravel/Modules/Patient/docs/ERROR_HANDLING_BEST_PRACTICES.md)
- [Validazione](/laravel/Modules/Patient/docs/VALIDATION_ERRORS.md)
- [Ottimizzazione delle performance](/laravel/Modules/Patient/docs/PERFORMANCE_OPTIMIZATION.md)
- [Best practices per le API](/laravel/Modules/Xot/docs/API_BEST_PRACTICES.md)

## Introduzione

Questo documento descrive le misure di sicurezza implementate per proteggere gli endpoint API del modulo Patient. La sicurezza delle API è fondamentale per garantire l'integrità, la confidenzialità e la disponibilità dei dati dei pazienti e dei medici.

## Autenticazione e Autorizzazione

### Autenticazione

Il modulo Patient utilizza diversi metodi di autenticazione per le API:

1. **Token API**: Utilizzato per l'autenticazione di applicazioni client
2. **OAuth 2.0**: Utilizzato per l'autenticazione di applicazioni di terze parti
3. **JWT (JSON Web Tokens)**: Utilizzato per l'autenticazione stateless

#### Implementazione Token API

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('patients', PatientApiController::class);
    Route::apiResource('doctors', DoctorApiController::class);
});
```

#### Implementazione OAuth 2.0

Il modulo utilizza Laravel Passport per l'implementazione di OAuth 2.0:

```php
// Configurazione in AuthServiceProvider.php
public function boot()
{
    $this->registerPolicies();
    Passport::routes();
    Passport::tokensExpireIn(now()->addDays(15));
    Passport::refreshTokensExpireIn(now()->addDays(30));
}
```

### Autorizzazione

L'autorizzazione è gestita tramite:

1. **Policy Laravel**: Definiscono le regole di accesso per ogni risorsa
2. **Middleware personalizzati**: Implementano controlli di accesso specifici
3. **Gate**: Definiscono regole di autorizzazione centralizzate

#### Esempio di Policy

```php
namespace Modules\Patient\Policies;

use App\Models\User;
use Modules\Patient\Models\Patient;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view patients');
    }

    public function view(User $user, Patient $patient)
    {
        return $user->hasPermissionTo('view patients') || $user->id === $patient->id;
    }

    // Altri metodi di policy...
}
```

## Protezione da Attacchi Comuni

### Cross-Site Request Forgery (CSRF)

Per le API che utilizzano l'autenticazione basata su cookie, è implementata la protezione CSRF tramite il middleware `VerifyCsrfToken` di Laravel.

```php
// Middleware applicato alle route web
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];
```

### Cross-Origin Resource Sharing (CORS)

La configurazione CORS è implementata per consentire l'accesso alle API solo da domini autorizzati:

```php
// config/cors.php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
```

### SQL Injection

La protezione da SQL Injection è garantita dall'utilizzo di:

1. **Query Builder di Laravel**: Utilizza prepared statements
2. **Eloquent ORM**: Sanitizza automaticamente gli input
3. **Validazione degli input**: Filtra e valida tutti i dati in ingresso

### Rate Limiting

Il rate limiting è implementato per prevenire attacchi di brute force e DoS:

```php
// Middleware di rate limiting
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::apiResource('patients', PatientApiController::class);
});
```

La configurazione del throttle è definita in `RouteServiceProvider`:

```php
protected function configureRateLimiting()
{
    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
    });
}
```

## Gestione dei Dati Sensibili

### Crittografia

I dati sensibili dei pazienti sono crittografati utilizzando:

1. **Crittografia a livello di database**: Utilizzo di campi crittografati
2. **Crittografia a livello di applicazione**: Utilizzo della classe `Crypt` di Laravel

```php
// Esempio di crittografia a livello di modello
protected function medicalNotes(): Attribute
{
    return Attribute::make(
        get: fn ($value) => $value ? Crypt::decrypt($value) : null,
        set: fn ($value) => $value ? Crypt::encrypt($value) : null,
    );
}
```

### Mascheramento dei Dati

Le API implementano il mascheramento dei dati sensibili nelle risposte:

```php
// Esempio di mascheramento in una API Resource
public function toArray($request)
{
    return [
        'id' => $this->id,
        'name' => $this->name,
        'email' => $this->email,
        'phone' => $this->when(
            $request->user()->can('view_patient_details', $this->resource),
            $this->phone,
            $this->maskPhone()
        ),
        // Altri campi...
    ];
}

protected function maskPhone()
{
    return substr($this->phone, 0, 3) . '****' . substr($this->phone, -3);
}
```

## Logging e Monitoraggio

### Audit Trail

Tutte le operazioni sulle API sono registrate in un audit trail per consentire il monitoraggio e l'analisi:

```php
// Middleware di audit
class ApiAuditMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        if ($request->user()) {
            AuditLog::create([
                'user_id' => $request->user()->id,
                'action' => $request->method(),
                'endpoint' => $request->path(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'request_data' => json_encode($request->except(['password', 'password_confirmation'])),
                'response_code' => $response->getStatusCode(),
            ]);
        }
        
        return $response;
    }
}
```

### Monitoraggio in Tempo Reale

Il sistema implementa il monitoraggio in tempo reale delle API per rilevare attività sospette:

1. **Monitoraggio degli errori**: Registrazione e notifica degli errori API
2. **Monitoraggio delle performance**: Tracciamento dei tempi di risposta
3. **Rilevamento anomalie**: Identificazione di pattern di utilizzo anomali

## Conformità e Standard

### GDPR

Le API sono progettate per essere conformi al GDPR:

1. **Consenso esplicito**: Raccolta e gestione del consenso dell'utente
2. **Diritto all'oblio**: Implementazione di endpoint per la cancellazione dei dati
3. **Portabilità dei dati**: Implementazione di endpoint per l'esportazione dei dati

### HIPAA (per applicazioni mediche)

Per le applicazioni che gestiscono dati sanitari, sono implementate misure di conformità HIPAA:

1. **Controlli di accesso rigorosi**: Implementazione di accesso basato sui ruoli
2. **Crittografia end-to-end**: Protezione dei dati in transito e a riposo
3. **Audit completo**: Registrazione dettagliata di tutte le operazioni sui dati

## Best Practices Implementate

### Versionamento delle API

Le API sono versionate per garantire la compatibilità:

```php
// Esempio di versionamento delle API
Route::prefix('api/v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('patients', PatientApiV1Controller::class);
});

Route::prefix('api/v2')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('patients', PatientApiV2Controller::class);
});
```

### Documentazione OpenAPI

Le API sono documentate utilizzando le specifiche OpenAPI (Swagger):

```php
/**
 * @OA\Get(
 *     path="/api/patients",
 *     summary="Get list of patients",
 *     tags={"Patients"},
 *     security={{"sanctum": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Patient")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */
public function index()
{
    // Implementazione...
}
```

### Gestione degli Errori

Le API implementano una gestione standardizzata degli errori:

```php
// Esempio di gestione degli errori
public function show($id)
{
    try {
        $patient = Patient::findOrFail($id);
        
        $this->authorize('view', $patient);
        
        return new PatientResource($patient);
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'error' => 'Patient not found',
            'code' => 'RESOURCE_NOT_FOUND',
        ], 404);
    } catch (AuthorizationException $e) {
        return response()->json([
            'error' => 'Unauthorized access',
            'code' => 'UNAUTHORIZED_ACCESS',
        ], 403);
    } catch (\Exception $e) {
        Log::error('API Error', ['exception' => $e]);
        
        return response()->json([
            'error' => 'Internal server error',
            'code' => 'INTERNAL_ERROR',
        ], 500);
    }
}
```

## Conclusione

La sicurezza delle API è un aspetto fondamentale del modulo Patient. Implementando le misure di sicurezza descritte in questo documento, è possibile garantire la protezione dei dati sensibili e prevenire accessi non autorizzati.

## Riferimenti

- [Laravel Security Best Practices](https://laravel.com/docs/security)
- [OWASP API Security Top 10](https://owasp.org/www-project-api-security/)
- [JWT Authentication](https://jwt.io/introduction)
- [OAuth 2.0 Framework](https://oauth.net/2/)

# API Security for Patient Module

## Overview
This document outlines the security measures and best practices for protecting API endpoints within the Patient module. Given the sensitive nature of healthcare data, ensuring robust security is critical to protect patient and doctor information from unauthorized access and breaches.

## Authentication and Authorization

1. **API Token Authentication**:
   - All API endpoints must require authentication via API tokens or JWT (JSON Web Tokens).
   - Tokens should have a limited lifespan and be refreshed periodically.

2. **Role-Based Access Control (RBAC)**:
   - Implement RBAC to ensure users can only access endpoints relevant to their role (e.g., admin, doctor, patient).
   - Use Laravel's built-in policies and gates for fine-grained access control.

3. **Multi-Factor Authentication (MFA)**:
   - For endpoints handling highly sensitive data (e.g., patient records), enforce MFA to add an extra layer of security.

## Data Protection

1. **Encryption**:
   - Encrypt sensitive data both in transit (using HTTPS/TLS) and at rest (using database encryption).
   - Ensure API responses containing personal health information (PHI) are encrypted.

2. **Input Validation and Sanitization**:
   - Validate all incoming data to prevent injection attacks (e.g., SQL injection, XSS).
   - Use Laravel's validation rules to enforce data integrity before processing.

3. **Data Minimization**:
   - Return only the necessary data in API responses. Avoid exposing sensitive fields unless explicitly required.
   - Implement field-level access control to restrict visibility of sensitive data based on user roles.

## Rate Limiting and Throttling

- Implement rate limiting on API endpoints to prevent abuse and denial-of-service (DoS) attacks.
- Configure throttling to allow a reasonable number of requests per minute per user or IP address, adjusting based on endpoint sensitivity.

## Logging and Monitoring

1. **Audit Logging**:
   - Log all API access attempts, especially for endpoints handling sensitive data.
   - Record user ID, endpoint accessed, timestamp, and success/failure status for audit purposes.

2. **Anomaly Detection**:
   - Monitor for unusual patterns (e.g., repeated failed login attempts, unusual data access patterns) that might indicate a security threat.
   - Use tools like Laravel Telescope or external services for real-time monitoring.

## API Endpoint Security

1. **Versioning**:
   - Use API versioning to manage changes and ensure backward compatibility without exposing outdated, potentially vulnerable endpoints.

2. **CORS Policies**:
   - Configure Cross-Origin Resource Sharing (CORS) to restrict access to trusted domains only.

3. **CSRF Protection**:
   - Although typically not applicable to stateless APIs, ensure CSRF tokens are used if the API interacts with browser-based clients.

## Common Security Pitfalls and How to Avoid Them

- **Exposing API Keys**: Never hardcode API keys or secrets in code. Use environment variables or Laravel's configuration system.
- **Insufficient Validation**: Always validate and sanitize input data to prevent injection attacks.
- **Over-Exposing Data**: Avoid returning full datasets unnecessarily. Use pagination and selective field retrieval.

## Compliance with Regulations

- Ensure compliance with GDPR and other relevant data protection regulations when handling patient data.
- Implement data anonymization techniques for analytics or reporting purposes to protect patient privacy.

## Conclusion

Securing API endpoints in the Patient module is essential to safeguard sensitive healthcare data. By adhering to these best practices, including robust authentication, data encryption, and proactive monitoring, we can maintain a secure environment for all users. Regular security audits and updates to these practices are necessary to address emerging threats.

## Related Documentation

- [API Overview](API_OVERVIEW.md)
- [API Authentication](API_AUTHENTICATION.md)
- [Performance Optimization](PERFORMANCE_OPTIMIZATION.md)
- [Error Resolution Guidelines](../../../docs/ERROR_RESOLUTION_GUIDELINES.md)
