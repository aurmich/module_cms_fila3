<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SaluteOra\Models\Studio;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

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

        $studioType = SafeStringCastAction::cast($this->faker->randomElement($studioTypes));
        $lastName = SafeStringCastAction::cast($this->faker->lastName);

        return [
            'name' => SafeStringCastAction::cast($studioType) . ' ' . SafeStringCastAction::cast($lastName),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->companyEmail(),
            'website' => $this->faker->optional()->url(),
            'registration_number' => $this->faker->numerify('######'),
            'vat_number' => $this->faker->numerify('IT###########'),
            'description' => $this->faker->optional()->paragraph(),
            'opening_hours' => $openingHours,
            'services' => $this->faker->randomElements($services, $this->faker->numberBetween(3, 7)),
            'active' => true,
        ];
    }

    /**
     * Indica che lo studio è attivo.
     *
     * @return static
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => true,
        ]);
    }

    /**
     * Indica che lo studio è inattivo.
     *
     * @return static
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }

    /**
     * Crea uno studio con orari estesi.
     *
     * @return static
     */
    public function withExtendedHours(): static
    {
        return $this->state(fn (array $attributes) => [
            'opening_hours' => [
                'monday' => ['08:00-13:00', '14:00-20:00'],
                'tuesday' => ['08:00-13:00', '14:00-20:00'],
                'wednesday' => ['08:00-13:00', '14:00-20:00'],
                'thursday' => ['08:00-13:00', '14:00-20:00'],
                'friday' => ['08:00-13:00', '14:00-20:00'],
                'saturday' => ['08:00-14:00'],
                'sunday' => ['09:00-13:00'],
            ],
        ]);
    }

    /**
     * Crea uno studio specializzato in ortodonzia.
     *
     * @return static
     */
    public function orthodontics(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Centro Ortodontico ' . $this->faker->lastName,
            'services' => [
                'Ortodonzia',
                'Ortodonzia invisibile',
                'Ortodonzia pediatrica',
                'Apparecchi ortodontici',
                'Bite dentali'
            ],
        ]);
    }

    /**
     * Crea uno studio con servizi completi.
     *
     * @return static
     */
    public function fullService(): static
    {
        return $this->state(fn (array $attributes) => [
            'services' => [
                'Igiene dentale',
                'Ortodonzia',
                'Implantologia',
                'Endodonzia',
                'Parodontologia',
                'Chirurgia orale',
                'Protesi dentale',
                'Odontoiatria pediatrica',
                'Estetica dentale',
                'Radiologia dentale'
            ],
        ]);
    }

    /**
     * Crea uno studio con dati completi per testing avanzato.
     *
     * @return static
     */
    public function withCompleteData(): static
    {
        return $this->state(fn (array $attributes) => [
            'website' => $this->faker->url(),
            'description' => $this->faker->paragraph(3),
            // Provide native array; let Eloquent JSON cast handle serialization
            'settings' => [
                'appointment_duration' => 45,
                'max_appointments_per_day' => 12,
                'booking_advance_days' => 60,
                'cancellation_hours' => 48,
                'online_booking_enabled' => true,
                'reminder_emails' => true,
                'reminder_sms' => false,
            ],
        ]);
    }

    /**
     * Crea uno studio in una città specifica.
     *
     * @param string $city
     * @return static
     */
    public function inCity(string $city): static
    {
        return $this->state(fn (array $attributes) => [
            'city' => $city,
            'address' => $this->faker->streetAddress() . ', ' . $city,
        ]);
    }
}