<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Providers\Filament;

use Filament\Panel;
use LaraZeus\Bolt\BoltPlugin;
use Filament\SpatieLaravelTranslatablePlugin;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'FormBuilder';

    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);

        $spatieLaravelTranslatablePlugin = SpatieLaravelTranslatablePlugin::make()
            ->defaultLocales(['it', 'en']);

        $boltPlugin = BoltPlugin::make();

        $plugins = [
            $spatieLaravelTranslatablePlugin,
            $boltPlugin
        ];
        
        $panel->plugins($plugins);

        return $panel;
    }
}
