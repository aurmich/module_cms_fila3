<?php

declare(strict_types=1);

/**
 * Script per popolare i dati di business logic principali
 * Concentrato sui modelli core del progetto SaluteOra
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "🚀 Popolamento dati business logic SaluteOra\n";
echo "==========================================\n\n";

// Modelli core di SaluteOra (business logic principale)
$coreModels = [
    'SaluteOra' => [
        'User' => 50,
        'Admin' => 10,
        'Doctor' => 30,
        'Patient' => 100,
        'Studio' => 15,
        'Appointment' => 200,
        'Report' => 50,
        'Profile' => 100,
    ],
    'User' => [
        'User' => 50,
        'Role' => 10,
        'Permission' => 20,
        'Team' => 5,
        'Profile' => 50,
    ],
    'Geo' => [
        'Region' => 20,
        'Province' => 100,
        'Comune' => 500,
        'Address' => 200,
        'Location' => 100,
    ],
    'Notify' => [
        'MailTemplate' => 10,
        'NotificationTemplate' => 15,
        'Contact' => 100,
    ],
    'Media' => [
        'Media' => 50,
        'TemporaryUpload' => 20,
    ],
    'Gdpr' => [
        'Consent' => 100,
        'Treatment' => 50,
        'Event' => 200,
    ]
];

$totalCreated = 0;
$errors = [];

foreach ($coreModels as $module => $models) {
    echo "📦 Modulo: {$module}\n";
    echo str_repeat('-', 20) . "\n";
    
    foreach ($models as $model => $count) {
        $modelClass = "\\Modules\\{$module}\\Models\\{$model}";
        
        try {
            // Verifica se la classe esiste
            if (!class_exists($modelClass)) {
                echo "⚠️  {$model}: Classe non trovata\n";
                continue;
            }
            
            // Verifica se ha factory
            if (!method_exists($modelClass, 'factory')) {
                echo "⚠️  {$model}: Factory non disponibile\n";
                continue;
            }
            
            // Crea i record
            $created = $modelClass::factory()->count($count)->create();
            echo "✅ {$model}: Creati {$count} record\n";
            $totalCreated += $count;
            
        } catch (Exception $e) {
            $error = "{$module}::{$model}: " . $e->getMessage();
            $errors[] = $error;
            echo "❌ {$model}: Errore - " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n";
}

// Popolamento relazioni pivot (importante per la business logic)
echo "🔗 Popolamento relazioni pivot\n";
echo str_repeat('-', 30) . "\n";

try {
    // Doctor-Studio relationships
    $doctors = \Modules\SaluteOra\Models\Doctor::all();
    $studios = \Modules\SaluteOra\Models\Studio::all();
    
    foreach ($doctors as $doctor) {
        $randomStudios = $studios->random(rand(1, 3));
        foreach ($randomStudios as $studio) {
            try {
                \Modules\SaluteOra\Models\DoctorStudio::factory()->create([
                    'doctor_id' => $doctor->id,
                    'studio_id' => $studio->id,
                ]);
            } catch (Exception $e) {
                // Ignora duplicati
            }
        }
    }
    echo "✅ Doctor-Studio: Relazioni create\n";
    
    // Patient-Studio relationships  
    $patients = \Modules\SaluteOra\Models\Patient::all();
    
    foreach ($patients->take(50) as $patient) {
        $randomStudio = $studios->random();
        try {
            \Modules\SaluteOra\Models\PatientStudio::factory()->create([
                'patient_id' => $patient->id,
                'studio_id' => $randomStudio->id,
            ]);
        } catch (Exception $e) {
            // Ignora duplicati
        }
    }
    echo "✅ Patient-Studio: Relazioni create\n";
    
} catch (Exception $e) {
    echo "❌ Errore relazioni pivot: " . $e->getMessage() . "\n";
}

// Summary
echo "\n" . str_repeat('=', 50) . "\n";
echo "📊 RIEPILOGO POPOLAMENTO\n";
echo str_repeat('=', 50) . "\n";
echo "✅ Record totali creati: {$totalCreated}\n";
echo "❌ Errori riscontrati: " . count($errors) . "\n\n";

if (!empty($errors)) {
    echo "🔍 Dettaglio errori:\n";
    foreach ($errors as $error) {
        echo "  - {$error}\n";
    }
    echo "\n";
}

// Verifica finale dei dati
echo "🔍 VERIFICA DATI CREATI\n";
echo str_repeat('-', 25) . "\n";

$verificationQueries = [
    'Utenti totali' => "SELECT COUNT(*) as count FROM users",
    'Dottori' => "SELECT COUNT(*) as count FROM users WHERE type = 'doctor'",
    'Pazienti' => "SELECT COUNT(*) as count FROM users WHERE type = 'patient'", 
    'Studi medici' => "SELECT COUNT(*) as count FROM studios",
    'Appuntamenti' => "SELECT COUNT(*) as count FROM appointments",
    'Report' => "SELECT COUNT(*) as count FROM reports",
];

foreach ($verificationQueries as $label => $query) {
    try {
        $result = DB::select($query);
        $count = $result[0]->count ?? 0;
        echo "📈 {$label}: {$count}\n";
    } catch (Exception $e) {
        echo "⚠️  {$label}: Tabella non trovata\n";
    }
}

echo "\n🎉 Popolamento completato!\n";
echo "💡 Usa 'php artisan tinker' per esplorare i dati creati\n";
