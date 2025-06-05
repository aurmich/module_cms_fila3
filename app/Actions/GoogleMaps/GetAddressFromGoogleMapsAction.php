<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GoogleMaps;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Datas\AddressData;
use Modules\Geo\Datas\GoogleMaps\GoogleMapResponseData;
use Modules\Geo\Datas\GoogleMaps\GoogleMapResultData;
use Modules\Geo\Exceptions\GoogleMaps\GoogleMapsApiException;
use Spatie\LaravelData\DataCollection;

/**
 * Gestisce le richieste e l'elaborazione delle risposte dell'API di geocodifica di Google Maps.
 */
final class GetAddressFromGoogleMapsAction
{
    private const BASE_URL = 'https://maps.googleapis.com/maps/api/geocode/json';

    private const REQUIRED_ADDRESS_COMPONENTS = [
        'country',
        'administrative_area_level_3',
        'postal_code',
        'locality',
        'administrative_area_level_2',
        'route',
        'street_number',
        'sublocality_level_1',
        'administrative_area_level_1',
    ];

    /**
     * @throws GoogleMapsApiException Se la richiesta fallisce o i dati non sono validi
     */
    public function execute(string $address): AddressData
    {
        $apiKey = $this->getApiKey();
        $response = $this->makeApiRequest($address, $apiKey);

        $responseData = $this->validateResponse($response);
        $firstResult = $this->getFirstResult($responseData);

        return $this->mapResponseToAddressData($firstResult);
    }

    private function getApiKey(): string
    {
        $apiKey = config('services.google.maps_api_key');

        if (empty($apiKey)) {
            throw GoogleMapsApiException::missingApiKey();
        }

        return $apiKey;
    }

    private function makeApiRequest(string $address, string $apiKey): Response
    {
        $response = Http::get(self::BASE_URL, [
            'address' => $address,
            'key' => $apiKey,
        ]);

        if (! $response->successful()) {
            throw GoogleMapsApiException::requestFailed((string) $response->status());
        }

        return $response;
    }

    private function validateResponse(Response $response): GoogleMapResponseData
    {
        /** @var GoogleMapResponseData $responseData */
        $responseData = GoogleMapResponseData::from($response->json());

        if (0 === $responseData->results->count()) {
            throw GoogleMapsApiException::noResultsFound();
        }

        return $responseData;
    }

    private function getFirstResult(GoogleMapResponseData $responseData): GoogleMapResultData
    {
        $firstResult = $responseData->results->first();

        if (null === $firstResult->geometry?->location) {
            throw GoogleMapsApiException::invalidLocationData();
        }

        return $firstResult;
    }

    private function mapResponseToAddressData(GoogleMapResultData $result): AddressData
    {
        return AddressData::from([
            'latitude' => $result->geometry->location->lat,
            'longitude' => $result->geometry->location->lng,
            'country' => $this->getComponent($result->address_components, ['country']),
            'city' => $this->getComponent($result->address_components, ['administrative_area_level_3']),
            'country_code' => $this->getComponent($result->address_components, ['country'], true),
            'postal_code' => (int) $this->getComponent($result->address_components, ['postal_code']),
            'locality' => $this->getComponent($result->address_components, ['locality']) ?? '',
            'county' => $this->getComponent($result->address_components, ['administrative_area_level_2']),
            'street' => $this->getComponent($result->address_components, ['route']) ?? '',
            'street_number' => $this->getComponent($result->address_components, ['street_number']) ?? '',
            'district' => $this->getComponent($result->address_components, ['sublocality_level_1']) ?? '',
            'state' => $this->getComponent($result->address_components, ['administrative_area_level_1']),
        ]);
    }

    /**
     * Ottiene un componente dell'indirizzo dal risultato di Google Maps.
     *
     * @param DataCollection $components Componenti dell'indirizzo
     * @param array<string>  $types      Tipi di componente da cercare
     * @param bool           $short      Se true, restituisce il nome breve invece di quello lungo
     */
    private function getComponent(DataCollection $components, array $types, bool $short = false): ?string
    {
        $component = $components->toCollection()->first(function ($component) use ($types) {
            return ! empty($component->types)
                && count(array_intersect($component->types, $types)) > 0;
        });

        return $component?->{$short ? 'short_name' : 'long_name'};
    }
}
