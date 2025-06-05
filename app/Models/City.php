<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

/**
 * Model readonly per le città italiane, ispirato a Squire.
 * Legge i dati da json tramite GeoJsonModel.
 * Vedi Geo/docs/geo-json-model.md, module_geo.md, Xot/module-structure.md
 */

use Illuminate\Support\Collection;

class City extends GeoJsonModel
{
    /**
     * Restituisce la lista unica delle città per provincia.
     */
    public static function byProvince(string $province): Collection
    {
        return static::loadData()->where('province', $province)->pluck('city')->unique()->values();
    }
}