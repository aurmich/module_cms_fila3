<?php

declare(strict_types=1);

/**
 * Script per popolare il database con molti record usando Tinker
 * 
 * Questo script può essere eseguito con:
 * php artisan tinker < scripts/populate_database.php
 * 
 * Oppure copiando e incollando i comandi in Tinker
 */

echo "🚀 Inizializzazione popolazione massiva del database SaluteOra...\n";
echo "⏰ Tempo stimato: 5-10 minuti\n";
echo "📊 Verranno creati migliaia di record realistici\n\n";

// Importa le classi necessarie
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\Appointment;
use Modules\User\Models\Team;
use Modules\User\Models\Role;
use Modules\Geo\Models\Address;
use Modules\Media\Models\Media;
use Modules\Notify\Models\Notification;
use Modules\Gdpr\Models\Consent;
use Illuminate\Support\Facades\DB;

// Disabilita i controlli di foreign key per performance
DB::statement('SET FOREIGN_KEY_CHECKS=0;');

try {
    echo "👥 Creazione utenti amministratori...\n";
    
    // Crea 10 admin con dati completi
    $admins = User::factory()
        ->admin()
        ->active()
        ->count(10)
        ->create();
    
    foreach ($admins as $admin) {
        $admin->assignRole('admin');
    }
    
    echo "   ✓ Creati " . $admins->count() . " amministratori\n";

    echo "🏥 Creazione studi dentistici...\n";
    
    // Crea 100 studi con diverse specializzazioni
    $generalStudios = Studio::factory()->count(50)->create();
    $orthodonticsStudios = Studio::factory()->orthodontics()->count(20)->create();
    $fullServiceStudios = Studio::factory()->fullService()->count(15)->create();
    $extendedHoursStudios = Studio::factory()->withExtendedHours()->count(10)->create();
    $emergencyStudios = Studio::factory()->emergencyOnly()->count(5)->create();
    
    $totalStudios = Studio::count();
    echo "   ✓ Creati {$totalStudios} studi dentistici\n";

    echo "👨‍⚕️ Creazione dottori...\n";
    
    // Crea 300 dottori con diverse specializzazioni
    $generalDoctors = Doctor::factory()->active()->count(100)->create();
    $seniorDoctors = Doctor::factory()->senior()->active()->count(30)->create();
    $newGraduateDoctors = Doctor::factory()->newGraduate()->active()->count(50)->create();
    $pediatricDoctors = Doctor::factory()->pediatricSpecialist()->active()->count(25)->create();
    $aestheticDoctors = Doctor::factory()->aestheticSpecialist()->active()->count(20)->create();
    $emergencyDoctors = Doctor::factory()->emergencyOnly()->active()->count(15)->create();
    $pendingDoctors = Doctor::factory()->pending()->count(30)->create();
    $integrationDoctors = Doctor::factory()->integrationRequested()->count(30)->create();
    
    // Assegna ruolo e studi ai dottori
    $allDoctors = Doctor::all();
    foreach ($allDoctors as $doctor) {
        $doctor->assignRole('doctor');
        
        // Assegna ogni dottore a 1-4 studi casuali
        $randomStudios = Studio::inRandomOrder()->take(rand(1, 4))->get();
        $doctor->tenants()->sync($randomStudios->pluck('id'));
    }
    
    echo "   ✓ Creati " . $allDoctors->count() . " dottori\n";

    echo "🤱 Creazione pazienti...\n";
    
    // Crea 2000 pazienti con diverse caratteristiche
    $activePatientsGeneral = Patient::factory()->active()->count(800)->create();
    $pendingPatients = Patient::factory()->pending()->count(200)->create();
    $integrationPatients = Patient::factory()->integrationRequested()->count(150)->create();
    $pregnantPatients = Patient::factory()->pregnant()->active()->count(100)->create();
    $elderlyPatients = Patient::factory()->elderly()->active()->count(200)->create();
    $pediatricPatients = Patient::factory()->pediatric()->active()->count(300)->create();
    $highIncomePatients = Patient::factory()->highIncome()->active()->count(100)->create();
    $lowIncomePatients = Patient::factory()->lowIncome()->active()->count(200)->create();
    $medicalHistoryPatients = Patient::factory()->withMedicalHistory()->active()->count(150)->create();
    $specialNeedsPatients = Patient::factory()->specialNeeds()->active()->count(50)->create();
    
    // Assegna ruolo ai pazienti
    $allPatients = Patient::all();
    foreach ($allPatients as $patient) {
        $patient->assignRole('patient');
    }
    
    echo "   ✓ Creati " . $allPatients->count() . " pazienti\n";

    echo "📅 Creazione appuntamenti...\n";
    
    $appointmentCount = 0;
    $studios = Studio::with('doctors')->get();
    $patients = Patient::all();
    
    foreach ($studios as $studio) {
        $studioDoctors = $studio->doctors;
        
        if ($studioDoctors->isEmpty()) {
            continue;
        }
        
        // Crea 50-150 appuntamenti per studio
        $studioAppointments = rand(50, 150);
        
        for ($i = 0; $i < $studioAppointments; $i++) {
            $doctor = $studioDoctors->random();
            $patient = $patients->random();
            
            // Varia i tipi di appuntamenti
            $appointmentType = rand(1, 10);
            
            if ($appointmentType <= 2) {
                // 20% emergenze
                $appointment = Appointment::factory()
                    ->emergency()
                    ->forStudio($studio->id)
                    ->forDoctor($doctor->id)
                    ->forPatient($patient->id)
                    ->create();
            } elseif ($appointmentType <= 4) {
                // 20% completati
                $appointment = Appointment::factory()
                    ->completed()
                    ->forStudio($studio->id)
                    ->forDoctor($doctor->id)
                    ->forPatient($patient->id)
                    ->create();
            } elseif ($appointmentType <= 6) {
                // 20% confermati
                $appointment = Appointment::factory()
                    ->confirmed()
                    ->forStudio($studio->id)
                    ->forDoctor($doctor->id)
                    ->forPatient($patient->id)
                    ->create();
            } else {
                // 40% normali
                $appointment = Appointment::factory()
                    ->forStudio($studio->id)
                    ->forDoctor($doctor->id)
                    ->forPatient($patient->id)
                    ->create();
            }
            
            $appointmentCount++;
        }
    }
    
    echo "   ✓ Creati {$appointmentCount} appuntamenti\n";

    echo "👥 Creazione team...\n";
    
    $teamCount = 0;
    
    // Crea team per ogni studio
    foreach ($studios as $studio) {
        $team = Team::factory()
            ->create([
                'name' => "Team {$studio->name}",
                'personal_team' => false,
            ]);
        
        // Aggiungi dottori del studio al team
        $studioDoctors = $studio->doctors()->take(8)->get();
        foreach ($studioDoctors as $doctor) {
            $team->users()->attach($doctor, [
                'role' => 'member',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $teamCount++;
    }
    
    // Crea team personali per alcuni dottori
    $doctors = Doctor::inRandomOrder()->take(50)->get();
    foreach ($doctors as $doctor) {
        Team::factory()
            ->personal()
            ->ownedBy($doctor->id)
            ->create();
        $teamCount++;
    }
    
    echo "   ✓ Creati {$teamCount} team\n";

    echo "📍 Creazione indirizzi...\n";
    
    // Crea indirizzi per studi e utenti
    $addressCount = 0;
    
    // Indirizzi per studi
    foreach ($studios as $studio) {
        Address::factory()
            ->forModel($studio)
            ->create();
        $addressCount++;
    }
    
    // Indirizzi per alcuni utenti
    $usersWithAddresses = User::inRandomOrder()->take(500)->get();
    foreach ($usersWithAddresses as $user) {
        Address::factory()
            ->forModel($user)
            ->create();
        $addressCount++;
    }
    
    echo "   ✓ Creati {$addressCount} indirizzi\n";

    echo "📄 Creazione consensi GDPR...\n";
    
    // Crea consensi per tutti i pazienti
    $consentCount = 0;
    foreach ($allPatients as $patient) {
        // Consenso privacy
        Consent::factory()
            ->forUser($patient->id)
            ->privacy()
            ->create();
        
        // Consenso marketing (50% probabilità)
        if (rand(1, 2) === 1) {
            Consent::factory()
                ->forUser($patient->id)
                ->marketing()
                ->create();
        }
        
        $consentCount += rand(1, 2);
    }
    
    echo "   ✓ Creati {$consentCount} consensi GDPR\n";

    echo "🔔 Creazione notifiche...\n";
    
    // Crea notifiche per utenti
    $notificationCount = 0;
    $allUsers = User::all();
    
    foreach ($allUsers->take(1000) as $user) {
        $userNotifications = rand(1, 10);
        
        for ($i = 0; $i < $userNotifications; $i++) {
            Notification::factory()
                ->forUser($user->id)
                ->create();
            $notificationCount++;
        }
    }
    
    echo "   ✓ Creati {$notificationCount} notifiche\n";

    // Riabilita i controlli di foreign key
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    echo "\n🎉 POPOLAZIONE COMPLETATA CON SUCCESSO!\n\n";
    
    // Mostra statistiche finali
    echo "📊 STATISTICHE FINALI:\n";
    echo "┌─────────────────────────────────────┐\n";
    echo "│ 👥 Utenti totali:           " . str_pad((string)User::count(), 6, ' ', STR_PAD_LEFT) . " │\n";
    echo "│    - Admin:                 " . str_pad((string)User::admins()->count(), 6, ' ', STR_PAD_LEFT) . " │\n";
    echo "│    - Dottori:               " . str_pad((string)Doctor::count(), 6, ' ', STR_PAD_LEFT) . " │\n";
    echo "│    - Pazienti:              " . str_pad((string)Patient::count(), 6, ' ', STR_PAD_LEFT) . " │\n";
    echo "│ 🏥 Studi:                   " . str_pad((string)Studio::count(), 6, ' ', STR_PAD_LEFT) . " │\n";
    echo "│ 📅 Appuntamenti:            " . str_pad((string)Appointment::count(), 6, ' ', STR_PAD_LEFT) . " │\n";
    echo "│ 👥 Team:                    " . str_pad((string)Team::count(), 6, ' ', STR_PAD_LEFT) . " │\n";
    echo "│ 📍 Indirizzi:               " . str_pad((string)Address::count(), 6, ' ', STR_PAD_LEFT) . " │\n";
    echo "│ 📄 Consensi GDPR:           " . str_pad((string)Consent::count(), 6, ' ', STR_PAD_LEFT) . " │\n";
    echo "│ 🔔 Notifiche:               " . str_pad((string)Notification::count(), 6, ' ', STR_PAD_LEFT) . " │\n";
    echo "└─────────────────────────────────────┘\n\n";
    
    echo "💡 CREDENZIALI DI ACCESSO:\n";
    echo "Admin: admin@saluteora.com / password\n\n";
    
    echo "🚀 Il database è ora popolato con migliaia di record realistici!\n";
    echo "Puoi iniziare a testare tutte le funzionalità del sistema.\n\n";

} catch (Exception $e) {
    echo "❌ ERRORE: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} finally {
    // Assicurati che i controlli di foreign key siano riabilitati
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
}
