<?php

/**
 * Script Tinker per Popolamento Massivo SaluteOra - 1000 Record per Modello
 * 
 * Genera esattamente:
 * - 1000 Doctor (utenti con tipo 'doctor')
 * - 1000 Patient (utenti con tipo 'patient') 
 * - 1000 Studio (studi medici)
 * 
 * ISTRUZIONI TINKER:
 * 1. Esegui: php artisan tinker
 * 2. Copia e incolla questi comandi uno alla volta
 * 3. Ogni comando creerà molti record nel database
 */

// ========================================
// FASE 1: CREAZIONE 1000 STUDI MEDICI
// ========================================

echo "🏥 Creazione 1000 studi medici...\n";

// Crea studi in batch di 100 per performance
$studios = collect();
for ($i = 0; $i < 10; $i++) {
    echo "Batch " . ($i + 1) . "/10: 100 studi...\n";
    
    $batchStudios = \Modules\SaluteOra\Models\Studio::factory()
        ->count(100)
        ->create([
            'name' => fn() => 'Studio Medico ' . fake()->company(),
            'address' => fn() => fake()->streetAddress(),
            'city' => fn() => fake()->city(),
            'province' => fn() => fake()->stateAbbr(),
            'cap' => fn() => fake()->postcode(),
            'phone' => fn() => fake()->phoneNumber(),
            'email' => fn() => fake()->companyEmail(),
            'website' => fn() => 'https://' . fake()->domainName(),
            'description' => fn() => fake()->paragraph(),
            'is_active' => true,
        ]);
    
    $studios = $studios->merge($batchStudios);
    echo "✓ Creati " . $batchStudios->count() . " studi (totale: " . $studios->count() . ")\n";
}

echo "✅ Completati {$studios->count()} studi medici\n\n";

// ========================================
// FASE 2: CREAZIONE 1000 DOTTORI
// ========================================

echo "👨‍⚕️ Creazione 1000 dottori...\n";

// Crea dottori in batch di 100
$doctors = collect();
for ($i = 0; $i < 10; $i++) {
    echo "Batch " . ($i + 1) . "/10: 100 dottori...\n";
    
    $batchDoctors = \Modules\SaluteOra\Models\User::factory()
        ->count(100)
        ->create([
            'type' => 'doctor',
            'first_name' => fn() => fake()->firstName('male'),
            'last_name' => fn() => fake()->lastName(),
            'email' => fn() => 'dr.' . fake()->unique()->userName() . '@saluteora.com',
            'phone' => fn() => fake()->phoneNumber(),
            'date_of_birth' => fn() => fake()->dateTimeBetween('-60 years', '-25 years'),
            'gender' => fn() => fake()->randomElement(['male', 'female']),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    
    // Assegna studio casuale a ogni dottore
    foreach ($batchDoctors as $doctor) {
        $studio = $studios->random();
        $doctor->studio_id = $studio->id;
        $doctor->save();
    }
    
    $doctors = $doctors->merge($batchDoctors);
    echo "✓ Creati " . $batchDoctors->count() . " dottori (totale: " . $doctors->count() . ")\n";
}

echo "✅ Completati {$doctors->count()} dottori\n\n";

// ========================================
// FASE 3: CREAZIONE 1000 PAZIENTI
// ========================================

echo "👤 Creazione 1000 pazienti...\n";

// Crea pazienti in batch di 100
$patients = collect();
for ($i = 0; $i < 10; $i++) {
    echo "Batch " . ($i + 1) . "/10: 100 pazienti...\n";
    
    $batchPatients = \Modules\SaluteOra\Models\User::factory()
        ->count(100)
        ->create([
            'type' => 'patient',
            'first_name' => fn() => fake()->firstName(),
            'last_name' => fn() => fake()->lastName(),
            'email' => fn() => fake()->unique()->safeEmail(),
            'phone' => fn() => fake()->phoneNumber(),
            'date_of_birth' => fn() => fake()->dateTimeBetween('-80 years', '-18 years'),
            'gender' => fn() => fake()->randomElement(['male', 'female']),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    
    $patients = $patients->merge($batchPatients);
    echo "✓ Creati " . $batchPatients->count() . " pazienti (totale: " . $patients->count() . ")\n";
}

echo "✅ Completati {$patients->count()} pazienti\n\n";

// ========================================
// FASE 4: CREAZIONE APPUNTAMENTI ESEMPIO
// ========================================

echo "📅 Creazione appuntamenti di esempio...\n";

// Crea 500 appuntamenti distribuiti negli ultimi 30 giorni
$appointmentCount = 500;
$batchSize = 50;

for ($i = 0; $i < $appointmentCount; $i += $batchSize) {
    $currentBatch = min($batchSize, $appointmentCount - $i);
    echo "Batch " . (floor($i / $batchSize) + 1) . ": {$currentBatch} appuntamenti...\n";
    
    \Modules\SaluteOra\Models\Appointment::factory()
        ->count($currentBatch)
        ->create([
            'doctor_id' => fn() => $doctors->random()->id,
            'patient_id' => fn() => $patients->random()->id,
            'studio_id' => fn() => $studios->random()->id,
            'start_time' => fn() => fake()->dateTimeBetween('-30 days', '+30 days'),
            'end_time' => fn() => fake()->dateTimeBetween('+1 hour', '+3 hours'),
            'status' => fn() => fake()->randomElement(['scheduled', 'confirmed', 'completed', 'cancelled']),
            'type' => fn() => fake()->randomElement(['consultation', 'treatment', 'checkup', 'emergency']),
            'notes' => fn() => fake()->optional(0.7)->sentence(),
            'is_emergency' => fn() => fake()->optional(0.1)->boolean(),
        ]);
    
    echo "✓ Creati {$currentBatch} appuntamenti\n";
}

echo "✅ Completati {$appointmentCount} appuntamenti\n\n";

// ========================================
// FASE 5: STATISTICHE FINALI
// ========================================

echo "📊 STATISTICHE FINALI:\n";
echo "• Studi medici: " . \Modules\SaluteOra\Models\Studio::count() . "\n";
echo "• Dottori: " . \Modules\SaluteOra\Models\User::where('type', 'doctor')->count() . "\n";
echo "• Pazienti: " . \Modules\SaluteOra\Models\User::where('type', 'patient')->count() . "\n";
echo "• Appuntamenti: " . \Modules\SaluteOra\Models\Appointment::count() . "\n";
echo "• Utenti totali: " . \Modules\SaluteOra\Models\User::count() . "\n";

// Statistiche per studio
echo "\n🏥 DISTRIBUZIONE PER STUDIO (TOP 5):\n";
$studioStats = \Modules\SaluteOra\Models\Studio::withCount(['doctors', 'appointments'])
    ->orderBy('doctors_count', 'desc')
    ->limit(5)
    ->get();

foreach ($studioStats as $studio) {
    echo "• {$studio->name}: {$studio->doctors_count} dottori, {$studio->appointments_count} appuntamenti\n";
}

echo "\n🎉 POPOLAMENTO MASSIVO COMPLETATO CON SUCCESSO!\n";
echo "Il database ora contiene migliaia di record realistici per test e sviluppo.\n";
