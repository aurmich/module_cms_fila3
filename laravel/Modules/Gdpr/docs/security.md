# Sicurezza Modulo GDPR

## Panoramica
Il modulo GDPR implementa misure di sicurezza avanzate per proteggere i dati personali in conformità con il GDPR. Questo documento descrive le misure di sicurezza implementate e le best practices da seguire.

## Crittografia

### Dati a Riposo
```php
namespace Modules\Gdpr\Models;

use Modules\Gdpr\Traits\EncryptsAttributes;

class PersonalData extends Model
{
    use EncryptsAttributes;

    protected array $encryptedAttributes = [
        'email',
        'phone',
        'address',
    ];
}
```

### Dati in Transito
```php
// config/gdpr.php
return [
    'encryption' => [
        'key' => env('GDPR_ENCRYPTION_KEY'),
        'cipher' => 'AES-256-CBC',
    ],
];
```

## Autenticazione

### Rate Limiting
```php
// routes/api.php
Route::middleware(['throttle:6,1'])->group(function () {
    Route::post('/gdpr/consent', [ConsentController::class, 'store']);
    Route::post('/gdpr/export', [ExportController::class, 'store']);
});
```

### Token Management
```php
namespace Modules\Gdpr\Services;

class TokenService
{
    public function generateToken(): string
    {
        return hash_hmac(
            'sha256',
            Str::random(40),
            config('gdpr.encryption.key')
        );
    }

    public function validateToken(string $token): bool
    {
        return hash_equals($this->getStoredToken(), $token);
    }
}
```

## Autorizzazione

### Policy
```php
namespace Modules\Gdpr\Policies;

class ConsentPolicy
{
    public function view(User $user, Consent $consent): bool
    {
        return $user->id === $consent->user_id
            || $user->hasRole('gdpr-officer');
    }

    public function export(User $user): bool
    {
        return $user->hasVerifiedEmail()
            && !$user->isSuspended();
    }
}
```

### Middleware
```php
namespace Modules\Gdpr\Http\Middleware;

class EnsureValidConsent
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->hasValidConsent($request)) {
            throw new ConsentRequiredException();
        }

        return $next($request);
    }
}
```

## Validazione Input

### Request Validation
```php
namespace Modules\Gdpr\Http\Requests;

class ConsentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::in(ConsentType::values())],
            'value' => ['required', 'boolean'],
            'expires_at' => ['required', 'date', 'after:now'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.in' => 'Il tipo di consenso non è valido',
            'expires_at.after' => 'La data di scadenza deve essere futura',
        ];
    }
}
```

### Sanitizzazione
```php
namespace Modules\Gdpr\Services;

class DataSanitizer
{
    public function sanitize(array $data): array
    {
        return array_map(function ($value) {
            return is_string($value)
                ? strip_tags($value)
                : $value;
        }, $data);
    }
}
```

## Logging

### Audit Trail
```php
namespace Modules\Gdpr\Traits;

trait LogsGdprActivity
{
    public function logActivity(string $event, array $properties = []): void
    {
        activity()
            ->performedOn($this)
            ->withProperties([
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                ...$properties,
            ])
            ->log($event);
    }
}
```

### Security Events
```php
namespace Modules\Gdpr\Events;

class SecurityEvent
{
    public function __construct(
        public readonly string $type,
        public readonly array $context,
        public readonly ?User $user = null,
    ) {}
}
```

## Backup e Recovery

### Backup Strategy
```php
namespace Modules\Gdpr\Jobs;

class BackupPersonalData implements ShouldQueue
{
    public function handle(): void
    {
        $data = PersonalData::chunk(100, function ($records) {
            foreach ($records as $record) {
                $this->backupRecord($record);
            }
        });
    }

    private function backupRecord(PersonalData $record): void
    {
        Storage::disk('encrypted')->put(
            "backups/{$record->id}.enc",
            encrypt($record->toArray())
        );
    }
}
```

### Disaster Recovery
```php
namespace Modules\Gdpr\Services;

class DisasterRecovery
{
    public function restore(string $backupId): void
    {
        $backup = Storage::disk('encrypted')
            ->get("backups/{$backupId}.enc");

        $data = decrypt($backup);
        
        DB::transaction(function () use ($data) {
            PersonalData::create($data);
        });
    }
}
```

## Best Practices

### 1. Minimizzazione dei Dati
- Raccogliere solo i dati necessari
- Implementare TTL per i dati temporanei
- Eliminare regolarmente i dati non necessari

### 2. Principio del Minimo Privilegio
- Utilizzare ruoli e permessi granulari
- Limitare l'accesso ai dati sensibili
- Registrare tutti gli accessi ai dati

### 3. Sicurezza delle API
- Utilizzare HTTPS
- Implementare rate limiting
- Validare tutti gli input
- Sanitizzare tutti gli output

### 4. Monitoraggio
- Logging di sicurezza
- Alert per attività sospette
- Monitoraggio performance
- Health checks regolari

## Collegamenti Bidirezionali

### Collegamenti ad Altri Moduli
- [Sicurezza User](../User/docs/security.md)
- [Sicurezza Activity](../Activity/docs/security.md)
- [Sicurezza Xot](../Xot/docs/security.md)

### Collegamenti Interni
- [README Principale](./README.md)
- [Configurazione](./configuration.md)
- [Troubleshooting](./troubleshooting.md)
- [Testing](./testing.md) 
## Collegamenti tra versioni di security.md
* [security.md](packages/security.md)
* [security.md](../../Cms/docs/frontoffice/security.md)
* [security.md](../../../Themes/One/docs/security.md)

