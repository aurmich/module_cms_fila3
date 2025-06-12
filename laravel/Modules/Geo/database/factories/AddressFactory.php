<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\Address as Model;
use Modules\Geo\Enums\AddressTypeEnum;

/**
 * AddressFactory
 * 
 * Factory per generare indirizzi di test per il modello Address
 */
class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Coordinate per alcune città italiane principali
        $italianCities = [
            'Milano' => ['lat' => 45.4642, 'lng' => 9.1900, 'province' => 'Milano', 'region' => 'Lombardia', 'postal' => '20100'],
            'Roma' => ['lat' => 41.9028, 'lng' => 12.4964, 'province' => 'Roma', 'region' => 'Lazio', 'postal' => '00100'],
            'Napoli' => ['lat' => 40.8518, 'lng' => 14.2681, 'province' => 'Napoli', 'region' => 'Campania', 'postal' => '80100'],
            'Torino' => ['lat' => 45.0703, 'lng' => 7.6869, 'province' => 'Torino', 'region' => 'Piemonte', 'postal' => '10100'],
            'Palermo' => ['lat' => 38.1157, 'lng' => 13.3613, 'province' => 'Palermo', 'region' => 'Sicilia', 'postal' => '90100'],
            'Genova' => ['lat' => 44.4056, 'lng' => 8.9463, 'province' => 'Genova', 'region' => 'Liguria', 'postal' => '16100'],
            'Bologna' => ['lat' => 44.4949, 'lng' => 11.3426, 'province' => 'Bologna', 'region' => 'Emilia-Romagna', 'postal' => '40100'],
            'Firenze' => ['lat' => 43.7696, 'lng' => 11.2558, 'province' => 'Firenze', 'region' => 'Toscana', 'postal' => '50100'],
            'Venezia' => ['lat' => 45.4408, 'lng' => 12.3155, 'province' => 'Venezia', 'region' => 'Veneto', 'postal' => '30100'],
            'Bari' => ['lat' => 41.1171, 'lng' => 16.8719, 'province' => 'Bari', 'region' => 'Puglia', 'postal' => '70100'],
        ];

        // Seleziona una città casuale
        $cityName = $this->faker->randomElement(array_keys($italianCities));
        $cityData = $italianCities[$cityName];
        
        // Aggiungi variazione alle coordinate (±0.05 gradi per simulare diversi indirizzi nella stessa città)
        $latitude = $cityData['lat'] + $this->faker->randomFloat(4, -0.05, 0.05);
        $longitude = $cityData['lng'] + $this->faker->randomFloat(4, -0.05, 0.05);
        
        $streetName = $this->faker->streetName();
        $streetNumber = $this->faker->buildingNumber();
        $route = "Via {$streetName}";

        return [
            'name' => $this->faker->optional(0.7)->randomElement([
                'Casa',
                'Ufficio',
                'Sede Principale',
                'Filiale',
                'Magazzino',
                'Studio',
            ]),
            'description' => $this->faker->optional(0.5)->sentence(),
            'route' => $route,
            'street_number' => $streetNumber,
            'locality' => $cityName,
            'administrative_area_level_3' => $cityData['province'], // Provincia
            'administrative_area_level_2' => $cityData['region'], // Regione
            'administrative_area_level_1' => 'Italia',
            'country' => 'IT',
            'postal_code' => $this->faker->randomElement([
                $cityData['postal'],
                substr($cityData['postal'], 0, 3) . $this->faker->numberBetween(10, 99),
            ]),
            'formatted_address' => "{$route} {$streetNumber}, {$cityData['postal']} {$cityName} ({$cityData['province']}), Italia",
            'place_id' => $this->faker->optional(0.8)->regexify('ChIJ[A-Za-z0-9_-]{20,30}'),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'type' => $this->faker->randomElement(AddressTypeEnum::cases()),
            'is_primary' => $this->faker->boolean(30), // 30% probabilità di essere primario
            'extra_data' => $this->faker->optional(0.4)->randomElements([
                'provincia_sigla' => substr($cityData['province'], 0, 2),
                'google_rating' => $this->faker->randomFloat(1, 3.0, 5.0),
                'google_reviews_count' => $this->faker->numberBetween(10, 500),
                'verified' => $this->faker->boolean(80),
                'notes' => $this->faker->sentence(),
            ], $this->faker->numberBetween(1, 3), true),
        ];
    }

    /**
     * Indicate that the address is primary.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function primary(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_primary' => true,
            ];
        });
    }

    /**
     * Indicate that the address is of a specific type.
     *
     * @param AddressTypeEnum $type
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function ofType(AddressTypeEnum $type): Factory
    {
        return $this->state(function (array $attributes) use ($type) {
            return [
                'type' => $type,
            ];
        });
    }

    /**
     * Generate a home address.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function home(): Factory
    {
        return $this->ofType(AddressTypeEnum::HOME)->state([
            'name' => 'Casa',
            'is_primary' => true,
        ]);
    }

    /**
     * Generate a work address.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function work(): Factory
    {
        return $this->ofType(AddressTypeEnum::WORK)->state([
            'name' => 'Ufficio',
        ]);
    }

    /**
     * Generate a billing address.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function billing(): Factory
    {
        return $this->ofType(AddressTypeEnum::BILLING)->state([
            'name' => 'Indirizzo di Fatturazione',
        ]);
    }

    /**
     * Generate a shipping address.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function shipping(): Factory
    {
        return $this->ofType(AddressTypeEnum::SHIPPING)->state([
            'name' => 'Indirizzo di Spedizione',
        ]);
    }

    /**
     * Generate an address in a specific city.
     *
     * @param string $city
     * @param array<string, mixed> $cityData
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inCity(string $city, array $cityData = []): Factory
    {
        $defaultCityData = [
            'lat' => 45.4642,
            'lng' => 9.1900,
            'province' => $city,
            'region' => 'Lombardia',
            'postal' => '20100',
        ];

        $cityInfo = array_merge($defaultCityData, $cityData);

        return $this->state(function (array $attributes) use ($city, $cityInfo) {
            $latitude = $cityInfo['lat'] + $this->faker->randomFloat(4, -0.05, 0.05);
            $longitude = $cityInfo['lng'] + $this->faker->randomFloat(4, -0.05, 0.05);
            $streetName = $this->faker->streetName();
            $streetNumber = $this->faker->buildingNumber();
            $route = "Via {$streetName}";

            return [
                'locality' => $city,
                'administrative_area_level_3' => $cityInfo['province'],
                'administrative_area_level_2' => $cityInfo['region'],
                'postal_code' => $cityInfo['postal'],
                'latitude' => $latitude,
                'longitude' => $longitude,
                'route' => $route,
                'street_number' => $streetNumber,
                'formatted_address' => "{$route} {$streetNumber}, {$cityInfo['postal']} {$city} ({$cityInfo['province']}), Italia",
            ];
        });
    }
} 