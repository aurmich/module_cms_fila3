<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

/**
 * Servizio per la gestione dei dati geografici.
 * 
 * Questo servizio fornisce metodi per accedere e manipolare i dati geografici
 * memorizzati nel file JSON.
 * 
 * @see \Modules\Geo\docs\json-database.md
 */
class GeoDataService
{
    /**
     * Chiavi di cache.
     */
    private const CACHE_KEY_REGIONS = 'geo.regions';
    private const CACHE_KEY_PROVINCES = 'geo.provinces.%s';
    private const CACHE_KEY_CITIES = 'geo.cities.%s';
    private const CACHE_KEY_CAP = 'geo.cap.%s.%s';

    /**
     * Tempo di cache in secondi (24 ore).
     */
    private const CACHE_TTL = 86400;

    /**
     * Percorso del file JSON.
     */
    private const JSON_PATH = 'Modules/Geo/resources/json/comuni.json';

    /**
     * Validatore dei dati.
     */
    private GeoDataValidator $validator;

    /**
     * Costruttore.
     */
    public function __construct()
    {
        $this->validator = new GeoDataValidator();
    }

    /**
     * Ottiene tutte le regioni.
     * 
     * @return Collection<int, array{name: string, code: string}>
     */
    public function getRegions(): Collection
    {
        return Cache::remember(
            self::CACHE_KEY_REGIONS,
            self::CACHE_TTL,
            fn () => $this->loadData()->pluck('name', 'code')
        );
    }

    /**
     * Ottiene le province di una regione.
     * 
     * @param string $regionCode Codice della regione
     * @return Collection<int, array{name: string, code: string}>
     */
    public function getProvinces(string $regionCode): Collection
    {
        $cacheKey = sprintf(self::CACHE_KEY_PROVINCES, $regionCode);

        return Cache::remember(
            $cacheKey,
            self::CACHE_TTL,
            function () use ($regionCode) {
                $region = $this->loadData()->firstWhere('code', $regionCode);
                return $region ? collect($region['provinces'])->pluck('name', 'code') : collect();
            }
        );
    }

    /**
     * Ottiene le città di una provincia.
     * 
     * @param string $provinceCode Codice della provincia
     * @return Collection<int, array{name: string, code: string}>
     */
    public function getCities(string $provinceCode): Collection
    {
        $cacheKey = sprintf(self::CACHE_KEY_CITIES, $provinceCode);

        return Cache::remember(
            $cacheKey,
            self::CACHE_TTL,
            function () use ($provinceCode) {
                $province = $this->loadData()
                    ->flatMap(fn ($region) => $region['provinces'])
                    ->firstWhere('code', $provinceCode);

                return $province ? collect($province['cities'])->pluck('name', 'code') : collect();
            }
        );
    }

    /**
     * Ottiene il CAP di una città.
     * 
     * @param string $provinceCode Codice della provincia
     * @param string $cityCode Codice della città
     * @return string|null
     */
    public function getCap(string $provinceCode, string $cityCode): ?string
    {
        $cacheKey = sprintf(self::CACHE_KEY_CAP, $provinceCode, $cityCode);

        return Cache::remember(
            $cacheKey,
            self::CACHE_TTL,
            function () use ($provinceCode, $cityCode) {
                $province = $this->loadData()
                    ->flatMap(fn ($region) => $region['provinces'])
                    ->firstWhere('code', $provinceCode);

                if (!$province) {
                    return null;
                }

                $city = collect($province['cities'])
                    ->firstWhere('code', $cityCode);

                return $city ? $city['cap'] : null;
            }
        );
    }

    /**
     * Carica i dati dal file JSON.
     * 
     * @return Collection<int, array>
     * @throws \RuntimeException Se il file non esiste o non è valido
     */
    private function loadData(): Collection
    {
        if (!File::exists(base_path(self::JSON_PATH))) {
            throw new \RuntimeException('Il file JSON dei comuni non esiste');
        }

        $data = json_decode(File::get(base_path(self::JSON_PATH)), true);

        if (!$this->validator->checkIntegrity($data)) {
            throw new \RuntimeException('Il file JSON dei comuni non è valido');
        }

        return collect($data['regions']);
    }

    /**
     * Pulisce la cache.
     * 
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY_REGIONS);
        Cache::forgetPattern(self::CACHE_KEY_PROVINCES . '*');
        Cache::forgetPattern(self::CACHE_KEY_CITIES . '*');
        Cache::forgetPattern(self::CACHE_KEY_CAP . '*');
    }
} 