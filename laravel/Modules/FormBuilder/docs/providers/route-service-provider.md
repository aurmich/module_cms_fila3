# RouteServiceProvider Implementation Rules

## Principi Fondamentali

Nel framework Laraxot, **MAI** estendere direttamente `Illuminate\Foundation\Support\Providers\RouteServiceProvider`. Tutti i moduli devono estendere `Modules\Xot\Providers\XotBaseRouteServiceProvider`.

## Filosofia e Motivazione

- **Filosofia**: "Un solo punto di verità per la gestione delle route"
- **Politica**: "Non avrai altro provider all'infuori di XotBase"
- **Religione**: "La centralizzazione porta alla serenità del codice"
- **Zen**: "Semplicità nel routing, potenza nell'estensibilità"

## Struttura Corretta

### ✅ Pattern Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

/**
 * Route service provider per il modulo FormBuilder.
 *
 * Estende XotBaseRouteServiceProvider per garantire:
 * - Centralizzazione di namespace, middleware, prefix
 * - Override solo per logica realmente custom
 * - Coerenza, DRY, refactoring sicuro
 */
class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    /**
     * Module name for route registration and error messages.
     * OBBLIGATORIO per XotBaseRouteServiceProvider.
     */
    public string $name = 'FormBuilder';

    /**
     * The module's controller namespace.
     */
    protected string $moduleNamespace = 'Modules\\FormBuilder\\Http\\Controllers';

    /**
     * Module directory path.
     */
    protected string $module_dir = __DIR__;

    /**
     * Module PHP namespace.
     */
    protected string $module_ns = __NAMESPACE__;

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Register any route model bindings or patterns here
        // Example:
        // Route::pattern('id', '[0-9]+');
        // Route::model('form', Form::class);
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        parent::map();

        // Add any custom route registrations here
        // Example:
        // $this->mapCustomRoutes();
    }
}
```

### ❌ Anti-Pattern (da evitare)

```php
<?php

// ❌ MAI estendere direttamente RouteServiceProvider
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class RouteServiceProvider extends RouteServiceProvider
{
    // Questo approccio è VIETATO nel framework Laraxot
}
```

## Proprietà Obbligatorie

### `public string $name`

- **OBBLIGATORIA** per XotBaseRouteServiceProvider
- Deve corrispondere esattamente al nome della cartella del modulo
- Utilizzata per registrazione route e messaggi di errore

### `protected string $moduleNamespace`

- Namespace dei controller del modulo
- Override del namespace base da XotBaseRouteServiceProvider
- Formato: `'Modules\\{ModuleName}\\Http\\Controllers'`

### `protected string $module_dir`

- Path della directory del modulo
- Sempre impostato a `__DIR__`

### `protected string $module_ns`

- Namespace PHP del modulo
- Sempre impostato a `__NAMESPACE__`

## Funzionalità Ereditate da XotBaseRouteServiceProvider

### Gestione Automatica delle Route

- **Web Routes**: Automaticamente caricate da `routes/web.php`
- **API Routes**: Automaticamente caricate da `routes/api.php`
- **Middleware**: Applicazione automatica di middleware `web` e `api`
- **Namespace**: Risoluzione automatica del namespace dei controller

### Configurazione Database Dinamica

- Supporto per configurazione database dinamica tramite `extra_conn`
- Gestione automatica di segmenti URL per multi-tenancy

### Validazione e Error Handling

- Validazione automatica della proprietà `$name`
- Notifiche Filament per errori di configurazione
- Exception per configurazioni mancanti

## Best Practices

### 1. Chiamare Sempre i Metodi Parent

```php
public function boot(): void
{
    parent::boot(); // SEMPRE chiamare il parent

    // Aggiungere logica custom qui
}

public function map(): void
{
    parent::map(); // SEMPRE chiamare il parent

    // Aggiungere route custom qui
}
```

### 2. Route Model Binding

```php
public function boot(): void
{
    parent::boot();

    // Esempi di route model binding
    Route::pattern('id', '[0-9]+');
    Route::model('form', \Modules\FormBuilder\Models\Form::class);
    Route::model('field', \Modules\FormBuilder\Models\FormField::class);
}
```

### 3. Route Custom

```php
public function map(): void
{
    parent::map();

    // Aggiungere route custom se necessario
    $this->mapFormBuilderApiRoutes();
    $this->mapFormBuilderWebRoutes();
}

protected function mapFormBuilderApiRoutes(): void
{
    Route::prefix('api/form-builder')
        ->middleware('api')
        ->namespace($this->moduleNamespace)
        ->group($this->module_dir.'/../../routes/form-builder-api.php');
}
```

## Errori Comuni e Soluzioni

### Errore: "name is empty"

**Causa**: Proprietà `$name` non impostata o vuota

**Soluzione**:

```php
public string $name = 'FormBuilder'; // Nome del modulo
```

### Errore: Route non trovate

**Causa**: Namespace controller non corretto

**Soluzione**:

```php
protected string $moduleNamespace = 'Modules\\FormBuilder\\Http\\Controllers';
```

### Errore: File route non trovati

**Causa**: Path `$module_dir` non corretto

**Soluzione**:

```php
protected string $module_dir = __DIR__; // Path corretto
```

## Vantaggi dell'Approccio Centralizzato

### 1. DRY (Don't Repeat Yourself)

- Logica di routing centralizzata
- Nessuna duplicazione di codice tra moduli
- Configurazione standard per tutti i moduli

### 2. Manutenibilità

- Modifiche alla logica di routing in un solo punto
- Aggiornamenti automatici per tutti i moduli
- Refactoring sicuro e controllato

### 3. Coerenza

- Comportamento uniforme tra tutti i moduli
- Standard di naming e configurazione
- Pattern di sviluppo consolidati

### 4. Estensibilità

- Possibilità di override per logica custom
- Mantenimento della compatibilità
- Evoluzione controllata del framework

## Documentazione Correlata

- [XotBaseRouteServiceProvider Source](/var/www/html/_bases/base_saluteora/laravel/Modules/Xot/app/Providers/XotBaseRouteServiceProvider.php)
- [Esempi SaluteOra](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/app/Providers/RouteServiceProvider.php)
- [Esempi SaluteMo](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteMo/app/Providers/RouteServiceProvider.php)

## Note Importanti

- **Laravel 12+**: La proprietà `$namespace` è deprecata e vietata
- **Multi-tenancy**: Supporto automatico tramite configurazione `extra_conn`
- **Performance**: Caricamento ottimizzato delle route
- **Security**: Validazione automatica dei parametri

*Ultimo aggiornamento: Luglio 2025*
