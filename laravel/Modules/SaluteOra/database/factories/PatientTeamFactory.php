<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\PatientTeam;
use Modules\User\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for PatientTeam pivot model.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\PatientTeam>
 */
class PatientTeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\PatientTeam>
     */
    protected $model = PatientTeam::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => Patient::factory(),
            'team_id' => Team::factory(),
            'assigned_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'priority_level' => $this->faker->randomElement(['low', 'normal', 'high', 'urgent']),
            'treatment_category' => $this->faker->randomElement([
                'Prevenzione',
                'Conservativa',
                'Endodonzia',
                'Chirurgia',
                'Protesi',
                'Ortodonzia',
                'Parodontologia',
                'Estetica',
            ]),
            'care_plan' => [
                'phase' => $this->faker->randomElement(['assessment', 'treatment', 'maintenance', 'completed']),
                'estimated_sessions' => $this->faker->numberBetween(1, 12),
                'completed_sessions' => $this->faker->numberBetween(0, 6),
                'next_phase' => $this->faker->optional()->randomElement(['treatment', 'maintenance', 'review']),
            ],
            'notes' => $this->faker->optional(0.4)->paragraph(),
            'communication_preferences' => [
                'language' => $this->faker->randomElement(['it', 'en', 'fr', 'de', 'es']),
                'preferred_contact' => $this->faker->randomElement(['phone', 'email', 'sms', 'whatsapp']),
                'appointment_reminders' => $this->faker->boolean(80),
                'treatment_updates' => $this->faker->boolean(60),
            ],
            'accessibility_needs' => $this->faker->optional(0.1)->randomElements([
                'Wheelchair access',
                'Sign language interpreter',
                'Large print materials',
                'Audio instructions',
                'Extended appointment time',
            ], $this->faker->numberBetween(1, 2)),
            'status' => $this->faker->randomElement(['active', 'on_hold', 'completed', 'transferred']),
            'is_active' => $this->faker->boolean(85),
        ];
    }

    /**
     * Indicate that this is a high priority patient.
     */
    public function highPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority_level' => 'high',
            'status' => 'active',
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that this is an urgent case.
     */
    public function urgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority_level' => 'urgent',
            'status' => 'active',
            'is_active' => true,
            'treatment_category' => 'Chirurgia',
        ]);
    }

    /**
     * Indicate that the patient is in assessment phase.
     */
    public function assessment(): static
    {
        return $this->state(fn (array $attributes) => [
            'care_plan' => [
                'phase' => 'assessment',
                'estimated_sessions' => $this->faker->numberBetween(1, 3),
                'completed_sessions' => 0,
                'next_phase' => 'treatment',
            ],
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the patient is in treatment phase.
     */
    public function treatment(): static
    {
        return $this->state(fn (array $attributes) => [
            'care_plan' => [
                'phase' => 'treatment',
                'estimated_sessions' => $this->faker->numberBetween(4, 12),
                'completed_sessions' => $this->faker->numberBetween(1, 6),
                'next_phase' => 'maintenance',
            ],
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the patient is in maintenance phase.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'care_plan' => [
                'phase' => 'maintenance',
                'estimated_sessions' => $this->faker->numberBetween(2, 4),
                'completed_sessions' => $this->faker->numberBetween(0, 2),
                'next_phase' => 'review',
            ],
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the patient treatment is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'care_plan' => [
                'phase' => 'completed',
                'estimated_sessions' => $this->faker->numberBetween(3, 10),
                'completed_sessions' => function (array $attributes) {
                    return $attributes['care_plan']['estimated_sessions'] ?? $this->faker->numberBetween(3, 10);
                },
                'next_phase' => null,
            ],
            'status' => 'completed',
        ]);
    }

    /**
     * Set specific treatment category.
     */
    public function withTreatmentCategory(string $category): static
    {
        return $this->state(fn (array $attributes) => [
            'treatment_category' => $category,
        ]);
    }

    /**
     * Set specific communication preferences.
     *
     * @param array<string, mixed> $preferences
     */
    public function withCommunicationPreferences(array $preferences): static
    {
        return $this->state(fn (array $attributes) => [
            'communication_preferences' => array_merge($attributes['communication_preferences'], $preferences),
        ]);
    }

    /**
     * Set accessibility needs.
     *
     * @param array<string> $needs
     */
    public function withAccessibilityNeeds(array $needs): static
    {
        return $this->state(fn (array $attributes) => [
            'accessibility_needs' => $needs,
        ]);
    }
}
