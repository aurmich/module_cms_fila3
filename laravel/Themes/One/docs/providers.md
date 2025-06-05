# Provider del Tema

## Struttura

### 1. ThemeServiceProvider

```php
namespace Themes\One\Providers;

class ThemeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerConfig();
        $this->registerViews();
        $this->registerComponents();
    }

    public function boot()
    {
        $this->bootViews();
        $this->bootComponents();
        $this->bootAssets();
    }
}
```

### 2. ViewServiceProvider

Gestisce il caricamento e la configurazione delle view:

```php
namespace Themes\One\Providers;

class ViewServiceProvider extends ServiceProvider
{
    protected $views = [
        'layouts' => [
            'app',
            'guest',
        ],
        'components' => [
            'blocks/*',
            'forms/*',
        ]
    ];

    public function register()
    {
        $this->loadViewsFrom($this->getViewsPath(), 'theme');
    }
}
```

### 3. ComponentServiceProvider

Registra i componenti Blade:

```php
namespace Themes\One\Providers;

class ComponentServiceProvider extends ServiceProvider
{
    protected $components = [
        // Blocchi Base
        'blocks.hero.simple' => Components\Blocks\Hero\Simple::class,
        'blocks.feature_sections.v1' => Components\Blocks\FeatureSections\V1::class,
        'blocks.stats.v1' => Components\Blocks\Stats\V1::class,
        'blocks.cta.v1' => Components\Blocks\Cta\V1::class,
        
        // Form Components
        'forms.input' => Components\Forms\Input::class,
        'forms.select' => Components\Forms\Select::class,
    ];

    public function register()
    {
        $this->registerComponents();
    }
}
```

## Configurazione

### 1. Config Files

```php
// config/theme.php
return [
    'name' => 'One',
    'namespace' => 'Themes\\One',
    'path' => base_path('Themes/One'),
    
    'providers' => [
        ThemeServiceProvider::class,
        ViewServiceProvider::class,
        ComponentServiceProvider::class,
    ],
    
    'components' => [
        'prefix' => '',
        'namespace' => 'Themes\\One\\Components',
    ],
    
    'views' => [
        'paths' => [
            resource_path('views/vendor/one'),
            resource_path('views'),
        ],
    ],
];
```

## Asset Management

### 1. Asset Provider

```php
namespace Themes\One\Providers;

class AssetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/css' => public_path('themes/one/css'),
            __DIR__.'/../resources/js' => public_path('themes/one/js'),
            __DIR__.'/../resources/img' => public_path('themes/one/img'),
        ], 'theme-assets');
    }
}
```

## View Composers

### 1. Layout Composer

```php
namespace Themes\One\View\Composers;

class LayoutComposer
{
    public function compose(View $view)
    {
        $view->with([
            'theme' => [
                'name' => config('theme.name'),
                'assets' => [
                    'css' => ['/themes/one/css/app.css'],
                    'js' => ['/themes/one/js/app.js'],
                ],
            ],
        ]);
    }
}
```

## Eventi

### 1. Eventi del Tema

```php
namespace Themes\One\Events;

class ThemeBooted
{
    public $theme;
    
    public function __construct($theme)
    {
        $this->theme = $theme;
    }
}
```

## Middleware

### 1. Theme Middleware

```php
namespace Themes\One\Http\Middleware;

class ThemeMiddleware
{
    public function handle($request, Closure $next)
    {
        // Logica del tema
        return $next($request);
    }
}
```

## Best Practices

### 1. Registrazione Provider
- Registrare i provider nell'ordine corretto
- Evitare dipendenze circolari
- Utilizzare il metodo `defer` quando possibile

### 2. Caricamento Views
- Utilizzare namespace per le view
- Supportare l'override delle view
- Mantenere una struttura coerente

### 3. Gestione Asset
- Utilizzare Vite per la compilazione
- Implementare versioning degli asset
- Ottimizzare il caricamento

### 4. Componenti
- Registrare i componenti con namespace
- Utilizzare autoloading
- Supportare personalizzazione

## Testing

### 1. Provider Tests

```php
namespace Tests\Themes\One\Providers;

class ThemeServiceProviderTest extends TestCase
{
    /** @test */
    public function it_registers_components()
    {
        $this->assertTrue(
            Blade::getClassComponentAliases()
            ->has('blocks.hero.simple')
        );
    }
}
```

### 2. View Tests

```php
namespace Tests\Themes\One\Views;

class ViewTest extends TestCase
{
    /** @test */
    public function it_loads_theme_views()
    {
        $this->assertViewExists('theme::layouts.app');
    }
}
``` 
