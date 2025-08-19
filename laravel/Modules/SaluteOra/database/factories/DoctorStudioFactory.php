<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\DoctorStudio;
use Modules\SaluteOra\Models\Studio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for DoctorStudio pivot model.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\DoctorStudio>
 */
class DoctorStudioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\DoctorStudio>
     */
    protected $model = DoctorStudio::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => Doctor::factory(),
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
            'is_primary' => $this->faker->boolean(40), // 40% chance of being primary
            'hourly_rate' => $this->faker->numberBetween(50, 150), // Tariffa oraria in euro
            'commission_rate' => $this->faker->numberBetween(10, 30), // Percentuale commissione
            'specializations' => $this->faker->randomElements([
                'Odontoiatria Generale',
                'Ortodonzia',
                'Endodonzia',
                'Parodontologia',
                'Chirurgia Orale',
                'Protesi Dentaria',
                'Pedodonzia',
                'Odontoiatria Estetica',
            ], $this->faker->numberBetween(1, 3)),
            'available_services' => $this->faker->randomElements([
                'Visita di controllo',
                'Pulizia dentale',
                'Otturazione',
                'Devitalizzazione',
                'Estrazione',
                'Impianto',
                'Protesi',
                'Apparecchio ortodontico',
            ], $this->faker->numberBetween(3, 8)),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Indicate that this is the primary studio for the doctor.
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

    /**
     * Set specific specializations.
     *
     * @param array<string> $specializations
     */
    public function withSpecializations(array $specializations): static
    {
        return $this->state(fn (array $attributes) => [
            'specializations' => $specializations,
        ]);
    }

    /**
     * Set a part-time schedule.
     */
    public function partTime(): static
    {
        return $this->state(fn (array $attributes) => [
            'schedule' => [
                'monday' => ['09:00-12:00'],
                'tuesday' => [],
                'wednesday' => ['14:00-18:00'],
                'thursday' => [],
                'friday' => ['09:00-12:00'],
                'saturday' => [],
                'sunday' => [],
            ],
        ]);
    }

    /**
     * Set a full-time schedule.
     */
    public function fullTime(): static
    {
        return $this->state(fn (array $attributes) => [
            'schedule' => [
                'monday' => ['08:00-12:00', '14:00-19:00'],
                'tuesday' => ['08:00-12:00', '14:00-19:00'],
                'wednesday' => ['08:00-12:00', '14:00-19:00'],
                'thursday' => ['08:00-12:00', '14:00-19:00'],
                'friday' => ['08:00-12:00', '14:00-19:00'],
                'saturday' => ['08:00-12:00'],
                'sunday' => [],
            ],
        ]);
    }
}
