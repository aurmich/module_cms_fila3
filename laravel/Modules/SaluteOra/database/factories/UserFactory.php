<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\Pending;

/**
 * Factory per il modello User del modulo SaluteOra.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Il nome del modello corrispondente alla factory.
     *
     * @var class-string<\Modules\SaluteOra\Models\User>
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Avoid Faker name provider in tests: use static fallback
        $firstName = 'Mario';
        $lastName = 'Rossi';
        
        return [
            'name' => $firstName . ' ' . $lastName,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => 'test' . uniqid('', true) . '@example.com',
            'email_verified_at' => $this->faker->optional(0.8) ? now()->subDays(random_int(0, 365)) : null,
            // Use native hash to avoid container 'hash' binding during tests
            'password' => password_hash('password', PASSWORD_BCRYPT),
            'remember_token' => Str::random(10),
            'type' => UserTypeEnum::PATIENT, // Default to patient
            'state' => [Active::class, Pending::class][random_int(0, 1)],
            'date_of_birth' => now()->subYears(random_int(18, 80))->startOfDay(),
            'gender' => ['male', 'female', 'other'][random_int(0, 2)],
            'address' => 'Via Roma 1',
            'city' => 'Milano',
            'phone' => '+39 123 456 7890',
            'lang' => ['it', 'en', 'de'][random_int(0, 2)],
            'is_active' => random_int(1, 100) <= 90, // 90% active
            'is_otp' => random_int(1, 100) <= 10, // 10% OTP enabled
            'country_code' => 'IT',
            'nationality' => ['Italiana', 'Straniera'][random_int(0, 1)],
            'fiscal_code' => $this->generateItalianFiscalCode($firstName, $lastName),
            'children_count' => (string) random_int(0, 5),
            'family_members' => (string) random_int(1, 8),
            'years_in_italy' => (string) random_int(0, 50),
            'dental_problems' => random_int(1, 100) <= 30 ? 'generic issue' : null,
            'last_dental_visit' => random_int(1, 100) <= 70 ? Carbon::now()->subDays(random_int(30, 720))->toDateString() : null,
            'last_dental_visit_period' => random_int(1, 100) <= 70 ? [
                '< 6 mesi', '6-12 mesi', '1-2 anni', '> 2 anni'
            ][random_int(0, 3)] : null,
        ];
    }

    /**
     * Indica che l'utente è un admin.
     *
     * @return static
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => UserTypeEnum::ADMIN->value,
            'state' => Active::class,
            'registration_number' => null,
            'certifications' => null,
        ]);
    }

    /**
     * Indica che l'utente è un dottore.
     *
     * @return static
     */
    public function doctor(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => UserTypeEnum::DOCTOR->value,
            'state' => Active::class,
            'phone' => '+39 333 000 0000',
            'certifications' => [
                'Laurea in Odontoiatria',
                'Abilitazione all\'esercizio della professione'
            ],
            'certification' => [
                ['name' => 'Laurea in Odontoiatria', 'date' => now()->subYears(10)->toDateString()],
                ['name' => 'Abilitazione professionale', 'date' => now()->subYears(8)->toDateString()]
            ],
        ]);
    }

    /**
     * Indica che l'utente è un paziente.
     *
     * @return static
     */
    public function patient(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => UserTypeEnum::PATIENT->value,
            'state' => Active::class,
            'registration_number' => null,
            'certifications' => null,
            'certification' => null,
            'dental_problems' => $this->faker->optional()->sentence(),
            'last_dental_visit' => $this->faker->optional()->date(),
        ]);
    }

    /**
     * Indica che l'utente è in stato pending.
     *
     * @return static
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'state' => Pending::class,
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indica che l'utente è attivo.
     *
     * @return static
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'state' => Active::class,
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
    }

    /**
     * Indica che l'utente non è verificato.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Crea un utente con dati completi per testing avanzato.
     *
     * @return static
     */
    public function withCompleteData(): static
    {
        return $this->state(fn (array $attributes) => [
            'dental_problems' => 'generic issue',
            'last_dental_visit' => now()->subDays(100)->toDateString(),
            'pregnancy_certificate' => $this->faker->optional()->word,
            'isee_certificate' => $this->faker->optional()->word,
            'identity_document' => $this->faker->optional()->word,
            'health_card' => $this->faker->optional()->word,
            'data_privacy_form' => $this->faker->optional()->word,
            'doctor_certificate' => $this->faker->optional()->word,
        ]);
    }

    /**
     * Generate a realistic Italian fiscal code.
     *
     * @param string $firstName
     * @param string $lastName
     * @return string
     */
    private function generateItalianFiscalCode(string $firstName, string $lastName): string
    {
        // Simplified fiscal code generation for testing purposes
        $code = strtoupper(substr($lastName, 0, 3));
        $code .= strtoupper(substr($firstName, 0, 3));
        $code .= sprintf('%02d', random_int(0, 99));
        $code .= chr(random_int(65, 90)); // Random letter A-Z
        $code .= sprintf('%02d', random_int(0, 99));
        $code .= chr(random_int(65, 90)); // Random letter A-Z
        $code .= sprintf('%03d', random_int(0, 999));
        $code .= chr(random_int(65, 90)); // Random letter A-Z
        
        return $code;
    }
}