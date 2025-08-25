<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Enums\UserTypeEnum;

/**
 * Factory per la creazione di pazienti con dati realistici.
 * 
 * Boy Scout Rule Applied:
 * - Improved fiscal code generation with realistic format
 * - Enhanced date generation using faker methods
 * - Better phone number formatting for Italian context
 * - Realistic email generation using faker
 * - Improved address and city data
 * - Cleaner code structure and better documentation
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\Patient>
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'fiscal_code' => $this->generateRealisticFiscalCode(),
            'date_of_birth' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
            'phone' => $this->generateItalianPhoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'type' => UserTypeEnum::PATIENT->value,
            'status' => 'active',
            'is_active' => true,
            'is_otp' => false,
        ];
    }

    /**
     * Indica che il paziente è incinta.
     *
     * @return static
     */
    public function pregnant(): static
    {
        return $this->state(fn (array $attributes) => [
            'pregnancy_certificate' => 'pregnant',
        ]);
    }

    /**
     * Indica che il paziente ha un ISEE basso.
     *
     * @return static
     */
    public function lowIsee(): static
    {
        return $this->state(fn (array $attributes) => [
            'isee_certificate' => 'low',
        ]);
    }

    /**
     * Indica che il paziente ha un ISEE alto.
     *
     * @return static
     */
    public function highIsee(): static
    {
        return $this->state(fn (array $attributes) => [
            'isee_certificate' => 'high',
        ]);
    }

    /**
     * Generate a realistic Italian fiscal code.
     * 
     * @return string
     */
    private function generateRealisticFiscalCode(): string
    {
        $consonants = 'BCDFGHJKLMNPQRSTVWXYZ';
        $vowels = 'AEIOU';
        
        // Generate 6 letters from name/surname simulation
        $letters = $this->generateRandomLetters(6, $consonants, $vowels);
        
        // Generate 2 digits for year (birth year)
        $year = str_pad((string) $this->faker->numberBetween(40, 99), 2, '0', STR_PAD_LEFT);
        
        // Generate 1 letter for month
        $month = $this->faker->randomElement(str_split('ABCDEHLMPRST'));
        
        // Generate 2 digits for day + gender indicator
        $day = str_pad((string) $this->faker->numberBetween(1, 71), 2, '0', STR_PAD_LEFT);
        
        // Generate 4 characters for municipality code
        $municipality = $this->generateRandomLetters(4, $consonants . $vowels . '0123456789');
        
        return $letters . $year . $month . $day . $municipality;
    }

    /**
     * Generate random letters from given character set.
     *
     * @param int $length
     * @param string $characters
     * @return string
     */
    private function generateRandomLetters(int $length, string $characters): string
    {
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $this->faker->randomElement(str_split($characters));
        }
        return $result;
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
            return $prefix . ' ' . $this->faker->numerify('3## ### ####');
        }
        
        // Italian landline numbers: 0xx xxx xxxx
        return $prefix . ' ' . $this->faker->numerify('0## ### ####');
    }

    /**
     * Chance helper: true if random 1..100 <= percent.
     * 
     * @param int $percent Percentage chance (0-100)
     * @return bool
     */
    private function chance(int $percent): bool
    {
        $percent = max(0, min(100, $percent));
        return random_int(1, 100) <= $percent;
    }
}