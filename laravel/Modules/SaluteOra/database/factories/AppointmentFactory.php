<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\User;
use Modules\Xot\Actions\Cast\SafeIntCastAction;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Appointment>
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Usa metodi Faker corretti - genera data futura
        $startTime = $this->faker->dateTimeBetween('+1 day', '+2 months');
        // Centralized safe cast from mixed to int via Xot Cast actions
        $duration = SafeIntCastAction::cast($this->faker->randomElement([30, 45, 60, 90]), 30); // Durata in minuti
        $endTime = clone $startTime;
        $endTime->modify(sprintf('+%d minutes', $duration));

        $treatmentTypes = [
            'Visita di controllo',
            'Pulizia dentale',
            'Otturazione',
            'Estrazione',
            'Trattamento canalare',
            'Impianto dentale',
            'Ortodonzia',
            'Protesi dentale',
            'Chirurgia orale',
            'Sbiancamento',
        ];

        $typeCases = AppointmentTypeEnum::cases();
        $statusCases = AppointmentStatusEnum::cases();
        // Select enum instances via typed index to avoid mixed->value access
        $typeEnum = $typeCases[$this->faker->numberBetween(0, count($typeCases) - 1)];
        $statusEnum = $statusCases[$this->faker->numberBetween(0, count($statusCases) - 1)];

        return [
            'patient_id' => User::factory()->patient()->create()->id,
            'doctor_id' => User::factory()->doctor()->create()->id,
            'dentist_id' => null, // Legacy field - will be synced with doctor_id
            'studio_id' => Studio::factory()->create()->id,
            'tenant_id' => null, // Will be set based on studio
            'title' => $this->faker->randomElement($treatmentTypes),
            'starts_at' => $startTime,
            'ends_at' => $endTime,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'date' => Carbon::parse($startTime)->format('Y-m-d'),
            'start_datetime' => $startTime->format('Y-m-d H:i:s'),
            'end_datetime' => $endTime->format('Y-m-d H:i:s'),
            'type' => $typeEnum->value,
            'status' => $statusEnum->value,
            'notes' => $this->faker->optional(0.7)->text(200),
            'emergency' => $this->faker->boolean(10), // 10% chance of emergency
            'confirmed' => $this->faker->boolean(80), // 80% chance of confirmed
            'cancelled' => false,
            'no_show' => false,
            'completed' => false,
            'report_pending' => false,
            'report_completed' => false,
            'created_at' => (clone $startTime)->modify('-' . rand(1, 30) . ' days'),
            'updated_at' => (clone $startTime)->modify('-' . rand(1, 30) . ' days'),
        ];
    }

    /**
     * Configura l'appuntamento dopo la creazione.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Appointment $appointment) {
            // Sincronizza i campi legacy
            $appointment->update([
                'dentist_id' => $appointment->doctor_id,
                'is_emergency' => $appointment->emergency,
                'user_id' => $appointment->patient_id,
                'tenant_id' => $appointment->studio_id,
            ]);
        });
    }

    /**
     * Crea un appuntamento di emergenza.
     */
    public function emergency(): static
    {
        return $this->state(fn (array $attributes) => [
            'emergency' => true,
            'is_emergency' => true,
            'type' => AppointmentTypeEnum::EMERGENCY->value,
            'title' => $this->faker->randomElement([
                'Emergenza - Dolore acuto',
                'Emergenza - Trauma dentale',
                'Emergenza - Ascesso',
                'Urgenza - Protesi rotta',
                'Emergenza - Emorragia',
            ]),
            'notes' => 'Appuntamento di emergenza - priorità alta',
        ]);
    }

    /**
     * Crea un appuntamento confermato.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'state' => 'confirmed',
            'status' => AppointmentStatusEnum::CONFIRMED->value,
            'eligibility_confirmed' => true,
        ]);
    }

    /**
     * Crea un appuntamento per un paziente specifico.
     */
    public function forPatient(int $patientId): static
    {
        return $this->state(fn (array $attributes) => [
            'patient_id' => $patientId,
            'user_id' => $patientId,
        ]);
    }

    /**
     * Crea un appuntamento per un dottore specifico.
     */
    public function forDoctor(int $doctorId): static
    {
        return $this->state(fn (array $attributes) => [
            'doctor_id' => $doctorId,
            'dentist_id' => $doctorId,
        ]);
    }

    /**
     * Crea un appuntamento per uno studio specifico.
     */
    public function forStudio(int $studioId): static
    {
        return $this->state(fn (array $attributes) => [
            'studio_id' => $studioId,
            'tenant_id' => $studioId,
        ]);
    }

    /**
     * Crea un appuntamento in una data specifica.
     *
     * @param string $date Formato Y-m-d
     */
    public function onDate(string $date): static
    {
        $startHour = SafeIntCastAction::cast($this->faker->numberBetween(9, 17), 9);
        $minuteOptions = [0, 15, 30, 45];
        $durationOptions = [30, 45, 60];
        $startMinute = $minuteOptions[$this->faker->numberBetween(0, count($minuteOptions) - 1)];
        $durationMinutes = $durationOptions[$this->faker->numberBetween(0, count($durationOptions) - 1)];

        $startTime = Carbon::parse($date)->setHour($startHour)->setMinute(SafeIntCastAction::cast($this->faker->randomElement([0, 15, 30, 45])));
        $endTime = $startTime->copy()->addMinutes(SafeIntCastAction::cast($this->faker->randomElement([30, 45, 60])));

        return $this->state(fn (array $attributes) => [
            'starts_at' => $startTime,
            'ends_at' => $endTime,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'date' => $date,
            'start_datetime' => $startTime->format('Y-m-d H:i:s'),
            'end_datetime' => $endTime->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Crea un appuntamento di tipo specifico.
     */
    public function ofType(AppointmentTypeEnum $type): static
    {
        $titles = [
            AppointmentTypeEnum::CONSULTATION->value => [
                'Prima visita',
                'Consulto specialistico',
                'Valutazione ortodontica',
                'Consulto implantologico',
            ],
            AppointmentTypeEnum::TREATMENT->value => [
                'Otturazione',
                'Devitalizzazione',
                'Estrazione',
                'Pulizia dentale',
            ],
            AppointmentTypeEnum::SURGERY->value => [
                'Estrazione chirurgica',
                'Implanto dentale',
                'Chirurgia parodontale',
                'Apicectomia',
            ],
            AppointmentTypeEnum::EMERGENCY->value => [
                'Emergenza - Dolore acuto',
                'Emergenza - Trauma',
                'Urgenza dentale',
            ],
        ];

        return $this->state(fn (array $attributes) => [
            'type' => $type->value,
            'title' => $this->faker->randomElement($titles[$type->value] ?? ['Appuntamento generico']),
        ]);
    }

    /**
     * Crea un appuntamento con dati completi per testing avanzato.
     */
    public function withCompleteData(): static
    {
        return $this->state(fn (array $attributes) => [
            'notes' => $this->faker->paragraph(),
            'treatment_plan' => $this->faker->paragraph(3),
            'eligibility_confirmed' => true,
            'reminder_sent' => true,
            'reminder_sent_at' => $this->faker->dateTimeBetween('-1 week', '-1 day'),
        ]);
    }
}
