<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Report;
use Modules\SaluteOra\Models\Studio;

/**
 * Seeds core data for the SaluteOra module using existing factories.
 */
class SaluteOraDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create base references
        /** @var Collection<int, Studio> $studios */
        $studios = Studio::query()->count() > 0
            ? Studio::all()
            : Studio::factory()->count(10)->create();

        /** @var Collection<int, Doctor> $doctors */
        $doctors = Doctor::query()->count() > 0
            ? Doctor::all()
            : Doctor::factory()->count(25)->create();

        /** @var Collection<int, Patient> $patients */
        $patients = Patient::query()->count() > 0
            ? Patient::all()
            : Patient::factory()->count(200)->create();

        // Optionally relate doctors to studios if relation exists on the model
        if (Studio::query()->getModel()->isRelation('doctors')) {
            $studios->each(function (Studio $studio) use ($doctors): void {
                $ids = $doctors->random(min(6, max(2, (int) floor($doctors->count() / 5))))->pluck('id')->all();
                try {
                    // @phpstan-ignore-next-line (dynamic relation at runtime)
                    $studio->doctors()->syncWithoutDetaching($ids);
                } catch (\Throwable) {
                    // Silent if relation is not configured
                }
            });
        }

        // Create a large batch of appointments distributed over next 30 days
        $appointmentCount = 1000;
        if (Appointment::query()->count() < $appointmentCount) {
            // Chunk in batches to avoid memory spikes
            $batch = 200;
            $remaining = $appointmentCount - Appointment::query()->count();

            while ($remaining > 0) {
                $create = min($batch, $remaining);
                Appointment::factory()
                    ->count($create)
                    ->state(function () use ($doctors, $patients, $studios): array {
                        $doctor = $doctors->random();
                        $patient = $patients->random();
                        $studio  = $studios->random();
                        return [
                            'doctor_id'  => $doctor->id,
                            'patient_id' => $patient->id,
                            'studio_id'  => $studio->id,
                        ];
                    })
                    ->create();

                $remaining -= $create;
            }
        }

        // Optionally create reports for a subset of appointments if factory exists
        if (class_exists(Report::class)) {
            $appointmentsForReport = Appointment::query()->inRandomOrder()->limit(200)->get();
            $appointmentsForReport->each(function (Appointment $appointment): void {
                try {
                    // Avoid duplicates
                    if ($appointment->isRelation('report') && ! $appointment->report) {
                        Report::factory()->create([
                            'appointment_id' => $appointment->id,
                        ]);
                    }
                } catch (\Throwable) {
                    // Ignore if schema/relations differ
                }
            });
        }
    }
}
