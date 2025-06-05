<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

class CoordinatesData extends Data
{
    public float $latitude;

    public float $longitude;
}
