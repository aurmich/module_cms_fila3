<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Support\Collection;

/**
 * @deprecated Usare Modules\Geo\Models\Comune. Questa classe è solo una facciata legacy per compatibilità.
 * Tutti i metodi delegano a Comune.
 * Vedi Geo/docs/geo_entities.md
 */
class City
{
    /**
     * Restituisce tutte le città uniche (proxy).
     */
    public static function all(): Collection
    {
        return Comune::allCities();
    }

    /**
     * Restituisce le città per provincia (proxy).
     */
    public static function byProvince(string $provinceCode): Collection
    {
        return Comune::byProvince($provinceCode)->pluck('comune')->unique();
    }
}
