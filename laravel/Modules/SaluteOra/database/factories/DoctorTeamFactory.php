<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\DoctorTeam;
use Modules\User\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for DoctorTeam pivot model.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\DoctorTeam>
 */
class DoctorTeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\DoctorTeam>
     */
    protected $model = DoctorTeam::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => Doctor::factory(),
            'team_id' => Team::factory(),
            'role' => $this->faker->randomElement(['member', 'senior', 'lead']),
            'permissions' => [
                'view_appointments' => true,
                'manage_own_appointments' => true,
                'view_patients' => true,
                'manage_own_patients' => $this->faker->boolean(80),
                'view_reports' => $this->faker->boolean(70),
                'create_reports' => $this->faker->boolean(90),
            ],
            'specialization' => $this->faker->randomElement([
                'Odontoiatria Generale',
                'Ortodonzia',
                'Endodonzia',
                'Parodontologia',
                'Chirurgia Orale',
                'Protesi Dentaria',
                'Pedodonzia',
                'Odontoiatria Estetica',
            ]),
            'joined_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'weekly_hours' => $this->faker->numberBetween(20, 40),
            'is_active' => $this->faker->boolean(90),
        ];
    }

    /**
     * Indicate that this doctor is a team lead.
     */
    public function lead(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'lead',
            'permissions' => [
                'view_appointments' => true,
                'manage_own_appointments' => true,
                'manage_team_appointments' => true,
                'view_patients' => true,
                'manage_own_patients' => true,
                'manage_team_patients' => true,
                'view_reports' => true,
                'create_reports' => true,
                'approve_reports' => true,
            ],
            'weekly_hours' => $this->faker->numberBetween(35, 40),
        ]);
    }

    /**
     * Indicate that this doctor is a senior member.
     */
    public function senior(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'senior',
            'permissions' => [
                'view_appointments' => true,
                'manage_own_appointments' => true,
                'view_patients' => true,
                'manage_own_patients' => true,
                'view_reports' => true,
                'create_reports' => true,
                'mentor_junior' => true,
            ],
            'weekly_hours' => $this->faker->numberBetween(30, 40),
        ]);
    }

    /**
     * Indicate that this doctor is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
            'weekly_hours' => 0,
        ]);
    }

    /**
     * Set a specific specialization.
     */
    public function withSpecialization(string $specialization): static
    {
        return $this->state(fn (array $attributes) => [
            'specialization' => $specialization,
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
