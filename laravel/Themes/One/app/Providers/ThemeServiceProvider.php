<?php

declare(strict_types=1);

namespace Themes\One\Providers;

use Filament\Support\Facades\FilamentIcon;
use Illuminate\Support\ServiceProvider;
use Modules\Xot\Providers\XotBaseThemeServiceProvider;

class ThemeServiceProvider extends XotBaseThemeServiceProvider
{
    public string $name = 'One';
    public string $nameLower = 'one';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function register(): void
    {
        FilamentIcon::register([
            'logo' => asset('themes/One/svg/logo.svg'),
        ]);
    }

    public function boot(): void
    {
        parent::boot();
        
        // Registra il namespace pub_theme per le traduzioni
        $this->loadTranslationsFrom($this->module_dir.'/../lang', 'pub_theme');
        
        // Registra anche le view con il namespace pub_theme
        $this->loadViewsFrom($this->module_dir.'/../resources/views', 'pub_theme');
    }
} 