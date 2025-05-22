# Architettura Modulo GDPR

## Struttura del Modulo

```
Modules/Gdpr/
├── Config/
│   └── config.php
├── Console/
│   └── Commands/
├── Database/
│   ├── Factories/
│   ├── Migrations/
│   └── Seeders/
├── Filament/
│   ├── Resources/
│   ├── Pages/
│   └── Widgets/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Policies/
├── Providers/
├── Resources/
│   ├── lang/
│   └── views/
├── Services/
├── Tests/
└── docs/
```

## Layer Architetturali

### 1. Presentation Layer

#### Filament Resources
```php
namespace Modules\Gdpr\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class ConsentResource extends XotBaseResource
{
    protected static string $model = Consent::class;
    
    public static function getNavigationGroup(): ?string
    {
        return __('gdpr::navigation.privacy');
    }
}
```

#### Controllers
```php
namespace Modules\Gdpr\Http\Controllers;

use Modules\Xot\Http\Controllers\XotBaseController;

class ConsentController extends XotBaseController
{
    public function __construct(
        private readonly ConsentService $service
    ) {}

    public function store(ConsentRequest $request): JsonResponse
    {
        $consent = $this->service->createConsent($request->validated());
        return response()->json($consent, 201);
    }
}
```

### 2. Domain Layer

#### Models
```php
namespace Modules\Gdpr\Models;

use Modules\Xot\Models\XotBaseModel;

class Consent extends XotBaseModel
{
    protected $fillable = [
        'user_id',
        'type',
        'value',
        'expires_at',
    ];

    protected $casts = [
        'value' => 'boolean',
        'expires_at' => 'datetime',
    ];
}
```

#### Services
```php
namespace Modules\Gdpr\Services;

class ConsentService
{
    public function __construct(
        private readonly ConsentRepository $repository,
        private readonly ConsentValidator $validator
    ) {}

    public function createConsent(array $data): Consent
    {
        $this->validator->validate($data);
        return $this->repository->create($data);
    }
}
```

### 3. Data Layer

#### Repositories
```php
namespace Modules\Gdpr\Repositories;

use Modules\Xot\Repositories\XotBaseRepository;

class ConsentRepository extends XotBaseRepository
{
    public function getValidConsents(User $user): Collection
    {
        return $this->model
            ->where('user_id', $user->id)
            ->where('expires_at', '>', now())
            ->get();
    }
}
```

#### Factories
```php
namespace Modules\Gdpr\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ConsentFactory extends Factory
{
    protected $model = Consent::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['marketing', 'analytics']),
            'value' => $this->faker->boolean,
            'expires_at' => now()->addDays(30),
        ];
    }
}
```

## Componenti Principali

### 1. Service Provider
```php
namespace Modules\Gdpr\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class GdprServiceProvider extends XotBaseServiceProvider
{
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    
    public function boot(): void
    {
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom($this->module_dir.'/../Database/Migrations');
    }
}
```

### 2. Event System
```php
namespace Modules\Gdpr\Events;

class ConsentGranted
{
    public function __construct(
        public readonly Consent $consent,
        public readonly User $user
    ) {}
}

class ConsentListener
{
    public function handle(ConsentGranted $event): void
    {
        activity()
            ->performedOn($event->consent)
            ->causedBy($event->user)
            ->log('consent_granted');
    }
}
```

### 3. Job Queue
```php
namespace Modules\Gdpr\Jobs;

class ProcessDataExport implements ShouldQueue
{
    public function __construct(
        private readonly User $user,
        private readonly string $format
    ) {}

    public function handle(ExportService $service): void
    {
        $service->exportUserData($this->user, $this->format);
    }
}
```

## Pattern Utilizzati

### 1. Repository Pattern
- Separazione della logica di accesso ai dati
- Interfacce standardizzate per le operazioni CRUD
- Facilitazione dei test unitari

### 2. Service Layer
- Incapsulamento della logica di business
- Coordinamento tra repository e altri servizi
- Gestione delle transazioni

### 3. Factory Pattern
- Creazione standardizzata di oggetti
- Supporto per i test
- Generazione dati di esempio

### 4. Observer Pattern
- Gestione eventi GDPR
- Notifiche asincrone
- Audit logging

## Integrazione con Altri Moduli

### 1. User Module
```php
use Modules\Gdpr\Traits\HasGdprConsent;

class User extends XotBaseUser
{
    use HasGdprConsent;
}
```

### 2. Activity Module
```php
use Modules\Gdpr\Traits\LogsGdprActivity;

class GdprActivity extends Activity
{
    use LogsGdprActivity;
}
```

### 3. Notify Module
```php
use Modules\Gdpr\Events\ConsentExpiring;

class ConsentExpirationNotification extends Notification
{
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Consenso in scadenza')
            ->line('Il tuo consenso sta per scadere.');
    }
}
```

## Collegamenti Bidirezionali

### Collegamenti ad Altri Moduli
- [Architettura User](../User/docs/architecture.md)
- [Architettura Activity](../Activity/docs/architecture.md)
- [Architettura Xot](../Xot/docs/architecture.md)

### Collegamenti Interni
- [README Principale](./README.md)
- [Implementazione](./implementation.md)
- [Configurazione](./configuration.md)
- [Security](./security.md) 
## Estensibilità

### 1. Eventi
```php
interface ConsentEvents
{
    const CREATED = 'consent.created';
    const UPDATED = 'consent.updated';
    const DELETED = 'consent.deleted';
}
```

### 2. Middleware
```php
class GdprMiddleware
{
    public function handle($request, Closure $next)
    {
        // Logica personalizzabile
        return $next($request);
    }
}
```

## Collegamenti
- [README](../README.md)
- [Sviluppo](development.md)
- [Pacchetti](packages.md)
- [Roadmap](roadmap.md) 

## Collegamenti tra versioni di architecture.md
* [architecture.md](docs/tecnico/filament/architecture.md)
* [architecture.md](docs/rules/architecture.md)
* [architecture.md](laravel/Modules/Gdpr/docs/architecture.md)
* [architecture.md](laravel/Modules/Cms/docs/frontoffice/architecture.md)
* [architecture.md](laravel/Modules/Cms/docs/architecture.md)
* [architecture.md](laravel/Themes/One/docs/roadmap/inspiration/architecture.md)

