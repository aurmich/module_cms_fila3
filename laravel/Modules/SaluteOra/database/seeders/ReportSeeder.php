<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SaluteOra\Models\Report;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;

/**
 * Seeder for Report model.
 *
 * Creates reports for completed appointments.
 */
class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('Creating reports...');

        // Get completed appointments that don't have reports yet
        $completedAppointments = Appointment::where('status', AppointmentStatusEnum::COMPLETED)
            ->whereDoesntHave('report')
            ->get();

        if ($completedAppointments->isEmpty()) {
            $this->command->warn('No completed appointments found. Please run AppointmentSeeder first!');
            return;
        }

        $createdCount = 0;

        foreach ($completedAppointments as $appointment) {
            // Create report for 80% of completed appointments
            if (rand(1, 100) <= 80) {
                Report::factory()->create([
                    'appointment_id' => $appointment->id,
                    'patient_id' => $appointment->patient_id,
                    'doctor_id' => $appointment->doctor_id,
                    'studio_id' => $appointment->studio_id,
                ]);
                $createdCount++;
            }
        }

        $this->command->info("Created {$createdCount} reports");
    }
}
