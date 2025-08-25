<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SaluteOra\Models\Studio;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\Studio>
 */
class StudioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\Studio>
     */
    protected $model = Studio::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $studioTypes = [
            'Studio Dentistico',
            'Centro Odontoiatrico',
            'Clinica Dentale',
            'Ambulatorio Odontoiatrico',
            'Centro di Igiene Dentale',
            'Studio di Ortodonzia',
            'Centro Implantologico',
            'Studio di Endodonzia',
        ];

        $services = [
            'Igiene dentale',
            'Ortodonzia',
            'Implantologia',
            'Endodonzia',
            'Parodontologia',
            'Chirurgia orale',
            'Protesi dentale',
            'Odontoiatria pediatrica',
            'Estetica dentale',
            'Radiologia dentale',
            'Sbiancamento',
            'Devitalizzazione',
            'Otturazione',
            'Estrazione',
        ];

        $openingHours = [
            'monday' => ['08:00-13:00', '14:00-19:00'],
            'tuesday' => ['08:00-13:00', '14:00-19:00'],
            'wednesday' => ['08:00-13:00', '14:00-19:00'],
            'thursday' => ['08:00-13:00', '14:00-19:00'],
            'friday' => ['08:00-13:00', '14:00-19:00'],
            'saturday' => ['08:00-14:00'],
            'sunday' => [],
        ];

        return [
            'name' => $this->faker->randomElement($studioTypes) . ' ' . $this->faker->lastName(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->companyEmail(),
            'website' => $this->faker->optional()->url(),
            'registration_number' => $this->faker->numerify('######'),
            'vat_number' => $this->faker->numerify('IT###########'),
            'description' => $this->faker->optional()->paragraph(),
            'opening_hours' => $openingHours,
            'services' => $this->faker->randomElements($services, $this->faker->numberBetween(3, 7)),
            'active' => true,
            'slug' => $this->faker->unique()->slug(),
        ];
    }

    /**
     * Indica che lo studio è attivo.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => true,
        ]);
    }

    /**
     * Indica che lo studio è inattivo.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }

    /**
     * Indica che lo studio è specializzato in ortodonzia.
     */
    public function orthodontics(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Studio di Ortodonzia ' . $this->faker->lastName(),
            'services' => ['Ortodonzia', 'Igiene dentale', 'Odontoiatria pediatrica'],
        ]);
    }

    /**
     * Indica che lo studio è specializzato in implantologia.
     */
    public function implantology(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Centro Implantologico ' . $this->faker->lastName(),
            'services' => ['Implantologia', 'Chirurgia orale', 'Protesi dentale'],
        ]);
    }
}