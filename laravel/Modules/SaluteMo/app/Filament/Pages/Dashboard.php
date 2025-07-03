<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBaseDashboard;
use Illuminate\Contracts\View\View;
use Modules\SaluteMo\Filament\Widgets\StatsOverview;

/**
 * Dashboard amministrativa per il modulo SaluteMo.
 *
 * Entry point per widget, overview e navigazione amministrativa.
 * Titolo e descrizione sono presi dai file di traduzione.
 *
 * @package Modules\SaluteMo\Filament\Pages
 */
class Dashboard extends XotBaseDashboard
{
    protected static ?int $navigationSort = 1;

   
    public  function getWidgets(): array{
        return [];
    }
    /**
     * Widget da visualizzare nell'header della dashboard.
     *
     * @return array<class-string>
     */
    protected function getHeaderWidgets(): array
    {
        return [
            //StatsOverview::class,
        ];
    }

    /**
     * Widget da visualizzare nel footer della dashboard.
     *
     * @return array<class-string>
     */
    protected function getFooterWidgets(): array
    {
        return [];
    }
}
