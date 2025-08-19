<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Modules\SaluteOra\Models\Admin;
use Modules\SaluteOra\Models\AdminTeam;
use Modules\User\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for AdminTeam pivot model.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\AdminTeam>
 */
class AdminTeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\AdminTeam>
     */
    protected $model = AdminTeam::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => Admin::factory(),
            'team_id' => Team::factory(),
            'role' => $this->faker->randomElement(['owner', 'admin', 'manager']),
            'permissions' => [
                'manage_appointments' => $this->faker->boolean(80),
                'manage_doctors' => $this->faker->boolean(70),
                'manage_patients' => $this->faker->boolean(90),
                'manage_reports' => $this->faker->boolean(60),
                'manage_billing' => $this->faker->boolean(50),
            ],
            'joined_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Indicate that this admin is the team owner.
     */
    public function owner(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'owner',
            'permissions' => [
                'manage_appointments' => true,
                'manage_doctors' => true,
                'manage_patients' => true,
                'manage_reports' => true,
                'manage_billing' => true,
                'manage_settings' => true,
            ],
        ]);
    }

    /**
     * Indicate that this admin is a team manager.
     */
    public function manager(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'manager',
            'permissions' => [
                'manage_appointments' => true,
                'manage_doctors' => true,
                'manage_patients' => true,
                'manage_reports' => true,
                'manage_billing' => false,
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
            'permissions' => $permissions,
        ]);
    }
}
