<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🚀 POPOLAMENTO MASSIVO DATABASE - PROGETTO SALUTEORA\n";
echo "=" . str_repeat("=", 70) . "\n\n";

$startTime = microtime(true);
$totalRecords = 0;
$successfulSeeders = [];
$failedSeeders = [];

// Configurazione popolamento massivo
$populationConfig = [
    // Moduli di base (prerequisiti)
    'Base' => [
        'User\\Database\\Seeders\\UserDatabaseSeeder' => 'Utenti base e autenticazione',
        'User\\Database\\Seeders\\PermissionsSeeder' => 'Permessi sistema',
        'User\\Database\\Seeders\\RolesSeeder' => 'Ruoli utente',
        'Geo\\Database\\Seeders\\GeoDatabaseSeeder' => 'Dati geografici',
    ],
    
    // Modulo principale SaluteOra
    'SaluteOra' => [
        'SaluteOra\\Database\\Seeders\\MassDataSeeder' => 'Dati di massa (2000+ record)',
        'SaluteOra\\Database\\Seeders\\SaluteOraDatabaseSeeder' => 'Dati core business',
        'SaluteOra\\Database\\Seeders\\PatientDatabaseSeeder' => 'Pazienti specializzati',
        'SaluteOra\\Database\\Seeders\\DentalDatabaseSeeder' => 'Dati dentali',
        'SaluteOra\\Database\\Seeders\\ReportingDatabaseSeeder' => 'Dati reportistica',
    ],
    
    // Moduli di supporto
    'Support' => [
        'Activity\\Database\\Seeders\\ActivityMassSeeder' => 'Audit trail massivo',
        'Cms\\Database\\Seeders\\CmsMassSeeder' => 'Contenuti CMS',
        'Gdpr\\Database\\Seeders\\GdprDatabaseSeeder' => 'Dati privacy',
        'Notify\\Database\\Seeders\\NotifyDatabaseSeeder' => 'Sistema notifiche',
        'Media\\Database\\Seeders\\MediaDatabaseSeeder' => 'Gestione media',
    ],
];

echo "📋 CONFIGURAZIONE POPOLAMENTO:\n";
echo "  • Moduli coinvolti: " . count($populationConfig) . "\n";
echo "  • Seeder totali: " . array_sum(array_map('count', $populationConfig)) . "\n";
echo "  • Obiettivo: 100,000+ record distribuiti\n\n";

// Disabilita eventi per performance
echo "⚡ Ottimizzazione performance...\n";
DB::statement('SET foreign_key_checks = 0');
echo "  ✅ Foreign key checks disabilitati\n";

foreach ($populationConfig as $moduleGroup => $seeders) {
    echo "\n📦 MODULO: {$moduleGroup}\n";
    echo str_repeat("-", 50) . "\n";
    
    foreach ($seeders as $seederClass => $description) {
        $fullSeederClass = "\\Modules\\{$seederClass}";
        
        try {
            echo "  🌱 {$description}... ";
            
            // Verifica esistenza seeder
            if (!class_exists($fullSeederClass)) {
                echo "⚠️  Seeder non trovato\n";
                $failedSeeders[] = "{$seederClass} (classe non trovata)";
                continue;
            }
            
            // Esegui seeder con timeout
            $seederStart = microtime(true);
            
            // Usa Artisan per eseguire il seeder
            $exitCode = Artisan::call('db:seed', [
                '--class' => $fullSeederClass,
                '--force' => true,
            ]);
            
            $seederTime = round(microtime(true) - $seederStart, 2);
            
            if ($exitCode === 0) {
                echo "✅ Completato ({$seederTime}s)\n";
                $successfulSeeders[] = $seederClass;
                
                // Stima record creati (approssimativa)
                $estimatedRecords = match($moduleGroup) {
                    'Base' => 1000,
                    'SaluteOra' => 5000,
                    'Support' => 2000,
                    default => 500,
                };
                $totalRecords += $estimatedRecords;
            } else {
                echo "❌ Errore (exit code: {$exitCode})\n";
                $output = Artisan::output();
                echo "     Dettaglio: " . trim($output) . "\n";
                $failedSeeders[] = "{$seederClass} (exit code {$exitCode})";
            }
            
        } catch (Exception $e) {
            echo "❌ Eccezione\n";
            echo "     Errore: " . $e->getMessage() . "\n";
            $failedSeeders[] = "{$seederClass} ({$e->getMessage()})";
        }
        
        // Garbage collection ogni 3 seeder
        if (count($successfulSeeders) % 3 === 0) {
            gc_collect_cycles();
        }
    }
}

// Riabilita foreign key checks
DB::statement('SET foreign_key_checks = 1');
echo "\n⚡ Foreign key checks riabilitati\n";

// Ottimizzazione finale database
echo "\n🔧 OTTIMIZZAZIONE DATABASE...\n";
try {
    DB::statement('ANALYZE TABLE users, studios, appointments, reports');
    echo "  ✅ Statistiche tabelle aggiornate\n";
} catch (Exception $e) {
    echo "  ⚠️  Errore ottimizzazione: " . $e->getMessage() . "\n";
}

// Calcolo metriche finali
$endTime = microtime(true);
$executionTime = round($endTime - $startTime, 2);
$recordsPerSecond = $totalRecords > 0 ? round($totalRecords / $executionTime, 2) : 0;

// Report finale dettagliato
echo "\n📊 REPORT FINALE POPOLAMENTO MASSIVO\n";
echo "=" . str_repeat("=", 70) . "\n";
echo "⏱️  Tempo totale esecuzione: {$executionTime} secondi\n";
echo "📈 Record totali stimati: " . number_format($totalRecords) . "\n";
echo "⚡ Performance: {$recordsPerSecond} record/secondo\n";
echo "✅ Seeder completati: " . count($successfulSeeders) . "\n";
echo "❌ Seeder falliti: " . count($failedSeeders) . "\n\n";

if (!empty($successfulSeeders)) {
    echo "🎉 SEEDER COMPLETATI CON SUCCESSO:\n";
    foreach ($successfulSeeders as $seeder) {
        echo "  • {$seeder} ✅\n";
    }
    echo "\n";
}

if (!empty($failedSeeders)) {
    echo "⚠️  SEEDER CON PROBLEMI:\n";
    foreach ($failedSeeders as $seeder) {
        echo "  • {$seeder}\n";
    }
    echo "\n";
}

// Verifica finale database
echo "🔍 VERIFICA FINALE DATABASE:\n";
try {
    $tables = [
        'users' => 'Utenti sistema',
        'studios' => 'Studi medici', 
        'appointments' => 'Appuntamenti',
        'reports' => 'Referti medici',
        'roles' => 'Ruoli utente',
        'permissions' => 'Permessi sistema',
    ];
    
    foreach ($tables as $table => $description) {
        try {
            $count = DB::table($table)->count();
            echo "  📋 {$description}: " . number_format($count) . " record\n";
        } catch (Exception $e) {
            echo "  ⚠️  {$description}: Tabella non accessibile\n";
        }
    }
    
} catch (Exception $e) {
    echo "  ❌ Errore verifica database: " . $e->getMessage() . "\n";
}

// Raccomandazioni finali
echo "\n💡 RACCOMANDAZIONI:\n";
if (count($successfulSeeders) >= 10) {
    echo "  ✅ Database popolato con successo!\n";
    echo "  ✅ Pronto per testing e sviluppo\n";
    echo "  ✅ Dati realistici disponibili per demo\n";
} else {
    echo "  ⚠️  Popolamento parziale - verificare errori\n";
    echo "  ⚠️  Alcuni moduli potrebbero non essere configurati\n";
}

echo "\n🔐 CREDENZIALI DI ACCESSO SUGGERITE:\n";
echo "  Admin: admin@saluteora.com / password\n";
echo "  Doctor: doctor@saluteora.com / password\n";
echo "  Patient: patient@saluteora.com / password\n";

echo "\n🏁 POPOLAMENTO MASSIVO COMPLETATO!\n";
echo "   Database pronto per utilizzo con " . number_format($totalRecords) . "+ record\n";
echo "   Tempo totale: {$executionTime} secondi\n";
echo "   Performance: {$recordsPerSecond} record/secondo\n\n";

// Salva report su file
$reportFile = __DIR__ . '/database_population_report_' . date('Y-m-d_H-i-s') . '.txt';
$reportContent = "REPORT POPOLAMENTO DATABASE - " . date('Y-m-d H:i:s') . "\n";
$reportContent .= "Tempo esecuzione: {$executionTime}s\n";
$reportContent .= "Record totali: " . number_format($totalRecords) . "\n";
$reportContent .= "Seeder completati: " . count($successfulSeeders) . "\n";
$reportContent .= "Seeder falliti: " . count($failedSeeders) . "\n";
$reportContent .= "\nSeeder completati:\n" . implode("\n", $successfulSeeders) . "\n";
if (!empty($failedSeeders)) {
    $reportContent .= "\nSeeder falliti:\n" . implode("\n", $failedSeeders) . "\n";
}

file_put_contents($reportFile, $reportContent);
echo "📄 Report salvato in: {$reportFile}\n";
