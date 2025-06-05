<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Support\Collection;

/**
 * @deprecated Usare Modules\Geo\Models\Comune. Questa classe è solo una facciata legacy per compatibilità.
 * Tutti i metodi delegano a Comune.
 * Vedi Geo/docs/geo_entities.md
 */
class Province
{
    /**
     * Restituisce tutte le province uniche (proxy).
     */
    public static function all(): Collection
    {
        return Comune::allProvinces();
    }

    /**
     * Restituisce le province per regione (proxy).
     */
    public static function byRegion(string $regionCode): Collection
    {
        return Comune::byRegion($regionCode)->pluck('provincia.nome', 'provincia.codice')->unique();
    }
}
