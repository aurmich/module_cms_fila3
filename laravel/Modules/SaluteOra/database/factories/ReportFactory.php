<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Report;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\SaluteOra\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Report>
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Crea Patient e Appointment una sola volta per evitare duplicati
        static $patientId = null;
        static $appointmentId = null;

        if (null === $patientId) {
            $patientId = Patient::factory()->create()->id;
        }
        if (null === $appointmentId) {
            $appointmentId = Appointment::factory()->create()->id;
        }

        return [
            'patient_id' => $patientId,
            'appointment_id' => $appointmentId,
            'has_mouth_or_teeth_pain' => $this->faker->boolean(),
            'mouth_teeth_pain_frequency' => $this->faker->randomElement(['never', 'rarely', 'sometimes', 'often', 'always']),
            'pregnancy_month' => $this->faker->optional()->numberBetween(1, 9),
            'pregnancy_week' => $this->faker->optional()->numberBetween(1, 40),
            'teeth_brushing_frequency' => $this->faker->randomElement(['once', 'twice', 'three_times', 'more']),
            'smokes' => $this->faker->boolean(),
            'visits_dentist_yearly' => $this->faker->boolean(),
            'has_diseases' => $this->faker->boolean(),
            'specify_diseases' => $this->faker->optional()->text(100),
            'follows_diet_rules' => $this->faker->boolean(),
            'uses_asl_clinic_for_dental_care' => $this->faker->boolean(),
            'missing_teeth' => $this->faker->boolean(),
            'specify_missing_teeth' => $this->faker->optional()->text(100),
            'more_info_missing_teeth' => $this->faker->optional()->text(200),
            'decayed_teeth' => $this->faker->boolean(),
            'specify_decayed_teeth' => $this->faker->optional()->text(100),
            'more_info_decayed_teeth' => $this->faker->optional()->text(200),
            'has_fixed_prosthesis_or_implants' => $this->faker->boolean(),
            'specify_prosthesis_or_implants' => $this->faker->optional()->text(100),
            'more_info_prosthesis' => $this->faker->optional()->text(200),
            'has_tartar' => $this->faker->boolean(),
            'specify_tartar' => $this->faker->optional()->text(100),
            'more_info_tartar' => $this->faker->optional()->text(200),
            'has_plaque' => $this->faker->boolean(),
            'specify_plaque' => $this->faker->optional()->text(100),
            'more_info_plaque' => $this->faker->optional()->text(200),
            'needs_more_dental_care' => $this->faker->boolean(),
            'further_notes' => $this->faker->optional()->text(300),
        ];
    }

    /**
     * Indicate that the report is for a specific appointment.
     */
    public function forAppointment(Appointment $appointment): static
    {
        return $this->state(fn (array $attributes) => [
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
        ]);
    }

    /**
     * Indicate that the report is for a specific patient.
     */
    public function forPatient(Patient $patient): static
    {
        return $this->state(fn (array $attributes) => [
            'patient_id' => $patient->id,
        ]);
    }

    /**
     * Indicate that the report is for a specific doctor.
     * Note: Reports don't have doctor_id field in current schema.
     */
    public function forDoctor(Doctor $doctor): static
    {
        return $this->state(fn (array $attributes) => [
            // doctor_id not available in reports table
        ]);
    }
}
