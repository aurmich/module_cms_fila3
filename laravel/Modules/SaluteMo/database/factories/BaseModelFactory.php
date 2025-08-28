<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SaluteMo\Models\BaseModel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteMo\Models\BaseModel>
 */
class BaseModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteMo\Models\BaseModel>
     */
    protected $model = BaseModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'created_by' => $this->faker->uuid(),
            'updated_by' => $this->faker->uuid(),
        ];
    }
}