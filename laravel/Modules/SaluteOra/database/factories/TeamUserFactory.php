<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Modules\SaluteOra\Models\TeamUser;
use Modules\SaluteOra\Models\User;
use Modules\User\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for TeamUser pivot model.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\TeamUser>
 */
class TeamUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\TeamUser>
     */
    protected $model = TeamUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'team_id' => Team::factory(),
            'role' => $this->faker->randomElement(['owner', 'admin', 'member', 'guest']),
            'joined_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'permissions' => [
                'view_team_data' => $this->faker->boolean(90),
                'manage_team_members' => $this->faker->boolean(30),
                'manage_team_settings' => $this->faker->boolean(20),
                'view_team_reports' => $this->faker->boolean(70),
                'manage_team_reports' => $this->faker->boolean(40),
                'invite_members' => $this->faker->boolean(50),
                'remove_members' => $this->faker->boolean(25),
            ],
            'status' => $this->faker->randomElement(['active', 'inactive', 'pending', 'suspended']),
            'invitation_accepted_at' => $this->faker->optional(0.8)->dateTimeBetween('-1 year', 'now'),
            'last_activity_at' => $this->faker->optional(0.9)->dateTimeBetween('-1 month', 'now'),
            'department' => $this->faker->optional(0.6)->randomElement([
                'Amministrazione',
                'Clinico',
                'Chirurgia',
                'Ortodonzia',
                'Prevenzione',
                'Accoglienza',
                'Igiene Dentale',
            ]),
            'position' => $this->faker->optional(0.7)->randomElement([
                'Direttore Sanitario',
                'Odontoiatra Senior',
                'Odontoiatra Junior',
                'Igienista Dentale',
                'Assistente alla Poltrona',
                'Segretaria',
                'Responsabile Amministrativo',
            ]),
            'employment_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract', 'consultant']),
            'weekly_hours' => $this->faker->numberBetween(10, 40),
            'notes' => $this->faker->optional(0.3)->paragraph(),
        ];
    }

    /**
     * Indicate that this user is the team owner.
     */
    public function owner(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'owner',
            'status' => 'active',
            'permissions' => [
                'view_team_data' => true,
                'manage_team_members' => true,
                'manage_team_settings' => true,
                'view_team_reports' => true,
                'manage_team_reports' => true,
                'invite_members' => true,
                'remove_members' => true,
                'delete_team' => true,
                'billing_management' => true,
            ],
            'employment_type' => 'full-time',
            'weekly_hours' => 40,
        ]);
    }

    /**
     * Indicate that this user is a team admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'status' => 'active',
            'permissions' => [
                'view_team_data' => true,
                'manage_team_members' => true,
                'manage_team_settings' => false,
                'view_team_reports' => true,
                'manage_team_reports' => true,
                'invite_members' => true,
                'remove_members' => true,
            ],
            'employment_type' => $this->faker->randomElement(['full-time', 'part-time']),
            'weekly_hours' => $this->faker->numberBetween(25, 40),
        ]);
    }

    /**
     * Indicate that this user is a regular team member.
     */
    public function member(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'member',
            'status' => 'active',
            'permissions' => [
                'view_team_data' => true,
                'manage_team_members' => false,
                'manage_team_settings' => false,
                'view_team_reports' => true,
                'manage_team_reports' => false,
                'invite_members' => false,
                'remove_members' => false,
            ],
            'employment_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract']),
            'weekly_hours' => $this->faker->numberBetween(15, 40),
        ]);
    }

    /**
     * Indicate that this user is a guest.
     */
    public function guest(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'guest',
            'status' => 'active',
            'permissions' => [
                'view_team_data' => false,
                'manage_team_members' => false,
                'manage_team_settings' => false,
                'view_team_reports' => false,
                'manage_team_reports' => false,
                'invite_members' => false,
                'remove_members' => false,
            ],
            'employment_type' => 'consultant',
            'weekly_hours' => $this->faker->numberBetween(5, 20),
        ]);
    }

    /**
     * Indicate that this user has a pending invitation.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'invitation_accepted_at' => null,
            'last_activity_at' => null,
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
                'view_team_data' => false,
                'manage_team_members' => false,
                'manage_team_settings' => false,
                'view_team_reports' => false,
                'manage_team_reports' => false,
                'invite_members' => false,
                'remove_members' => false,
            ],
        ]);
    }

    /**
     * Set specific department and position.
     */
    public function withPosition(string $department, string $position): static
    {
        return $this->state(fn (array $attributes) => [
            'department' => $department,
            'position' => $position,
        ]);
    }

    /**
     * Set employment details.
     */
    public function withEmployment(string $type, int $weeklyHours): static
    {
        return $this->state(fn (array $attributes) => [
            'employment_type' => $type,
            'weekly_hours' => $weeklyHours,
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
     * Set recent activity.
     */
    public function recentlyActive(): static
    {
        return $this->state(fn (array $attributes) => [
            'last_activity_at' => $this->faker->dateTimeBetween('-3 days', 'now'),
            'status' => 'active',
        ]);
    }

    /**
     * Set inactive status.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
            'last_activity_at' => $this->faker->dateTimeBetween('-6 months', '-1 month'),
        ]);
    }
}
