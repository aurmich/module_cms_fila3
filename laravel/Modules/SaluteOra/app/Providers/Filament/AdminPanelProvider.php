<?php

namespace Modules\SaluteOra\Providers\Filament;

use Modules\Xot\Providers\XotBaseServiceProvider;
use Filament\Panel;

class AdminPanelProvider extends XotBaseServiceProvider
{
    public string $name = 'SaluteOra';

    public function panel(Panel $panel): Panel
    {

        return parent::panel($panel);
    }
}
