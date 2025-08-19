<?php

/**
 * Script per Popolamento Massivo SaluteOra - 1000 Record per Modello
 * 
 * Genera esattamente:
 * - 1000 Doctor (utenti con tipo 'doctor')
 * - 1000 Patient (utenti con tipo 'patient') 
 * - 1000 Studio (studi medici)
 * 
 * ESECUZIONE:
 * 1. Copia questo script nella root del progetto
 * 2. Esegui: php bashscripts/database/seeding/saluteora-1000-records.php
 * 
 * ALTERNATIVA TINKER:
 * 1. Esegui: php artisan tinker
 * 2. Incolla il contenuto dello script
 * 3. Esegui: runMassiveSeeding()
 */

// Funzione principale per eseguire il seeding massivo
function runMassiveSeeding() {
    echo "🚀 Inizializzazione seeding massivo SaluteOra - 1000 record per modello...\n";
    
    // Disabilita controlli foreign key per performance
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
    try {
        // FASE 1: Creazione studi (prima degli utenti per foreign key)
        echo "\n🏥 FASE 1: Creazione 1000 studi medici...\n";
        $studios = createStudios(1000);
        
        // FASE 2: Creazione dottori
        echo "\n👨‍⚕️ FASE 2: Creazione 1000 dottori...\n";
        $doctors = createDoctors(1000, $studios);
        
        // FASE 3: Creazione pazienti
        echo "\n👤 FASE 3: Creazione 1000 pazienti...\n";
        $patients = createPatients(1000);
        
        // FASE 4: Creazione appuntamenti di esempio
        echo "\n📅 FASE 4: Creazione appuntamenti di esempio...\n";
        createSampleAppointments($doctors, $patients, $studios);
        
        // FASE 5: Statistiche finali
        echo "\n📊 FASE 5: Statistiche finali...\n";
        showFinalStatistics();
        
        echo "\n✅ Seeding massivo completato con successo!\n";
        
    } catch (Exception $e) {
        echo "\n❌ Errore durante il seeding: " . $e->getMessage() . "\n";
        echo "Stack trace: " . $e->getTraceAsString() . "\n";
    } finally {
        // Riabilita controlli foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

/**
 * Crea studi medici
 */
function createStudios(int $count): Collection {
    echo "  • Creazione {$count} studi medici...\n";
    
    $studios = collect();
    $batchSize = 100; // Processa in batch per performance
    
    for ($i = 0; $i < $count; $i += $batchSize) {
        $currentBatch = min($batchSize, $count - $i);
        echo "    - Batch " . (floor($i / $batchSize) + 1) . ": {$currentBatch} studi...\n";
        
        $batchStudios = \Modules\SaluteOra\Models\Studio::factory()
            ->count($currentBatch)
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
        
        // Progress bar
        $progress = round((($i + $currentBatch) / $count) * 100, 1);
        echo "    ✓ Progresso: {$progress}%\n";
    }
    
    echo "  ✅ Creati {$studios->count()} studi medici\n";
    return $studios;
}

/**
 * Crea dottori
 */
function createDoctors(int $count, Collection $studios): Collection {
    echo "  • Creazione {$count} dottori...\n";
    
    $doctors = collect();
    $batchSize = 100;
    
    for ($i = 0; $i < $count; $i += $batchSize) {
        $currentBatch = min($batchSize, $count - $i);
        echo "    - Batch " . (floor($i / $batchSize) + 1) . ": {$currentBatch} dottori...\n";
        
        $batchDoctors = \Modules\SaluteOra\Models\User::factory()
            ->count($currentBatch)
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
        
        // Progress bar
        $progress = round((($i + $currentBatch) / $count) * 100, 1);
        echo "    ✓ Progresso: {$progress}%\n";
    }
    
    echo "  ✅ Creati {$doctors->count()} dottori\n";
    return $doctors;
}

/**
 * Crea pazienti
 */
function createPatients(int $count): Collection {
    echo "  • Creazione {$count} pazienti...\n";
    
    $patients = collect();
    $batchSize = 100;
    
    for ($i = 0; $i < $count; $i += $batchSize) {
        $currentBatch = min($batchSize, $count - $i);
        echo "    - Batch " . (floor($i / $batchSize) + 1) . ": {$currentBatch} pazienti...\n";
        
        $batchPatients = \Modules\SaluteOra\Models\User::factory()
            ->count($currentBatch)
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
        
        // Progress bar
        $progress = round((($i + $currentBatch) / $count) * 100, 1);
        echo "    ✓ Progresso: {$progress}%\n";
    }
    
    echo "  ✅ Creati {$patients->count()} pazienti\n";
    return $patients;
}

/**
 * Crea appuntamenti di esempio
 */
function createSampleAppointments(Collection $doctors, Collection $patients, Collection $studios): void {
    echo "  • Creazione appuntamenti di esempio...\n";
    
    // Crea 500 appuntamenti distribuiti negli ultimi 30 giorni
    $appointmentCount = 500;
    $batchSize = 50;
    
    for ($i = 0; $i < $appointmentCount; $i += $batchSize) {
        $currentBatch = min($batchSize, $appointmentCount - $i);
        
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
    }
    
    echo "  ✅ Creati {$appointmentCount} appuntamenti di esempio\n";
}

/**
 * Mostra statistiche finali
 */
function showFinalStatistics(): void {
    echo "\n📊 STATISTICHE FINALI:\n";
    echo "  • Studi medici: " . \Modules\SaluteOra\Models\Studio::count() . "\n";
    echo "  • Dottori: " . \Modules\SaluteOra\Models\User::where('type', 'doctor')->count() . "\n";
    echo "  • Pazienti: " . \Modules\SaluteOra\Models\User::where('type', 'patient')->count() . "\n";
    echo "  • Appuntamenti: " . \Modules\SaluteOra\Models\Appointment::count() . "\n";
    echo "  • Utenti totali: " . \Modules\SaluteOra\Models\User::count() . "\n";
    
    // Statistiche per studio
    echo "\n🏥 DISTRIBUZIONE PER STUDIO:\n";
    $studioStats = \Modules\SaluteOra\Models\Studio::withCount(['doctors', 'appointments'])
        ->orderBy('doctors_count', 'desc')
        ->limit(5)
        ->get();
    
    foreach ($studioStats as $studio) {
        echo "  • {$studio->name}: {$studio->doctors_count} dottori, {$studio->appointments_count} appuntamenti\n";
    }
}

/**
 * Funzioni di utilità per Tinker
 */
function showHelp() {
    echo "\n🎯 FUNZIONI DISPONIBILI:\n";
    echo "• runMassiveSeeding() - Esegue tutto il seeding massivo\n";
    echo "• createStudios(1000) - Crea 1000 studi\n";
    echo "• createDoctors(1000, \$studios) - Crea 1000 dottori\n";
    echo "• createPatients(1000) - Crea 1000 pazienti\n";
    echo "• showFinalStatistics() - Mostra statistiche finali\n";
    echo "\n🎯 Per iniziare, esegui: runMassiveSeeding()\n";
}

// Se eseguito direttamente, mostra l'aiuto
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'] ?? '')) {
    showHelp();
    echo "\n🚀 Esecuzione seeding massivo...\n";
    runMassiveSeeding();
}
