<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Admin;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Report;
use Modules\SaluteOra\Models\Profile;
use Modules\SaluteOra\Models\DoctorStudio;
use Modules\SaluteOra\Models\PatientStudio;

/**
 * Seeder per popolare il database con grandi quantità di dati realistici.
 * 
 * Questo seeder crea:
 * - 100+ Admin
 * - 500+ Dottori
 * - 2000+ Pazienti
 * - 50+ Studi
 * - 5000+ Appuntamenti
 * - 1000+ Report
 * - Relazioni pivot complete
 */
class MassDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting MASS data seeding for SaluteOra...');
        $this->command->info('⚠️  This will create THOUSANDS of records!');
        
        // Disable foreign key checks to avoid issues during seeding (MySQL only)
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        try {
            $this->seedUsers();
            $this->seedStudios();
            $this->seedProfiles();
            $this->seedAppointments();
            $this->seedReports();
            $this->seedPivotRelations();
            
            $this->command->info('✅ MASS data seeding completed successfully!');
            $this->displayDetailedSummary();
        } finally {
            // Re-enable foreign key checks (MySQL only)
            if (DB::getDriverName() !== 'sqlite') {
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        }
    }

    /**
     * Seed users with different types.
     */
    private function seedUsers(): void
    {
        $this->command->info('👥 Creating users...');

        // Create Admins
        $this->command->info('   Creating 100 Admins...');
        User::factory()->count(100)->admin()->create();

        // Create Doctors
        $this->command->info('   Creating 500 Doctors...');
        User::factory()->count(500)->doctor()->create();

        // Create Patients
        $this->command->info('   Creating 2000 Patients...');
        User::factory()->count(2000)->patient()->create();

        $this->command->info('✅ Users created');
    }

    /**
     * Seed studios.
     */
    private function seedStudios(): void
    {
        $this->command->info('🏥 Creating 50 Studios...');
        
        Studio::factory()->count(50)->create();
        
        $this->command->info('✅ Studios created');
    }

    /**
     * Seed profiles for all users.
     */
    private function seedProfiles(): void
    {
        $this->command->info('👤 Creating profiles...');

        $users = User::all();
        $this->command->info("   Creating profiles for {$users->count()} users...");

        foreach ($users as $user) {
            Profile::factory()->create([
                'user_id' => $user->id,
            ]);
        }

        $this->command->info('✅ Profiles created');
    }

    /**
     * Seed appointments.
     */
    private function seedAppointments(): void
    {
        $this->command->info('📅 Creating appointments...');

        $doctors = Doctor::all();
        $patients = Patient::all();
        $studios = Studio::all();

        if ($doctors->isEmpty() || $patients->isEmpty() || $studios->isEmpty()) {
            $this->command->warn('⚠️ Skipping appointments - missing doctors, patients, or studios');
            return;
        }

        $this->command->info('   Creating 5000 appointments...');

        // Create appointments in batches for better performance
        $batchSize = 100;
        $totalAppointments = 5000;
        $batches = ceil($totalAppointments / $batchSize);

        for ($i = 0; $i < $batches; $i++) {
            $batchCount = min($batchSize, $totalAppointments - ($i * $batchSize));
            
            Appointment::factory()
                ->count($batchCount)
                ->create([
                    'patient_id' => $patients->random()->id,
                    'doctor_id' => $doctors->random()->id,
                    'studio_id' => $studios->random()->id,
                ]);

            if (($i + 1) % 10 === 0) {
                $progress = ($i + 1) * $batchSize;
                $this->command->info("   Progress: {$progress}/{$totalAppointments} appointments");
            }
        }

        // Create some emergency appointments
        $this->command->info('   Creating 200 emergency appointments...');
        Appointment::factory()
            ->count(200)
            ->emergency()
            ->create([
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'studio_id' => $studios->random()->id,
            ]);

        $this->command->info('✅ Appointments created');
    }

    /**
     * Seed reports for appointments.
     */
    private function seedReports(): void
    {
        $this->command->info('📋 Creating reports...');

        $appointments = Appointment::whereNotNull('id')->limit(1000)->get();
        
        if ($appointments->isEmpty()) {
            $this->command->warn('⚠️ Skipping reports - no appointments found');
            return;
        }

        $this->command->info("   Creating reports for {$appointments->count()} appointments...");

        foreach ($appointments as $appointment) {
            if ($appointment->patient_id) {
                Report::factory()->create([
                    'appointment_id' => $appointment->id,
                    'patient_id' => $appointment->patient_id,
                ]);
            }
        }

        $this->command->info('✅ Reports created');
    }

    /**
     * Seed pivot relations.
     */
    private function seedPivotRelations(): void
    {
        $this->command->info('🔗 Creating pivot relationships...');

        $doctors = Doctor::all();
        $patients = Patient::all();
        $studios = Studio::all();

        if ($doctors->isEmpty() || $patients->isEmpty() || $studios->isEmpty()) {
            $this->command->warn('⚠️ Skipping pivot relations - missing base data');
            return;
        }

        // Doctor-Studio relationships
        $this->command->info('   Creating Doctor-Studio relationships...');
        foreach ($doctors as $doctor) {
            // Each doctor works in 1-3 studios
            $studioCount = rand(1, 3);
            $randomStudios = $studios->random($studioCount);
            
            foreach ($randomStudios as $studio) {
                DoctorStudio::firstOrCreate([
                    'user_id' => $doctor->id,
                    'studio_id' => $studio->id,
                ], [
                    'schedule' => $this->generateRandomSchedule(),
                ]);
            }
        }

        // Patient-Studio relationships
        $this->command->info('   Creating Patient-Studio relationships...');
        foreach ($patients as $patient) {
            // Each patient may visit 1-2 studios
            if (rand(1, 100) <= 80) { // 80% of patients have studio relationships
                $studioCount = rand(1, 2);
                $randomStudios = $studios->random($studioCount);
                
                foreach ($randomStudios as $studio) {
                    PatientStudio::firstOrCreate([
                        'user_id' => $patient->id,
                        'studio_id' => $studio->id,
                    ]);
                }
            }
        }

        $this->command->info('✅ Pivot relationships created');
    }

    /**
     * Generate random schedule for doctor-studio relationship.
     */
    private function generateRandomSchedule(): array
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $schedule = [];

        foreach ($days as $day) {
            if (rand(1, 100) <= 80) { // 80% chance doctor works this day
                $morningStart = rand(8, 9);
                $morningEnd = rand(12, 13);
                $afternoonStart = rand(14, 15);
                $afternoonEnd = rand(17, 19);

                $schedule[$day] = [
                    sprintf('%02d:00', $morningStart) . '-' . sprintf('%02d:00', $morningEnd),
                    sprintf('%02d:00', $afternoonStart) . '-' . sprintf('%02d:00', $afternoonEnd),
                ];
            } else {
                $schedule[$day] = [];
            }
        }

        // Sunday is usually closed
        $schedule['sunday'] = rand(1, 100) <= 20 ? ['09:00-13:00'] : [];

        return $schedule;
    }

    /**
     * Display detailed seeding summary.
     */
    private function displayDetailedSummary(): void
    {
        $this->command->info('');
        $this->command->info('📊 DETAILED Seeding Summary:');
        $this->command->info('============================');
        
        // Count all models
        $userCount = User::count();
        $adminCount = Admin::count();
        $doctorCount = Doctor::count();
        $patientCount = Patient::count();
        $studioCount = Studio::count();
        $appointmentCount = Appointment::count();
        $profileCount = Profile::count();
        $reportCount = Report::count();
        $doctorStudioCount = DoctorStudio::count();
        $patientStudioCount = PatientStudio::count();

        // Calculate some statistics
        $emergencyAppointments = Appointment::where('emergency', true)->count();
        $activeStudios = Studio::where('active', true)->count();
        $verifiedUsers = User::whereNotNull('email_verified_at')->count();

        $this->command->info("👥 USERS: {$userCount} total");
        $this->command->info("   - 👔 Admins: {$adminCount}");
        $this->command->info("   - 👨‍⚕️ Doctors: {$doctorCount}");
        $this->command->info("   - 🤒 Patients: {$patientCount}");
        $this->command->info("   - ✅ Verified: {$verifiedUsers}");
        
        $this->command->info("🏥 STUDIOS: {$studioCount} total");
        $this->command->info("   - ✅ Active: {$activeStudios}");
        
        $this->command->info("👤 PROFILES: {$profileCount}");
        
        $this->command->info("📅 APPOINTMENTS: {$appointmentCount} total");
        $this->command->info("   - 🚨 Emergencies: {$emergencyAppointments}");
        
        $this->command->info("📋 REPORTS: {$reportCount}");
        
        $this->command->info("🔗 RELATIONSHIPS:");
        $this->command->info("   - Doctor-Studio: {$doctorStudioCount}");
        $this->command->info("   - Patient-Studio: {$patientStudioCount}");
        
        $this->command->info('');
        $this->command->info('🎯 Database is now FULLY populated for comprehensive testing!');
        $this->command->info('💡 You can now use tinker to explore the data or run the application.');
    }
}
