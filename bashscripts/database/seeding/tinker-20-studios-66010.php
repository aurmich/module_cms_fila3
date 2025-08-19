<?php

/**
 * Script Tinker per Creazione 20 Studi Medici con Postal Code 66010 - SaluteOra
 * 
 * Genera esattamente 20 studi medici tutti con postal_code = '66010'
 * Ogni studio avrà ALMENO un dottore collegato
 * Utilizza i factory esistenti del modulo SaluteOra
 * 
 * ISTRUZIONI TINKER:
 * 1. Esegui: php artisan tinker
 * 2. Copia e incolla questi comandi uno alla volta
 * 3. Ogni comando creerà studi e dottori nel database
 */

// ========================================
// FASE 1: VERIFICA STUDI ESISTENTI
// ========================================

echo "🔍 Verifica studi esistenti con postal_code = 66010...\n";

$existingStudios = \Modules\SaluteOra\Models\Studio::where('postal_code', '66010')->get();

if ($existingStudios->count() > 0) {
    echo "📋 Studi esistenti trovati:\n";
    foreach ($existingStudios as $studio) {
        echo "  - ID: {$studio->id}, Nome: {$studio->name}, Indirizzo: {$studio->address}\n";
    }
    
    echo "⚠️  ATTENZIONE: Esistono già {$existingStudios->count()} studi con postal_code 66010\n";
    echo "   Vuoi continuare e creare altri 20 studi? (y/N): ";
    
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    fclose($handle);
    
    if (trim($line) !== 'y' && trim($line) !== 'Y') {
        echo "❌ Operazione annullata dall'utente.\n";
        return;
    }
}

// ========================================
// FASE 2: CREAZIONE 20 STUDI MEDICI
// ========================================

echo "\n🏥 FASE 2: Creazione 20 studi medici...\n";

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
        'address' => 'Via ' . ['Roma', 'Milano', 'Napoli', 'Firenze', 'Venezia', 'Torino', 'Bologna', 'Genova', 'Palermo', 'Bari'][$i % 10] . ', ' . rand(1, 200),
        'phone' => '+39' . rand(800, 899) . rand(100000, 999999),
        'email' => 'info@' . strtolower(str_replace(' ', '', $studioNames[$i])) . '.it',
        'website' => 'https://www.' . strtolower(str_replace(' ', '', $studioNames[$i])) . '.it',
        'description' => 'Studio medico specializzato in ' . ['Cardiologia', 'Dermatologia', 'Neurologia', 'Ortopedia', 'Pediatria', 'Ginecologia', 'Urologia', 'Gastroenterologia', 'Endocrinologia', 'Pneumologia', 'Reumatologia', 'Allergologia', 'Oncologia', 'Psichiatria', 'Oculistica', 'Otorinolaringoiatria', 'Chirurgia Generale', 'Radiologia', 'Anestesiologia', 'Medicina Interna'][$i],
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

// ========================================
// FASE 3: CREAZIONE DOTTORI COLLEGATI
// ========================================

echo "\n🎯 FASE 3: Creazione dottori collegati agli studi...\n";

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
        $secondDoctorNames = ['Antonio Ferrari', 'Marco Russo', 'Luca Bianchi', 'Giovanni Romano', 'Roberto Colombo'];
        $secondDoctor = \Modules\SaluteOra\Models\User::factory()->create([
            'name' => 'Dr. ' . $secondDoctorNames[$index % 5],
            'email' => 'dottore2.' . ($index + 1) . '@' . strtolower(str_replace(' ', '', $studio->name)) . '.it',
            'type' => 'doctor',
            'studio_id' => $studio->id,
            'specialization' => $doctorSpecializations[($index + 5) % count($doctorSpecializations)],
            'license_number' => 'CH' . str_pad($index + 21, 6, '0', STR_PAD_LEFT),
            'is_active' => true,
            'email_verified_at' => now(),
            'password' => bcrypt('password123')
        ]);
        
        echo "    👨‍⚕️ Secondo dottore: {$secondDoctor->name} - {$secondDoctor->specialization}\n";
    }
}

// ========================================
// FASE 4: VERIFICA FINALE
// ========================================

echo "\n🔍 FASE 4: Verifica finale...\n";

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
