<?php

namespace Modules\SaluteOra\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PatientIseeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\SaluteOra\Models\PatientIsee::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

