<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Report;
use Modules\User\Models\User;

/**
 * Seeder per il popolamento massivo del modulo SaluteOra.
 * 
 * Questo seeder crea un dataset completo per testing e sviluppo,
 * includendo utenti, dottori, pazienti, studi, appuntamenti e report.
 */
class SaluteOraMassSeeder extends Seeder
{
    /**
     * Esegue il seeder.
     */
    public function run(): void
    {
        $this->command->info('🚀 Avvio popolamento massivo modulo SaluteOra...');

        // 1. Creazione utenti base
        $this->createUsers();
        
        // 2. Creazione dottori
        $this->createDoctors();
        
        // 3. Creazione pazienti
        $this->createPatients();
        
        // 4. Creazione relazioni dottore-studio
        $this->createDoctorStudioRelations();
        
        // 5. Creazione relazioni paziente-studio
        $this->createPatientStudioRelations();
        
        // 6. Creazione appuntamenti
        $this->createAppointments();
        
        // 7. Creazione report
        $this->createReports();
        
        // 8. Verifica finale
        $this->verifyPopulation();
        
        $this->command->info('✅ Popolamento massivo completato con successo!');
    }

    /**
     * Crea utenti base per il sistema.
     */
    private function createUsers(): void
    {
        $this->command->info('1. Creazione utenti base...');
        
        $existingUsers = User::count();
        if ($existingUsers < 50) {
            $usersToCreate = 50 - $existingUsers;
            User::factory()->count($usersToCreate)->create();
            $this->command->info("   ✅ {$usersToCreate} utenti aggiuntivi creati");
        } else {
            $this->command->info("   ℹ️  Utenti sufficienti già presenti ({$existingUsers})");
        }
    }

    /**
     * Crea dottori per il sistema sanitario.
     */
    private function createDoctors(): void
    {
        $this->command->info('2. Creazione dottori...');
        
        $existingDoctors = Doctor::count();
        if ($existingDoctors < 25) {
            $doctorsToCreate = 25 - $existingDoctors;
            
            for ($i = 0; $i < $doctorsToCreate; $i++) {
                Doctor::create([
                    'name' => fake()->firstName(),
                    'last_name' => 'Dr. ' . fake()->lastName(),
                    'email' => fake()->unique()->safeEmail(),
                    'phone' => fake()->phoneNumber(),
                    'type' => 'doctor',
                    'status' => 'approved'
                ]);
            }
            
            $this->command->info("   ✅ {$doctorsToCreate} dottori aggiuntivi creati");
        } else {
            $this->command->info("   ℹ️  Dottori sufficienti già presenti ({$existingDoctors})");
        }
    }

    /**
     * Crea pazienti per il sistema sanitario.
     */
    private function createPatients(): void
    {
        $this->command->info('3. Creazione pazienti...');
        
        $existingPatients = Patient::count();
        if ($existingPatients < 100) {
            $patientsToCreate = 100 - $existingPatients;
            
            for ($i = 0; $i < $patientsToCreate; $i++) {
                Patient::create([
                    'name' => fake()->firstName(),
                    'last_name' => fake()->lastName(),
                    'email' => fake()->unique()->safeEmail(),
                    'phone' => fake()->phoneNumber(),
                    'type' => 'patient',
                    'date_of_birth' => fake()->dateTimeBetween('-80 years', '-18 years'),
                    'gender' => fake()->randomElement(['M', 'F'])
                ]);
            }
            
            $this->command->info("   ✅ {$patientsToCreate} pazienti aggiuntivi creati");
        } else {
            $this->command->info("   ℹ️  Pazienti sufficienti già presenti ({$existingPatients})");
        }
    }

    /**
     * Crea relazioni tra dottori e studi.
     */
    private function createDoctorStudioRelations(): void
    {
        $this->command->info('4. Creazione relazioni dottore-studio...');
        
        $doctors = Doctor::all();
        $studios = Studio::all();
        $relations = 0;
        
        foreach ($studios as $studio) {
            $studioDoctors = $doctors->random(rand(2, 5));
            foreach ($studioDoctors as $doctor) {
                // Verifica se la relazione esiste già
                $exists = DB::table('studio_user')
                    ->where('studio_id', $studio->id)
                    ->where('user_id', $doctor->id)
                    ->exists();
                
                if (!$exists) {
                    DB::table('studio_user')->insert([
                        'studio_id' => $studio->id,
                        'user_id' => $doctor->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $relations++;
                }
            }
        }
        
        $this->command->info("   ✅ {$relations} nuove relazioni dottore-studio create");
    }

    /**
     * Crea relazioni tra pazienti e studi.
     */
    private function createPatientStudioRelations(): void
    {
        $this->command->info('5. Creazione relazioni paziente-studio...');
        
        $patients = Patient::all();
        $studios = Studio::all();
        $relations = 0;
        
        foreach ($studios as $studio) {
            $studioPatients = $patients->random(rand(10, 30));
            foreach ($studioPatients as $patient) {
                // Verifica se la relazione esiste già
                $exists = DB::table('studio_user')
                    ->where('studio_id', $studio->id)
                    ->where('user_id', $patient->id)
                    ->exists();
                
                if (!$exists) {
                    DB::table('studio_user')->insert([
                        'studio_id' => $studio->id,
                        'user_id' => $patient->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $relations++;
                }
            }
        }
        
        $this->command->info("   ✅ {$relations} nuove relazioni paziente-studio create");
    }

    /**
     * Crea appuntamenti per il sistema.
     */
    private function createAppointments(): void
    {
        $this->command->info('6. Creazione appuntamenti...');
        
        $existingAppointments = Appointment::count();
        if ($existingAppointments < 200) {
            $appointmentsToCreate = 200 - $existingAppointments;
            
            $doctors = Doctor::all();
            $patients = Patient::all();
            $studios = Studio::all();
            
            for ($i = 0; $i < $appointmentsToCreate; $i++) {
                $startsAt = fake()->dateTimeBetween('now', '+30 days');
                $endsAt = (clone $startsAt)->modify('+1 hour');
                
                Appointment::create([
                    'doctor_id' => $doctors->random()->id,
                    'patient_id' => $patients->random()->id,
                    'studio_id' => $studios->random()->id,
                    'title' => fake()->sentence(3),
                    'starts_at' => $startsAt,
                    'ends_at' => $endsAt,
                    'type' => fake()->randomElement(['consultation', 'cleaning', 'treatment', 'followup']),
                    'state' => fake()->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
                    'emergency' => fake()->boolean(10),
                    'notes' => fake()->optional(0.7)->sentence()
                ]);
            }
            
            $this->command->info("   ✅ {$appointmentsToCreate} appuntamenti aggiuntivi creati");
        } else {
            $this->command->info("   ℹ️  Appuntamenti sufficienti già presenti ({$existingAppointments})");
        }
    }

    /**
     * Crea report per il sistema.
     */
    private function createReports(): void
    {
        $this->command->info('7. Creazione report...');
        
        $existingReports = Report::count();
        if ($existingReports < 150) {
            $reportsToCreate = 150 - $existingReports;
            
            $doctors = Doctor::all();
            $patients = Patient::all();
            
            for ($i = 0; $i < $reportsToCreate; $i++) {
                Report::create([
                    'patient_id' => $patients->random()->id,
                    'doctor_id' => $doctors->random()->id,
                    'type' => fake()->randomElement(['consultation', 'treatment', 'followup', 'emergency']),
                    'content' => fake()->paragraphs(3, true),
                    'date' => fake()->dateTimeBetween('-6 months', 'now')
                ]);
            }
            
            $this->command->info("   ✅ {$reportsToCreate} report aggiuntivi creati");
        } else {
            $this->command->info("   ℹ️  Report sufficienti già presenti ({$existingReports})");
        }
    }

    /**
     * Verifica il popolamento finale del database.
     */
    private function verifyPopulation(): void
    {
        $this->command->info('8. Verifica finale...');
        
        $counts = [
            'Users' => User::count(),
            'Studi' => Studio::count(),
            'Dottori' => Doctor::count(),
            'Pazienti' => Patient::count(),
            'Appuntamenti' => Appointment::count(),
            'Report' => Report::count(),
            'Relazioni Studio-User' => DB::table('studio_user')->count()
        ];
        
        foreach ($counts as $entity => $count) {
            $this->command->info("   📊 {$entity}: {$count}");
        }
        
        $this->command->info('   ✅ Verifica completata');
    }
}

