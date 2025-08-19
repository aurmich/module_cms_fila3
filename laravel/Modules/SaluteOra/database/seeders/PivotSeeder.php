<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SaluteOra\Models\Admin;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\AdminStudio;
use Modules\SaluteOra\Models\DoctorStudio;
use Modules\SaluteOra\Models\PatientStudio;
use Modules\SaluteOra\Models\StudioUser;
use Modules\User\Models\Team;

/**
 * Seeder for pivot table relationships.
 *
 * Creates relationships between users and studios, teams, etc.
 */
class PivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('Creating pivot relationships...');

        // Ensure we have the required models
        $admins = Admin::all();
        $doctors = Doctor::all();
        $patients = Patient::all();
        $studios = Studio::where('active', true)->get();
        $teams = Team::all();

        if ($admins->isEmpty() || $doctors->isEmpty() || $patients->isEmpty() || $studios->isEmpty()) {
            $this->command->warn('Please run UserSeeder and StudioSeeder first!');
            return;
        }

        $this->createAdminStudioRelationships($admins, $studios);
        $this->createDoctorStudioRelationships($doctors, $studios);
        $this->createPatientStudioRelationships($patients, $studios);

        $this->command->info('Pivot relationships created successfully!');
    }

    /**
     * Create admin-studio relationships.
     *
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Admin> $admins
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $studios
     * @return void
     */
    private function createAdminStudioRelationships($admins, $studios): void
    {
        $this->command->info('Creating admin-studio relationships...');

        $createdCount = 0;

        foreach ($admins as $admin) {
            // Each admin manages 1-3 studios
            $studioCount = rand(1, 3);
            $selectedStudios = $studios->random($studioCount);
            $isPrimarySet = false;

            foreach ($selectedStudios as $studio) {
                AdminStudio::factory()->create([
                    'user_id' => $admin->id,
                    'studio_id' => $studio->id,
                    'is_primary' => !$isPrimarySet, // First one is primary
                ]);
                
                if (!$isPrimarySet) {
                    $isPrimarySet = true;
                }
                
                $createdCount++;
            }
        }

        $this->command->info("Created {$createdCount} admin-studio relationships");
    }

    /**
     * Create doctor-studio relationships.
     *
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Doctor> $doctors
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $studios
     * @return void
     */
    private function createDoctorStudioRelationships($doctors, $studios): void
    {
        $this->command->info('Creating doctor-studio relationships...');

        $createdCount = 0;

        foreach ($doctors as $doctor) {
            // Each doctor works in 1-2 studios
            $studioCount = rand(1, 2);
            $selectedStudios = $studios->random($studioCount);
            $isPrimarySet = false;

            foreach ($selectedStudios as $studio) {
                $isPrimary = !$isPrimarySet;
                
                DoctorStudio::factory()->create([
                    'user_id' => $doctor->id,
                    'studio_id' => $studio->id,
                    'is_primary' => $isPrimary,
                ]);
                
                if (!$isPrimarySet) {
                    $isPrimarySet = true;
                }
                
                $createdCount++;
            }
        }

        $this->command->info("Created {$createdCount} doctor-studio relationships");
    }

    /**
     * Create patient-studio relationships.
     *
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Patient> $patients
     * @param \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $studios
     * @return void
     */
    private function createPatientStudioRelationships($patients, $studios): void
    {
        $this->command->info('Creating patient-studio relationships...');

        $createdCount = 0;

        foreach ($patients as $patient) {
            // Most patients are registered to 1 studio, some to 2
            $studioCount = rand(1, 100) <= 85 ? 1 : 2;
            $selectedStudios = $studios->random($studioCount);
            $isPrimarySet = false;

            foreach ($selectedStudios as $studio) {
                $isPrimary = !$isPrimarySet;
                
                PatientStudio::factory()->create([
                    'user_id' => $patient->id,
                    'studio_id' => $studio->id,
                    'is_primary' => $isPrimary,
                    'status' => 'active',
                ]);
                
                if (!$isPrimarySet) {
                    $isPrimarySet = true;
                }
                
                $createdCount++;
            }
        }

        $this->command->info("Created {$createdCount} patient-studio relationships");
    }
}
