<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Pages;

use Filament\Pages\Page;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'lang::filament.pages.dashboard';
}
