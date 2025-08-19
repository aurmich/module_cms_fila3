<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

/**
 * Main seeder for SaluteOra module.
 * 
 * Orchestrates all individual seeders to populate the database with realistic test data.
 * 
 * Seeding order:
 * 1. Users (Admin, Doctors, Patients)
 * 2. Studios
 * 3. Profiles
 * 4. Appointments
 * 5. Reports
 * 6. Pivot relationships
 */
class SaluteOraSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🦷 Starting SaluteOra seeding...');

        // Disable foreign key checks to avoid issues during seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            // Run individual seeders in correct order
            $this->call([
                UserSeeder::class,
                StudioSeeder::class,
                ProfileSeeder::class,
                AppointmentSeeder::class,
                ReportSeeder::class,
                PivotSeeder::class,
            ]);
            
            $this->command->info('✅ SaluteOra seeding completed successfully!');
            $this->displaySummary();
        } finally {
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }

    /**
     * Display seeding summary.
     *
     * @return void
     */
    private function displaySummary(): void
    {
        $this->command->info('');
        $this->command->info('📊 Seeding Summary:');
        $this->command->info('==================');
        
        // Count models and display summary
        $userCount = \Modules\SaluteOra\Models\User::count();
        $adminCount = \Modules\SaluteOra\Models\Admin::count();
        $doctorCount = \Modules\SaluteOra\Models\Doctor::count();
        $patientCount = \Modules\SaluteOra\Models\Patient::count();
        $studioCount = \Modules\SaluteOra\Models\Studio::count();
        $appointmentCount = \Modules\SaluteOra\Models\Appointment::count();
        $profileCount = \Modules\SaluteOra\Models\Profile::count();
        $reportCount = \Modules\SaluteOra\Models\Report::count();

        $this->command->info("👥 Users: {$userCount} total");
        $this->command->info("   - Admins: {$adminCount}");
        $this->command->info("   - Doctors: {$doctorCount}");
        $this->command->info("   - Patients: {$patientCount}");
        $this->command->info("🏥 Studios: {$studioCount}");
        $this->command->info("👤 Profiles: {$profileCount}");
        $this->command->info("📅 Appointments: {$appointmentCount}");
        $this->command->info("📋 Reports: {$reportCount}");
        
        $this->command->info('');
        $this->command->info('🎯 Ready for testing!');
    }
}
