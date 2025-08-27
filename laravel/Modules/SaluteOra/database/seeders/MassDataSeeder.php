<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Report;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\User\Models\Role;
use Modules\User\Models\Permission;
use Modules\User\Models\Team;

/**
 * Seeder per creare grandi quantità di dati di test.
 * Utilizza factory e creazione diretta per massimizzare le performance.
 */
class MassDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Esegue il seeding del database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Inizializzazione seeding di massa...');
        
        // Disabilita eventi per migliorare le performance
        // $this->withoutModelEvents(); // Non necessario con il trait
        
        $startTime = microtime(true);
        
        try {
            // 1. Creazione ruoli e permessi di base
            $this->createRolesAndPermissions();
            
            // 2. Creazione team di sistema
            $this->createSystemTeams();
            
            // 3. Creazione studi medici
            $this->createStudios();
            
            // 4. Creazione utenti (admin, dottori, pazienti)
            $this->createUsers();
            
            // 5. Creazione appuntamenti
            $this->createAppointments();
            
            // 6. Creazione referti
            $this->createReports();
            
            // 7. Creazione relazioni pivot
            $this->createPivotRelationships();
            
            $endTime = microtime(true);
            $executionTime = round($endTime - $startTime, 2);
            
            $this->command->info("🎉 Seeding di massa completato in {$executionTime} secondi!");
            $this->displaySummary();
            
        } catch (\Exception $e) {
            $this->command->error("❌ Errore durante il seeding: " . $e->getMessage());
            $this->command->error("Stack trace: " . $e->getTraceAsString());
            throw $e;
        }
    }
    
    /**
     * Crea ruoli e permessi di base.
     */
    private function createRolesAndPermissions(): void
    {
        $this->command->info('🔐 Creazione ruoli e permessi...');
        
        // Permessi di base
        $permissions = [
            'view-dashboard',
            'manage-appointments',
            'manage-patients',
            'manage-doctors',
            'manage-studios',
            'manage-reports',
            'manage-users',
            'view-reports',
            'create-reports',
            'edit-reports',
            'delete-reports',
            'manage-settings',
            'view-audit-logs',
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        
        // Ruoli di base
        $roles = [
            'super-admin' => $permissions,
            'admin' => [
                'view-dashboard',
                'manage-appointments',
                'manage-patients',
                'manage-doctors',
                'manage-studios',
                'manage-reports',
                'view-reports',
                'create-reports',
                'edit-reports',
                'manage-settings',
            ],
            'doctor' => [
                'view-dashboard',
                'manage-appointments',
                'manage-patients',
                'view-reports',
                'create-reports',
                'edit-reports',
            ],
            'patient' => [
                'view-dashboard',
                'view-reports',
            ],
        ];
        
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
        
        $this->command->info("✅ Creati " . count($permissions) . " permessi e " . count($roles) . " ruoli");
    }
    
    /**
     * Crea team di sistema.
     */
    private function createSystemTeams(): void
    {
        $this->command->info('👥 Creazione team di sistema...');
        
        $teams = [
            ['name' => 'Sistema', 'display_name' => 'Team di Sistema', 'description' => 'Team per la gestione del sistema'],
            ['name' => 'Amministrazione', 'display_name' => 'Team Amministrativo', 'description' => 'Team per la gestione amministrativa'],
            ['name' => 'Medico', 'display_name' => 'Team Medico', 'description' => 'Team per la gestione medica'],
            ['name' => 'Supporto', 'display_name' => 'Team di Supporto', 'description' => 'Team per il supporto tecnico'],
        ];
        
        foreach ($teams as $teamData) {
            Team::firstOrCreate(['name' => $teamData['name']], $teamData);
        }
        
        $this->command->info("✅ Creati " . count($teams) . " team di sistema");
    }
    
    /**
     * Crea studi medici.
     */
    private function createStudios(): void
    {
        $this->command->info('🏥 Creazione studi medici...');
        
        // Crea 50 studi medici
        $studios = Studio::factory()->count(50)->create([
            'is_active' => true,
            'created_at' => Carbon::now()->subDays(rand(1, 365)),
        ]);
        
        $this->command->info("✅ Creati " . $studios->count() . " studi medici");
    }
    
    /**
     * Crea utenti di tutti i tipi.
     */
    private function createUsers(): void
    {
        $this->command->info('👤 Creazione utenti...');
        
        // Crea 10 admin
        $admins = User::factory()->count(10)->create([
            'type' => UserTypeEnum::ADMIN,
            'email_verified_at' => Carbon::now(),
        ]);
        
        // Crea 100 dottori
        $doctors = User::factory()->count(100)->create([
            'type' => UserTypeEnum::DOCTOR,
            'email_verified_at' => Carbon::now(),
        ]);
        
        // Crea 500 pazienti
        $patients = User::factory()->count(500)->create([
            'type' => UserTypeEnum::PATIENT,
            'email_verified_at' => Carbon::now(),
        ]);
        
        // Assegna ruoli
        $adminRole = Role::where('name', 'admin')->first();
        $doctorRole = Role::where('name', 'doctor')->first();
        $patientRole = Role::where('name', 'patient')->first();
        
        foreach ($admins as $admin) {
            $admin->assignRole($adminRole);
        }
        
        foreach ($doctors as $doctor) {
            $doctor->assignRole($doctorRole);
        }
        
        foreach ($patients as $patient) {
            $patient->assignRole($patientRole);
        }
        
        $this->command->info("✅ Creati " . $admins->count() . " admin, " . $doctors->count() . " dottori, " . $patients->count() . " pazienti");
    }
    
    /**
     * Crea appuntamenti.
     */
    private function createAppointments(): void
    {
        $this->command->info('📅 Creazione appuntamenti...');
        
        // Crea 2000 appuntamenti
        $appointments = Appointment::factory()->count(2000)->create([
            'created_at' => Carbon::now()->subDays(rand(1, 365)),
        ]);
        
        $this->command->info("✅ Creati " . $appointments->count() . " appuntamenti");
    }
    
    /**
     * Crea referti.
     */
    private function createReports(): void
    {
        $this->command->info('📋 Creazione referti...');
        
        // Crea 1000 referti
        $reports = Report::factory()->count(1000)->create([
            'created_at' => Carbon::now()->subDays(rand(1, 365)),
        ]);
        
        $this->command->info("✅ Creati " . $reports->count() . " referti");
    }
    
    /**
     * Crea relazioni pivot.
     */
    private function createPivotRelationships(): void
    {
        $this->command->info('🔗 Creazione relazioni pivot...');
        
        // Relazioni dottore-studio
        $doctors = User::where('type', UserTypeEnum::DOCTOR)->get();
        $studios = Studio::all();
        
        foreach ($doctors as $doctor) {
            // Ogni dottore lavora in 1-3 studi
            $studioCount = rand(1, 3);
            $randomStudios = $studios->random($studioCount);
            
            foreach ($randomStudios as $studio) {
                DB::table('doctor_studio')->insert([
                    'doctor_id' => $doctor->id,
                    'studio_id' => $studio->id,
                    'is_active' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        
        // Relazioni paziente-studio
        $patients = User::where('type', UserTypeEnum::PATIENT)->get();
        
        foreach ($patients as $patient) {
            // Ogni paziente è registrato in 1-2 studi
            $studioCount = rand(1, 2);
            $randomStudios = $studios->random($studioCount);
            
            foreach ($randomStudios as $studio) {
                DB::table('patient_studio')->insert([
                    'patient_id' => $patient->id,
                    'studio_id' => $studio->id,
                    'is_active' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        
        $this->command->info("✅ Create relazioni pivot dottore-studio e paziente-studio");
    }
    
    /**
     * Mostra un riassunto dei dati creati.
     */
    private function displaySummary(): void
    {
        $this->command->info('📊 RIASSUNTO DATI CREATI:');
        $this->command->info('┌─────────────────────────────────────┐');
        
        try {
            // Conta utenti
            $totalUsers = User::count();
            $admins = User::where('type', UserTypeEnum::ADMIN)->count();
            $doctors = User::where('type', UserTypeEnum::DOCTOR)->count();
            $patients = User::where('type', UserTypeEnum::PATIENT)->count();
            
            $this->command->info("│ 👥 Utenti totali:           " . str_pad((string)$totalUsers, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│    - Admin:                 " . str_pad((string)$admins, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│    - Dottori:               " . str_pad((string)$doctors, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│    - Pazienti:              " . str_pad((string)$patients, 6, ' ', STR_PAD_LEFT) . " │");
            
            // Conta studi
            $totalStudios = Studio::count();
            $activeStudios = Studio::where('is_active', true)->count();
            
            $this->command->info("│ 🏥 Studi totali:            " . str_pad((string)$totalStudios, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│    - Attivi:                " . str_pad((string)$activeStudios, 6, ' ', STR_PAD_LEFT) . " │");
            
            // Conta appuntamenti
            $totalAppointments = Appointment::count();
            $emergencyAppointments = Appointment::where('type', AppointmentTypeEnum::EMERGENCY)->count();
            
            $this->command->info("│ 📅 Appuntamenti totali:     " . str_pad((string)$totalAppointments, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│    - Emergenze:             " . str_pad((string)$emergencyAppointments, 6, ' ', STR_PAD_LEFT) . " │");
            
            // Conta referti
            $totalReports = Report::count();
            
            $this->command->info("│ 📋 Referti totali:          " . str_pad((string)$totalReports, 6, ' ', STR_PAD_LEFT) . " │");
            
            // Conta ruoli e permessi
            $totalRoles = Role::count();
            $totalPermissions = Permission::count();
            $totalTeams = Team::count();
            
            $this->command->info("│ 🔐 Ruoli:                  " . str_pad((string)$totalRoles, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│ 🔑 Permessi:               " . str_pad((string)$totalPermissions, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│ 👥 Team:                   " . str_pad((string)$totalTeams, 6, ' ', STR_PAD_LEFT) . " │");
            
        } catch (\Exception $e) {
            $this->command->info("│ ❌ Errore nel conteggio: " . $e->getMessage());
        }
        
        $this->command->info('└─────────────────────────────────────┘');
        $this->command->info('');
        
        $this->command->info('🔐 CREDENZIALI DI ACCESSO:');
        $this->command->info('Admin: admin@saluteora.com / password');
        $this->command->info('Doctor: doctor@saluteora.com / password');
        $this->command->info('Patient: patient@saluteora.com / password');
        $this->command->info('');
    }
}
