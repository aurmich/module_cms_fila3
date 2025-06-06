<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Providers;

use Illuminate\Support\Facades\Blade;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Modules\Xot\Providers\XotBaseServiceProvider;

/**
 * Service provider per il modulo SaluteMo.
 *
 * Estende XotBaseServiceProvider per garantire:
 * - Centralizzazione di config, views, traduzioni, migrations, comandi, Livewire/Blade components
 * - Override solo per logica realmente custom (es. observer, schedule, config extra)
 * - Coerenza, DRY, refactoring sicuro
 *
 * Politica: "Non avrai altro provider all'infuori di XotBase..."
 *
 * @package Modules\SaluteMo\Providers
 */
class SaluteMoServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'SaluteMo';

}
