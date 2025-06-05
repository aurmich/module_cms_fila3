<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Datas\CoordinatesData;

class GetCoordinatesByAddressAction
{
    public function execute(string $address): ?CoordinatesData
    {
        // Prova con Google Maps
        $coordinates = $this->getFromGoogle($address);

        if (! $coordinates) {
            // Prova con Bing Maps
            $coordinates = $this->getFromBing($address);
        }

        if (! $coordinates) {
            // Prova con OpenCage
            $coordinates = $this->getFromOpenCage($address);
        }

        if (! $coordinates) {
            // Prova con OpenStreetMap Nominatim
            $coordinates = $this->getFromNominatim($address);
        }

        if (! $coordinates) {
            // Prova con OpenAPI Geocoding
            $coordinates = $this->getFromOpenApi($address);
        }

        if (! $coordinates) {
            Notification::make()
                ->title('Error')
                ->body('Failed to fetch coordinates from all providers.')
                ->danger()
                ->persistent()
                ->send();
        }

        return $coordinates;
    }

    private function getFromGoogle(string $address): ?CoordinatesData
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $address,
            'key' => config('services.google.maps_api_key'),
        ]);

        if (! $response->successful() || empty($response->json()['results'])) {
            return null;
        }

        $location = $response->json()['results'][0]['geometry']['location'];

        return new CoordinatesData(
            latitude: $location['lat'],
            longitude: $location['lng']
        );
    }

    private function getFromBing(string $address): ?CoordinatesData
    {
        $maps_api_key = config('services.bing.maps_api_key');

        $response = Http::get('http://dev.virtualearth.net/REST/v1/Locations', [
            'q' => $address,
            'key' => $maps_api_key,
        ]);

        if (! $response->successful() || empty($response->json()['resourceSets'][0]['resources'])) {
            // dddx($response->json());

            return null;
        }

        $location = $response->json()['resourceSets'][0]['resources'][0]['point']['coordinates'];

        return CoordinatesData::from(
            [
                'latitude' => $location[0],
                'longitude' => $location[1],
            ]
        );
    }

    private function getFromOpenCage(string $address): ?CoordinatesData
    {
        $response = Http::get('https://api.opencagedata.com/geocode/v1/json', [
            'q' => $address,
            'key' => config('services.opencage.api_key'),
        ]);

        if (! $response->successful() || empty($response->json()['results'])) {
            return null;
        }

        $location = $response->json()['results'][0]['geometry'];

        return new CoordinatesData(
            latitude: $location['lat'],
            longitude: $location['lng']
        );
    }

    private function getFromNominatim(string $address): ?CoordinatesData
    {
        $response = Http::get('https://nominatim.openstreetmap.org/search', [
            'q' => $address,
            'format' => 'json',
        ]);

        if (! $response->successful() || empty($response->json())) {
            return null;
        }

        $location = $response->json()[0];

        return new CoordinatesData(
            latitude: (float) $location['lat'],
            longitude: (float) $location['lon']
        );
    }

    private function getFromOpenApi(string $address): ?CoordinatesData
    {
        $response = Http::get('https://api.open-meteo.com/v1/geocode', [
            'address' => $address,
            'key' => config('services.openapi.api_key'),
        ]);

        if (! $response->successful() || empty($response->json()['results'])) {
            return null;
        }

        $location = $response->json()['results'][0];

        return new CoordinatesData(
            latitude: $location['latitude'],
            longitude: $location['longitude']
        );
    }
}
