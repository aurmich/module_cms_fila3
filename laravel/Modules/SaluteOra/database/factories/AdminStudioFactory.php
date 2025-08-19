<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Modules\SaluteOra\Models\Admin;
use Modules\SaluteOra\Models\AdminStudio;
use Modules\SaluteOra\Models\Studio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for AdminStudio pivot model.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\AdminStudio>
 */
class AdminStudioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\AdminStudio>
     */
    protected $model = AdminStudio::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => Admin::factory(),
            'studio_id' => Studio::factory(),
            'schedule' => [
                'monday' => ['09:00-12:00', '14:00-18:00'],
                'tuesday' => ['09:00-12:00', '14:00-18:00'],
                'wednesday' => ['09:00-12:00', '14:00-18:00'],
                'thursday' => ['09:00-12:00', '14:00-18:00'],
                'friday' => ['09:00-12:00', '14:00-18:00'],
                'saturday' => ['09:00-12:00'],
                'sunday' => [],
            ],
            'is_primary' => $this->faker->boolean(30), // 30% chance of being primary
        ];
    }

    /**
     * Indicate that this is the primary studio for the admin.
     */
    public function primary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => true,
        ]);
    }

    /**
     * Indicate that this is not a primary studio.
     */
    public function secondary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => false,
        ]);
    }

    /**
     * Set a custom schedule.
     *
     * @param array<string, array<string>> $schedule
     */
    public function withSchedule(array $schedule): static
    {
        return $this->state(fn (array $attributes) => [
            'schedule' => $schedule,
        ]);
    }
}
