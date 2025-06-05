<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Modello unico readonly per i comuni italiani (Facade pattern).
 * 
 * Implementa il pattern Facade per fornire un'interfaccia unificata a tutti i dati geografici:
 * regioni, province, città, CAP, codici ISTAT, ecc.
 * Tutti i dati sono estratti da un'unica fonte (comuni.json) e gestiti tramite metodi statici.
 * Include un sistema di caching multilivello per ottimizzare le performance.
 * 
 * @see GeoJsonModel Classe base per l'accesso ai dati JSON
 * @see docs/consolidamento-modelli-geografici.md Analisi comparativa della struttura
 * @see docs/comune-unificazione-analisi.md Analisi dell'unificazione dei modelli
 * @see docs/geo-json-model.md Documentazione tecnica del modello base
 */
class Comune extends GeoJsonModel
{
    /**
     * Cache duration in seconds (1 week)
     */
    protected const CACHE_TTL = 604800;

    /**
     * Get all comuni with their complete data
     * 
     * @return Collection<array-key, array{
     *     nome: string,
     *     codice: string,
     *     regione: array{codice: string, nome: string},
     *     provincia: array{codice: string, nome: string},
     *     cap: array<int, string>,
     *     codiceCatastale: string,
     *     popolazione: int
     * }>
     */
    public static function all(): Collection
    {
        return static::loadData();
    }

    /**
     * Get comuni by region code
     */
    public static function byRegion(string $regionCode): Collection
    {
        $cacheKey = "geo_region_{$regionCode}";
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($regionCode) {
            return static::all()
                ->where('regione.codice', $regionCode)
                ->sortBy('nome')
                ->values();
        });
    }

    /**
     * Get comuni by province code
     */
    public static function byProvince(string $provinceCode): Collection
    {
        $cacheKey = "geo_province_{$provinceCode}";
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($provinceCode) {
            return static::all()
                ->where('provincia.codice', $provinceCode)
                ->sortBy('nome')
                ->values();
        });
    }

    /**
     * Get all comuni by name (case insensitive partial match)
     * 
     * @param string $name Nome parziale del comune da cercare
     * @param int $limit Numero massimo di risultati (0 = nessun limite)
     * @return Collection<array-key, array> Comuni che corrispondono alla ricerca
     */
    public static function searchByName(string $name, int $limit = 0): Collection
    {
        $name = mb_strtolower($name);
        $cacheKey = "geo_search_" . md5($name) . "_" . $limit;
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($name, $limit) {
            $results = static::all()
                ->filter(fn($item) => str_contains(mb_strtolower($item['nome']), $name))
                ->sortBy('nome');
                
            return $limit > 0 ? $results->take($limit)->values() : $results->values();
        });
    }

    /**
     * Get comuni by CAP
     */
    public static function byCap(string $cap): Collection
    {
        return static::all()
            ->filter(fn($item) => in_array($cap, $item['cap'], true))
            ->sortBy('nome')
            ->values();
    }

    /**
     * Get all regions with their codes and names
     * 
     * @return Collection<string, string> [code => name]
     */
    public static function allRegions(): Collection
    {
        return Cache::remember('geo_all_regions', self::CACHE_TTL, function () {
            return static::all()
                ->pluck('regione.nome', 'regione.codice')
                ->unique()
                ->sort();
        });
    }

    /**
     * Get all provinces with their codes and names
     * 
     * @return Collection<string, string> [code => name]
     */
    public static function allProvinces(): Collection
    {
        return Cache::remember('geo_all_provinces', self::CACHE_TTL, function () {
            return static::all()
                ->pluck('provincia.nome', 'provincia.codice')
                ->unique()
                ->sort();
        });
    }

    /**
     * Get all provinces for a specific region
     * 
     * @return Collection<string, string> [code => name]
     */
    public static function getProvincesByRegion(string $regionCode): Collection
    {
        $cacheKey = "geo_region_{$regionCode}_provinces";
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($regionCode) {
            return static::all()
                ->where('regione.codice', $regionCode)
                ->pluck('provincia.nome', 'provincia.codice')
                ->unique()
                ->sort();
        });
    }

    /**
     * Get all CAPs for a specific city
     */
    public static function getCapsByCity(string $cityName): Collection
    {
        return static::all()
            ->where('nome', $cityName)
            ->pluck('cap')
            ->flatten()
            ->unique()
            ->sort()
            ->values();
    }

    /**
     * Clear all cached data
     * 
     * @param bool $verbose Se true, restituisce la lista delle chiavi di cache eliminate
     * @return array<int, string>|void Lista delle chiavi di cache eliminate se $verbose è true
     */
    public static function clearCache(bool $verbose = false): array|void
    {
        $clearedKeys = [];
        
        // Chiavi base
        $baseKeys = ['geo_all_regions', 'geo_all_provinces'];
        foreach ($baseKeys as $key) {
            Cache::forget($key);
            $clearedKeys[] = $key;
        }
        
        // Chiavi specifiche per regione
        static::allRegions()->keys()->each(function ($code) use (&$clearedKeys) {
            $keys = ["geo_region_{$code}", "geo_region_{$code}_provinces"];
            foreach ($keys as $key) {
                Cache::forget($key);
                $clearedKeys[] = $key;
            }
        });
        
        // Chiavi specifiche per provincia
        static::allProvinces()->keys()->each(function ($code) use (&$clearedKeys) {
            $key = "geo_province_{$code}";
            Cache::forget($key);
            $clearedKeys[] = $key;
        });
        
        // Rimuovi tutte le chiavi di ricerca (pattern matching)
        $searchKeys = Cache::getStore()->keys('geo_search_*');
        foreach ($searchKeys as $key) {
            Cache::forget($key);
            $clearedKeys[] = $key;
        }
        
        return $verbose ? $clearedKeys : null;
    }
}
