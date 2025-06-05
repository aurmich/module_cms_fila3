<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;

/**
 * Classe base per i servizi geografici.
 */
abstract class BaseGeoService
{
    /**
     * Nome del servizio per la configurazione.
     */
    abstract protected function getServiceName(): string;

    /**
     * Ottiene la chiave API dal file di configurazione.
     *
     * @throws \RuntimeException Se la chiave API non è configurata
     */
    protected function getApiKey(): string
    {
        $apiKey = config("geo.api_keys.{$this->getServiceName()}");

        if (empty($apiKey)) {
            throw new \RuntimeException("API key non configurata per {$this->getServiceName()}");
        }

        return $apiKey;
    }

    /**
     * Esegue una richiesta HTTP con rate limiting, cache e retry.
     *
     * @param string               $method   Metodo HTTP (GET, POST, etc.)
     * @param string               $url      URL della richiesta
     * @param array<string, mixed> $params   Parametri della richiesta
     * @param bool                 $useCache Se utilizzare la cache
     *
     * @throws \RuntimeException Se la richiesta fallisce
     *
     * @return array<string, mixed>
     */
    protected function makeRequest(string $method, string $url, array $params = [], bool $useCache = true): array
    {
        $cacheKey = $this->getCacheKey($method, $url, $params);

        if ($useCache && config('geo.cache.enabled')) {
            $cached = Cache::get($cacheKey);
            if (null !== $cached) {
                return $cached;
            }
        }

        // Rate limiting
        RateLimiter::attempt(
            $this->getServiceName(),
            config("geo.rate_limits.{$this->getServiceName()}.requests_per_second", 50),
            function () {
                return true;
            }
        );

        try {
            $response = $this->buildHttpClient()
                ->{strtolower($method)}($url, $params);

            if (! $response->successful()) {
                throw new \RuntimeException("Richiesta fallita a {$this->getServiceName()}: ".$response->status());
            }

            $data = $response->json();

            if ($useCache && config('geo.cache.enabled')) {
                Cache::put($cacheKey, $data, config('geo.cache.ttl', 86400));
            }

            return $data;
        } catch (\Throwable $e) {
            throw new \RuntimeException("Errore durante la richiesta a {$this->getServiceName()}: ".$e->getMessage(), 0, $e);
        }
    }

    /**
     * Costruisce il client HTTP con timeout e retry configurati.
     */
    protected function buildHttpClient(): PendingRequest
    {
        return Http::timeout(config('geo.http_client.timeout', 5.0))
            ->retry(
                config('geo.http_client.retry.times', 3),
                config('geo.http_client.retry.sleep', 100),
                function ($exception) {
                    $whenTypes = config('geo.http_client.retry.when', []);

                    foreach ($whenTypes as $type) {
                        if (is_a($exception, "\\GuzzleHttp\\Exception\\{$type}")) {
                            return true;
                        }
                    }

                    return false;
                }
            );
    }

    /**
     * Genera una chiave di cache per la richiesta.
     *
     * @param string               $method Metodo HTTP
     * @param string               $url    URL della richiesta
     * @param array<string, mixed> $params Parametri della richiesta
     */
    protected function getCacheKey(string $method, string $url, array $params): string
    {
        $prefix = config('geo.cache.prefix', 'geo_');
        $hash = md5($method.$url.serialize($params));

        return "{$prefix}{$this->getServiceName()}_{$hash}";
    }
}
