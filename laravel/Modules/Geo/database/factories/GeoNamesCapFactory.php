<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\GeoNamesCap;

/**
 * GeoNamesCap Factory
 * 
 * @extends Factory<GeoNamesCap>
 */
class GeoNamesCapFactory extends Factory
{
    protected $model = GeoNamesCap::class;

    public function definition(): array
    {
        /** @var string $cap */
        $cap = $this->faker->regexify('[0-9]{5}');
        /** @var string $comune */
        $comune = $this->faker->randomElement(['Milano', 'Roma', 'Napoli', 'Torino', 'Palermo']);
        
        return [
            'cap' => $cap,
            'comune' => $comune,
            'provincia' => $this->faker->randomElement(['MI', 'RM', 'NA', 'TO', 'PA']),
            'regione' => $this->faker->randomElement(['Lombardia', 'Lazio', 'Campania', 'Piemonte', 'Sicilia']),
            'latitude' => $this->faker->latitude(35.0, 47.0),
            'longitude' => $this->faker->longitude(6.0, 19.0),
        ];
    }

    public function milano(): static
    {
        return $this->state(fn (array $attributes): array => [
            'cap' => '20100',
            'comune' => 'Milano',
            'provincia' => 'MI',
            'regione' => 'Lombardia',
        ]);
    }
}
