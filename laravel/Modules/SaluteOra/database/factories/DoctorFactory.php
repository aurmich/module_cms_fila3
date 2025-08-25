<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Enums\UserTypeEnum;

/**
 * Factory per la creazione di dottori con dati realistici.
 * 
 * Boy Scout Rule Applied:
 * - Aggiunta gestione nomi realistici per dottori italiani
 * - Migliorata struttura delle certificazioni
 * - Aggiunta coerenza con dati italiani
 * - Rimossi campi non esistenti nella tabella
 * - Cleaner code structure and better documentation
 *
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
        $firstName = $this->getRandomFirstName();
        $lastName = $this->getRandomLastName();
        $title = $this->getRandomDoctorTitle();
        
        return [
            'name' => $title . ' ' . $firstName . ' ' . $lastName,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->generateItalianPhoneNumber(),
            'address' => $this->generateFullAddress(),
            'city' => $this->getRandomItalianCity(),
            'type' => UserTypeEnum::DOCTOR->value,
            'status' => 'active',
            'is_active' => true,
            'is_otp' => $this->faker->boolean(20), // 20% doctors use OTP
            
            // Professional credentials (enhanced structure)
            'registration_number' => $this->generateRegistrationNumber(),
            'certifications' => $this->generateCertifications(),
        ];
    }

    /**
     * Indica che il dottore ha molte certificazioni.
     *
     * @return static
     */
    public function highlyCertified(): static
    {
        return $this->state(fn (array $attributes) => [
            'certifications' => json_encode([
                'basic_certification' => true,
                'advanced_certification' => true,
                'specialty_certification' => true
            ]),
        ]);
    }

    /**
     * Indica che il dottore ha poche certificazioni.
     *
     * @return static
     */
    public function basicCertified(): static
    {
        return $this->state(fn (array $attributes) => [
            'certifications' => json_encode([
                'basic_certification' => true,
                'advanced_certification' => false,
                'specialty_certification' => false
            ]),
        ]);
    }

    /**
     * Get a random Italian first name.
     *
     * @return string
     */
    private function getRandomFirstName(): string
    {
        $firstNames = [
            'Marco', 'Giuseppe', 'Francesco', 'Antonio', 'Alessandro', 'Andrea', 'Luigi', 
            'Matteo', 'Luca', 'Giovanni', 'Maria', 'Anna', 'Giuseppina', 'Rosa', 'Angela',
            'Giovanna', 'Teresa', 'Lucia', 'Francesca', 'Paola'
        ];
        
        return $this->faker->randomElement($firstNames);
    }

    /**
     * Get a random Italian last name.
     *
     * @return string
     */
    private function getRandomLastName(): string
    {
        $lastNames = [
            'Rossi', 'Russo', 'Ferrari', 'Esposito', 'Bianchi', 'Romano', 'Colombo', 
            'Ricci', 'Marino', 'Greco', 'Bruno', 'Gallo', 'Conti', 'De Luca', 'Mancini'
        ];
        
        return $this->faker->randomElement($lastNames);
    }

    /**
     * Get a random doctor title.
     *
     * @return string
     */
    private function getRandomDoctorTitle(): string
    {
        $doctorTitles = ['Dr.', 'Dr.ssa'];
        return $this->faker->randomElement($doctorTitles);
    }

    /**
     * Get a random Italian city.
     *
     * @return string
     */
    private function getRandomItalianCity(): string
    {
        $cities = ['Milano', 'Roma', 'Napoli', 'Torino', 'Palermo', 'Genova', 'Bologna', 'Firenze'];
        return $this->faker->randomElement($cities);
    }

    /**
     * Generate a realistic Italian phone number.
     *
     * @return string
     */
    private function generateItalianPhoneNumber(): string
    {
        $prefixes = ['+39', '0039'];
        $prefix = $this->faker->randomElement($prefixes);
        
        // Italian mobile numbers: 3xx xxx xxxx
        if ($this->faker->boolean(70)) {
            return $prefix . ' ' . $this->faker->numerify('### ### ####');
        }
        
        // Italian landline numbers: 0xx xxx xxxx
        return $prefix . ' ' . $this->faker->numerify('### ### ####');
    }

    /**
     * Generate a full address with building number.
     *
     * @return string
     */
    private function generateFullAddress(): string
    {
        return $this->faker->streetAddress() . ', ' . $this->faker->buildingNumber();
    }

    /**
     * Generate a registration number.
     *
     * @return string
     */
    private function generateRegistrationNumber(): string
    {
        return 'ORD' . $this->faker->unique()->numberBetween(1000, 9999);
    }

    /**
     * Generate certifications data.
     *
     * @return array<string, mixed>
     */
    private function generateCertifications(): array
    {
        $specializations = [
            'Odontoiatria Generale', 'Ortodonzia', 'Endodonzia', 'Parodontologia',
            'Chirurgia Orale', 'Implantologia', 'Odontoiatria Pediatrica', 'Estetica Dentale'
        ];

        return [
            'specialization' => $this->faker->randomElement($specializations),
            'basic_certification' => true,
            'advanced_certification' => $this->faker->boolean(70),
            'specialty_certification' => $this->faker->boolean(50),
            'years_experience' => $this->faker->numberBetween(2, 35),
            'graduation_year' => $this->faker->numberBetween(1990, 2020),
            'continuing_education' => $this->faker->boolean(80),
        ];
    }
}
