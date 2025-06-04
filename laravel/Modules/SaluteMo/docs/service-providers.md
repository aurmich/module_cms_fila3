# Service Providers Architecture

## Overview

Service providers in the SaluteMo module follow a strict inheritance pattern to ensure consistency and maintainability across the application. This document outlines the architecture and requirements for service providers.

## Base Provider Pattern

All service providers must extend their corresponding Xot base provider:

| Provider Type | Base Class | Purpose |
|--------------|------------|---------|
| Module Service Provider | `XotBaseServiceProvider` | Main module bootstrap |
| Event Service Provider | `XotBaseEventServiceProvider` | Event and listener registration |
| Route Service Provider | `XotBaseRouteServiceProvider` | Route definitions and bindings |

## Implementation Requirements

### 1. Module Service Provider

```php
namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class SaluteMoServiceProvider extends XotBaseServiceProvider
{
    // Implementation...
}
```

### 2. Event Service Provider

```php
namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseEventServiceProvider;

class EventServiceProvider extends XotBaseEventServiceProvider
{
    protected $listen = [
        // Event => [Listener1::class, Listener2::class]
    ];
}
```

### 3. Route Service Provider

```php
namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    protected $namespace = 'Modules\\SaluteMo\\Http\\Controllers';
    
    public function boot()
    {
        parent::boot();
    }
}
```

## Registration in module.json

Ensure all providers are registered in `module.json`:

```json
{
    "providers": [
        "Modules\\SaluteMo\\Providers\\SaluteMoServiceProvider",
        "Modules\\SaluteMo\\Providers\\EventServiceProvider",
        "Modules\\SaluteMo\\Providers\\RouteServiceProvider"
    ]
}
```

## Best Practices

1. **Consistent Namespacing**
   - Keep providers in the `Modules\{ModuleName}\Providers` namespace
   - Follow PSR-4 autoloading standards

2. **Minimal Overrides**
   - Only override methods when absolutely necessary
   - Call parent implementations when overriding

3. **Documentation**
   - Document all custom event listeners and route bindings
   - Keep PHPDoc blocks up to date

## Common Issues

1. **Provider Not Found**
   - Check namespace and class name in `module.json`
   - Verify file location matches namespace

2. **Method Not Found**
   - Ensure you're extending the correct base class
   - Check method signatures match parent class

3. **Service Not Registered**
   - Verify provider is registered in `module.json`
   - Check for typos in the provider class name

## Related Documentation

- [Laravel Service Providers](https://laravel.com/docs/providers)
- [Module Configuration](module-configuration.md)
- [Event System](events.md)
- [Routing](routing.md)
