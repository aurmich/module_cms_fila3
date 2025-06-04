<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Pages;

use Filament\Pages\Dashboard as FilamentDashboard;
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
class Dashboard extends FilamentDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationGroup = 'SaluteMo';
    protected static ?int $navigationSort = 1;

    /**
     * Restituisce il titolo della dashboard.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return __('salutemo::dashboard.title');
    }

    /**
     * Restituisce la descrizione della dashboard.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return __('salutemo::dashboard.description');
    }

    /**
     * Widget da visualizzare nell'header della dashboard.
     *
     * @return array<class-string>
     */
    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
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
