<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

/**
 * Model readonly per le province italiane, ispirato a Squire.
 * Legge i dati da json tramite GeoJsonModel.
 * Vedi Geo/docs/geo-json-model.md, module_geo.md, Xot/module-structure.md
 */

use Illuminate\Support\Collection;

class Province extends GeoJsonModel
{
    /**
     * Restituisce la lista unica delle province per regione.
     */
    public static function byRegion(string $region): Collection
    {
        return static::loadData()->where('regione.codice', $region)->pluck('provincia')->unique()->values();
    }
}