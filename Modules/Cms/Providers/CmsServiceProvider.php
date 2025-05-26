<?php

declare(strict_types=1);

namespace Modules\Cms\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class CmsServiceProvider extends ServiceProvider
{
    public string $name = 'Cms';

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'pub_theme');

        Blade::componentNamespace('Modules\\Cms\\View\\Components', 'pub_theme');
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
