<?php

declare(strict_types=1);

namespace Modules\Xot\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Datas\MetatagData;
use Nwidart\Modules\Facades\Module;
use Modules\Xot\Actions\File\AssetPathAction;
use Nwidart\Modules\Laravel\Module as LaravelModule;

/**
 * Class XotComposer.
 */
class XotComposer
{
    /**
     * Undocumented function.
     *
     * @param array<mixed|void> $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        $modules = Module::getOrdered();

        $module = Arr::first(
            $modules,
            static function ($module) use ($name): bool {
                // Ensure the module is an instance of LaravelModule
                if (! $module instanceof LaravelModule) {
                    return false;
                }

                Assert::string($moduleName = $module->getName());
                $class = '\Modules\\'.$moduleName.'\View\Composers\ThemeComposer';

                return method_exists($class, $name);
            }
        );

        if (! \is_object($module)) {
            throw new \Exception('Create a View\Composers\ThemeComposer.php inside a module with ['.$name.'] method');
        }

        Assert::isInstanceOf($module, LaravelModule::class, '['.__LINE__.']['.class_basename($this).']');
        $class = '\Modules\\'.$module->getName().'\View\Composers\ThemeComposer';

        $app = app($class);
        $callback = [$app, $name];
        Assert::isCallable($callback);

        return call_user_func_array($callback, $arguments);
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // ✅ Protezione anti-loop infinito
        static $composing = false;
        
        if ($composing) {
            return; // Evita chiamate ricorsive
        }
        
        $composing = true;
        
        try {
            $lang = app()->getLocale();
            $view->with('lang', $lang);
            $view->with('_theme', $this);

            // Safely check authentication without triggering guards
            if (auth()->check()) {
                try {
                    $profile = XotData::make()->getProfileModel();
                    $view->with('_profile', $profile);
                    $view->with('_user', auth()->user());
                } catch (\Throwable $e) {
                    // Silently fail if we can't load the profile
                    \Log::warning('Failed to load user profile in XotComposer: ' . $e->getMessage());
                }
            }
        } finally {
            $composing = false; // Reset flag sempre, anche in caso di eccezione
        }
    }
    
    /**
     * Controllo sicuro per verificare se l'auth è pronto.
     */
    private function isAuthenticationSafe(): bool
    {
        try {
            // Verifica se l'app è completamente inizializzata
            if (!app()->bound('auth')) {
                return false;
            }
            
            // Verifica se c'è una sessione attiva
            if (!app()->bound('session') || !session()->isStarted()) {
                return false;
            }
            
            // Verifica Auth senza scatenare risoluzione complessa
            return Auth::hasUser() || Auth::guest();
            
        } catch (\Exception $e) {
            return false; // In caso di errore, considera auth non sicuro
        }
    }

    public function asset(string $str): string
    {
        return asset(app(\Modules\Xot\Actions\File\AssetAction::class)->execute($str));
    }

    public function path(string $str): string
    {
        return (app(AssetPathAction::class)->execute($str));
    }

    public function metatag(string $str): string|bool|null
    {
        $metatag = MetatagData::make();
        $fun = 'get'.Str::studly($str);
        if (method_exists($metatag, $fun)) {
            // @phpstan-ignore return.type
            return $metatag->{$fun}();
        }

        // @phpstan-ignore return.type
        return $metatag->{$str};
    }
}
