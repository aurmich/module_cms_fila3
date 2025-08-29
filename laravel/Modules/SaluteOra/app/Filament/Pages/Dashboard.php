<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    // protected static string $view = 'gdpr::filament.pages.dashboard';
    public function getWidgets(): array
    {
        return [
            
        ];
    }
}
