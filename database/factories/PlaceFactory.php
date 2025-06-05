<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\Place as Model;

/**
 * Class ArticleFactory.
 */
class PlaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            // 'title' => $this->faker->sentence,
            // 'description' => $this->faker->paragraph,
            // 'user_id' => factory(\Modules\Xot\Datas\XotData::make()->getUserClass())->create()->id,

            // 'latitude' => $this->faker->latitude(),
            /*
            'latitude' => $this->faker->Address->latitude,
            'longitude' => $this->faker->longitude(),
            'route' => $this->faker->streetName(),
            'country' => $this->faker->country(),
            'street_number' => $this->faker->buildingNumber(),
            'postal_code' => $this->faker->postcode(),
            'locality' => $this->faker->city(),
            'formatted_address' => $this->faker->streetAddress(),
            */
        ];
    }
}
