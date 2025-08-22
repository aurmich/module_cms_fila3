<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

/**
 * Master Seeder per popolare il database con molti record realistici.
 * 
 * Questo seeder coordina la creazione di una grande quantità di dati
 * per tutti i moduli del sistema, rispettando le dipendenze e
 * creando relazioni realistiche tra i modelli.
 */
class MassiveDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting MASSIVE data seeding for SaluteOra system...');
        $startTime = microtime(true);

        // Fase 1: Dati di base geografici e utenti
        $this->seedGeographicalData();
        $this->seedBaseUsers();
        $this->seedTenantData();
        
        // Fase 2: Dati sanitari principali
        $this->seedHealthcareData();
        
        // Fase 3: Dati operativi e relazioni
        $this->seedOperationalData();
        
        // Fase 4: Dati storici e analitici
        $this->seedHistoricalData();

        $endTime = microtime(true);
        $executionTime = round($endTime - $startTime, 2);
        
        $this->command->info("✅ MASSIVE seeding completed in {$executionTime} seconds!");
        $this->printStatistics();
    }

    /**
     * Seed geographical data (regions, provinces, comuni).
     *
     * @return void
     */
    private function seedGeographicalData(): void
    {
        $this->command->info('🗺️  Seeding geographical data...');
        
        // Regioni italiane (20 + 2 province autonome)
        $this->call(\Modules\Geo\Database\Seeders\GeoDatabaseSeeder::class);
        
        // Aggiungi province e comuni extra
        \Modules\Geo\Models\Province::factory()->count(50)->create();
        \Modules\Geo\Models\Comune::factory()->count(500)->create();
        
        $this->command->info('✅ Geographical data seeded');
    }

    /**
     * Seed base users and authentication data.
     *
     * @return void
     */
    private function seedBaseUsers(): void
    {
        $this->command->info('👥 Seeding base users...');
        
        $this->call(\Modules\User\Database\Seeders\UserDatabaseSeeder::class);
        
        // Aggiungi molti utenti base
        \Modules\User\Models\User::factory()->count(200)->create();
        
        $this->command->info('✅ Base users seeded');
    }

    /**
     * Seed tenant and multi-tenancy data.
     *
     * @return void
     */
    private function seedTenantData(): void
    {
        $this->command->info('🏢 Seeding tenant data...');
        
        $this->call(\Modules\Tenant\Database\Seeders\TenantDatabaseSeeder::class);
        
        // Team aggiuntivi
        \Modules\User\Models\Team::factory()->count(50)->create();
        
        $this->command->info('✅ Tenant data seeded');
    }

    /**
     * Seed healthcare-specific data.
     *
     * @return void
     */
    private function seedHealthcareData(): void
    {
        $this->command->info('🏥 Seeding healthcare data...');
        
        // SaluteOra - Sistema sanitario principale
        $this->call(\Modules\SaluteOra\Database\Seeders\SaluteOraSeeder::class);
        
        // Studi medici extra (simuliamo molti studi in Italia)
        \Modules\SaluteOra\Models\Studio::factory()->count(150)->create();
        
        // Dottori (molti specialisti)
        $doctors = \Modules\SaluteOra\Models\Doctor::factory()->count(300)->create();
        
        // Pazienti (popolazione realistica)
        $patients = \Modules\SaluteOra\Models\Patient::factory()->count(2000)->create();
        
        // Pazienti con condizioni speciali
        \Modules\SaluteOra\Models\Patient::factory()->pregnant()->count(150)->create();
        \Modules\SaluteOra\Models\Patient::factory()->elderly()->count(300)->create();
        \Modules\SaluteOra\Models\Patient::factory()->pediatric()->count(200)->create();
        \Modules\SaluteOra\Models\Patient::factory()->withMedicalHistory()->count(250)->create();
        
        // Admin del sistema
        \Modules\SaluteOra\Models\Admin::factory()->count(20)->create();
        
        // SaluteMo - Gestanti Modena
        $this->call(\Modules\SaluteMo\Database\Seeders\PatientSeeder::class);
        
        $this->command->info('✅ Healthcare data seeded');
    }

    /**
     * Seed operational data (appointments, reports, etc.).
     *
     * @return void
     */
    private function seedOperationalData(): void
    {
        $this->command->info('📅 Seeding operational data...');
        
        // Appuntamenti massivi (simula 2 anni di attività)
        $this->call(\Modules\SaluteOra\Database\Seeders\AppointmentSeeder::class);
        
        // Appuntamenti extra per stress test
        \Modules\SaluteOra\Models\Appointment::factory()->count(5000)->create();
        
        // Report medici
        $this->call(\Modules\SaluteOra\Database\Seeders\ReportSeeder::class);
        \Modules\SaluteOra\Models\Report::factory()->count(1500)->create();
        
        // Relazioni many-to-many
        $this->createDoctorStudioRelations();
        $this->createPatientStudioRelations();
        $this->createTeamRelations();
        
        $this->command->info('✅ Operational data seeded');
    }

    /**
     * Seed historical data for analytics.
     *
     * @return void
     */
    private function seedHistoricalData(): void
    {
        $this->command->info('📊 Seeding historical data...');
        
        // Dati di attività per analytics
        $this->call(\Modules\Activity\Database\Seeders\ActivityDatabaseSeeder::class);
        
        // Log di autenticazione
        $users = \Modules\User\Models\User::all();
        foreach ($users->random(100) as $user) {
            \Modules\User\Models\AuthenticationLog::factory()->count(rand(5, 50))->create([
                'authenticatable_id' => $user->id,
                'authenticatable_type' => get_class($user),
            ]);
        }
        
        // Notifiche storiche
        $this->call(\Modules\Notify\Database\Seeders\NotifyDatabaseSeeder::class);
        
        // Job e task
        $this->call(\Modules\Job\Database\Seeders\JobDatabaseSeeder::class);
        
        // Media files
        $this->call(\Modules\Media\Database\Seeders\MediaDatabaseSeeder::class);
        
        // CMS content
        $this->call(\Modules\Cms\Database\Seeders\CmsDatabaseSeeder::class);
        
        // GDPR compliance data
        $this->call(\Modules\Gdpr\Database\Seeders\GdprDatabaseSeeder::class);
        
        // Traduzioni
        $this->call(\Modules\Lang\Database\Seeders\LangDatabaseSeeder::class);
        
        $this->command->info('✅ Historical data seeded');
    }

    /**
     * Create doctor-studio many-to-many relations.
     *
     * @return void
     */
    private function createDoctorStudioRelations(): void
    {
        $this->command->info('🔗 Creating doctor-studio relations...');
        
        $doctors = \Modules\SaluteOra\Models\Doctor::all();
        $studios = \Modules\SaluteOra\Models\Studio::all();
        
        foreach ($doctors as $doctor) {
            // Ogni dottore lavora in 1-3 studi
            $randomStudios = $studios->random(rand(1, 3));
            foreach ($randomStudios as $studio) {
                \Modules\SaluteOra\Models\DoctorStudio::factory()->create([
                    'doctor_id' => $doctor->id,
                    'studio_id' => $studio->id,
                ]);
            }
        }
        
        $this->command->info('✅ Doctor-studio relations created');
    }

    /**
     * Create patient-studio many-to-many relations.
     *
     * @return void
     */
    private function createPatientStudioRelations(): void
    {
        $this->command->info('🔗 Creating patient-studio relations...');
        
        $patients = \Modules\SaluteOra\Models\Patient::all();
        $studios = \Modules\SaluteOra\Models\Studio::all();
        
        foreach ($patients->random(1500) as $patient) {
            // Alcuni pazienti sono associati a studi specifici
            $randomStudios = $studios->random(rand(1, 2));
            foreach ($randomStudios as $studio) {
                \Modules\SaluteOra\Models\PatientStudio::factory()->create([
                    'patient_id' => $patient->id,
                    'studio_id' => $studio->id,
                ]);
            }
        }
        
        $this->command->info('✅ Patient-studio relations created');
    }

    /**
     * Create team relations for multi-tenancy.
     *
     * @return void
     */
    private function createTeamRelations(): void
    {
        $this->command->info('🔗 Creating team relations...');
        
        $users = \Modules\SaluteOra\Models\User::all();
        $teams = \Modules\User\Models\Team::all();
        
        foreach ($users->random(800) as $user) {
            // Gli utenti appartengono a 1-2 team
            $randomTeams = $teams->random(rand(1, 2));
            foreach ($randomTeams as $team) {
                \Modules\SaluteOra\Models\TeamUser::factory()->create([
                    'user_id' => $user->id,
                    'team_id' => $team->id,
                ]);
            }
        }
        
        $this->command->info('✅ Team relations created');
    }

    /**
     * Print seeding statistics.
     *
     * @return void
     */
    private function printStatistics(): void
    {
        $this->command->info('');
        $this->command->info('📊 SEEDING STATISTICS:');
        $this->command->line('================================');
        
        // Conteggi per modulo
        $stats = [
            'Users' => \Modules\User\Models\User::count(),
            'SaluteOra Users' => \Modules\SaluteOra\Models\User::count(),
            'Patients' => \Modules\SaluteOra\Models\Patient::count(),
            'Doctors' => \Modules\SaluteOra\Models\Doctor::count(),
            'Admins' => \Modules\SaluteOra\Models\Admin::count(),
            'Studios' => \Modules\SaluteOra\Models\Studio::count(),
            'Appointments' => \Modules\SaluteOra\Models\Appointment::count(),
            'Reports' => \Modules\SaluteOra\Models\Report::count(),
            'Teams' => \Modules\User\Models\Team::count(),
            'Provinces' => \Modules\Geo\Models\Province::count(),
            'Comuni' => \Modules\Geo\Models\Comune::count(),
            'SaluteMo Patients' => \Modules\SaluteMo\Models\Patient::count(),
        ];
        
        foreach ($stats as $model => $count) {
            $this->command->line(sprintf('%-20s: %s', $model, number_format($count)));
        }
        
        $this->command->line('================================');
        $this->command->info('🎉 Ready for production-scale testing!');
    }
}
