# Provider Patterns - FormBuilder Module

## Data: 2025-07-29

## Panoramica

Questo documento definisce i pattern corretti per l'implementazione dei service provider nel modulo FormBuilder, basandosi sull'analisi comparativa con altri moduli del progetto e le convenzioni Laraxot.

## Analisi Comparativa Provider

### 1. EventServiceProvider Pattern

#### Pattern Corretto (SaluteMo - Riferimento)
```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Providers;

use Illuminate\Support\Facades\Event;
use Modules\Xot\Providers\XotBaseEventServiceProvider;

/**
 * Event service provider for the SaluteMo module.
 *
 * This class manages event discovery and registration for the SaluteMo module.
 * It extends XotBaseEventServiceProvider to inherit common event handling functionality.
 *
 * @package Modules\SaluteMo\Providers
 */
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
        // Example:
        // 'Modules\SaluteMo\Events\ExampleEvent' => [
        //     'Modules\SaluteMo\Listeners\ExampleListener',
        // ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array<int, string>
     */
    protected $subscribe = [
        // 'Modules\SaluteMo\Listeners\ExampleEventSubscriber',
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

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        // Register any manual event listeners here
        // Event::listen('event.name', function ($foo, $bar) {
        //     //
        // });
    }
}
```

#### Pattern Alternativo (Cms - Semplificato)
```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;

class EventServiceProvider extends BaseEventServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void
    {
    }
}
```

#### Problemi FormBuilder Attuale
1. **Proprietà non standard**: `public string $name`, `public string $nameLower`
2. **Proprietà ridondanti**: `protected string $module_dir`, `protected string $module_ns`
3. **Metodi non necessari**: `registerFormBuilderEvents()`
4. **Documentazione eccessiva**: PHPDoc troppo dettagliato per pattern standard

### 2. FormBuilderServiceProvider Pattern

#### Pattern Corretto (Già Implementato)
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

/**
 * FormBuilderServiceProvider for the FormBuilder module.
 *
 * Handles module registration, configuration, and service bindings.
 * Extends XotBaseServiceProvider to inherit standard Laraxot behaviors.
 *
 * @package Modules\FormBuilder\Providers
 */
class FormBuilderServiceProvider extends XotBaseServiceProvider
{
    /**
     * The module name.
     *
     * @var string
     */
    public string $name = 'FormBuilder';

    /**
     * The module directory.
     *
     * @var string
     */
    protected string $module_dir = __DIR__;

    /**
     * The module namespace.
     *
     * @var string
     */
    protected string $module_ns = __NAMESPACE__;

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        parent::boot();

        // Add any FormBuilder-specific boot logic here
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();

        // Register FormBuilder-specific providers
        $this->app->register(\Modules\FormBuilder\Providers\Filament\AdminPanelProvider::class);

        // Register FormBuilder-specific services
    }
}
```

**Status**: ✅ CORRETTO - Già conforme alle convenzioni

### 3. RouteServiceProvider Pattern

#### Pattern Corretto (Già Implementato)
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

/**
 * Route service provider for the FormBuilder module.
 *
 * Extends XotBaseRouteServiceProvider to inherit standard Laraxot behaviors
 * for route registration, middleware handling, and namespace management.
 * Provides centralized route configuration following project conventions.
 *
 * @package Modules\FormBuilder\Providers
 */
class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    /**
     * Module name for route registration and error messages.
     *
     * @var string
     */
    public string $name = 'FormBuilder';

    /**
     * The module's controller namespace.
     * Override the base namespace from XotBaseRouteServiceProvider.
     *
     * @var string
     */
    protected string $moduleNamespace = 'Modules\\FormBuilder\\Http\\Controllers';

    /**
     * Module directory path.
     *
     * @var string
     */
    protected string $module_dir = __DIR__;

    /**
     * Module PHP namespace.
     *
     * @var string
     */
    protected string $module_ns = __NAMESPACE__;

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Register any FormBuilder-specific route model bindings or patterns here
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        parent::map();

        // Add any custom FormBuilder route registrations here
    }
}
```

**Status**: ✅ CORRETTO - Già conforme alle convenzioni

## Convenzioni Identificate

### 1. Estensione Classi Base

#### ✅ SEMPRE Estendere:
- **EventServiceProvider**: `XotBaseEventServiceProvider` (preferito) o `BaseEventServiceProvider` (semplificato)
- **ServiceProvider**: `XotBaseServiceProvider`
- **RouteServiceProvider**: `XotBaseRouteServiceProvider`

#### ❌ MAI Estendere:
- `Illuminate\Support\ServiceProvider` direttamente
- `Illuminate\Foundation\Support\Providers\RouteServiceProvider` direttamente
- `Illuminate\Foundation\Support\Providers\EventServiceProvider` direttamente

### 2. Proprietà Standard

#### EventServiceProvider
```php
// ✅ CORRETTO (Pattern XotBase)
protected string $moduleName = 'ModuleName';
protected $listen = [];
protected $subscribe = [];
protected static $shouldDiscoverEvents = true;

// ❌ ERRATO (FormBuilder attuale)
public string $name = 'ModuleName';
public string $nameLower = 'modulename';
protected string $module_dir = __DIR__;
protected string $module_ns = __NAMESPACE__;
```

#### ServiceProvider
```php
// ✅ CORRETTO
public string $name = 'ModuleName';
protected string $module_dir = __DIR__;
protected string $module_ns = __NAMESPACE__;
```

#### RouteServiceProvider
```php
// ✅ CORRETTO
public string $name = 'ModuleName';
protected string $moduleNamespace = 'Modules\\ModuleName\\Http\\Controllers';
protected string $module_dir = __DIR__;
protected string $module_ns = __NAMESPACE__;
```

### 3. Metodi Standard

#### EventServiceProvider
```php
// ✅ SEMPRE Implementare
public function boot(): void
{
    parent::boot();
    // Logica specifica del modulo
}

// ✅ OPZIONALE (solo se necessario)
protected function discoverEventsWithin(): array
{
    return [
        app_path('Listeners'),
        module_path($this->moduleName, 'app/Listeners'),
    ];
}

// ❌ NON Implementare metodi custom non necessari
```

### 4. Documentazione PHPDoc

#### ✅ CORRETTO
```php
/**
 * Event service provider for the ModuleName module.
 *
 * This class manages event discovery and registration for the ModuleName module.
 * It extends XotBaseEventServiceProvider to inherit common event handling functionality.
 *
 * @package Modules\ModuleName\Providers
 */
```

#### ❌ ECCESSIVO
```php
/**
 * Event Service Provider per il modulo FormBuilder.
 *
 * Estende XotBaseEventServiceProvider per ereditare tutte le funzionalità standard
 * e configurazioni comuni del framework Laraxot.
 * 
 * Responsabilità:
 * - Registrazione eventi e listener del modulo
 * - Gestione subscriber per eventi complessi
 * - Integrazione con sistemi di logging
 * - Gestione automatica delle dipendenze
 */
```

## Correzioni Necessarie FormBuilder

### EventServiceProvider
1. **Rimuovere proprietà non standard**:
   - `public string $name`
   - `public string $nameLower`
   - `protected string $module_dir`
   - `protected string $module_ns`

2. **Aggiungere proprietà standard**:
   - `protected string $moduleName = 'FormBuilder';`
   - `protected static $shouldDiscoverEvents = true;`

3. **Rimuovere metodi non necessari**:
   - `registerFormBuilderEvents()`

4. **Semplificare documentazione**:
   - Usare pattern standard come SaluteMo

5. **Aggiungere metodo discovery** (opzionale):
   - `discoverEventsWithin()`

### FormBuilderServiceProvider
**Status**: ✅ GIÀ CORRETTO - Nessuna modifica necessaria

### RouteServiceProvider
**Status**: ✅ GIÀ CORRETTO - Nessuna modifica necessaria

## Best Practices

### 1. Semplicità
- Utilizzare solo le proprietà e metodi necessari
- Non aggiungere logica custom se non strettamente necessaria
- Seguire i pattern degli altri moduli

### 2. Coerenza
- Utilizzare gli stessi nomi di proprietà tra moduli
- Seguire le stesse convenzioni di documentazione
- Mantenere la stessa struttura di base

### 3. Estensibilità
- Chiamare sempre `parent::boot()` e `parent::register()`
- Aggiungere logica specifica dopo le chiamate parent
- Documentare eventuali personalizzazioni

### 4. Tipizzazione
- Utilizzare sempre `declare(strict_types=1);`
- Specificare tipi per tutte le proprietà e metodi
- Utilizzare PHPDoc completi ma non eccessivi

## Template di Implementazione

### EventServiceProvider Template
```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Providers;

use Modules\Xot\Providers\XotBaseEventServiceProvider;

/**
 * Event service provider for the {ModuleName} module.
 *
 * This class manages event discovery and registration for the {ModuleName} module.
 * It extends XotBaseEventServiceProvider to inherit common event handling functionality.
 *
 * @package Modules\{ModuleName}\Providers
 */
class EventServiceProvider extends XotBaseEventServiceProvider
{
    /**
     * The module name for event discovery.
     *
     * @var string
     */
    protected string $moduleName = '{ModuleName}';

    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Example:
        // 'Modules\{ModuleName}\Events\ExampleEvent' => [
        //     'Modules\{ModuleName}\Listeners\ExampleListener',
        // ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array<int, string>
     */
    protected $subscribe = [
        // 'Modules\{ModuleName}\Listeners\ExampleEventSubscriber',
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

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        // Register any manual event listeners here
        // Event::listen('event.name', function ($foo, $bar) {
        //     //
        // });
    }
}
```

## Validazione e Testing

### Checklist Pre-Implementazione
- [ ] Analizzare pattern di altri moduli
- [ ] Identificare proprietà e metodi standard
- [ ] Verificare estensione classi base corrette
- [ ] Documentare differenze e motivazioni
- [ ] Creare template di implementazione

### Checklist Post-Implementazione
- [ ] Verificare che tutti i provider estendano le classi base corrette
- [ ] Controllare che le proprietà seguano le convenzioni
- [ ] Testare che i provider si registrino correttamente
- [ ] Validare con PHPStan livello 9+
- [ ] Aggiornare documentazione

## Collegamenti

- [Providers Overview](../providers.md) - Panoramica completa dei service provider
- [Module Manifest](../module-manifest.md) - Configurazione manifest del modulo
- [Architecture Overview](../architecture.md) - Architettura generale del modulo

## Aggiornamenti

- **2025-07-29**: Creazione documentazione pattern provider
- **2025-07-29**: Analisi comparativa con altri moduli
- **2025-07-29**: Identificazione correzioni necessarie per EventServiceProvider
