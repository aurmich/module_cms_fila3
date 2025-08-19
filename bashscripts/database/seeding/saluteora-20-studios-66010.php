<?php

/**
 * Script per Creazione 20 Studi Medici con Postal Code 66010 - SaluteOra
 * 
 * Genera esattamente 20 studi medici tutti con postal_code = '66010'
 * Ogni studio avrà ALMENO un dottore collegato
 * Utilizza i factory esistenti del modulo SaluteOra
 * 
 * ESECUZIONE:
 * 1. Copia questo script nella root del progetto
 * 2. Esegui: php bashscripts/database/seeding/saluteora-20-studios-66010.php
 * 
 * ALTERNATIVA TINKER:
 * 1. Esegui: php artisan tinker
 * 2. Incolla il contenuto dello script
 * 3. Esegui: createStudios66010()
 */

// Funzione principale per creare 20 studi con postal_code 66010 e dottori collegati
function createStudios66010() {
    echo "🏥 Creazione 20 studi medici con postal_code = 66010 e dottori collegati...\n";
    
    try {
        // Verifica esistenza modulo SaluteOra
        if (!class_exists('\\Modules\\SaluteOra\\Models\\Studio')) {
            throw new Exception('Modulo SaluteOra non trovato. Verifica che sia installato e attivo.');
        }
        
        if (!class_exists('\\Modules\\SaluteOra\\Models\\User')) {
            throw new Exception('Modello User del modulo SaluteOra non trovato.');
        }
        
        // Verifica se esistono già studi con postal_code 66010
        $existingStudios = \Modules\SaluteOra\Models\Studio::where('postal_code', '66010')->get();
        
        if ($existingStudios->count() > 0) {
            echo "📋 Studi esistenti trovati con postal_code 66010:\n";
            foreach ($existingStudios as $studio) {
                echo "  - ID: {$studio->id}, Nome: {$studio->name}, Indirizzo: {$studio->address}\n";
            }
            
            $response = readline("Vuoi continuare e creare studi aggiuntivi? (y/N): ");
            if (strtolower($response) !== 'y') {
                echo "Operazione annullata dall'utente.\n";
                return;
            }
        }
        
        // FASE 1: Creazione 20 studi medici
        echo "\n🏥 FASE 1: Creazione 20 studi medici...\n";
        
        $studios = collect();
        $studioNames = [
            'Centro Medico Chieti Centro', 'Studio Dentistico Chieti Nord', 'Clinica Chieti Sud',
            'Ambulatorio Chieti Est', 'Centro Diagnostico Chieti Ovest', 'Studio Cardiologico Chieti',
            'Clinica Ortopedica Chieti', 'Ambulatorio Pediatrico Chieti', 'Centro Dermatologico Chieti',
            'Studio Oculistico Chieti', 'Clinica Neurologica Chieti', 'Ambulatorio Ginecologico Chieti',
            'Centro Urologico Chieti', 'Studio Gastroenterologico Chieti', 'Clinica Endocrinologica Chieti',
            'Ambulatorio Pneumologico Chieti', 'Centro Reumatologico Chieti', 'Studio Allergologico Chieti',
            'Clinica Oncologica Chieti', 'Ambulatorio Psichiatrico Chieti'
        ];
        
        for ($i = 0; $i < 20; $i++) {
            $studio = \Modules\SaluteOra\Models\Studio::factory()->create([
                'name' => $studioNames[$i],
                'postal_code' => '66010',
                'city' => 'Chieti',
                'province' => 'CH',
                'region' => 'Abruzzo',
                'country' => 'Italia',
                'address' => 'Via ' . generateRandomStreetName() . ', ' . rand(1, 200),
                'phone' => '+39' . rand(800, 899) . rand(100000, 999999),
                'email' => 'info@' . strtolower(str_replace(' ', '', $studioNames[$i])) . '.it',
                'website' => 'https://www.' . strtolower(str_replace(' ', '', $studioNames[$i])) . '.it',
                'description' => 'Studio medico specializzato in ' . getSpecialization($i),
                'is_active' => true,
                'opening_hours' => json_encode([
                    'monday' => ['09:00-18:00'],
                    'tuesday' => ['09:00-18:00'],
                    'wednesday' => ['09:00-18:00'],
                    'thursday' => ['09:00-18:00'],
                    'friday' => ['09:00-18:00'],
                    'saturday' => ['09:00-12:00'],
                    'sunday' => []
                ])
            ]);
            
            $studios->push($studio);
            echo "  ✅ Studio creato: {$studio->name} (ID: {$studio->id})\n";
        }
        
        echo "\n🎯 FASE 2: Creazione dottori collegati agli studi...\n";
        
        // FASE 2: Creazione dottori collegati agli studi
        $doctorNames = [
            'Dr. Mario Rossi', 'Dr. Anna Bianchi', 'Dr. Giuseppe Verdi', 'Dr. Maria Neri',
            'Dr. Carlo Gialli', 'Dr. Elena Rosa', 'Dr. Paolo Azzurri', 'Dr. Laura Viola',
            'Dr. Roberto Marroni', 'Dr. Francesca Celesti', 'Dr. Alessandro Dorati',
            'Dr. Valentina Argenti', 'Dr. Marco Bronzi', 'Dr. Sofia Ramei',
            'Dr. Luca Smeraldi', 'Dr. Giulia Indaco', 'Dr. Davide Turchesi',
            'Dr. Chiara Coralli', 'Dr. Federico Ametisti', 'Dr. Beatrice Zaffiri'
        ];
        
        $doctorSpecializations = [
            'Cardiologia', 'Dermatologia', 'Neurologia', 'Ortopedia', 'Pediatria',
            'Ginecologia', 'Urologia', 'Gastroenterologia', 'Endocrinologia',
            'Pneumologia', 'Reumatologia', 'Allergologia', 'Oncologia', 'Psichiatria',
            'Oculistica', 'Otorinolaringoiatria', 'Chirurgia Generale', 'Radiologia',
            'Anestesiologia', 'Medicina Interna'
        ];
        
        foreach ($studios as $index => $studio) {
            // Crea un dottore per ogni studio
            $doctor = \Modules\SaluteOra\Models\User::factory()->create([
                'name' => $doctorNames[$index],
                'email' => 'dottore' . ($index + 1) . '@' . strtolower(str_replace(' ', '', $studio->name)) . '.it',
                'type' => 'doctor',
                'studio_id' => $studio->id,
                'specialization' => $doctorSpecializations[$index],
                'license_number' => 'CH' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => bcrypt('password123')
            ]);
            
            echo "  👨‍⚕️ Dottore creato: {$doctor->name} - {$doctor->specialization} per studio {$studio->name}\n";
            
            // Crea anche un secondo dottore per alcuni studi (per varietà)
            if ($index % 3 == 0 && $index < 15) { // Ogni 3 studi, crea un secondo dottore
                $secondDoctorIndex = $index + 20; // Usa nomi diversi
                $secondDoctor = \Modules\SaluteOra\Models\User::factory()->create([
                    'name' => 'Dr. ' . generateRandomDoctorName(),
                    'email' => 'dottore2.' . ($index + 1) . '@' . strtolower(str_replace(' ', '', $studio->name)) . '.it',
                    'type' => 'doctor',
                    'studio_id' => $studio->id,
                    'specialization' => $doctorSpecializations[($index + 5) % count($doctorSpecializations)],
                    'license_number' => 'CH' . str_pad($secondDoctorIndex + 1, 6, '0', STR_PAD_LEFT),
                    'is_active' => true,
                    'email_verified_at' => now(),
                    'password' => bcrypt('password123')
                ]);
                
                echo "    👨‍⚕️ Secondo dottore: {$secondDoctor->name} - {$secondDoctor->specialization}\n";
            }
        }
        
        // FASE 3: Verifica finale
        echo "\n🔍 FASE 3: Verifica finale...\n";
        
        $finalStudios = \Modules\SaluteOra\Models\Studio::where('postal_code', '66010')->get();
        $finalDoctors = \Modules\SaluteOra\Models\User::where('type', 'doctor')
            ->whereHas('studio', function($query) {
                $query->where('postal_code', '66010');
            })->get();
        
        echo "📊 RISULTATO FINALE:\n";
        echo "  - Studi creati: {$finalStudios->count()}\n";
        echo "  - Dottori totali: {$finalDoctors->count()}\n";
        echo "  - Media dottori per studio: " . round($finalDoctors->count() / $finalStudios->count(), 2) . "\n";
        
        // Verifica che ogni studio abbia almeno un dottore
        $studiosWithoutDoctors = $finalStudios->filter(function($studio) {
            return !$studio->doctors()->exists();
        });
        
        if ($studiosWithoutDoctors->count() > 0) {
            echo "⚠️  ATTENZIONE: {$studiosWithoutDoctors->count()} studi senza dottori:\n";
            foreach ($studiosWithoutDoctors as $studio) {
                echo "    - {$studio->name} (ID: {$studio->id})\n";
            }
        } else {
            echo "✅ SUCCESSO: Tutti gli studi hanno almeno un dottore collegato!\n";
        }
        
        echo "\n✨ Script completato!\n";
        
    } catch (Exception $e) {
        echo "❌ ERRORE: " . $e->getMessage() . "\n";
        echo "Stack trace: " . $e->getTraceAsString() . "\n";
    }
}

// Funzioni helper
function generateRandomStreetName() {
    $streets = ['Roma', 'Milano', 'Napoli', 'Firenze', 'Venezia', 'Torino', 'Bologna', 'Genova', 'Palermo', 'Bari'];
    return $streets[array_rand($streets)];
}

function getSpecialization($index) {
    $specializations = [
        'Cardiologia', 'Dermatologia', 'Neurologia', 'Ortopedia', 'Pediatria',
        'Ginecologia', 'Urologia', 'Gastroenterologia', 'Endocrinologia',
        'Pneumologia', 'Reumatologia', 'Allergologia', 'Oncologia', 'Psichiatria',
        'Oculistica', 'Otorinolaringoiatria', 'Chirurgia Generale', 'Radiologia',
        'Anestesiologia', 'Medicina Interna'
    ];
    return $specializations[$index % count($specializations)];
}

function generateRandomDoctorName() {
    $firstNames = ['Antonio', 'Marco', 'Luca', 'Giovanni', 'Roberto', 'Andrea', 'Stefano', 'Paolo', 'Matteo', 'Simone'];
    $lastNames = ['Ferrari', 'Russo', 'Bianchi', 'Romano', 'Colombo', 'Ricci', 'Marino', 'Greco', 'Bruno', 'Galli'];
    
    return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
}

// Esegui la funzione se lo script viene chiamato direttamente
if (basename(__FILE__) == basename($_SERVER['SCRIPT_NAME'])) {
    createStudios66010();
}
