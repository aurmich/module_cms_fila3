# Estensione delle Classi XotBase nei Provider

## Regola Fondamentale

**IMPORTANTE**: Tutti i Service Provider nel modulo SaluteMo DEVONO estendere le loro controparti XotBase, NON le classi Laravel native.

## Mappatura dei Provider

| Provider Laravel | Provider XotBase da Estendere |
|-----------------|----------------------------|
| `Illuminate\Support\ServiceProvider` | `Modules\Xot\Providers\XotBaseServiceProvider` |
| `Illuminate\Foundation\Support\Providers\RouteServiceProvider` | `Modules\Xot\Providers\XotBaseRouteServiceProvider` |
| `Illuminate\Foundation\Support\Providers\EventServiceProvider` | `Modules\Xot\Providers\XotBaseEventServiceProvider` |
| `Illuminate\Foundation\Support\Providers\AuthServiceProvider` | `Modules\Xot\Providers\XotBaseAuthServiceProvider` |

## Problemi Identificati in SaluteMo

### `SaluteMoServiceProvider.php`

#### Implementazione Attuale (Errata)
```php
namespace Modules\SaluteMo\Providers;

use Illuminate\Support\ServiceProvider;

class SaluteMoServiceProvider extends ServiceProvider
```

#### Implementazione Corretta
```php
namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class SaluteMoServiceProvider extends XotBaseServiceProvider
```

### Possibili Altri Provider con Lo Stesso Problema

Verificare anche:
- `RouteServiceProvider.php`
- `EventServiceProvider.php`

## Motivazioni per l'Utilizzo dei Provider XotBase

1. **Funzionalità Estese**: I provider XotBase offrono funzionalità aggiuntive specifiche per il progetto
2. **Coerenza**: Mantiene uniformità in tutto il progetto
3. **Gestione Centralizzata**: Permette modifiche a livello di sistema tramite le classi base
4. **Compatibilità**: Garantisce compatibilità con altri moduli del sistema

## Implementazione Corretta del Provider Principale

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class SaluteMoServiceProvider extends XotBaseServiceProvider
{
    protected string $moduleName = 'SaluteMo';
    protected string $moduleNameLower = 'salutemo';
    
    /**
     * Register services.
     */
    public function register(): void
    {
        parent::register();
        // Registrazioni specifiche del modulo...
    }
    
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        parent::boot();
        // Inizializzazioni specifiche del modulo...
    }
}
```

## Implementazione Corretta di RouteServiceProvider

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    protected string $moduleNamespace = 'Modules\SaluteMo\Http\Controllers';
    protected string $moduleName = 'SaluteMo';
    
    // Altri metodi...
}
```

## Implementazione Corretta di EventServiceProvider

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseEventServiceProvider;

class EventServiceProvider extends XotBaseEventServiceProvider
{
    protected $listen = [
        // Eventi e listener...
    ];
    
    // Altri metodi...
}
```

## Collegamenti Correlati
- [Problemi Strutturali](../issues/structural-problems.md)
- [Convenzioni dei Namespace](../structure/namespace-conventions.md)
- [Service Provider](./service-provider.md)
