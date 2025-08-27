<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PopulateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:populate 
                            {--count=1000 : Number of records to create per model}
                            {--modules=all : Specific modules to populate (comma-separated)}
                            {--force : Force population without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Popola il database con grandi quantità di dati di test';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $count = (int) $this->option('count');
        $modules = $this->option('modules');
        $force = $this->option('force');

        if (!$force) {
            if (!$this->confirm("⚠️  Questo comando creerà {$count} record per ogni modello. Continuare?")) {
                $this->info('Operazione annullata.');
                return Command::SUCCESS;
            }
        }

        $this->info('🚀 Inizializzazione popolamento database...');
        $startTime = microtime(true);

        try {
            // Esegui il seeding di massa
            $this->info('📊 Esecuzione seeder di massa...');
            Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);

            // Popolamento aggiuntivo tramite factory
            $this->populateWithFactories($count, $modules);

            $endTime = microtime(true);
            $executionTime = round($endTime - $startTime, 2);

            $this->info("🎉 Popolamento completato in {$executionTime} secondi!");
            $this->displaySummary();

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Errore durante il popolamento: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
            return Command::FAILURE;
        }
    }

    /**
     * Popola il database usando le factory.
     */
    private function populateWithFactories(int $count, string $modules): void
    {
        $this->info("🏭 Popolamento con factory ({$count} record per modello)...");

        if ($modules === 'all' || str_contains($modules, 'saluteora')) {
            $this->populateSaluteOra($count);
        }

        if ($modules === 'all' || str_contains($modules, 'user')) {
            $this->populateUser($count);
        }

        if ($modules === 'all' || str_contains($modules, 'activity')) {
            $this->populateActivity($count);
        }

        if ($modules === 'all' || str_contains($modules, 'cms')) {
            $this->populateCms($count);
        }
    }

    /**
     * Popola il modulo SaluteOra.
     */
    private function populateSaluteOra(int $count): void
    {
        $this->info('🏥 Popolamento modulo SaluteOra...');

        // Popola studi
        $this->info("   Creazione {$count} studi...");
        \Modules\SaluteOra\Models\Studio::factory()->count($count)->create();

        // Popola utenti
        $this->info("   Creazione {$count} utenti...");
        \Modules\SaluteOra\Models\User::factory()->count($count)->create();

        // Popola appuntamenti
        $this->info("   Creazione {$count} appuntamenti...");
        \Modules\SaluteOra\Models\Appointment::factory()->count($count)->create();

        // Popola referti
        $this->info("   Creazione {$count} referti...");
        \Modules\SaluteOra\Models\Report::factory()->count($count)->create();

        $this->info('✅ Modulo SaluteOra popolato');
    }

    /**
     * Popola il modulo User.
     */
    private function populateUser(int $count): void
    {
        $this->info('👤 Popolamento modulo User...');

        // Popola utenti
        $this->info("   Creazione {$count} utenti...");
        \Modules\User\Models\User::factory()->count($count)->create();

        // Popola profili
        $this->info("   Creazione {$count} profili...");
        \Modules\User\Models\Profile::factory()->count($count)->create();

        // Popola log di autenticazione
        $this->info("   Creazione {$count} log di autenticazione...");
        \Modules\User\Models\AuthenticationLog::factory()->count($count)->create();

        $this->info('✅ Modulo User popolato');
    }

    /**
     * Popola il modulo Activity.
     */
    private function populateActivity(int $count): void
    {
        $this->info('📝 Popolamento modulo Activity...');

        // Popola attività
        $this->info("   Creazione {$count} attività...");
        \Modules\Activity\Models\Activity::factory()->count($count)->create();

        // Popola snapshot
        $this->info("   Creazione {$count} snapshot...");
        \Modules\Activity\Models\Snapshot::factory()->count($count)->create();

        // Popola eventi memorizzati
        $this->info("   Creazione {$count} eventi memorizzati...");
        \Modules\Activity\Models\StoredEvent::factory()->count($count)->create();

        $this->info('✅ Modulo Activity popolato');
    }

    /**
     * Popola il modulo Cms.
     */
    private function populateCms(int $count): void
    {
        $this->info('📄 Popolamento modulo Cms...');

        // Popola moduli
        $this->info("   Creazione {$count} moduli...");
        \Modules\Cms\Models\Module::factory()->count($count)->create();

        // Popola sezioni
        $this->info("   Creazione {$count} sezioni...");
        \Modules\Cms\Models\Section::factory()->count($count)->create();

        // Popola pagine
        $this->info("   Creazione {$count} pagine...");
        \Modules\Cms\Models\Page::factory()->count($count)->create();

        // Popola contenuti
        $this->info("   Creazione {$count} contenuti...");
        \Modules\Cms\Models\PageContent::factory()->count($count)->create();

        $this->info('✅ Modulo Cms popolato');
    }

    /**
     * Mostra un riassunto dei dati creati.
     */
    private function displaySummary(): void
    {
        $this->info('📊 RIASSUNTO FINALE DATI NEL DATABASE:');
        $this->info('┌─────────────────────────────────────┐');

        try {
            // Conta utenti
            $totalUsers = \Modules\SaluteOra\Models\User::count();
            $admins = \Modules\SaluteOra\Models\User::where('type', 'admin')->count();
            $doctors = \Modules\SaluteOra\Models\User::where('type', 'doctor')->count();
            $patients = \Modules\SaluteOra\Models\User::count() - $admins - $doctors;

            $this->info("│ 👥 Utenti totali:           " . str_pad((string)$totalUsers, 6, ' ', STR_PAD_LEFT) . " │");
            $this->info("│    - Admin:                 " . str_pad((string)$admins, 6, ' ', STR_PAD_LEFT) . " │");
            $this->info("│    - Dottori:               " . str_pad((string)$doctors, 6, ' ', STR_PAD_LEFT) . " │");
            $this->info("│    - Pazienti:              " . str_pad((string)$patients, 6, ' ', STR_PAD_LEFT) . " │");

            // Conta studi
            $totalStudios = \Modules\SaluteOra\Models\Studio::count();
            $this->info("│ 🏥 Studi totali:            " . str_pad((string)$totalStudios, 6, ' ', STR_PAD_LEFT) . " │");

            // Conta appuntamenti
            $totalAppointments = \Modules\SaluteOra\Models\Appointment::count();
            $this->info("│ 📅 Appuntamenti totali:     " . str_pad((string)$totalAppointments, 6, ' ', STR_PAD_LEFT) . " │");

            // Conta referti
            $totalReports = \Modules\SaluteOra\Models\Report::count();
            $this->info("│ 📋 Referti totali:          " . str_pad((string)$totalReports, 6, ' ', STR_PAD_LEFT) . " │");

            // Conta attività
            $totalActivities = \Modules\Activity\Models\Activity::count();
            $this->info("│ 📝 Attività totali:         " . str_pad((string)$totalActivities, 6, ' ', STR_PAD_LEFT) . " │");

            // Conta pagine CMS
            $totalPages = \Modules\Cms\Models\Page::count();
            $this->info("│ 📄 Pagine CMS totali:       " . str_pad((string)$totalPages, 6, ' ', STR_PAD_LEFT) . " │");

        } catch (\Exception $e) {
            $this->info("│ ❌ Errore nel conteggio: " . $e->getMessage());
        }

        $this->info('└─────────────────────────────────────┘');
        $this->info('');

        $this->info('🔐 CREDENZIALI DI ACCESSO:');
        $this->info('Admin: admin@saluteora.com / password');
        $this->info('Doctor: doctor@saluteora.com / password');
        $this->info('Patient: patient@saluteora.com / password');
        $this->info('');

        $this->info('💡 SUGGERIMENTI:');
        $this->info('- Usa php artisan tinker per esplorare i dati');
        $this->info('- Esegui php artisan db:populate --count=5000 per più record');
        $this->info('- Usa --modules=saluteora,user per moduli specifici');
        $this->info('');
    }
}
