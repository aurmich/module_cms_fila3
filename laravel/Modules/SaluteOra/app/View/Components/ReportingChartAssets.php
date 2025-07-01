<?php

declare(strict_types=1);

namespace Modules\SaluteOra\View\Components;

use Illuminate\View\Component;

/**
 * Componente per il caricamento degli asset dei grafici.
 * Questo componente deve essere incluso in tutte le pagine che utilizzano i grafici.
 */
class ReportingChartAssets extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('reporting::components.chart-assets');
    }
}
