# Modulo Tenant - Modular Monolith

## Introduzione

Il modulo Tenant implementa un sistema di multi-tenancy seguendo l'approccio Modular Monolith, che combina i vantaggi dell'architettura modulare con la semplicità di un'applicazione monolitica.

## Architettura

### Principi Fondamentali

1. **Isolamento dei Moduli**
   - Ogni modulo è un'unità indipendente con le proprie:
     - Migrazioni
     - Modelli
     - Controller
     - Viste
     - Test
     - Configurazioni

2. **Comunicazione tra Moduli**
   - Eventi e Listener per comunicazione asincrona
   - Service Provider per registrazione dei servizi
   - Contracts per definire interfacce tra moduli

3. **Gestione delle Dipendenze**
   - Dipendenze esplicite tra moduli
   - Uso di interfacce per il disaccoppiamento
   - Iniezione delle dipendenze tramite Service Container

### Struttura del Modulo

```
Tenant/
├── Actions/           # Azioni di business logic
├── Console/          # Comandi Artisan
├── Contracts/        # Interfacce pubbliche
├── Database/         # Migrazioni e seeders
├── Events/           # Eventi del modulo
├── Exceptions/       # Eccezioni personalizzate
├── Http/             # Controller e Middleware
├── Listeners/        # Listener per gli eventi
├── Models/           # Modelli del modulo
├── Providers/        # Service Provider
├── Resources/        # Assets e viste
├── Routes/           # Definizione delle rotte
├── Services/         # Servizi del modulo
└── Tests/            # Test unitari e di integrazione
```

## Best Practices

### 1. Isolamento

- Ogni modulo deve essere il più possibile indipendente
- Evitare dipendenze circolari tra moduli
- Utilizzare eventi per la comunicazione tra moduli
- Definire interfacce chiare per l'interazione tra moduli

### 2. Gestione delle Dipendenze

```php
// Service Provider del modulo
public function register()
{
    $this->app->bind(TenantRepositoryInterface::class, TenantRepository::class);
    $this->app->bind(TenantServiceInterface::class, TenantService::class);
}
```

### 3. Eventi e Listener

```php
// Evento
class TenantCreated
{
    public function __construct(public Tenant $tenant)
    {
    }
}

// Listener
class HandleTenantCreated
{
    public function handle(TenantCreated $event): void
    {
        // Logica di gestione
    }
}
```

### 4. Contracts e Interfacce

```php
interface TenantRepositoryInterface
{
    public function findById(int $id): ?Tenant;
    public function create(array $data): Tenant;
    public function update(Tenant $tenant, array $data): bool;
}
```

## Integrazione con Altri Moduli

### 1. Service Provider

```php
class TenantServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Registrazione dei servizi
    }

    public function boot()
    {
        // Caricamento delle configurazioni
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
    }
}
```

### 2. Eventi tra Moduli

```php
// Nel modulo Tenant
event(new TenantCreated($tenant));

// Nel modulo User
Event::listen(TenantCreated::class, function ($event) {
    // Gestione della creazione del tenant
});
```

## Testing

### 1. Test Unitari

```php
class TenantTest extends TestCase
{
    public function test_can_create_tenant()
    {
        $tenant = Tenant::factory()->create();
        $this->assertInstanceOf(Tenant::class, $tenant);
    }
}
```

### 2. Test di Integrazione

```php
class TenantIntegrationTest extends TestCase
{
    public function test_tenant_creation_triggers_events()
    {
        Event::fake();
        
        $tenant = Tenant::factory()->create();
        
        Event::assertDispatched(TenantCreated::class);
    }
}
```

## Deployment

### 1. Migrazioni

- Le migrazioni sono caricate automaticamente dal Service Provider
- Utilizzare il comando `php artisan migrate` per applicare le migrazioni

### 2. Configurazione

```php
// config/tenant.php
return [
    'default' => env('TENANT_CONNECTION', 'tenant'),
    'connections' => [
        'tenant' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
        ],
    ],
];
```

## Manutenzione

### 1. Aggiornamenti

- Mantenere le dipendenze aggiornate
- Testare gli aggiornamenti in ambiente di sviluppo
- Documentare le modifiche breaking

### 2. Debugging

- Utilizzare il logging per tracciare le operazioni
- Implementare monitoraggio delle performance
- Gestire correttamente le eccezioni

## Collegamenti Correlati

- [Struttura del Modulo](structure.md)
- [Gestione dei Pacchetti](packages.md)
- [Risoluzione dei Conflitti](risoluzione_conflitti.md)
- [Roadmap](roadmap.md)
- [Documentazione Filament](filament_resources.md)

## Collegamenti correlati
- [README.md documentazione generale](../../../docs/README.md)
- [README.md toolkit bashscripts](../../../bashscripts/docs/README.md)
- [README.md modulo GDPR](../Gdpr/docs/README.md)
- [README.md modulo User](../User/docs/README.md)
- [README.md modulo Lang](../Lang/docs/README.md)
- [README.md modulo Activity](../Activity/docs/README.md)
- [README.md modulo Media](../Media/docs/README.md)
- [README.md modulo Notify](../Notify/docs/README.md)
- [README.md modulo Tenant](../Tenant/docs/README.md)
- [README.md modulo UI](../UI/docs/README.md)
- [README.md modulo Xot](../Xot/docs/README.md)
- [Collegamenti documentazione centrale](../../../docs/collegamenti-documentazione.md)


---

## Collegamenti Principali

### Documentazione Core
- [Struttura del Modulo](./structure.md)
- [Modelli Tenant](./models/tenant.md)
- [Traits](./traits/README.md)
- [Middleware](./middleware.md)
- [Best Practices](./BEST-PRACTICES.md)

### Integrazioni
- [Integrazione con User](../User/docs/README.md)
- [Integrazione con Xot](../Xot/docs/README.md)
- [Integrazione con Lang](../Lang/docs/README.md)

### Best Practices
- [Convenzioni Tenant](./tenant-conventions.md)
- [Gestione Database](./database-management.md)
- [PHPStan Fixes](./phpstan-fixes.md)

### Testing e Qualità
- [PHPStan Level 9](./PHPSTAN_LEVEL9_FIXES.md)
- [PHPStan Level 10](./PHPSTAN_LEVEL10_FIXES.md)
- [Testing Best Practices](./testing-best-practices.md)

## Struttura del Modulo

```
Modules/Tenant/
├── app/
│   ├── Models/
│   │   ├── Tenant.php
│   │   └── TenantUser.php
│   ├── Providers/
│   │   ├── TenantServiceProvider.php
│   │   └── TenantBaseServiceProvider.php
│   ├── Filament/
│   │   ├── Resources/
│   │   │   └── TenantResource.php
│   │   ├── Widgets/
│   │   │   └── TenantStatsWidget.php
│   │   └── Pages/
│   │       └── TenantManager.php
│   └── Http/
│       └── Controllers/
│           └── TenantController.php
├── config/
│   └── tenant.php
├── database/
│   └── migrations/
│       ├── create_tenants_table.php
│       └── create_tenant_users_table.php
└── resources/
    └── views/
        └── tenant/
            ├── dashboard.blade.php
            └── settings.blade.php
```

## Gestione Tenant

### 1. Modello Tenant
```php
// app/Models/Tenant.php
namespace App\Models;

use Modules\Tenant\Models\XotBaseTenant;
use Modules\Lang\Facades\Lang;

class Tenant extends XotBaseTenant
{
    protected $fillable = [
        'name',
        'domain',
        'database',
        'settings'
    ];

    protected $casts = [
        'settings' => 'array'
    ];

    public function getDisplayNameAttribute(): string
    {
        return Lang::get('tenant.name', ['name' => $this->name]);
    }
}
```

### 2. Trait HasTenant
```php
// ❌ NON FARE QUESTO
class User extends Model
{
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}

// ✅ FARE QUESTO
use Modules\Tenant\Traits\HasTenant;

class User extends XotBaseModel
{
    use HasTenant;

    protected $fillable = [
        'name',
        'email',
        'tenant_id'
    ];
}
```

### 3. Middleware Tenant
```php
// ❌ NON FARE QUESTO
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

// ✅ FARE QUESTO
Route::middleware(['auth', 'tenant'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
```

## Best Practices

### 1. Database
- Utilizzare connessioni separate
- Implementare migrazioni tenant
- Gestire backup tenant
- Isolare i dati

### 2. Autenticazione
```php
// ❌ NON FARE QUESTO
if (auth()->attempt($credentials)) {
    return redirect()->intended();
}

// ✅ FARE QUESTO
if (Tenant::current()->authenticate($credentials)) {
    return redirect()->intended();
}
```

### 3. Configurazione
```php
// ❌ NON FARE QUESTO
config(['app.name' => 'My App']);

// ✅ FARE QUESTO
Tenant::current()->configure([
    'app.name' => 'My App'
]);
```

## Dipendenze Principali

### Moduli
- **User**: Gestione utenti tenant
- **Xot**: Tenant base
- **Lang**: Traduzioni tenant

### Pacchetti
- Laravel Framework
- Filament
- Livewire
- Spatie Permission

## Roadmap

### Prossime Feature
1. Nuovi tipi tenant
2. Miglioramento isolamento
3. Ottimizzazione performance

### Miglioramenti Pianificati
1. Refactoring tenant
2. Miglioramento UI
3. Ottimizzazione query

## Contribuire

### Setup Sviluppo
1. Clona il repository
2. Installa le dipendenze
3. Configura l'ambiente
4. Esegui i test

### Convenzioni di Codice
- Seguire PSR-12
- Utilizzare type hints
- Documentare il codice
- Scrivere test unitari

### Processo di Pull Request
1. Crea un branch feature
2. Implementa le modifiche
3. Aggiungi i test
4. Aggiorna la documentazione
5. Crea la PR

## Troubleshooting

### Problemi Comuni
1. Connessione database
2. Isolamento dati
3. Errori configurazione

### Soluzioni
1. Verifica configurazione
2. Controlla log
3. Consulta documentazione

## Riferimenti

### Documentazione
- [Laravel Multi-Tenancy](https://laravel.com/docs/12.x/multi-tenancy)
- [Filament](https://filamentphp.com/docs)
- [Spatie Permission](https://spatie.be/docs/laravel-permission)

### Collegamenti Interni
- [User Module](../User/docs/README.md)
- [Xot Module](../Xot/docs/README.md)
- [Lang Module](../Lang/docs/README.md)

## Changelog

### [1.0.0] - 2024-03-20
#### Added
- Implementazione iniziale
- Sistema tenant
- Isolamento dati
- Configurazione tenant

#### Changed
- Miglioramento performance
- Ottimizzazione query
- Refactoring codice

#### Fixed
- Bug tenant
- Problemi isolamento
### Versione HEAD

- Errori configurazione 

### Versione Incoming

- Errori configurazione 
## Collegamenti
- [Modulo Xot](../../Xot/docs/README.md)
- [Modulo Cms](../../Cms/docs/README.md)
- [Modulo Lang](../../Lang/docs/README.md) 
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)


---

## Collegamenti sulla risoluzione dei conflitti

- [Risoluzione conflitti nel modulo Tenant](risoluzione_conflitti.md)
- [Linee guida globali per la risoluzione dei conflitti git](../../../docs/risoluzione_conflitti_git.md)

