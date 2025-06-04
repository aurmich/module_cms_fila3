# Service Provider Documentation

## Base Service Provider

### Critical Implementation Detail

The `SaluteMoServiceProvider` **must** extend `XotBaseServiceProvider` instead of the default Laravel `ServiceProvider`. This is a fundamental architectural requirement in the project.

**Correct Implementation:**

```php
<?php

namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class SaluteMoServiceProvider extends XotBaseServiceProvider
{
    // Implementation...
}
```

**Incorrect Implementation (to avoid):**

```php
use Illuminate\Support\ServiceProvider;

class SaluteMoServiceProvider extends ServiceProvider
{
    // This is incorrect for this project
}
```

## Why This Matters

1. **Consistency**: All modules in the project follow this pattern for consistency
2. **Base Functionality**: `XotBaseServiceProvider` provides essential functionality used across the application
3. **Dependency Management**: Ensures proper loading order and dependency resolution
4. **Module Integration**: Required for proper module discovery and bootstrapping

## Required Methods

When extending `XotBaseServiceProvider`, ensure these methods are properly implemented:

1. `register()` - Register bindings in the container
2. `boot()` - Bootstrap any application services
3. `registerTranslations()` - Register module translations
4. `registerConfig()` - Register module configuration

## Best Practices

1. **Service Registration**
   - Register all services in the `register()` method
   - Use the container bindings for better testability

2. **Boot Process**
   - Perform bootstrapping in the `boot()` method
   - Use `parent::boot()` to ensure parent boot methods are called

3. **Deferred Loading**
   - Implement `provides()` for deferred providers
   - Register only what's necessary during each request

## Common Issues

1. **Service Not Found**
   - Ensure the provider is registered in `config/app.php`
   - Check for typos in service names

2. **Missing Dependencies**
   - All dependencies should be type-hinted in the constructor
   - Use the service container for complex dependencies

3. **Boot Order Issues**
   - Be mindful of service provider boot order
   - Use `afterResolving` for services that depend on others

## Testing

Test your service provider by:

1. Verifying services are registered
2. Checking that bindings work as expected
3. Ensuring boot methods don't throw errors

Example test:

```php
public function test_service_provider_boots()
{
    $this->assertTrue($this->app->bound('salutemo'));
}
```

## Deployment Considerations

1. **Cache Clearing**
   - Clear configuration cache after deployment
   - Clear route cache if routes are registered in the provider

2. **Environment**
   - Test in all environments
   - Handle environment-specific configurations properly

3. **Performance**
   - Keep the provider lean
   - Defer registration when possible
