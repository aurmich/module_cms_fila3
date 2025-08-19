<?php

/**
 * Script completo per popolare il database con molti record
 * Utilizza i factory dei moduli SaluteMo e SaluteOra
 * 
 * ESECUZIONE:
 * 1. Copia questo script nella root del progetto Laravel
 * 2. Esegui: php artisan tinker
 * 3. Incolla il contenuto dello script
 * 4. Esegui: runDatabaseSeeding()
 */

// Funzione principale per eseguire tutto il seeding
function runDatabaseSeeding() {
    echo "🚀 Inizializzazione seeding massivo del database...\n";
    
    // Disabilita controlli foreign key per performance
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
    try {
        // FASE 1: Creazione ruoli e permessi
        echo "\n👤 FASE 1: Creazione ruoli e permessi...\n";
        createRolesAndPermissions();
        
        // FASE 2: Creazione studi dentistici
        echo "\n🏥 FASE 2: Creazione studi dentistici...\n";
        createStudios();
        
        // FASE 3: Creazione utenti (admin, dottori, pazienti)
        echo "\n👥 FASE 3: Creazione utenti...\n";
        createUsers();
        
        // FASE 4: Creazione team
        echo "\n👥 FASE 4: Creazione team...\n";
        createTeams();
        
        // FASE 5: Creazione appuntamenti
        echo "\n📅 FASE 5: Creazione appuntamenti...\n";
        createAppointments();
        
        // FASE 6: Creazione dati aggiuntivi
        echo "\n📊 FASE 6: Creazione dati aggiuntivi...\n";
        createAdditionalData();
        
        echo "\n✅ SEEDING COMPLETATO CON SUCCESSO!\n";
        echo "📊 STATISTICHE FINALI:\n";
        showFinalStatistics();
        
    } catch (Exception $e) {
        echo "\n❌ ERRORE durante il seeding: " . $e->getMessage() . "\n";
        echo "Stack trace: " . $e->getTraceAsString() . "\n";
    } finally {
        // Riabilita controlli foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

/**
 * Crea ruoli e permessi di base
 */
function createRolesAndPermissions() {
    $permissions = [
        'manage users', 'create users', 'edit users', 'delete users', 'view users',
        'manage studios', 'create studios', 'edit studios', 'delete studios', 'view studios',
        'manage appointments', 'create appointments', 'edit appointments', 'delete appointments', 'view appointments',
        'manage reports', 'view reports', 'manage settings', 'manage teams', 'view teams',
        'manage patients', 'view patients', 'manage doctors', 'view doctors',
        'manage calendar', 'view calendar', 'edit calendar', 'delete calendar',
        'manage billing', 'view billing', 'manage insurance', 'view insurance'
    ];

    foreach ($permissions as $permission) {
        \Modules\User\Models\Permission::firstOrCreate([
            'name' => $permission,
            'guard_name' => 'web',
        ]);
    }

    // Crea ruoli principali
    $adminRole = \Modules\User\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    $doctorRole = \Modules\User\Models\Role::firstOrCreate(['name' => 'doctor', 'guard_name' => 'web']);
    $patientRole = \Modules\User\Models\Role::firstOrCreate(['name' => 'patient', 'guard_name' => 'web']);
    $receptionistRole = \Modules\User\Models\Role::firstOrCreate(['name' => 'receptionist', 'guard_name' => 'web']);

    // Assegna permessi ai ruoli
    $adminRole->givePermissionTo(\Modules\User\Models\Permission::all());
    
    $doctorRole->givePermissionTo([
        'view users', 'view studios', 'manage appointments', 'create appointments', 
        'edit appointments', 'view appointments', 'view reports', 'view calendar', 'edit calendar',
        'view patients', 'view teams'
    ]);

    $patientRole->givePermissionTo([
        'view appointments', 'create appointments', 'view calendar', 'view teams'
    ]);

    $receptionistRole->givePermissionTo([
        'view users', 'view studios', 'manage appointments', 'create appointments', 
        'edit appointments', 'view appointments', 'view patients', 'view doctors'
    ]);

    echo "   ✓ Creati " . count($permissions) . " permessi";
    echo "\n   ✓ Creati 4 ruoli (admin, doctor, patient, receptionist)";
}

/**
 * Crea studi dentistici con varietà
 */
function createStudios() {
    // Studi standard
    $standardStudios = \Modules\SaluteOra\Models\Studio::factory()
        ->count(50)
        ->create();

    // Studi specializzati in ortodonzia
    $orthoStudios = \Modules\SaluteOra\Models\Studio::factory()
        ->orthodontics()
        ->count(15)
        ->create();

    // Studi con servizi completi
    $fullServiceStudios = \Modules\SaluteOra\Models\Studio::factory()
        ->fullService()
        ->count(25)
        ->create();

    // Studi con orari estesi
    $extendedHoursStudios = \Modules\SaluteOra\Models\Studio::factory()
        ->withExtendedHours()
        ->count(10)
        ->create();

    // Studi in città specifiche
    $cities = ['Milano', 'Roma', 'Napoli', 'Torino', 'Palermo', 'Genova', 'Bologna', 'Firenze', 'Bari', 'Catania'];
    foreach ($cities as $city) {
        \Modules\SaluteOra\Models\Studio::factory()
            ->inCity($city)
            ->count(5)
            ->create();
    }

    $totalStudios = \Modules\SaluteOra\Models\Studio::count();
    echo "   ✓ Creati {$totalStudios} studi dentistici";
    echo "\n     - Standard: 50";
    echo "\n     - Ortodonzia: 15";
    echo "\n     - Servizi completi: 25";
    echo "\n     - Orari estesi: 10";
    echo "\n     - Per città: " . (count($cities) * 5);
}

/**
 * Crea utenti del sistema
 */
function createUsers() {
    // Admin di sistema
    $admin = \Modules\SaluteOra\Models\User::factory()
        ->admin()
        ->active()
        ->create([
            'name' => 'Super Admin',
            'email' => 'admin@saluteora.com',
            'first_name' => 'Super',
            'last_name' => 'Admin',
        ]);
    
    $admin->assignRole('admin');
    echo "   ✓ Creato admin: {$admin->email}";

    // Dottori
    $doctors = \Modules\SaluteOra\Models\User::factory()
        ->doctor()
        ->active()
        ->count(150)
        ->create();

    foreach ($doctors as $doctor) {
        $doctor->assignRole('doctor');
        
        // Assegna ogni dottore a 1-4 studi casuali
        $randomStudios = \Modules\SaluteOra\Models\Studio::inRandomOrder()->take(rand(1, 4))->get();
        $doctor->tenants()->attach($randomStudios);
    }

    echo "\n   ✓ Creati {$doctors->count()} dottori";

    // Pazienti
    $patients = \Modules\SaluteOra\Models\User::factory()
        ->patient()
        ->active()
        ->count(500)
        ->create();

    foreach ($patients as $patient) {
        $patient->assignRole('patient');
    }

    echo "\n   ✓ Creati {$patients->count()} pazienti";

    // Pazienti con dati completi
    $completePatients = \Modules\SaluteOra\Models\User::factory()
        ->patient()
        ->withCompleteData()
        ->count(100)
        ->create()
        ->each(function ($patient) {
            $patient->assignRole('patient');
        });

    echo "\n   ✓ Creati {$completePatients->count()} pazienti con dati completi";

    // Receptionist
    $receptionists = \Modules\SaluteOra\Models\User::factory()
        ->count(30)
        ->create()
        ->each(function ($user) {
            $user->assignRole('receptionist');
            $user->update(['type' => 'receptionist']);
        });

    echo "\n   ✓ Creati {$receptionists->count()} receptionist";

    $totalUsers = \Modules\SaluteOra\Models\User::count();
    echo "\n   ✓ Totale utenti creati: {$totalUsers}";
}

/**
 * Crea team per gli studi
 */
function createTeams() {
    $studios = \Modules\SaluteOra\Models\Studio::all();
    $teamCount = 0;

    foreach ($studios as $studio) {
        // Crea un team principale per ogni studio
        $team = \Modules\User\Models\Team::factory()
            ->ownedBy($studio->user_id ?? \Modules\SaluteOra\Models\User::first()->id)
            ->create([
                'name' => "Team {$studio->name}",
                'description' => "Team principale dello studio {$studio->name}",
            ]);

        // Aggiungi dottori del studio al team
        $studioDoctors = $studio->doctors()->take(rand(3, 8))->get();
        foreach ($studioDoctors as $doctor) {
            $team->users()->attach($doctor, [
                'role' => 'member',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Crea team specializzati per studio
        $specializedTeams = ['Ortodonzia', 'Implantologia', 'Pediatria', 'Chirurgia'];
        foreach ($specializedTeams as $specialization) {
            if (rand(0, 1)) { // 50% di probabilità
                $specializedTeam = \Modules\User\Models\Team::factory()
                    ->ownedBy($studio->user_id ?? \Modules\SaluteOra\Models\User::first()->id)
                    ->create([
                        'name' => "Team {$specialization} - {$studio->name}",
                        'description' => "Team specializzato in {$specialization}",
                    ]);

                // Aggiungi dottori specializzati
                $specializedDoctors = $studioDoctors->take(rand(2, 4));
                foreach ($specializedDoctors as $doctor) {
                    $specializedTeam->users()->attach($doctor, [
                        'role' => 'member',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $teamCount++;
            }
        }

        $teamCount++;
    }

    // Crea team personali per alcuni dottori
    $users = \Modules\SaluteOra\Models\User::where('type', 'doctor')->take(25)->get();
    foreach ($users as $user) {
        \Modules\User\Models\Team::factory()
            ->personal()
            ->ownedBy($user->id)
            ->create();
        $teamCount++;
    }

    echo "   ✓ Creati {$teamCount} team";
}

/**
 * Crea appuntamenti per tutti gli studi
 */
function createAppointments() {
    $studios = \Modules\SaluteOra\Models\Studio::with('doctors')->get();
    $patients = \Modules\SaluteOra\Models\User::where('type', 'patient')->get();
    $appointmentCount = 0;

    foreach ($studios as $studio) {
        $studioDoctors = $studio->doctors;
        
        if ($studioDoctors->isEmpty()) {
            continue;
        }

        // Crea appuntamenti per ogni studio (50-150 per studio)
        $studioAppointments = rand(50, 150);
        
        for ($i = 0; $i < $studioAppointments; $i++) {
            $doctor = $studioDoctors->random();
            $patient = $patients->random();

            $appointment = \Modules\SaluteOra\Models\Appointment::factory()
                ->forStudio($studio->id)
                ->forDoctor($doctor->id)
                ->forPatient($patient->id)
                ->create();

            $appointmentCount++;
        }
    }

    // Crea appuntamenti di emergenza
    $emergencyAppointments = \Modules\SaluteOra\Models\Appointment::factory()
        ->emergency()
        ->count(100)
        ->create();

    $appointmentCount += $emergencyAppointments->count();

    // Crea appuntamenti completati
    $completedAppointments = \Modules\SaluteOra\Models\Appointment::factory()
        ->completed()
        ->count(300)
        ->create();

    $appointmentCount += $completedAppointments->count();

    // Crea appuntamenti confermati
    $confirmedAppointments = \Modules\SaluteOra\Models\Appointment::factory()
        ->confirmed()
        ->count(500)
        ->create();

    $appointmentCount += $confirmedAppointments->count();

    // Crea appuntamenti programmati
    $scheduledAppointments = \Modules\SaluteOra\Models\Appointment::factory()
        ->scheduled()
        ->count(400)
        ->create();

    $appointmentCount += $scheduledAppointments->count();

    // Crea appuntamenti con dati completi
    $completeAppointments = \Modules\SaluteOra\Models\Appointment::factory()
        ->withCompleteData()
        ->count(200)
        ->create();

    $appointmentCount += $completeAppointments->count();

    echo "   ✓ Creati {$appointmentCount} appuntamenti totali";
    echo "\n     - Emergenze: 100";
    echo "\n     - Completati: 300";
    echo "\n     - Confermati: 500";
    echo "\n     - Programmati: 400";
    echo "\n     - Con dati completi: 200";
    echo "\n     - Per studio: " . ($appointmentCount - 1500);
}

/**
 * Crea dati aggiuntivi per arricchire il sistema
 */
function createAdditionalData() {
    // Crea appuntamenti per date specifiche (ultimi 6 mesi)
    $patients = \Modules\SaluteOra\Models\User::where('type', 'patient')->take(100)->get();
    $doctors = \Modules\SaluteOra\Models\User::where('type', 'doctor')->take(50)->get();
    $studios = \Modules\SaluteOra\Models\Studio::take(30)->get();
    
    $additionalAppointments = 0;
    
    for ($month = 6; $month >= 1; $month--) {
        $date = now()->subMonths($month);
        $daysInMonth = $date->daysInMonth;
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            if (rand(0, 2)) { // 66% di probabilità di avere appuntamenti
                $appointmentsPerDay = rand(5, 20);
                
                for ($i = 0; $i < $appointmentsPerDay; $i++) {
                    $appointmentDate = $date->copy()->setDay($day);
                    
                    \Modules\SaluteOra\Models\Appointment::factory()
                        ->forStudio($studios->random()->id)
                        ->forDoctor($doctors->random()->id)
                        ->forPatient($patients->random()->id)
                        ->onDate($appointmentDate->format('Y-m-d'))
                        ->create();
                    
                    $additionalAppointments++;
                }
            }
        }
    }

    echo "   ✓ Creati {$additionalAppointments} appuntamenti storici (ultimi 6 mesi)";
}

/**
 * Mostra statistiche finali del database
 */
function showFinalStatistics() {
    $totalUsers = \Modules\SaluteOra\Models\User::count();
    $totalStudios = \Modules\SaluteOra\Models\Studio::count();
    $totalAppointments = \Modules\SaluteOra\Models\Appointment::count();
    $totalTeams = \Modules\User\Models\Team::count();
    
    $adminUsers = \Modules\SaluteOra\Models\User::where('type', 'admin')->count();
    $doctorUsers = \Modules\SaluteOra\Models\User::where('type', 'doctor')->count();
    $patientUsers = \Modules\SaluteOra\Models\User::where('type', 'patient')->count();
    $receptionistUsers = \Modules\SaluteOra\Models\User::where('type', 'receptionist')->count();
    
    echo "\n📊 STATISTICHE FINALI DEL DATABASE:\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "👥 UTENTI TOTALI: {$totalUsers}\n";
    echo "   ├─ Admin: {$adminUsers}\n";
    echo "   ├─ Dottori: {$doctorUsers}\n";
    echo "   ├─ Pazienti: {$patientUsers}\n";
    echo "   └─ Receptionist: {$receptionistUsers}\n";
    echo "\n🏥 STUDI DENTISTICI: {$totalStudios}\n";
    echo "\n📅 APPUNTAMENTI TOTALI: {$totalAppointments}\n";
    echo "\n👥 TEAM CREATI: {$totalTeams}\n";
    echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "🎉 Database popolato con successo!\n";
    echo "💡 Puoi ora testare tutte le funzionalità del sistema.\n";
}

// Funzione per pulire il database (ATTENZIONE: cancella tutti i dati!)
function clearDatabase() {
    echo "⚠️  ATTENZIONE: Questa operazione cancellerà TUTTI i dati!\n";
    echo "Per continuare, esegui: clearDatabaseConfirm()\n";
}

function clearDatabaseConfirm() {
    echo "🗑️  Pulizia database in corso...\n";
    
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
    \Modules\SaluteOra\Models\Appointment::truncate();
    \Modules\SaluteOra\Models\Studio::truncate();
    \Modules\SaluteOra\Models\User::truncate();
    \Modules\User\Models\Team::truncate();
    \Modules\User\Models\Role::truncate();
    \Modules\User\Models\Permission::truncate();
    
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
    echo "✅ Database pulito con successo!\n";
}

// Funzione per eseguire solo una parte specifica
function runPartialSeeding($phase) {
    switch ($phase) {
        case 'users':
            echo "👥 Esecuzione solo creazione utenti...\n";
            createUsers();
            break;
        case 'studios':
            echo "🏥 Esecuzione solo creazione studi...\n";
            createStudios();
            break;
        case 'appointments':
            echo "📅 Esecuzione solo creazione appuntamenti...\n";
            createAppointments();
            break;
        case 'teams':
            echo "👥 Esecuzione solo creazione team...\n";
            createTeams();
            break;
        default:
            echo "❌ Fase non riconosciuta. Fasi disponibili: users, studios, appointments, teams\n";
    }
}

echo "🚀 Script di seeding del database caricato!\n";
echo "📋 Funzioni disponibili:\n";
echo "   - runDatabaseSeeding() - Esegue tutto il seeding\n";
echo "   - runPartialSeeding('fase') - Esegue solo una fase specifica\n";
echo "   - clearDatabase() - Pulisce il database (con conferma)\n";
echo "   - showFinalStatistics() - Mostra statistiche attuali\n";
echo "\n💡 Per iniziare, esegui: runDatabaseSeeding()\n";
