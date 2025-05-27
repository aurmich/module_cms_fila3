<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Exceptions\GoogleMaps\GoogleMapsApiException;

/**
 * Servizio per le interazioni con l'API di Google Maps.
 */
class GoogleMapsService extends BaseGeoService
{
    private const GEOCODING_URL = 'https://maps.googleapis.com/maps/api/geocode/json';

    private const DISTANCE_MATRIX_URL = 'https://maps.googleapis.com/maps/api/distancematrix/json';

    private const ELEVATION_URL = 'https://maps.googleapis.com/maps/api/elevation/json';

    protected function getServiceName(): string
    {
        return 'google_maps';
    }

    /**
     * Esegue una richiesta di geocodifica inversa.
     *
     * @throws GoogleMapsApiException Se la richiesta fallisce
     *
     * @return array<string, mixed>
     */
    public function reverseGeocode(float $latitude, float $longitude): array
    {
        try {
            return $this->makeRequest('GET', self::GEOCODING_URL, [
                'latlng' => "{$latitude},{$longitude}",
                'key' => $this->getApiKey(),
                'language' => 'it',
            ]);
        } catch (\Throwable $e) {
            throw GoogleMapsApiException::requestFailed($e->getMessage());
        }
    }

    /**
     * Calcola la matrice delle distanze.
     *
     * @param array<string> $origins      Punti di origine (formato: "lat,lng|lat,lng|...")
     * @param array<string> $destinations Punti di destinazione (formato: "lat,lng|lat,lng|...")
     *
     * @throws GoogleMapsApiException Se la richiesta fallisce
     *
     * @return array<string, mixed>
     */
    public function getDistanceMatrix(array $origins, array $destinations): array
    {
        try {
            return $this->makeRequest('GET', self::DISTANCE_MATRIX_URL, [
                'origins' => implode('|', $origins),
                'destinations' => implode('|', $destinations),
                'key' => $this->getApiKey(),
                'language' => 'it',
                'units' => 'metric',
            ]);
        } catch (\Throwable $e) {
            throw GoogleMapsApiException::requestFailed($e->getMessage());
        }
    }

    /**
     * Ottiene l'elevazione per un punto.
     *
     * @throws GoogleMapsApiException Se la richiesta fallisce
     *
     * @return array<string, mixed>
     */
    public function getElevation(float $latitude, float $longitude): array
    {
        try {
            return $this->makeRequest('GET', self::ELEVATION_URL, [
                'locations' => "{$latitude},{$longitude}",
                'key' => $this->getApiKey(),
            ]);
        } catch (\Throwable $e) {
            throw GoogleMapsApiException::requestFailed($e->getMessage());
        }
    }

    /**
     * @return array{
     *     results: array<array{
     *         elevation: float,
     *         location: array{lat: float, lng: float},
     *         resolution: float
     *     }>,
     *     status: string
     * }
     */
    public function getElevation(float $latitude, float $longitude): array
    {
        $cacheKey = "elevation:{$latitude},{$longitude}";

        return Cache::remember($cacheKey, now()->addDay(), function () use ($latitude, $longitude) {
            $response = Http::get("{$this->baseUrl}/elevation/json", [
                'locations' => "{$latitude},{$longitude}",
                'key' => $this->apiKey,
            ]);

            if (! $response->successful() || 'OK' !== $response->json('status')) {
                throw new \RuntimeException('Failed to get elevation data');
            }

            return $response->json();
        });
    }

    /**
     * @return array{
     *     destination_addresses: array<string>,
     *     origin_addresses: array<string>,
     *     rows: array<array{
     *         elements: array<array{
     *             distance?: array{text: string, value: int},
     *             duration?: array{text: string, value: int},
     *             status: string
     *         }>
     *     }>,
     *     status: string
     * }|null
     */
    public function getDistanceMatrix(string $origins, string $destinations): ?array
    {
        $cacheKey = "distance_matrix:{$origins}:{$destinations}";

        /** @var array|null $result */
        $result = Cache::remember($cacheKey, now()->addDay(), function () use ($origins, $destinations) {
            $response = Http::get("{$this->baseUrl}/distancematrix/json", [
                'origins' => $origins,
                'destinations' => $destinations,
                'key' => $this->apiKey,
            ]);

            if (! $response->successful() || 'OK' !== $response->json('status')) {
                return null;
            }

            /** @var array{
             * destination_addresses: array<string>,
             * origin_addresses: array<string>,
             * rows: array<array{
             * elements: array<array{
             * distance?: array{text: string, value: int},
             * duration?: array{text: string, value: int},
             * status: string
             * }>
             * }>,
             * status: string
             * }|null $data */
            $data = $response->json();

            return $data;
        });

        return $result;
    }

    /**
     * @return array{lat: float, lng: float}|null
     */
    public function getCoordinatesByAddress(string $address): ?array
    {
        $cacheKey = 'geocode:'.md5($address);

        /** @var array{lat: float, lng: float}|null $result */
        $result = Cache::remember($cacheKey, now()->addWeek(), function () use ($address) {
            $response = Http::get("{$this->baseUrl}/geocode/json", [
                'address' => $address,
                'key' => $this->apiKey,
            ]);

            if (! $response->successful()
                || 'OK' !== $response->json('status')
                || empty($response->json('results'))) {
                return null;
            }

            /** @var array{results: array<array{geometry: array{location: array{lat: float, lng: float}}}>} $data */
            $data = $response->json();

            if (empty($data['results'][0]['geometry']['location'])) {
                return null;
            }

            return $data['results'][0]['geometry']['location'];
        });

        return $result;
    }
}
