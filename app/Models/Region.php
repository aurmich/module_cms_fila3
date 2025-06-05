<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

/**
 * Model readonly per le regioni italiane, ispirato a Squire.
 * Legge i dati da json tramite GeoJsonModel.
 * Vedi Geo/docs/geo-json-model.md, module_geo.md, Xot/module-structure.md
 */

use Illuminate\Support\Collection;

class Region extends GeoJsonModel
{
    /**
     * Restituisce la lista unica delle regioni.
     */
    public static function all(): Collection
    {
        return static::loadData()->pluck('region')->unique()->values();
    }
}