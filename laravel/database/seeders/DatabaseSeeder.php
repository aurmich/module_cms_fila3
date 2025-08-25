<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Modules\User\Database\Seeders\UserSeeder;
use Modules\SaluteOra\Database\Seeders\SaluteOraSeeder;

/**
 * Seeder principale del database.
 * 
 * Coordina l'esecuzione di tutti i seeder dei moduli per popolare
 * il database con dati di test realistici.
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Esegue il seeding del database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Inizializzazione seeding completo del database...');
        $this->command->info('');

        $startTime = microtime(true);

        // Seeding dei moduli in ordine di dipendenza
        $this->call([
            UserSeeder::class,                // Base: ruoli, permessi, team di sistema
            \Modules\Activity\Database\Seeders\ActivityDatabaseSeeder::class, // Attività di sistema
            \Modules\Geo\Database\Seeders\GeoDatabaseSeeder::class,           // Dati geografici
            SaluteOraSeeder::class,           // Principale: utenti, studi, appuntamenti
        ]);

        // Seeding di massa per grandi quantità di dati
        $this->command->info('🚀 Avvio seeding di massa per tutti i moduli...');
        $this->call([
            \Modules\User\Database\Seeders\UserMassSeeder::class,           // Utenti, ruoli, team
            \Modules\Activity\Database\Seeders\ActivityMassSeeder::class,   // Attività, snapshot, eventi
            \Modules\Cms\Database\Seeders\CmsMassSeeder::class,            // Pagine, sezioni, menu
            \Modules\SaluteOra\Database\Seeders\MassDataSeeder::class,      // Dati principali SaluteOra
        ]);

        $endTime = microtime(true);
        $executionTime = round($endTime - $startTime, 2);

        $this->command->info('');
        $this->command->info("🎉 Seeding completo terminato in {$executionTime} secondi!");
        $this->command->info('');
        
        $this->displaySummary();
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
            $totalUsers = \Modules\SaluteOra\Models\User::count();
            $admins = \Modules\SaluteOra\Models\User::admins()->count();
            $doctors = \Modules\SaluteOra\Models\User::doctors()->count();
            $patients = \Modules\SaluteOra\Models\User::patients()->count();
            
            $this->command->info("│ 👥 Utenti totali:           " . str_pad((string)$totalUsers, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│    - Admin:                 " . str_pad((string)$admins, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│    - Dottori:               " . str_pad((string)$doctors, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│    - Pazienti:              " . str_pad((string)$patients, 6, ' ', STR_PAD_LEFT) . " │");
            
            // Conta studi
            $totalStudios = \Modules\SaluteOra\Models\Studio::count();
            $activeStudios = \Modules\SaluteOra\Models\Studio::active()->count();
            
            $this->command->info("│ 🏥 Studi totali:            " . str_pad((string)$totalStudios, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│    - Attivi:                " . str_pad((string)$activeStudios, 6, ' ', STR_PAD_LEFT) . " │");
            
            // Conta appuntamenti
            $totalAppointments = \Modules\SaluteOra\Models\Appointment::count();
            $emergencyAppointments = \Modules\SaluteOra\Models\Appointment::emergency()->count();
            
            $this->command->info("│ 📅 Appuntamenti totali:     " . str_pad((string)$totalAppointments, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│    - Emergenze:             " . str_pad((string)$emergencyAppointments, 6, ' ', STR_PAD_LEFT) . " │");
            
            // Conta ruoli e permessi
            $totalRoles = \Modules\User\Models\Role::count();
            $totalPermissions = \Modules\User\Models\Permission::count();
            $totalTeams = \Modules\User\Models\Team::count();
            
            $this->command->info("│ 🔐 Ruoli:                  " . str_pad((string)$totalRoles, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│ 🔑 Permessi:               " . str_pad((string)$totalPermissions, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│ 👥 Team:                   " . str_pad((string)$totalTeams, 6, ' ', STR_PAD_LEFT) . " │");
            
        } catch (\Exception $e) {
            $this->command->info("│ ❌ Errore nel conteggio: " . $e->getMessage());
        }
        
        $this->command->info('└─────────────────────────────────────┘');
        $this->command->info('');
        
        $this->command->info('🔐 CREDENZIALI DI ACCESSO:');
        $this->command->info('┌─────────────────────────────────────┐');
        $this->command->info('│ Admin:                              │');
        $this->command->info('│   Email: admin@saluteora.com        │');
        $this->command->info('│   Password: password                │');
        $this->command->info('└─────────────────────────────────────┘');
        $this->command->info('');
        
        $this->command->info('💡 PROSSIMI PASSI:');
        $this->command->info('1. Accedi al sistema con le credenziali admin');
        $this->command->info('2. Verifica che i dati siano stati creati correttamente');
        $this->command->info('3. Testa le funzionalità di calendario e appuntamenti');
        $this->command->info('4. Configura eventuali impostazioni aggiuntive');
        $this->command->info('');
    }
}