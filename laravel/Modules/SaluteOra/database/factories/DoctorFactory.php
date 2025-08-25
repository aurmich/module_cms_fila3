<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Enums\UserTypeEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\Doctor>
     */
    protected $model = Doctor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $yearsExperience = $this->faker->numberBetween(1, 35);
        $graduationYear = (int) date('Y') - $yearsExperience - $this->faker->numberBetween(6, 8);

        return [
            'name' => 'Dr. ' . $this->faker->name(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'province' => $this->faker->stateAbbr(),
            'country' => 'IT',
            'type' => UserTypeEnum::DOCTOR->value,
            'status' => 'active',
            
            // Professional credentials
            'registration_number' => 'OMD' . $this->faker->unique()->numberBetween(10000, 99999),
            'specialization' => $this->faker->randomElement([
                'Odontoiatria Generale',
                'Ortodonzia',
                'Endodonzia',
                'Parodontologia',
                'Chirurgia Orale',
                'Implantologia',
                'Odontoiatria Pediatrica',
                'Estetica Dentale'
            ]),
            'certifications' => json_encode([
                'basic_certification' => true,
                'advanced_certification' => $this->faker->boolean(70),
                'specialty_certification' => $this->faker->boolean(50)
            ]),
            
            // Education and training
            'graduation_year' => $graduationYear,
            'years_experience' => $yearsExperience,
            
            // Practice information
            'consultation_fee' => $this->faker->numberBetween(50, 200),
            'accepts_new_patients' => $this->faker->boolean(80),
            'emergency_availability' => $this->faker->boolean(60),
            
            // Availability
            'availability' => json_encode([
                'monday' => ['08:00-13:00', '14:00-19:00'],
                'tuesday' => ['08:00-13:00', '14:00-19:00'],
                'wednesday' => ['08:00-13:00', '14:00-19:00'],
                'thursday' => ['08:00-13:00', '14:00-19:00'],
                'friday' => ['08:00-13:00', '14:00-19:00'],
                'saturday' => ['08:00-14:00'],
                'sunday' => []
            ]),
        ];
    }

    /**
     * Indica che il dottore è specializzato in ortodonzia.
     */
    public function orthodontist(): static
    {
        return $this->state(fn (array $attributes) => [
            'specialization' => 'Ortodonzia',
        ]);
    }

    /**
     * Indica che il dottore è specializzato in implantologia.
     */
    public function implantologist(): static
    {
        return $this->state(fn (array $attributes) => [
            'specialization' => 'Implantologia',
        ]);
    }

    /**
     * Indica che il dottore è specializzato in endodonzia.
     */
    public function endodontist(): static
    {
        return $this->state(fn (array $attributes) => [
            'specialization' => 'Endodonzia',
        ]);
    }

    /**
     * Indica che il dottore ha molti anni di esperienza.
     */
    public function experienced(): static
    {
        return $this->state(fn (array $attributes) => [
            'years_experience' => $this->faker->numberBetween(15, 35),
        ]);
    }

    /**
     * Indica che il dottore è nuovo e ha poca esperienza.
     */
    public function newGraduate(): static
    {
        return $this->state(fn (array $attributes) => [
            'years_experience' => $this->faker->numberBetween(1, 5),
        ]);
    }
}
