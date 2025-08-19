<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Carbon\Carbon;

/**
 * Seeder for Appointment model.
 *
 * Creates appointments across different time periods and statuses.
 */
class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('Creating appointments...');

        // Ensure we have the required related models
        $doctors = Doctor::all();
        $patients = Patient::all();
        $studios = Studio::where('active', true)->get();

        if ($doctors->isEmpty() || $patients->isEmpty() || $studios->isEmpty()) {
            $this->command->warn('Please run UserSeeder and StudioSeeder first!');
            return;
        }

        // Create appointments for different time periods
        $this->createPastAppointments($doctors, $patients, $studios);
        $this->createCurrentAppointments($doctors, $patients, $studios);
        $this->createFutureAppointments($doctors, $patients, $studios);

        $this->command->info('Appointments created successfully!');
    }

    /**
     * Create past appointments.
     *
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Doctor> $doctors
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Patient> $patients
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $studios
     * @return void
     */
    private function createPastAppointments($doctors, $patients, $studios): void
    {
        $this->command->info('Creating past appointments...');

        // Create completed appointments from the last 6 months
        for ($i = 0; $i < 150; $i++) {
            $doctor = $doctors->random();
            $patient = $patients->random();
            $studio = $studios->random();

            $startDate = Carbon::now()->subMonths(6)->addDays(rand(0, 180));
            $startTime = $startDate->copy()->setHour(rand(8, 18))->setMinute(rand(0, 3) * 15);
            $endTime = $startTime->copy()->addMinutes(rand(30, 120));

            Appointment::factory()->create([
                'doctor_id' => $doctor->id,
                'patient_id' => $patient->id,
                'studio_id' => $studio->id,
                'title' => $this->generateAppointmentTitle(),
                'starts_at' => $startTime,
                'ends_at' => $endTime,
                'status' => $this->getRandomPastStatus(),
                'type' => $this->getRandomAppointmentType(),
                'emergency' => rand(1, 100) <= 5, // 5% emergency
            ]);
        }

        $this->command->info('Created 150 past appointments');
    }

    /**
     * Create current/today appointments.
     *
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Doctor> $doctors
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Patient> $patients
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $studios
     * @return void
     */
    private function createCurrentAppointments($doctors, $patients, $studios): void
    {
        $this->command->info('Creating current appointments...');

        // Create appointments for today and this week
        for ($i = 0; $i < 25; $i++) {
            $doctor = $doctors->random();
            $patient = $patients->random();
            $studio = $studios->random();

            $startDate = Carbon::now()->addDays(rand(-1, 7)); // Today to next week
            $startTime = $startDate->copy()->setHour(rand(8, 18))->setMinute(rand(0, 3) * 15);
            $endTime = $startTime->copy()->addMinutes(rand(30, 120));

            Appointment::factory()->create([
                'doctor_id' => $doctor->id,
                'patient_id' => $patient->id,
                'studio_id' => $studio->id,
                'title' => $this->generateAppointmentTitle(),
                'starts_at' => $startTime,
                'ends_at' => $endTime,
                'status' => $this->getRandomCurrentStatus(),
                'type' => $this->getRandomAppointmentType(),
                'emergency' => rand(1, 100) <= 8, // 8% emergency for current appointments
            ]);
        }

        $this->command->info('Created 25 current appointments');
    }

    /**
     * Create future appointments.
     *
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Doctor> $doctors
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Patient> $patients
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $studios
     * @return void
     */
    private function createFutureAppointments($doctors, $patients, $studios): void
    {
        $this->command->info('Creating future appointments...');

        // Create appointments for the next 3 months
        for ($i = 0; $i < 80; $i++) {
            $doctor = $doctors->random();
            $patient = $patients->random();
            $studio = $studios->random();

            $startDate = Carbon::now()->addDays(rand(8, 90)); // Next week to 3 months
            $startTime = $startDate->copy()->setHour(rand(8, 18))->setMinute(rand(0, 3) * 15);
            $endTime = $startTime->copy()->addMinutes(rand(30, 120));

            Appointment::factory()->create([
                'doctor_id' => $doctor->id,
                'patient_id' => $patient->id,
                'studio_id' => $studio->id,
                'title' => $this->generateAppointmentTitle(),
                'starts_at' => $startTime,
                'ends_at' => $endTime,
                'status' => AppointmentStatusEnum::SCHEDULED,
                'type' => $this->getRandomAppointmentType(),
                'emergency' => rand(1, 100) <= 3, // 3% emergency for future appointments
            ]);
        }

        $this->command->info('Created 80 future appointments');
    }

    /**
     * Generate a realistic appointment title.
     *
     * @return string
     */
    private function generateAppointmentTitle(): string
    {
        $titles = [
            'Visita di controllo',
            'Pulizia dentale',
            'Otturazione',
            'Devitalizzazione',
            'Estrazione dente',
            'Consulenza ortodontica',
            'Applicazione apparecchio',
            'Controllo ortodontico',
            'Impianto dentale',
            'Protesi dentaria',
            'Visita parodontale',
            'Chirurgia orale',
            'Sbiancamento dentale',
            'Riparazione protesi',
            'Controllo post-operatorio',
            'Prima visita',
            'Urgenza dentale',
            'Rimozione suture',
            'Bite dentale',
            'Panoramica dentale',
        ];

        return $titles[array_rand($titles)];
    }

    /**
     * Get random appointment type.
     *
     * @return AppointmentTypeEnum
     */
    private function getRandomAppointmentType(): AppointmentTypeEnum
    {
        $types = AppointmentTypeEnum::cases();
        return $types[array_rand($types)];
    }

    /**
     * Get random status for past appointments.
     *
     * @return AppointmentStatusEnum
     */
    private function getRandomPastStatus(): AppointmentStatusEnum
    {
        $statuses = [
            AppointmentStatusEnum::COMPLETED,
            AppointmentStatusEnum::COMPLETED,
            AppointmentStatusEnum::COMPLETED, // Higher probability
            AppointmentStatusEnum::CANCELLED,
            AppointmentStatusEnum::NO_SHOW,
        ];

        return $statuses[array_rand($statuses)];
    }

    /**
     * Get random status for current appointments.
     *
     * @return AppointmentStatusEnum
     */
    private function getRandomCurrentStatus(): AppointmentStatusEnum
    {
        $statuses = [
            AppointmentStatusEnum::CONFIRMED,
            AppointmentStatusEnum::CONFIRMED, // Higher probability
            AppointmentStatusEnum::SCHEDULED,
            AppointmentStatusEnum::IN_PROGRESS,
            AppointmentStatusEnum::CANCELLED,
        ];

        return $statuses[array_rand($statuses)];
    }
}
