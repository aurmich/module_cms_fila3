<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\SaluteOra\States\Appointment\Scheduled;
use Modules\SaluteOra\States\Appointment\Confirmed;
use Modules\SaluteOra\States\Appointment\Completed;
use Carbon\Carbon;

/**
 * Factory per il modello Appointment del modulo SaluteOra.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Il nome del modello corrispondente alla factory.
     *
     * @var class-string<\Modules\SaluteOra\Models\Appointment>
     */
    protected $model = Appointment::class;

    /**
     * Definisce lo stato di default del modello.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = $this->faker->dateTimeBetween('now', '+2 months');
        $duration = $this->faker->randomElement([30, 45, 60, 90]); // Durata in minuti
        $endTime = clone $startTime;
        $endTime->modify("+{$duration} minutes");

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
            'type' => $this->faker->randomElement(AppointmentTypeEnum::cases())->value,
            'status' => $this->faker->randomElement(AppointmentStatusEnum::cases())->value,
            'state' => $this->faker->randomElement([Scheduled::class, Confirmed::class]),
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
            'state' => Confirmed::class,
            'status' => AppointmentStatusEnum::CONFIRMED->value,
            'eligibility_confirmed' => true,
            'reminder_sent' => true,
            'reminder_sent_at' => $this->faker->dateTimeBetween('-3 days', 'now'),
        ]);
    }

    /**
     * Crea un appuntamento completato.
     *
     * @return static
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'state' => Completed::class,
            'status' => AppointmentStatusEnum::COMPLETED->value,
            'starts_at' => $this->faker->dateTimeBetween('-2 months', '-1 week'),
            'ends_at' => function (array $attributes) {
                $start = Carbon::parse($attributes['starts_at']);
                return $start->copy()->addMinutes(60);
            },
            'treatment_plan' => $this->faker->paragraph(),
            'notes' => $this->faker->paragraph() . ' - Trattamento completato con successo.',
        ]);
    }

    /**
     * Crea un appuntamento programmato.
     *
     * @return static
     */
    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'state' => Scheduled::class,
            'status' => AppointmentStatusEnum::SCHEDULED->value,
            'starts_at' => $this->faker->dateTimeBetween('+1 week', '+2 months'),
            'reminder_sent' => false,
            'reminder_sent_at' => null,
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
        $startTime = Carbon::parse($date)->setHour($this->faker->numberBetween(9, 17))->setMinute($this->faker->randomElement([0, 15, 30, 45]));
        $endTime = $startTime->copy()->addMinutes($this->faker->randomElement([30, 45, 60]));

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