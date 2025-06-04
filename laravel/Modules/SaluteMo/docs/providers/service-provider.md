# Service Provider in SaluteMo

## Introduzione

I service provider nel modulo SaluteMo seguono il pattern di ereditarietà definito dal framework Xot, estendendo le classi base fornite dal modulo Xot. Questo approccio garantisce coerenza e manutenibilità attraverso tutti i moduli dell'applicazione.

## Indice

- [SaluteMoServiceProvider](#salutemoserviceprovider)
- [RouteServiceProvider](#routeserviceprovider)
- [EventServiceProvider](#eventserviceprovider)
- [Best Practice](#best-practice)
- [Risoluzione dei Problemi](#risoluzione-dei-problemi)

## SaluteMoServiceProvider

Il Service Provider principale del modulo SaluteMo estende `XotBaseServiceProvider` per ereditare le funzionalità di base comuni a tutti i moduli.

### Responsabilità

1. Registrazione di componenti e servizi specifici del modulo
2. Caricamento di configurazioni
3. Registrazione di viste e risorse
4. Caricamento di migrazioni
5. Registrazione di comandi Artisan
6. Gestione delle traduzioni

### Implementazione

```php
namespace Modules\SaluteMo\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;

class SaluteMoServiceProvider extends XotBaseServiceProvider
{
    use PathNamespace;

    /**
     * Module name for public use
     *
     * @var string
     */
    public string $name = 'SaluteMo';
    
    /**
     * Module name for internal use
     *
     * @var string
     */
    protected string $moduleName = 'SaluteMo';
    
    /**
     * Module name in lowercase
     *
     * @var string
     */
    protected string $moduleNameLower = 'salutemo';
    
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'Modules\SaluteMo\Models\Model' => 'Modules\SaluteMo\Policies\ModelPolicy',
    ];
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        parent::register();
        
        // Register your module's services here
    }
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
        
        // Register your module's components here
    }
}
```

## RouteServiceProvider

Il RouteServiceProvider estende `XotBaseRouteServiceProvider` per gestire il routing specifico del modulo.

### Responsabilità

1. Definizione del namespace per i controller
2. Configurazione delle route web e API
3. Applicazione di middleware specifici
4. Gestione del prefisso API
5. Configurazione delle route di autenticazione

### Implementazione

```php
namespace Modules\SaluteMo\Providers;

use Illuminate\Support\Facades\Route;
use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = 'Modules\\SaluteMo\\Http\\Controllers';

    /**
     * The module name for route grouping.
     *
     * @var string
     */
    protected string $moduleName = 'SaluteMo';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The module namespace for controllers.
     *
     * @var string
     */
    protected string $moduleNamespace = 'Modules\\SaluteMo\\Http\\Controllers';
    
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        parent::map();
    }
}
```

## EventServiceProvider

L'EventServiceProvider estende `XotBaseEventServiceProvider` per gestire la registrazione degli eventi e dei listener specifici del modulo.

### Responsabilità

1. Registrazione dei listener per eventi globali
2. Configurazione della scoperta automatica degli eventi
3. Definizione delle directory per la scoperta dei listener
4. Gestione degli abbonati agli eventi (subscribers)

### Implementazione

```php
namespace Modules\SaluteMo\Providers;

use Illuminate\Support\Facades\Event;
use Modules\Xot\Providers\XotBaseEventServiceProvider;

class EventServiceProvider extends XotBaseEventServiceProvider
{
    /**
     * The module name for event discovery.
     *
     * @var string
     */
    protected string $moduleName = 'SaluteMo';

    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // 'Modules\\SaluteMo\\Events\\ExampleEvent' => [
        //     'Modules\\SaluteMo\\Listeners\\ExampleListener',
        // ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array<int, string>
     */
    protected $subscribe = [
        // 'Modules\\SaluteMo\\Listeners\\ExampleEventSubscriber',
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Get the listener directories that should be used to discover events.
     *
     * @return array<int, string>
     */
    protected function discoverEventsWithin(): array
    {
        return [
            app_path('Listeners'),
            module_path($this->moduleName, 'app/Listeners'),
        ];
    }
}
```

## Best Practice

### Linee Guida Generali

1. **Eredita sempre** dalle classi base Xot per garantire coerenza
2. **Mantieni pulito** il service provider principale delegando la logica a classi dedicate
3. **Documenta** tutte le proprietà e i metodi pubblici con PHPDoc
4. **Segui le convenzioni** di denominazione del progetto
5. **Testa** le tue implementazioni
6. **Mantieni leggero** il metodo `register()`
7. **Usa il metodo `boot()`** per la logica che dipende da altri servizi
8. **Evita dipendenze complesse** nei costruttori dei service provider

## Registrazione e Configurazione

### Registrazione dei Provider

Assicurati che tutti i service provider siano registrati nel file `module.json`:

```json
{
    "providers": [
        "Modules\\\\SaluteMo\\\\Providers\\\\SaluteMoServiceProvider",
        "Modules\\\\SaluteMo\\\\Providers\\\\RouteServiceProvider",
        "Modules\\\\SaluteMo\\\\Providers\\\\EventServiceProvider"
    ]
}
```

### Configurazione

#### Autenticazione

Per configurare l'autenticazione, assicurati che il tuo `AuthServiceProvider` estenda `XotBaseAuthServiceProvider`:

```php
namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseAuthServiceProvider;

class AuthServiceProvider extends XotBaseAuthServiceProvider
{
    // Configura le tue policy qui
}
```

#### Middleware

Registra i middleware personalizzati nel `$middleware` o `$middlewareGroups` del tuo `SaluteMoServiceProvider`:

```php
protected $middleware = [
    // 'module.middleware' => \Modules\SaluteMo\Http\Middleware\YourMiddleware::class,
];
```

## Risoluzione dei Problemi

### Service Provider non Registrato

1. Verifica che il service provider sia elencato nel file `module.json`
2. Controlla che il namespace sia corretto
3. Assicurati che il file esista nel percorso specificato
4. Verifica i log di Laravel per eventuali errori di caricamento

### Eventi non Rilevati

Se gli eventi non vengono rilevati, controlla che:

1. La proprietà `$shouldDiscoverEvents` sia impostata su `true`
2. I listener siano nella directory corretta (`app/Listeners` o `Modules/SaluteMo/app/Listeners`)
3. I namespace dei listener siano corretti
4. L'evento sia effettivamente invocato da qualche parte nel codice

### Namespace non Trovato

Verifica che il namespace sia correttamente definito in `composer.json`:

```json
{
    "autoload": {
        "psr-4": {
            "Modules\\\\\\\\SaluteMo\\\\\\\\": ""
        }
    }
}
```

## Test dei Service Provider

Ecco un esempio di test per un service provider:

```php
namespace Tests\Unit\Providers;

use Tests\TestCase;
use Illuminate\Support\Facades\App;

class SaluteMoServiceProviderTest extends TestCase
{
    /** @test */
    public function it_registers_services()
    {
        $this->assertTrue(App::bound('salutemo'));
    }
}
```

## Implementazione del Service Provider

```php
namespace Modules\SaluteMo\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;

class SaluteMoServiceProvider extends XotBaseServiceProvider
{
    use PathNamespace;

    /**
     * Module name for public use
     *
     * @var string
     */
    public string $name = 'SaluteMo';
    
    /**
     * Module name for internal use
     *
     * @var string
     */
    protected string $moduleName = 'SaluteMo';
    
    /**
     * Module name in lowercase
     *
     * @var string
     */
    protected string $moduleNameLower = 'salutemo';
    
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'Modules\SaluteMo\Models\Model' => 'Modules\SaluteMo\Policies\ModelPolicy',
    ];
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        parent::register();
        
        // Register your module's services here
    }
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
        
        // Register your module's components here
    }
    
    // ...
}
```

## RouteServiceProvider

Il RouteServiceProvider estende `XotBaseRouteServiceProvider` per gestire il routing specifico del modulo.

### Responsabilità del Route Provider

1. Definizione del namespace per i controller
2. Configurazione delle route web e API
3. Applicazione di middleware specifici
4. Gestione del prefisso API
5. Configurazione delle route di autenticazione

### Implementazione del Route Provider

```php
namespace Modules\SaluteMo\Providers;

use Illuminate\Support\Facades\Route;
use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = 'Modules\\SaluteMo\\Http\\Controllers';

    /**
     * The module name for route grouping.
     *
     * @var string
     */
    protected string $moduleName = 'SaluteMo';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The module namespace for controllers.
     *
     * @var string
     */
    protected string $moduleNamespace = 'Modules\\SaluteMo\\Http\\Controllers';
    
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        parent::map();
        
        // Register your custom route files here
        // $this->mapCustomRoutes();
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        parent::register();
        
        // Register route model bindings, etc.
    }
    
    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        parent::configureRateLimiting();
        
        // Configure rate limiting for your module
    }
```

## EventServiceProvider

L'EventServiceProvider gestisce gli eventi e i listener del modulo.

### Responsabilità

1. Registrazione di eventi
2. Collegamento di eventi a listener
3. Configurazione di subscriber

### Implementazione

```php
namespace Modules\SaluteMo\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // Eventi e listener...
    ];
    
    // ...
}
```

## Best Practice

### Provider Modulari

Ogni provider dovrebbe avere una responsabilità ben definita. Se un provider diventa troppo complesso, considerare di dividerlo in più provider specializzati.

### Lazy Loading

Utilizzare il lazy loading quando possibile per migliorare le prestazioni:

```php
protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }
```

### Caching

Evitare operazioni costose nel metodo `register()`. Utilizzare `boot()` per operazioni che richiedono che tutti i servizi siano già registrati.

## Collegamenti Correlati

- [Struttura del Modulo](../structure/namespace-conventions.md)
- [Configurazione](../configuration.md)
- [Route](../routes/api-routes.md)
