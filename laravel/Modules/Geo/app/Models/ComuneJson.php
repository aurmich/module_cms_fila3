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
class ComuneJson extends GeoJsonModel
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
     * @return array<int, string>|null Lista delle chiavi di cache eliminate se $verbose è true
     */
    public static function clearCache(bool $verbose = false): ?array
    {
        $clearedKeys = [];
        
        // Chiavi base
        $baseKeys = ['geo_all_regions', 'geo_all_provinces'];
        foreach ($baseKeys as $key) {
            Cache::forget($key);
            $clearedKeys[] = $key;
        }
        
        // Chiavi specifiche per regione
        static::allRegions()->each(function ($nome, $code) use (&$clearedKeys) {
            $keys = ["geo_region_{$code}", "geo_region_{$code}_provinces"];
            foreach ($keys as $key) {
                Cache::forget($key);
                $clearedKeys[] = $key;
            }
        });
        
        // Chiavi specifiche per provincia
        static::allProvinces()->each(function ($nome, $code) use (&$clearedKeys) {
            $key = "geo_province_{$code}";
            Cache::forget($key);
            $clearedKeys[] = $key;
        });
        
        // Nota: La pulizia delle chiavi di pattern matching è limitata
        // poiché non tutti i driver di cache supportano la ricerca per pattern
        // Le chiavi di ricerca più comuni vengono gestite esplicitamente
        $searchPatterns = [
            'geo_search_', // Ricerche generiche
            'geo_valid_cap_', // Validazione CAP
            'geo_gerarchia_', // Gerarchie geografiche
        ];
        
        // Puliamo alcune chiavi di ricerca comuni per essere sicuri
        foreach ($searchPatterns as $pattern) {
            for ($i = 0; $i < 10; $i++) {
                $testKey = $pattern . md5((string)$i);
                Cache::forget($testKey);
            }
        }
        
        return $verbose ? $clearedKeys : null;
    }
    
    /**
     * Verifica se il CAP esiste nel database
     * 
     * @param string $cap CAP da verificare
     * @return bool True se il CAP esiste, false altrimenti
     */
    public static function isValidCap(string $cap): bool
    {
        $cacheKey = "geo_valid_cap_{$cap}";
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($cap) {
            return static::byCap($cap)->isNotEmpty();
        });
    }
    
    /**
     * Ottiene la gerarchia completa per un comune (regione, provincia, comune, cap)
     * 
     * @param string $comuneNome Nome esatto del comune
     * @return array|null Gerarchia completa o null se il comune non esiste
     */
    public static function getGerarchia(string $comuneNome): ?array
    {
        $cacheKey = "geo_gerarchia_" . md5($comuneNome);
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($comuneNome) {
            $comune = static::all()->firstWhere('nome', $comuneNome);
            
            if (!$comune) {
                return null;
            }
            
            return [
                'regione' => $comune['regione'] ?? null,
                'provincia' => $comune['provincia'] ?? null,
                'comune' => [
                    'nome' => $comune['nome'],
                    'codice' => $comune['codice'] ?? null,
                    'codiceCatastale' => $comune['codiceCatastale'] ?? null,
                    'popolazione' => $comune['popolazione'] ?? null,
                ],
                'cap' => $comune['cap'] ?? [],
            ];
        });
    }
    
    /**
     * Restituisce regole di validazione Laravel per form geografici
     * 
     * @param bool $required Se true, tutti i campi sono obbligatori
     * @return array<string, array<int, mixed>> Regole di validazione
     */
    public static function getValidationRules(bool $required = true): array
    {
        $requiredRule = $required ? 'required' : 'nullable';
        
        return [
            'regione_codice' => [$requiredRule, 'string', function ($attribute, $value, $fail) {
                if (!static::allRegions()->has($value)) {
                    $fail('La regione selezionata non è valida.');
                }
            }],
            'provincia_codice' => [$requiredRule, 'string', function ($attribute, $value, $fail) {
                if (!static::allProvinces()->has($value)) {
                    $fail('La provincia selezionata non è valida.');
                }
            }],
            'comune_nome' => [$requiredRule, 'string', function ($attribute, $value, $fail) {
                if (!empty($value) && static::searchByName($value, 1)->isEmpty()) {
                    $fail('Il comune selezionato non è valido.');
                }
            }],
            'cap' => [$requiredRule, 'string', function ($attribute, $value, $fail) {
                if (!empty($value) && !static::isValidCap($value)) {
                    $fail('Il CAP inserito non è valido.');
                }
            }],
        ];
    }
}
