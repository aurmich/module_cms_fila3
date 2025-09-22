<?php

declare(strict_types=1);

namespace Modules\Cms\Providers;

use Exception;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Http\Middleware\SetDefaultLocaleForUrlsMiddleware;
use Modules\Xot\Providers\XotBaseRouteServiceProvider;

// public function boot(\Illuminate\Routing\Router $router)

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Cms\Http\Controllers';

    /**
     * The module directory.
     */
    protected string $module_dir = __DIR__;

    /**
     * The module namespace.
     */
    protected string $module_ns = __NAMESPACE__;
    public string $name = 'Cms';

<<<<<<< HEAD
    #[\Override]
=======
>>>>>>> bc33217 (.)
    public function boot(): void
    {
        parent::boot();
        // 36     Cannot access offset 'router' on Illuminate\Contracts\Foundation\Application
        // $router = $this->app['router'];
        $router = app('router');
        // dddx([$router, $router1]);

        // $this->registerLang();
        $this->registerRoutePattern($router);
        $this->registerMyMiddleware($router);
    }

    public function registerMyMiddleware(Router $router): void
    {
        // $router->pushMiddlewareToGroup('web', SetDefaultLocaleForUrlsMiddleware::class);
        // $router->prependMiddlewareToGroup('web', SetDefaultLocaleForUrlsMiddleware::class);
        // $router->prependMiddlewareToGroup('api', SetDefaultLocaleForUrlsMiddleware::class);
    }

    /*
<<<<<<< HEAD
     * public function registerLang(): void
     * {
     *
     * $locales = config('laravellocalization.supportedLocales');
     * if (! \is_array($locales)) {
     * // throw new \Exception('[.__LINE__.]['.class_basename(__CLASS__).']');
     * $locales = ['it' => 'it', 'en' => 'en'];
     * }
     * $langs = array_keys($locales);
     *
     * if (! \is_array($langs)) {
     * throw new \Exception('[.__LINE__.]['.class_basename(__CLASS__).']');
     * }
     * if (\in_array(\Request::segment(1),  $langs, false)) {
     * $lang = \Request::segment(1);
     * if (null !== $lang) {
     * App::setLocale($lang);
     * }
     * }
     * }
     */
=======
    public function registerLang(): void
    {

        $locales = config('laravellocalization.supportedLocales');
        if (! \is_array($locales)) {
            // throw new \Exception('[.__LINE__.]['.class_basename(__CLASS__).']');
            $locales = ['it' => 'it', 'en' => 'en'];
        }
        $langs = array_keys($locales);

        if (! \is_array($langs)) {
            throw new \Exception('[.__LINE__.]['.class_basename(__CLASS__).']');
        }
        if (\in_array(\Request::segment(1),  $langs, false)) {
            $lang = \Request::segment(1);
            if (null !== $lang) {
                App::setLocale($lang);
            }
        }
    }
    */
>>>>>>> bc33217 (.)

    public function registerRoutePattern(Router $router): void
    {
        // ---------- Lang Route Pattern
        // ✅ Controllo sicuro della configurazione laravellocalization
<<<<<<< HEAD
        $langs = config()->has('laravellocalization.supportedLocales')
            ? config('laravellocalization.supportedLocales')
            : ['it' => 'it', 'en' => 'en'];

        if (!\is_array($langs)) {
=======
        $langs = config()->has('laravellocalization.supportedLocales') 
            ? config('laravellocalization.supportedLocales') 
            : ['it' => 'it', 'en' => 'en'];
            
        if (! \is_array($langs)) {
>>>>>>> bc33217 (.)
            // throw new \Exception('[.__LINE__.]['.class_basename(__CLASS__).']');
            $langs = ['it' => 'it', 'en' => 'en'];
        }

        $lang_pattern = collect(array_keys($langs))->implode('|');
<<<<<<< HEAD
        $lang_pattern = '/|' . $lang_pattern . '|/i';
=======
        $lang_pattern = '/|'.$lang_pattern.'|/i';
>>>>>>> bc33217 (.)

        $router->pattern('lang', $lang_pattern);
        // -------------------------------------------------------------
        $models = config('morph_map');
<<<<<<< HEAD
        if (!\is_array($models)) {
=======
        if (! \is_array($models)) {
>>>>>>> bc33217 (.)
            // throw new Exception('[' . print_r($models, true) . '][' . __LINE__ . '][' . class_basename(__CLASS__) . ']');
            $models = [];
        }

        $models_collect = collect(array_keys($models));
        $models_collect->implode('|');
<<<<<<< HEAD
        $models_collect->map(static fn($item) => Str::plural((string) $item))->implode('|');

        /*--pattern vuoto
         * dddx([
         * 'lang_pattern' => $lang_pattern,
         * 'container0_pattern' => $container0_pattern,
         * 'config_path' => TenantService::getConfigPath('morph_map'),
         * ]);
         */
=======
        $models_collect->map(
            static fn ($item) => Str::plural((string) $item)
        )->implode('|');
        /*--pattern vuoto
        dddx([
            'lang_pattern' => $lang_pattern,
            'container0_pattern' => $container0_pattern,
            'config_path' => TenantService::getConfigPath('morph_map'),
        ]);
        */
>>>>>>> bc33217 (.)
        // da erore livewire ?
        // $router->pattern('container0', $container0_pattern);
    }

    // end registerRoutePattern
}
