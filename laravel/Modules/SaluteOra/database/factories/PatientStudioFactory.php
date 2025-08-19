<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\PatientStudio;
use Modules\SaluteOra\Models\Studio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for PatientStudio pivot model.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\PatientStudio>
 */
class PatientStudioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\PatientStudio>
     */
    protected $model = PatientStudio::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => Patient::factory(),
            'studio_id' => Studio::factory(),
            'registration_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'patient_code' => $this->faker->unique()->numerify('PAT####'),
            'is_primary' => $this->faker->boolean(80), // 80% chance of being primary
            'preferred_doctor_id' => null, // Will be set by relationships
            'medical_notes' => $this->faker->optional(0.3)->paragraph(),
            'allergies' => $this->faker->optional(0.2)->randomElements([
                'Penicillina',
                'Lattice',
                'Metalli',
                'Anestetici locali',
                'Iodio',
                'Aspirina',
            ], $this->faker->numberBetween(1, 3)),
            'emergency_contact' => [
                'name' => $this->faker->name(),
                'phone' => $this->faker->phoneNumber(),
                'relationship' => $this->faker->randomElement(['Coniuge', 'Genitore', 'Figlio/a', 'Fratello/Sorella', 'Amico/a']),
            ],
            'insurance_info' => [
                'provider' => $this->faker->optional(0.6)->company(),
                'policy_number' => $this->faker->optional(0.6)->numerify('POL########'),
                'coverage_type' => $this->faker->optional(0.6)->randomElement(['Completa', 'Parziale', 'Solo Emergenze']),
            ],
            'consent_forms' => [
                'privacy' => $this->faker->boolean(95),
                'treatment' => $this->faker->boolean(90),
                'marketing' => $this->faker->boolean(40),
                'data_sharing' => $this->faker->boolean(30),
            ],
            'last_visit' => $this->faker->optional(0.7)->dateTimeBetween('-1 year', 'now'),
            'next_appointment' => $this->faker->optional(0.3)->dateTimeBetween('now', '+3 months'),
            'status' => $this->faker->randomElement(['active', 'inactive', 'suspended', 'archived']),
        ];
    }

    /**
     * Indicate that this is the primary studio for the patient.
     */
    public function primary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => true,
            'status' => 'active',
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
     * Indicate that the patient is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'last_visit' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    /**
     * Indicate that the patient is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
            'last_visit' => $this->faker->dateTimeBetween('-2 years', '-1 year'),
            'next_appointment' => null,
        ]);
    }

    /**
     * Set specific allergies.
     *
     * @param array<string> $allergies
     */
    public function withAllergies(array $allergies): static
    {
        return $this->state(fn (array $attributes) => [
            'allergies' => $allergies,
        ]);
    }

    /**
     * Set specific medical notes.
     */
    public function withMedicalNotes(string $notes): static
    {
        return $this->state(fn (array $attributes) => [
            'medical_notes' => $notes,
        ]);
    }

    /**
     * Set emergency contact information.
     *
     * @param array<string, string> $contact
     */
    public function withEmergencyContact(array $contact): static
    {
        return $this->state(fn (array $attributes) => [
            'emergency_contact' => $contact,
        ]);
    }

    /**
     * Set insurance information.
     *
     * @param array<string, string|null> $insurance
     */
    public function withInsurance(array $insurance): static
    {
        return $this->state(fn (array $attributes) => [
            'insurance_info' => $insurance,
        ]);
    }
}
