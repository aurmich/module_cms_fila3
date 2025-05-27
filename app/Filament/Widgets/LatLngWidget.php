<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Filament\Widgets\Widget;

class LatLngWidget extends Widget
{
    protected static string $view = 'geo::filament.widgets.lat-lng';

    public float $lat = 0;

    public float $lng = 0;

    public ?int $err_code = null;

    public ?string $err_message = null;
}
