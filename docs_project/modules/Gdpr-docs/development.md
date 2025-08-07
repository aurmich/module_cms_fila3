# Linee Guida di Sviluppo per il Modulo GDPR

## Struttura del Codice

### Namespace e Directory
```
Gdpr/
├── Console/          # Comandi Artisan
├── Database/         # Migrazioni e seeders
├── Http/            # Controller e middleware
├── Models/          # Modelli Eloquent
├── Services/        # Servizi di business
├── Tests/           # Test unitari e di integrazione
└── docs/            # Documentazione
```

### Convenzioni di Codice
```php
// Nomi delle classi in PascalCase
class ConsentService
{
    // Nomi dei metodi in camelCase
    public function storeConsent(User $user, array $data): Consent
    {
        // Type hints obbligatori
        // Return types obbligatori
        // Docblocks per metodi pubblici
    }
}
```

## Testing

### Unit Test
```php
class ConsentTest extends TestCase
{
    public function test_can_store_consent()
    {
        // given
        $user = User::factory()->create();
        $data = [
            'type' => 'cookie',
            'status' => true,
            'version' => '1.0.0'
        ];

        // when
        $consent = $this->consentService->storeConsent($user, $data);

        // then
        $this->assertInstanceOf(Consent::class, $consent);
        $this->assertEquals($data['type'], $consent->type);
    }
}
```

### Feature Test
```php
class ConsentControllerTest extends TestCase
{
    public function test_can_create_consent_via_api()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->postJson('/api/gdpr/consents', [
                'type' => 'cookie',
                'status' => true,
                'version' => '1.0.0'
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'type',
                    'status',
                    'version'
                ]
            ]);
    }
}
```

## Best Practices

### 1. Sicurezza
```php
// Validazione input
class StoreConsentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'type' => ['required', 'string', 'in:cookie,privacy,marketing'],
            'status' => ['required', 'boolean'],
            'version' => ['required', 'string']
        ];
    }
}

// Cifratura dati
class ConsentService
{
    public function storeConsent(User $user, array $data): Consent
    {
        return DB::transaction(function () use ($user, $data) {
            $consent = new Consent([
                'user_id' => $user->id,
                'type' => $data['type'],
                'status' => $data['status'],
                'version' => $data['version'],
                'ip_address' => request()->ip(),
                'metadata' => encrypt($data['metadata'] ?? [])
            ]);

            $consent->save();

            return $consent;
        });
    }
}
```

### 2. Performance
```php
// Caching
class ConsentService
{
    public function getActiveConsents(User $user)
    {
        return Cache::remember(
            "user.{$user->id}.consents",
            now()->addHours(24),
            fn() => $user->consents()->active()->get()
        );
    }
}

// Queue per operazioni pesanti
class BackupJob implements ShouldQueue
{
    public function handle()
    {
        $this->backupService->createBackup();
    }
}
```

### 3. Manutenibilità
```php
// Interfacce per dipendenze
interface ConsentRepositoryInterface
{
    public function getLatestConsent(User $user, string $type): ?Consent;
}

// Trait per funzionalità comuni
trait HasConsent
{
    public function consents()
    {
        return $this->hasMany(Consent::class);
    }
}
```

## Processo di Sviluppo

### 1. Branching
- `main`: Branch principale
- `develop`: Branch di sviluppo
- `feature/*`: Nuove funzionalità
- `bugfix/*`: Correzioni bug
- `release/*`: Preparazione release

### 2. Commit
```bash

# Formato messaggi commit
feat(gdpr): aggiunta gestione consensi cookie
fix(gdpr): correzione validazione consensi
docs(gdpr): aggiornamento documentazione
```

### 3. Code Review
- Verifica conformità standard
- Test di sicurezza
- Performance review
- Documentazione aggiornata

## Strumenti di Sviluppo

### 1. PHPStan
```neon

# phpstan.neon.dist
parameters:
    level: 5
    paths:
        - app
    excludePaths:
        - tests
```

### 2. PHP CS Fixer
```php
// .php-cs-fixer.dist.php
return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR12' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
    ]);
```

### 3. Testing
```php
// phpunit.xml
<phpunit>
    <testsuites>
        <testsuite name="Gdpr">
            <directory>tests</directory>
        </testsuite>
    </testsuites>
</phpunit>
```

## Documentazione

### 1. PHPDoc
```php
/**
 * Registra un nuovo consenso per l'utente.
 *
 * @param User $user Utente a cui associare il consenso
 * @param array $data Dati del consenso
 * @return Consent
 * @throws ConsentException
 */
public function storeConsent(User $user, array $data): Consent
```

### 2. README
- Panoramica modulo
- Requisiti
- Installazione
- Configurazione
- Utilizzo

## Deployment

### 1. CI/CD
```yaml

# .github/workflows/gdpr.yml
name: Gdpr CI

on:
  push:
    paths:
      - 'laravel/Modules/Gdpr/**'

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Run tests
        run: php artisan test Gdpr
```

### 2. Versionamento
- Semantic Versioning
- CHANGELOG.md
- Tag per release

## Collegamenti
- [Architettura](architecture.md)
- [Pacchetti](packages.md)
- [Roadmap](roadmap.md) 

## Collegamenti tra versioni di development.md
* [development.md](laravel/Modules/Gdpr/docs/development.md)
* [development.md](laravel/Modules/Xot/docs/packages/development.md)

