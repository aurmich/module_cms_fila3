<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Pages;

use Modules\Geo\Filament\Widgets\WebbingbrasilMap as Map;
use Modules\Xot\Filament\Pages\XotBasePage;

class WebbingbrasilMap extends XotBasePage
{
    protected function getHeaderWidgets(): array
    {
        return [
            Map::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }
}
