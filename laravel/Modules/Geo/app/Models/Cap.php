<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Support\Collection;

/**
 * @deprecated Usare Modules\Geo\Models\Comune. Questa classe è solo una facciata legacy per compatibilità.
 * Tutti i metodi delegano a Comune.
 * Vedi Geo/docs/geo_entities.md
 */
class Cap
{
    /**
     * Restituisce tutti i CAP unici (proxy).
     */
    public static function all(): Collection
    {
        return Comune::allCaps();
    }

    /**
     * Restituisce i CAP per città (proxy).
     */
    public static function byCity(string $cityName): Collection
    {
        return Comune::byCity($cityName)->pluck('cap')->unique();
    }
}
