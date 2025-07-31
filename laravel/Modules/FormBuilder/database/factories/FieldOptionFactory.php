<?php

namespace Modules\FormBuilder\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FieldOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\FormBuilder\Models\FieldOption::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

