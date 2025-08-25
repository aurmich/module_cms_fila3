<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Enums\UserTypeEnum;

/**
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
            'name' => 'Mario',
            'last_name' => 'Rossi',
            'fiscal_code' => 'RSSMRA'.substr(strtoupper(md5(uniqid('', true))), 0, 10),
            'birth_date' => now()->subYears(random_int(18, 80)),
            'phone' => '+39 333 111 2222',
            'email' => 'patient+'.uniqid('', true).'@example.com',
            'address' => 'Via Roma, 1',
            'city' => 'Roma',
            'postal_code' => '00100',
            'province' => 'RM',
            'country' => 'IT',
            'emergency_contact_relationship' => Arr::random([
                'coniuge', 'genitore', 'figlio', 'fratello', 'amico'
            ]),
            'is_pregnant' => $this->chance(15),
            'isee_code' => $this->chance(80) ? 'ISE'.random_int(10000000, 99999999) : null,
            'isee_value' => $this->chance(80) ? random_int(5000, 35000) : null,
            'isee_expiry_date' => $this->chance(80) ? now()->addDays(random_int(30, 365)) : null,
            'insurance_provider' => $this->chance(60)
                ? Arr::random(['SSN', 'Unisalute', 'Generali', 'AXA', 'Allianz', 'MetLife'])
                : null,
            'notes' => $this->chance(70) ? 'Note cliniche' : null,
            'type' => UserTypeEnum::PATIENT->value,
            'status' => 'active',
        ];
    }

    /**
     * Indica che il paziente è incinta.
     */
    public function pregnant(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_pregnant' => true,
        ]);
    }

    /**
     * Indica che il paziente ha un ISEE basso.
     */
    public function lowIsee(): static
    {
        return $this->state(fn (array $attributes) => [
            'isee_value' => $this->faker->numberBetween(5000, 15000),
        ]);
    }

    /**
     * Indica che il paziente ha un ISEE alto.
     */
    public function highIsee(): static
    {
        return $this->state(fn (array $attributes) => [
            'isee_value' => $this->faker->numberBetween(25000, 35000),
        ]);
    }

    /**
     * Chance helper: true if random 1..100 <= percent.
     */
    private function chance(int $percent): bool
    {
        $percent = max(0, min(100, $percent));
        return random_int(1, 100) <= $percent;
    }
}