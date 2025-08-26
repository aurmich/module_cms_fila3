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
     * Boy Scout Rule Applied:
     * - Migliorata randomizzazione con dati realistici
     * - Aggiunta gestione locale per nomi italiani
     * - Implementato pattern per dati demografici coerenti
     * - Migliorata leggibilità e manutenibilità
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Nomi italiani realistici per migliore variety
        $firstNames = [
            'male' => ['Marco', 'Giuseppe', 'Francesco', 'Antonio', 'Alessandro', 'Andrea', 'Luigi', 'Matteo', 'Luca', 'Giovanni'],
            'female' => ['Maria', 'Anna', 'Giuseppina', 'Rosa', 'Angela', 'Giovanna', 'Teresa', 'Lucia', 'Francesca', 'Paola'],
        ];
        
        $lastNames = [
            'Rossi', 'Russo', 'Ferrari', 'Esposito', 'Bianchi', 'Romano', 'Colombo', 'Ricci', 'Marino', 'Greco',
            'Bruno', 'Gallo', 'Conti', 'De Luca', 'Mancini', 'Costa', 'Giordano', 'Rizzo', 'Lombardi', 'Moretti'
        ];
        
        $gender = $this->faker->randomElement(['male', 'female', 'other']);
        $firstName = (string) ($gender === 'other' ? $this->faker->firstName() : $this->faker->randomElement($firstNames[$gender]));
        $lastName = (string) $this->faker->randomElement($lastNames);
        
        // Città italiane realistiche
        /** @var array<int, array{name: string, code: string, region: string}> $cities */
        $cities = [
            ['name' => 'Milano', 'code' => 'MI', 'region' => 'Lombardia'],
            ['name' => 'Roma', 'code' => 'RM', 'region' => 'Lazio'],
            ['name' => 'Napoli', 'code' => 'NA', 'region' => 'Campania'],
            ['name' => 'Torino', 'code' => 'TO', 'region' => 'Piemonte'],
            ['name' => 'Palermo', 'code' => 'PA', 'region' => 'Sicilia'],
            ['name' => 'Genova', 'code' => 'GE', 'region' => 'Liguria'],
            ['name' => 'Bologna', 'code' => 'BO', 'region' => 'Emilia-Romagna'],
            ['name' => 'Firenze', 'code' => 'FI', 'region' => 'Toscana'],
        ];
        
        /** @var array{name: string, code: string, region: string} $city */
        $city = $this->faker->randomElement($cities);
        $age = $this->faker->numberBetween(18, 85);
        
        return [
            'name' => $firstName . ' ' . $lastName,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => $this->faker->optional(0.85)->dateTimeBetween('-1 year', 'now'),
            'password' => Hash::make('password'), // Più sicuro
            'remember_token' => Str::random(10),
            'type' => UserTypeEnum::PATIENT, // Default to patient
            'state' => $this->faker->randomElement([Active::class, Pending::class]),
            'date_of_birth' => now()->subYears($age)->subDays($this->faker->numberBetween(0, 364)),
            'gender' => $gender,
            'address' => $this->faker->streetAddress() . ', ' . $this->faker->buildingNumber(),
            'city' => $city['name'],
            'phone' => '+39 ' . sprintf('%03d %03d %04d', rand(100, 999), rand(100, 999), rand(1000, 9999)),
            'lang' => $this->faker->randomElement(['it', 'en', 'de']),
            'is_active' => $this->faker->boolean(90), // 90% active
            'is_otp' => $this->faker->boolean(15), // 15% OTP enabled
            'country_code' => 'IT',
            'nationality' => $this->faker->randomElement(['Italiana', 'Straniera']),
            'fiscal_code' => $this->generateItalianFiscalCode($firstName, $lastName),
            'children_count' => (string) $this->faker->numberBetween(0, 4),
            'family_members' => (string) $this->faker->numberBetween(1, 6),
            'years_in_italy' => (string) $this->faker->numberBetween(0, min($age, 50)),
            'dental_problems' => $this->faker->optional(0.3)->randomElement(['Carie dentali', 'Gengivite', 'Sensibilità dentale', 'Malocclusione', 'Bruxismo', 'Alitosi', 'Dolore mandibolare']),
            'last_dental_visit' => $this->faker->optional(0.75)->passthrough($this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d')),
            'last_dental_visit_period' => $this->faker->optional(0.75)->randomElement(['< 6 mesi', '6-12 mesi', '1-2 anni', '> 2 anni']),
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