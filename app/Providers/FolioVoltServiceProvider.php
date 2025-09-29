<?php

declare(strict_types=1);

namespace Modules\Cms\Providers;

use Livewire\Volt\Volt;
use Laravel\Folio\Folio;
use Illuminate\Support\Arr;
use Webmozart\Assert\Assert;
use Modules\Xot\Datas\XotData;
use Illuminate\Support\Collection;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Modules\Tenant\Services\TenantService;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FolioVoltServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /*
        Folio::path(resource_path('views/pages'))->middleware([
            '*' => [
                //
            ],
        ]);
        */
        $middleware = TenantService::config('middleware');
        if (! is_array($middleware)) {
            $middleware = [];
        }
        Assert::isArray($base_middleware = Arr::get($middleware, 'base', []));

        //$base_middleware[]=\Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class;
        $base_middleware[]=\Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class;
        $base_middleware[]=\Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class;
        //$base_middleware[]=\Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class;
        //$base_middleware[]=\Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class;

        $theme_path = XotData::make()->getPubThemeViewPath('pages');
        /*
        // Ottieni la lingua corrente in modo sicuro
        $currentLocale = app()->getLocale();
        $supportedLocales = config('laravellocalization.supportedLocales', []);
        if (!isset($supportedLocales[$currentLocale])) {
            $currentLocale = array_key_first($supportedLocales) ?? 'it';
            app()->setLocale($currentLocale);
        }
        */
        //$currentLocale = LaravelLocalization::setLocale() ?? app()->getLocale();

        Folio::path($theme_path)
            ->uri(LaravelLocalization::setLocale() ?? app()->getLocale() )
            //->uri('{lang}')
            ->middleware([
                '*' => $base_middleware,
            ]);

        /**
         * @var Collection<Module>
         */
        $modules = Module::collections();
        $paths = [];
        $paths[] = $theme_path;
        foreach ($modules as $module) {
            $path = $module->getPath().'/resources/views/pages';
            if (! File::exists($path)) {
                continue;
            }
            $paths[] = $path;
            Folio::path($path)
                ->uri( LaravelLocalization::setLocale() ?? app()->getLocale() )
                //->uri('{lang}')
                ->middleware([
                    '*' => $base_middleware
                ]);
        }

        Volt::mount($paths);
    }
}
