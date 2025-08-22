<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\Address;
use Modules\Geo\Models\Comune;

/**
 * Address Factory
 * 
 * @extends Factory<Address>
 */
class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'street' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'zip' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            // Use explicit Italian regions to avoid calling unavailable faker->state()
            'state' => $this->faker->randomElement([
                'Lombardia', 'Lazio', 'Campania', 'Sicilia', 'Veneto',
                'Piemonte', 'Toscana', 'Emilia-Romagna', 'Puglia', 'Calabria',
            ]),
            'country' => 'IT',
            'latitude' => $this->faker->latitude(35.0, 47.0), // Italy bounds
            'longitude' => $this->faker->longitude(6.0, 19.0),
            'comune_id' => Comune::factory(),
        ];
    }

    public function italian(): static
    {
        return $this->state(fn (array $attributes): array => [
            'country' => 'IT',
            'state' => $this->faker->randomElement(['Lombardia', 'Lazio', 'Campania', 'Sicilia', 'Veneto']),
        ]);
    }
}