<?php

namespace Modules\Lang\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Lang\Models\TranslationFile::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

