<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'FormBuilder';
    protected string $moduleNamespace = 'Modules\\FormBuilder\\Http\\Controllers';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
    }

    public function map(): void
    {
        parent::map();
    }
}
