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

<<<<<<< HEAD
=======
<<<<<<< HEAD
// --- bases -----

=======
>>>>>>> origin/dev
>>>>>>> feb96d7 (.)
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
<<<<<<< HEAD
<<<<<<< HEAD
=======

>>>>>>> f1c9277 (.)
    public string $name = 'Cms';
=======
<<<<<<< HEAD
=======
    public string $name = 'Cms';
>>>>>>> origin/dev
>>>>>>> feb96d7 (.)

    public function boot(): void
    {
        parent::boot();
        $router = app('router');
        $this->registerRoutePattern($router);
        $this->registerMyMiddleware($router);
    }

    public function registerMyMiddleware(Router $router): void
    {
        // Middleware registration if needed
    }

    /*
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

    public function registerRoutePattern(Router $router): void
    {
        // ---------- Lang Route Pattern
        $langs = config('laravellocalization.supportedLocales');
        if (! \is_array($langs)) {
            $langs = ['it' => 'it', 'en' => 'en'];
        }

        $lang_pattern = collect(array_keys($langs))->implode('|');
        $lang_pattern = '/|'.$lang_pattern.'|/i';

        $router->pattern('lang', $lang_pattern);
        
        $models = config('morph_map');
        if (! \is_array($models)) {
            $models = [];
        }

        $models_collect = collect(array_keys($models));
        $models_collect->implode('|');
        $models_collect->map(
            static fn ($item) => Str::plural((string) $item)
        )->implode('|');
    }

    // end registerRoutePattern
}
