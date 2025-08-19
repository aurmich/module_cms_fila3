<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\StudioUser;
use Modules\SaluteOra\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for StudioUser pivot model.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\StudioUser>
 */
class StudioUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\StudioUser>
     */
    protected $model = StudioUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'studio_id' => Studio::factory(),
            'type' => $this->faker->randomElement(['doctor', 'admin', 'patient']),
            'schedule' => [
                'monday' => ['09:00-12:00', '14:00-18:00'],
                'tuesday' => ['09:00-12:00', '14:00-18:00'],
                'wednesday' => ['09:00-12:00', '14:00-18:00'],
                'thursday' => ['09:00-12:00', '14:00-18:00'],
                'friday' => ['09:00-12:00', '14:00-18:00'],
                'saturday' => ['09:00-12:00'],
                'sunday' => [],
            ],
            'is_primary' => $this->faker->boolean(30),
            'role' => $this->faker->randomElement(['owner', 'manager', 'member', 'guest']),
            'permissions' => [
                'view_appointments' => $this->faker->boolean(90),
                'manage_appointments' => $this->faker->boolean(60),
                'view_patients' => $this->faker->boolean(80),
                'manage_patients' => $this->faker->boolean(40),
                'view_reports' => $this->faker->boolean(70),
                'manage_reports' => $this->faker->boolean(30),
                'billing_access' => $this->faker->boolean(20),
            ],
            'joined_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'status' => $this->faker->randomElement(['active', 'inactive', 'suspended', 'pending']),
            'hourly_rate' => $this->faker->optional(0.6)->numberBetween(30, 120),
            'commission_rate' => $this->faker->optional(0.4)->numberBetween(5, 25),
            'notes' => $this->faker->optional(0.3)->paragraph(),
        ];
    }

    /**
     * Indicate that this user is the studio owner.
     */
    public function owner(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'admin',
            'role' => 'owner',
            'is_primary' => true,
            'status' => 'active',
            'permissions' => [
                'view_appointments' => true,
                'manage_appointments' => true,
                'view_patients' => true,
                'manage_patients' => true,
                'view_reports' => true,
                'manage_reports' => true,
                'billing_access' => true,
                'studio_settings' => true,
                'user_management' => true,
            ],
        ]);
    }

    /**
     * Indicate that this user is a studio manager.
     */
    public function manager(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'admin',
            'role' => 'manager',
            'status' => 'active',
            'permissions' => [
                'view_appointments' => true,
                'manage_appointments' => true,
                'view_patients' => true,
                'manage_patients' => true,
                'view_reports' => true,
                'manage_reports' => true,
                'billing_access' => false,
                'user_management' => false,
            ],
        ]);
    }

    /**
     * Indicate that this user is a doctor.
     */
    public function doctor(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'doctor',
            'role' => 'member',
            'status' => 'active',
            'hourly_rate' => $this->faker->numberBetween(50, 120),
            'commission_rate' => $this->faker->numberBetween(15, 30),
            'permissions' => [
                'view_appointments' => true,
                'manage_appointments' => true,
                'view_patients' => true,
                'manage_patients' => true,
                'view_reports' => true,
                'manage_reports' => true,
                'billing_access' => false,
            ],
        ]);
    }

    /**
     * Indicate that this user is a patient.
     */
    public function patient(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'patient',
            'role' => 'guest',
            'schedule' => null,
            'hourly_rate' => null,
            'commission_rate' => null,
            'permissions' => [
                'view_appointments' => true,
                'manage_appointments' => false,
                'view_patients' => false,
                'manage_patients' => false,
                'view_reports' => false,
                'manage_reports' => false,
                'billing_access' => false,
            ],
        ]);
    }

    /**
     * Indicate that this user is pending approval.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'permissions' => [
                'view_appointments' => false,
                'manage_appointments' => false,
                'view_patients' => false,
                'manage_patients' => false,
                'view_reports' => false,
                'manage_reports' => false,
                'billing_access' => false,
            ],
        ]);
    }

    /**
     * Indicate that this user is suspended.
     */
    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'suspended',
            'permissions' => [
                'view_appointments' => false,
                'manage_appointments' => false,
                'view_patients' => false,
                'manage_patients' => false,
                'view_reports' => false,
                'manage_reports' => false,
                'billing_access' => false,
            ],
        ]);
    }

    /**
     * Set custom permissions.
     *
     * @param array<string, bool> $permissions
     */
    public function withPermissions(array $permissions): static
    {
        return $this->state(fn (array $attributes) => [
            'permissions' => array_merge($attributes['permissions'], $permissions),
        ]);
    }

    /**
     * Set a custom schedule.
     *
     * @param array<string, array<string>>|null $schedule
     */
    public function withSchedule(?array $schedule): static
    {
        return $this->state(fn (array $attributes) => [
            'schedule' => $schedule,
        ]);
    }

    /**
     * Set financial terms.
     */
    public function withFinancialTerms(int $hourlyRate, int $commissionRate): static
    {
        return $this->state(fn (array $attributes) => [
            'hourly_rate' => $hourlyRate,
            'commission_rate' => $commissionRate,
        ]);
    }
}
