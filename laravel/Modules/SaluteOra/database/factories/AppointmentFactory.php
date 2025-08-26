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

        // Crea User e Studio una sola volta per evitare duplicati
        static $patientId = null;
        static $doctorId = null;
        static $studioId = null;
        
        if ($patientId === null) {
            $patientId = User::factory()->patient()->create()->id;
        }
        if ($doctorId === null) {
            $doctorId = User::factory()->doctor()->create()->id;
        }
        if ($studioId === null) {
            $studioId = Studio::factory()->create()->id;
        }
        
        return [
            'patient_id' => $patientId,
            'doctor_id' => $doctorId,
            'studio_id' => $studioId,
            'title' => $this->faker->randomElement($treatmentTypes),
            'starts_at' => $startTime,
            'ends_at' => $endTime,
            'type' => $typeEnum->value,
            'state' => $statusEnum->value,
            'notes' => $this->faker->optional(0.7)->text(200),
            'emergency' => $this->faker->boolean(10), // 10% chance of emergency
        ];
    }

    /**
     * Configura l'appuntamento dopo la creazione.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Appointment $appointment) {
            // Configurazione post-creazione se necessaria
            // Rimossi campi legacy non esistenti nello schema
        });
    }

    /**
     * Crea un appuntamento di emergenza.
     */
    public function emergency(): static
    {
        return $this->state(fn (array $attributes) => [
            'emergency' => true,
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
        ]);
    }

    /**
     * Crea un appuntamento per uno studio specifico.
     */
    public function forStudio(int $studioId): static
    {
        return $this->state(fn (array $attributes) => [
            'studio_id' => $studioId,
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
        ]);
    }
}
