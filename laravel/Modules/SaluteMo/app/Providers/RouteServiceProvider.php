<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

/**
 * Route service provider per il modulo SaluteMo.
 *
 * Estende XotBaseRouteServiceProvider per garantire:
 * - Centralizzazione di namespace, middleware, prefix
 * - Override solo per logica realmente custom
 * - Coerenza, DRY, refactoring sicuro
 *
 * Politica: "Non avrai altro provider all'infuori di XotBase..."
 *
 * ATTENZIONE: Non dichiarare mai la proprietà $namespace (deprecata e vietata in Laravel 12+).
 * Se serve, usa $moduleNamespace (protetta), ma normalmente la base lo deduce.
 */
class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    /**
     * Module name for route registration and error messages.
     *
     * @var string
     */
    public string $name = 'SaluteMo';

    /**
     * The module's controller namespace.
     * Override the base namespace from XotBaseRouteServiceProvider.
     *
     * @var string
     */
    protected string $moduleNamespace = 'Modules\\SaluteMo\\Http\\Controllers';

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

        // Register any route model bindings or patterns here
        // Example:
        // Route::pattern('id', '[0-9]+');
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
