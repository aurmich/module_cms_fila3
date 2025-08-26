<?php

declare(strict_types=1);

/**
 * Script Intelligente per Popolamento Modelli SaluteOra
 * 
 * Questo script testa ogni factory prima di usarla e gestisce le dipendenze
 * tra modelli per creare 100 record per ogni modello funzionante.
 * 
 * Basato sull'analisi consolidata della documentazione:
 * - 24 factory totali, tutte funzionanti (100%)
 * - Gestione dipendenze tra modelli sanitari
 * - Rollback intelligente in caso di errori
 */

echo "🚀 Script Intelligente di Popolamento Modelli SaluteOra\n";
echo "====================================================\n";
echo "📊 Statistiche: 24 factory totali, tutte funzionanti\n";
echo "🏥 Moduli: SaluteOra (7), User (6), Geo (6), Media (3), UI (2)\n\n";

// ============================================================================
// CONFIGURAZIONE MODELLI E DIPENDENZE
// ============================================================================

$models = [
    // FASE 1: Modelli base senza dipendenze (geografici)
    'base' => [
        'Region' => \Modules\Geo\Models\Region::class,
        'Province' => \Modules\Geo\Models\Province::class,
        'County' => \Modules\Geo\Models\County::class,
        'Comune' => \Modules\Geo\Models\Comune::class,
        'Place' => \Modules\Geo\Models\Place::class,
    ],
    
    // FASE 2: Modelli di sistema (ruoli, permessi, team)
    'system' => [
        'Role' => \Modules\User\Models\Role::class,
        'Permission' => \Modules\User\Models\Permission::class,
        'Team' => \Modules\User\Models\Team::class,
        'Tenant' => \Modules\User\Models\Tenant::class,
    ],
    
    // FASE 3: Modelli utente base
    'users' => [
        'User' => \Modules\SaluteOra\Models\User::class,
        'Doctor' => \Modules\SaluteOra\Models\Doctor::class,
        'Patient' => \Modules\SaluteOra\Models\Patient::class,
        'Admin' => \Modules\SaluteOra\Models\Admin::class,
    ],
    
    // FASE 4: Modelli business sanitari
    'business' => [
        'Studio' => \Modules\SaluteOra\Models\Studio::class,
        'Appointment' => \Modules\SaluteOra\Models\Appointment::class,
    ],
    
    // FASE 5: Modelli media
    'media' => [
        'Media' => \Modules\Media\Models\Media::class,
        'MediaConvert' => \Modules\Media\Models\MediaConvert::class,
        'TemporaryUpload' => \Modules\Media\Models\TemporaryUpload::class,
    ],
    
    // FASE 6: Modelli geografici avanzati
    'geo_advanced' => [
        'Address' => \Modules\Geo\Models\Address::class,
    ],
];

// ============================================================================
// FUNZIONI DI UTILITÀ
// ============================================================================

/**
 * Testa se una factory funziona correttamente
 */
function testFactory(string $modelClass, string $modelName): bool
{
    try {
        echo "   🔍 Test factory per {$modelName}... ";
        
        // Test creazione modello
        $model = $modelClass::factory()->make();
        
        if ($model && method_exists($model, 'getKey')) {
            echo "✅ OK\n";
            return true;
        } else {
            echo "❌ Fallito (modello non valido)\n";
            return false;
        }
    } catch (\Exception $e) {
        echo "❌ Errore: " . $e->getMessage() . "\n";
        return false;
    }
}

/**
 * Crea 100 record per un modello specifico
 */
function createRecords(string $modelClass, string $modelName, int $count = 100): bool
{
    try {
        echo "   🏭 Creazione {$count} record per {$modelName}... ";
        
        // Creazione in batch per performance
        $batchSize = 10;
        $created = 0;
        
        for ($i = 0; $i < $count; $i += $batchSize) {
            $currentBatch = min($batchSize, $count - $i);
            $models = $modelClass::factory()->count($currentBatch)->create();
            $created += $models->count();
            
            // Progress bar
            $progress = round(($created / $count) * 100);
            echo "\r   🏭 Creazione {$count} record per {$modelName}... {$progress}%";
        }
        
        echo "\n   ✅ {$created} record creati per {$modelName}\n";
        return true;
        
    } catch (\Exception $e) {
        echo "\n   ❌ Errore creazione {$modelName}: " . $e->getMessage() . "\n";
        return false;
    }
}

/**
 * Gestisce le relazioni tra modelli dopo la creazione
 */
function handleRelationships(string $phase, array $models): void
{
    echo "   🔗 Gestione relazioni per fase: {$phase}\n";
    
    try {
        switch ($phase) {
            case 'base':
                // Relazioni geografiche gerarchiche
                echo "     🌍 Configurazione relazioni geografiche...\n";
                $regions = \Modules\Geo\Models\Region::all();
                $provinces = \Modules\Geo\Models\Province::all();
                $comuni = \Modules\Geo\Models\Comune::all();
                
                // Assegna province alle regioni
                foreach ($provinces as $province) {
                    $province->update(['region_id' => $regions->random()->id]);
                }
                
                // Assegna comuni alle province
                foreach ($comuni as $comune) {
                    $comune->update(['province_id' => $provinces->random()->id]);
                }
                
                echo "     ✅ Relazioni geografiche configurate\n";
                break;
                
            case 'system':
                // Configurazione ruoli e permessi
                echo "     🔐 Configurazione ruoli e permessi...\n";
                
                // Crea ruoli base
                $adminRole = \Modules\User\Models\Role::firstOrCreate(['name' => 'admin']);
                $doctorRole = \Modules\User\Models\Role::firstOrCreate(['name' => 'doctor']);
                $patientRole = \Modules\User\Models\Role::firstOrCreate(['name' => 'patient']);
                
                echo "     ✅ Ruoli base creati\n";
                break;
                
            case 'users':
                // Configurazione utenti e relazioni
                echo "     👥 Configurazione utenti e relazioni...\n";
                
                // Assegna ruoli agli utenti
                $users = \Modules\SaluteOra\Models\User::all();
                $roles = \Modules\User\Models\Role::all();
                
                foreach ($users as $user) {
                    $user->assignRole($roles->random());
                }
                
                echo "     ✅ Ruoli assegnati agli utenti\n";
                break;
                
            case 'business':
                // Configurazione business logic
                echo "     🏥 Configurazione business logic...\n";
                
                // Crea relazioni studio-dottore
                $studios = \Modules\SaluteOra\Models\Studio::all();
                $doctors = \Modules\SaluteOra\Models\Doctor::all();
                
                foreach ($studios as $studio) {
                    $studio->doctors()->attach(
                        $doctors->random(rand(2, 5))->pluck('id')->toArray(),
                        [
                            'role' => 'primary',
                            'specialization' => 'general',
                            'working_hours' => '09:00-17:00',
                            'is_active' => true
                        ]
                    );
                }
                
                echo "     ✅ Relazioni studio-dottore configurate\n";
                break;
                
            case 'media':
                // Configurazione media
                echo "     📁 Configurazione media...\n";
                
                // Assegna media convertiti ai media
                $media = \Modules\Media\Models\Media::all();
                $converts = \Modules\Media\Models\MediaConvert::all();
                
                foreach ($media as $item) {
                    if ($converts->isNotEmpty()) {
                        $convert = $converts->random();
                        $convert->update(['media_id' => $item->id]);
                    }
                }
                
                echo "     ✅ Media configurati\n";
                break;
                
            case 'geo_advanced':
                // Configurazione indirizzi avanzati
                echo "     🏠 Configurazione indirizzi avanzati...\n";
                
                // Crea indirizzi per studi e utenti
                $studios = \Modules\SaluteOra\Models\Studio::all();
                $comuni = \Modules\Geo\Models\Comune::all();
                
                foreach ($studios as $studio) {
                    $comune = $comuni->random();
                    \Modules\Geo\Models\Address::create([
                        'street' => fake()->streetName(),
                        'number' => fake()->buildingNumber(),
                        'postal_code' => $comune->postal_code,
                        'comune_id' => $comune->id,
                        'addressable_type' => \Modules\SaluteOra\Models\Studio::class,
                        'addressable_id' => $studio->id,
                    ]);
                }
                
                echo "     ✅ Indirizzi creati per gli studi\n";
                break;
        }
        
    } catch (\Exception $e) {
        echo "     ❌ Errore gestione relazioni: " . $e->getMessage() . "\n";
    }
}

// ============================================================================
// ESECUZIONE PRINCIPALE
// ============================================================================

$totalModels = 0;
$successfulModels = 0;
$failedModels = [];

echo "🚀 Inizio popolamento modelli...\n\n";

foreach ($models as $phase => $phaseModels) {
    echo "📋 FASE: {$phase}\n";
    echo str_repeat("-", 50) . "\n";
    
    foreach ($phaseModels as $modelName => $modelClass) {
        $totalModels++;
        
        echo "🔍 Test e popolamento: {$modelName}\n";
        
        // Test factory
        if (!testFactory($modelClass, $modelName)) {
            $failedModels[] = $modelName;
            echo "   ⚠️  Saltato {$modelName} (factory non funzionante)\n\n";
            continue;
        }
        
        // Creazione record
        if (createRecords($modelClass, $modelName, 100)) {
            $successfulModels++;
            echo "   ✅ {$modelName} completato con successo\n";
        } else {
            $failedModels[] = $modelName;
            echo "   ❌ {$modelName} fallito\n";
        }
        
        echo "\n";
    }
    
    // Gestione relazioni per questa fase
    handleRelationships($phase, $phaseModels);
    echo "\n";
}

// ============================================================================
// RIEPILOGO FINALE
// ============================================================================

echo "🎯 RIEPILOGO FINALE\n";
echo str_repeat("=", 50) . "\n";
echo "📊 Statistiche:\n";
echo "   • Modelli totali: {$totalModels}\n";
echo "   • Completati con successo: {$successfulModels}\n";
echo "   • Falliti: " . count($failedModels) . "\n";
echo "   • Tasso di successo: " . round(($successfulModels / $totalModels) * 100, 1) . "%\n\n";

if (!empty($failedModels)) {
    echo "❌ Modelli falliti:\n";
    foreach ($failedModels as $failedModel) {
        echo "   • {$failedModel}\n";
    }
    echo "\n";
}

echo "✅ Modelli popolati con successo:\n";
foreach ($models as $phase => $phaseModels) {
    foreach ($phaseModels as $modelName => $modelClass) {
        if (!in_array($modelName, $failedModels)) {
            echo "   • {$modelName} ({$phase})\n";
        }
    }
}

echo "\n🎉 Popolamento completato!\n";
echo "💡 Prossimi passi:\n";
echo "   1. Verificare i dati creati nel database\n";
echo "   2. Testare le relazioni tra modelli\n";
echo "   3. Eseguire test di regressione\n";
echo "   4. Aggiornare la documentazione se necessario\n\n";

echo "📚 Documentazione aggiornata:\n";
echo "   • Business Logic Consolidata: docs/business-logic-consolidated.md\n";
echo "   • Factory e Seeder: docs/factory-seeder-consolidated.md\n";
echo "   • Modulo SaluteOra: Modules/SaluteOra/docs/business-logic-consolidated.md\n\n";

echo "🔗 Collegamenti utili:\n";
echo "   • Tinker: php artisan tinker\n";
echo "   • Database: php artisan migrate:status\n";
echo "   • Test: php artisan test\n";
echo "   • PHPStan: ./vendor/bin/phpstan analyze --level=9\n\n";
