<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Modules\Xot\Filament\Traits\TransTrait;
use Filament\Widgets\StatsOverviewWidget as FilamentStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Actions\Action;

/**
 * Classe base per i widget StatsOverview del sistema Xot.
 *
 * Fornisce funzionalità comuni per tutti i widget di statistiche overview.
 * Estende Filament\Widgets\StatsOverviewWidget e aggiunge funzionalità specifiche del progetto.
 *
 * @package Modules\Xot\Filament\Widgets
 */
abstract class XotBaseStatsOverviewWidget extends FilamentStatsOverviewWidget
{
    use TransTrait;

   
} 