<?php

<<<<<<< HEAD
declare(strict_types=1);

namespace Modules\Notify\Providers;

use Modules\Xot\Providers\XotBaseContextServiceProvider;

class FilamentServiceProvider extends XotBaseContextServiceProvider
{
    public static string $name = 'notify-filament';
    public static string $module = 'Notify';
=======
namespace Modules\Notify\Providers;


use Modules\Xot\Providers\XotBaseContextServiceProvider;

class FilamentServiceProvider extends XotBaseContextServiceProvider
{
    public static string $name = 'notify-filament';
    public static string $module = 'Notify';

<<<<<<< HEAD
    public function packageRegistered(): void
    {
        $this->app->booting(function () {
            $this->registerConfigs();
        });
        parent::packageRegistered();
    }

    public function registerConfigs() {
        $this->mergeConfigFrom(
            app('modules')->findOrFail(static::$module)->getExtraPath( 'Config/'.static::$name.'.php'),
            static::$name
        );
    }

    public function boot()
    {
        parent::boot();
        Filament::serving(function () {
            Filament::forContext('filament', function (){
                Filament::registerNavigationItems([
                    NavigationItem::make(static::$module)
                        ->label(static::$module.' ')
                        ->url(route(static::$name.'.pages.dashboard'))
                        ->icon('heroicon-o-bookmark')
                        ->group('Modules')
                ]);
            });
            Filament::forContext(static::$name, function (){
                Filament::registerRenderHook('sidebar.start',fn():string => \Blade::render('<div class="p-2 px-6 bg-primary-100 font-black w-full">'.static::$module.' Module</div>'));
            });
        });
    }
>>>>>>> 911eb41 (up)
=======
    
>>>>>>> 812a135 (up)
}
