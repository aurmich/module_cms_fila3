<?php

use Illuminate\Support\Facades\DB;

/**
 * Script per popolare il database tramite Tinker.
 * 
 * Utilizzo:
 * 1. Esegui: php artisan tinker
 * 2. Copia e incolla questo script
 * 3. Premi Enter per eseguire
 */

echo "🚀 Inizializzazione popolamento database tramite Tinker...\n";

$startTime = microtime(true);

try {
    // 1. Popolamento modulo SaluteOra
    echo "🏥 Popolamento modulo SaluteOra...\n";
    
    // Crea 1000 studi
    echo "   Creazione 1000 studi...\n";
    \Modules\SaluteOra\Models\Studio::factory()->count(1000)->create();
    
    // Crea 5000 utenti
    echo "   Creazione 5000 utenti...\n";
    \Modules\SaluteOra\Models\User::factory()->count(5000)->create();
    
    // Crea 10000 appuntamenti
    echo "   Creazione 10000 appuntamenti...\n";
    \Modules\SaluteOra\Models\Appointment::factory()->count(10000)->create();
    
    // Crea 5000 referti
    echo "   Creazione 5000 referti...\n";
    \Modules\SaluteOra\Models\Report::factory()->count(5000)->create();
    
    echo "✅ Modulo SaluteOra popolato\n";
    
    // 2. Popolamento modulo User
    echo "👤 Popolamento modulo User...\n";
    
    // Crea 2000 utenti generici
    echo "   Creazione 2000 utenti generici...\n";
    \Modules\User\Models\User::factory()->count(2000)->create();
    
    // Crea 2000 profili
    echo "   Creazione 2000 profili...\n";
    \Modules\User\Models\Profile::factory()->count(2000)->create();
    
    // Crea 5000 log di autenticazione
    echo "   Creazione 5000 log di autenticazione...\n";
    \Modules\User\Models\AuthenticationLog::factory()->count(5000)->create();
    
    echo "✅ Modulo User popolato\n";
    
    // 3. Popolamento modulo Activity
    echo "📝 Popolamento modulo Activity...\n";
    
    // Crea 5000 attività
    echo "   Creazione 5000 attività...\n";
    \Modules\Activity\Models\Activity::factory()->count(5000)->create();
    
    // Crea 2000 snapshot
    echo "   Creazione 2000 snapshot...\n";
    \Modules\Activity\Models\Snapshot::factory()->count(2000)->create();
    
    // Crea 3000 eventi memorizzati
    echo "   Creazione 3000 eventi memorizzati...\n";
    \Modules\Activity\Models\StoredEvent::factory()->count(3000)->create();
    
    echo "✅ Modulo Activity popolato\n";
    
    // 4. Popolamento modulo Cms
    echo "📄 Popolamento modulo Cms...\n";
    
    // Crea 1000 moduli CMS
    echo "   Creazione 1000 moduli CMS...\n";
    \Modules\Cms\Models\Module::factory()->count(1000)->create();
    
    // Crea 2000 sezioni
    echo "   Creazione 2000 sezioni...\n";
    \Modules\Cms\Models\Section::factory()->count(2000)->create();
    
    // Crea 5000 pagine
    echo "   Creazione 5000 pagine...\n";
    \Modules\Cms\Models\Page::factory()->count(5000)->create();
    
    // Crea 10000 contenuti
    echo "   Creazione 10000 contenuti...\n";
    \Modules\Cms\Models\PageContent::factory()->count(10000)->create();
    
    echo "✅ Modulo Cms popolato\n";
    
    // 5. Creazione relazioni pivot
    echo "🔗 Creazione relazioni pivot...\n";
    
    // Relazioni dottore-studio
    $doctors = \Modules\SaluteOra\Models\User::where('type', 'doctor')->get();
    $studios = \Modules\SaluteOra\Models\Studio::all();
    
    foreach ($doctors as $doctor) {
        // Ogni dottore lavora in 1-3 studi
        $studioCount = rand(1, 3);
        $randomStudios = $studios->random($studioCount);
        
        foreach ($randomStudios as $studio) {
            \DB::table('doctor_studio')->insert([
                'doctor_id' => $doctor->id,
                'studio_id' => $studio->id,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    
    // Relazioni paziente-studio
    $patients = \Modules\SaluteOra\Models\User::where('type', 'patient')->get();
    
    foreach ($patients as $patient) {
        // Ogni paziente è registrato in 1-2 studi
        $studioCount = rand(1, 2);
        $randomStudios = $studios->random($studioCount);
        
        foreach ($randomStudios as $studio) {
            \DB::table('patient_studio')->insert([
                'patient_id' => $patient->id,
                'studio_id' => $studio->id,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    
    echo "✅ Relazioni pivot create\n";
    
    $endTime = microtime(true);
    $executionTime = round($endTime - $startTime, 2);
    
    echo "🎉 Popolamento completato in {$executionTime} secondi!\n";
    
    // Mostra riassunto
    echo "\n📊 RIASSUNTO FINALE DATI NEL DATABASE:\n";
    echo "┌─────────────────────────────────────┐\n";
    
    // Conta utenti
    $totalUsers = \Modules\SaluteOra\Models\User::count();
    $admins = \Modules\SaluteOra\Models\User::where('type', 'admin')->count();
    $doctors = \Modules\SaluteOra\Models\User::where('type', 'doctor')->count();
    $patients = \Modules\SaluteOra\Models\User::where('type', 'patient')->count();
    
    echo "│ 👥 Utenti totali:           " . str_pad((string)$totalUsers, 6, ' ', STR_PAD_LEFT) . " │\n";
    echo "│    - Admin:                 " . str_pad((string)$admins, 6, ' ', STR_PAD_LEFT) . " │\n";
    echo "│    - Dottori:               " . str_pad((string)$doctors, 6, ' ', STR_PAD_LEFT) . " │\n";
    echo "│    - Pazienti:              " . str_pad((string)$patients, 6, ' ', STR_PAD_LEFT) . " │\n";
    
    // Conta studi
    $totalStudios = \Modules\SaluteOra\Models\Studio::count();
    echo "│ 🏥 Studi totali:            " . str_pad((string)$totalStudios, 6, ' ', STR_PAD_LEFT) . " │\n";
    
    // Conta appuntamenti
    $totalAppointments = \Modules\SaluteOra\Models\Appointment::count();
    echo "│ 📅 Appuntamenti totali:     " . str_pad((string)$totalAppointments, 6, ' ', STR_PAD_LEFT) . " │\n";
    
    // Conta referti
    $totalReports = \Modules\SaluteOra\Models\Report::count();
    echo "│ 📋 Referti totali:          " . str_pad((string)$totalReports, 6, ' ', STR_PAD_LEFT) . " │\n";
    
    // Conta attività
    $totalActivities = \Modules\Activity\Models\Activity::count();
    echo "│ 📝 Attività totali:         " . str_pad((string)$totalActivities, 6, ' ', STR_PAD_LEFT) . " │\n";
    
    // Conta pagine CMS
    $totalPages = \Modules\Cms\Models\Page::count();
    echo "│ 📄 Pagine CMS totali:       " . str_pad((string)$totalPages, 6, ' ', STR_PAD_LEFT) . " │\n";
    
    echo "└─────────────────────────────────────┘\n";
    
    echo "\n🔐 CREDENZIALI DI ACCESSO:\n";
    echo "Admin: admin@saluteora.com / password\n";
    echo "Doctor: doctor@saluteora.com / password\n";
    echo "Patient: patient@saluteora.com / password\n";
    
    echo "\n💡 SUGGERIMENTI:\n";
    echo "- Usa User::count() per contare utenti\n";
    echo "- Usa Studio::all() per vedere tutti gli studi\n";
    echo "- Usa Appointment::latest()->take(10)->get() per ultimi appuntamenti\n";
    echo "- Usa Report::with('appointment')->get() per referti con relazioni\n";
    
    echo "\n🎯 Database completamente popolato per testing completo!\n";

} catch (\Exception $e) {
    echo "❌ Errore durante il popolamento: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
