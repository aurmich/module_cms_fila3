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
     * @var class-string<\Modules\SaluteOra\Models\Appointment>
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = $this->faker->dateTimeBetween('now', '+2 months');
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
        $appointmentType = $typeCases[array_rand($typeCases)];
        $appointmentStatus = $statusCases[array_rand($statusCases)];

        return [
            'patient_id' => User::factory()->patient(),
            'doctor_id' => User::factory()->doctor(),
            'dentist_id' => null, // Legacy field - will be synced with doctor_id
            'studio_id' => Studio::factory(),
            'tenant_id' => null, // Will be set based on studio
            'title' => $this->faker->randomElement($treatmentTypes),
            'starts_at' => $startTime,
            'ends_at' => $endTime,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'date' => Carbon::parse($startTime)->format('Y-m-d'),
            'start_datetime' => $startTime->format('Y-m-d H:i:s'),
            'end_datetime' => $endTime->format('Y-m-d H:i:s'),
            'type' => $appointmentType->value,
            'status' => $appointmentStatus->value,
            'state' => $this->faker->randomElement(['scheduled', 'confirmed']),
            'notes' => $this->faker->optional()->paragraph(),
            'treatment_plan' => $this->faker->optional()->paragraph(),
            'emergency' => $this->faker->boolean(10), // 10% di probabilità di emergenza
            'is_emergency' => false, // Will be synced with emergency
            'eligibility_confirmed' => $this->faker->boolean(80),
            'reminder_sent' => $this->faker->boolean(60),
            'reminder_sent_at' => $this->faker->optional()->dateTimeBetween('-1 week', 'now'),
        ];
    }

    /**
     * Configura l'appuntamento dopo la creazione.
     *
     * @return static
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
     *
     * @return static
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
     *
     * @return static
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
     *
     * @param int $patientId
     * @return static
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
     *
     * @param int $doctorId
     * @return static
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
     *
     * @param int $studioId
     * @return static
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
     * @return static
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
     *
     * @param AppointmentTypeEnum $type
     * @return static
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
     *
     * @return static
     */
    public function withCompleteData(): static
    {
        return $this->state(fn (array $attributes) => [
            'notes' => $this->faker->paragraph(),
            'treatment_plan' => $this->faker->paragraph(3),
            'eligibility_confirmed' => true,
            'reminder_sent' => true,
            'reminder_sent_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ]);
    }
}