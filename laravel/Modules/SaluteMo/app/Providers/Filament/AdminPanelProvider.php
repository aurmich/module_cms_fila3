<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Providers\Filament;

use Filament\Panel;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

/**
 * AdminPanelProvider for SaluteMo module.
 *
 * Handles Filament admin panel configuration, widgets, plugins, and customizations.
 * Extends XotBasePanelProvider to inherit all standard behaviors.
 *
 * @package Modules\SaluteMo\Providers\Filament
 */
class AdminPanelProvider extends XotBasePanelProvider
{
    /**
     * The module name for context.
     *
     * @var string
     */
    protected string $module = 'SaluteMo';

    /**
     * Configure the Filament admin panel for this module.
     *
     * @param Panel $panel
     * @return Panel
     */
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);

        // Example: add custom widgets
        // $panel->widgets([
        //     \Modules\SaluteMo\Filament\Widgets\StatsOverviewWidget::class,
        // ]);

        // Example: add custom plugins
        // $panel->plugin(
        //     \Saade\FilamentFullCalendar\FilamentFullCalendarPlugin::make()
        //         ->config([...])
        // );

        // Add further customizations here...

        return $panel;
    }
}
