<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Pages;

use Modules\Geo\Filament\Widgets;
use Modules\Xot\Filament\Pages\XotBasePage;

class OSMMap extends XotBasePage
{
    protected function getHeaderWidgets(): array
    {
        return [
            // Widgets\LocationMapTableWidget::class,
            // Widgets\LocationMapWidget::class,
            Widgets\OSMMapWidget::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }
}
