<?php

declare(strict_types=1);

namespace Themes\Two;

use Modules\Xot\Providers\XotBaseThemeServiceProvider;

class ThemeServiceProvider extends XotBaseThemeServiceProvider
{
    public string $name = 'Two';
    public string $nameLower = 'two';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function register(): void
    {
        parent::register();
        // Aggiungi qui solo logica specifica del tema
    }

    public function boot(): void
    {
        parent::boot();
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'theme-two');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/theme.php' => config_path('theme-two.php'),
            ], 'theme-two-config');
        }
    }
}
