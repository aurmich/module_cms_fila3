# Architettura del Modulo CMS

Questo documento descrive l'architettura e i principi di design del modulo CMS.

## Struttura del Modulo

```
laravel/Modules/Cms/
├── app/
│   ├── Actions/         # Azioni riutilizzabili
│   ├── Blocks/         # Blocchi di contenuto
│   ├── Console/        # Comandi artisan
│   ├── Contracts/      # Interfacce
│   ├── Events/         # Eventi
│   ├── Exceptions/     # Eccezioni personalizzate
│   ├── Facades/        # Facades
│   ├── Filament/       # Componenti Filament
│   ├── Http/           # Controllers e Middleware
│   ├── Listeners/      # Listener degli eventi
│   ├── Models/         # Modelli Eloquent
│   ├── Notifications/  # Notifiche
│   ├── Policies/       # Policies
│   ├── Providers/      # Service Providers
│   ├── Services/       # Servizi
│   └── Support/        # Classi di supporto
├── config/            # Configurazioni
├── database/
│   ├── factories/     # Model Factories
│   ├── migrations/    # Migrazioni
│   └── seeders/      # Seeders
├── lang/             # Traduzioni
├── resources/
│   ├── js/           # Asset JavaScript
│   ├── css/          # Asset CSS
│   └── views/        # Views Blade
├── routes/           # Route
└── tests/            # Test
```

## Principi di Design

### Domain-Driven Design

Il modulo segue i principi del DDD:

- **Entities**: Modelli di dominio (`app/Models`)
- **Value Objects**: Oggetti immutabili (`app/ValueObjects`)
- **Services**: Logica di business (`app/Services`)
- **Repositories**: Accesso ai dati (`app/Repositories`)
- **Events**: Eventi di dominio (`app/Events`)

### SOLID

- **Single Responsibility**: Ogni classe ha una sola responsabilità
- **Open/Closed**: Estensibile senza modificare il codice esistente
- **Liskov Substitution**: Sottoclassi sostituibili alle classi base
- **Interface Segregation**: Interfacce specifiche per i client
- **Dependency Inversion**: Dipendenze verso le astrazioni

## Componenti Principali

### Models

```php
namespace Modules\Cms\Models;

class Page extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
    ];
    
    protected $casts = [
        'published_at' => 'datetime',
        'metadata' => 'array',
    ];
}
```

### Services

```php
namespace Modules\Cms\Services;

class PageService
{
    public function create(array $data): Page
    {
        return DB::transaction(function () use ($data) {
            $page = Page::create($data);
            event(new PageCreated($page));
            return $page;
        });
    }
}
```

### Actions

```php
namespace Modules\Cms\Actions;

class PublishPage
{
    public function execute(Page $page): void
    {
        $page->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
        
        event(new PagePublished($page));
    }
}
```

### Controllers

```php
namespace Modules\Cms\Http\Controllers;

class PageController extends Controller
{
    public function __construct(
        private PageService $service
    ) {}
    
    public function store(StorePageRequest $request)
    {
        $page = $this->service->create(
            $request->validated()
        );
        
        return new PageResource($page);
    }
}
```

## Flusso dei Dati

1. Request → Controller
2. Controller → Service
3. Service → Model/Repository
4. Service → Events
5. Events → Listeners
6. Response → Client

## Estensibilità

### Eventi

```php
// Pubblicare un evento
event(new PageCreated($page));

// Ascoltare un evento
class NotifyAdmins
{
    public function handle(PageCreated $event)
    {
        // Logica di notifica
    }
}
```

### Service Provider

```php
namespace Modules\Cms\Providers;

class CmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            PageRepositoryInterface::class,
            PageRepository::class
        );
    }
}
```

### Middleware

```php
namespace Modules\Cms\Http\Middleware;

class CheckPagePermission
{
    public function handle($request, Closure $next)
    {
        if (!$request->user()->can('view', $request->page)) {
            abort(403);
        }
        
        return $next($request);
    }
}
```

## Testing

### Unit Tests

```php
namespace Modules\Cms\Tests\Unit;

class PageTest extends TestCase
{
    /** @test */
    public function it_can_be_published()
    {
        $page = Page::factory()->create();
        
        $page->publish();
        
        $this->assertTrue($page->isPublished());
    }
}
```

### Feature Tests

```php
namespace Modules\Cms\Tests\Feature;

class PageControllerTest extends TestCase
{
    /** @test */
    public function it_can_create_a_page()
    {
        $response = $this->postJson('/api/pages', [
            'title' => 'Test Page',
            'content' => 'Content',
        ]);
        
        $response->assertCreated();
    }
}
```

## Collegamenti

- [Configurazione](configuration.md)
- [API](api.md)
- [Eventi](events.md)
- [Testing](testing.md)

## Collegamenti Bidirezionali
- [README](README.md) - Documentazione principale del modulo
- [Struttura](structure.md) - Struttura dettagliata del modulo
- [Linee Guida](module-guidelines.md) - Convenzioni e standard
- [Content Management](content-management.md) - Gestione dei contenuti
- [Filament](filament-integration.md) - Integrazione con Filament
- [Testing](testing.md) - Strategie di testing
- [Configurazione](configuration.md) - Configurazione del modulo

## Vedi Anche
- [Modulo Xot](../Xot/docs/README.md) - Classi base e utilities
- [Modulo UI](../UI/docs/README.md) - Componenti di interfaccia
- [Modulo Theme](../Theme/docs/README.md) - Gestione temi
- [Documentazione Laravel](https://laravel.com/docs) - Documentazione ufficiale
- [Best Practices](https://laravel.com/docs/11.x/best-practices) - Best practices Laravel
- [DDD in Laravel](https://laravel-news.com/domain-driven-design-laravel) - Approccio DDD
- [Testing](testing.md) 

## Collegamenti tra versioni di architecture.md
* [architecture.md](docs/tecnico/filament/architecture.md)
* [architecture.md](docs/rules/architecture.md)
* [architecture.md](laravel/Modules/Gdpr/docs/architecture.md)
* [architecture.md](laravel/Modules/Cms/docs/frontoffice/architecture.md)
* [architecture.md](laravel/Modules/Cms/docs/architecture.md)
* [architecture.md](laravel/Themes/One/docs/roadmap/inspiration/architecture.md)

