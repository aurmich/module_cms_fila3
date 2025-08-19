<?php

/**
 * COMANDI DIRETTI PER TINKER - Popolamento Database SaluteOra
 * 
 * ISTRUZIONI:
 * 1. Esegui: php artisan tinker
 * 2. Copia e incolla questi comandi uno alla volta
 * 3. Ogni comando creerà molti record nel database
 */

// ========================================
// FASE 1: CREAZIONE RUOLI E PERMESSI
// ========================================

echo "👤 Creazione ruoli e permessi...\n";

// Crea permessi
$permissions = [
    'manage users', 'create users', 'edit users', 'delete users', 'view users',
    'manage studios', 'create studios', 'edit studios', 'delete studios', 'view studios',
    'manage appointments', 'create appointments', 'edit appointments', 'delete appointments', 'view appointments',
    'manage reports', 'view reports', 'manage settings', 'manage teams', 'view teams',
    'manage patients', 'view patients', 'manage doctors', 'view doctors',
    'manage calendar', 'view calendar', 'edit calendar', 'delete calendar'
];

foreach ($permissions as $permission) {
    \Modules\User\Models\Permission::firstOrCreate([
        'name' => $permission,
        'guard_name' => 'web',
    ]);
}

// Crea ruoli
$adminRole = \Modules\User\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
$doctorRole = \Modules\User\Models\Role::firstOrCreate(['name' => 'doctor', 'guard_name' => 'web']);
$patientRole = \Modules\User\Models\Role::firstOrCreate(['name' => 'patient', 'guard_name' => 'web']);

// Assegna permessi
$adminRole->givePermissionTo(\Modules\User\Models\Permission::all());
$doctorRole->givePermissionTo(['view users', 'view studios', 'manage appointments', 'create appointments', 'edit appointments', 'view appointments', 'view reports']);
$patientRole->givePermissionTo(['view appointments', 'create appointments']);

echo "✅ Ruoli e permessi creati!\n";

// ========================================
// FASE 2: CREAZIONE STUDI DENTISTICI
// ========================================

echo "\n🏥 Creazione studi dentistici...\n";

// Studi standard
$standardStudios = \Modules\SaluteOra\Models\Studio::factory()->count(50)->create();

// Studi specializzati
$orthoStudios = \Modules\SaluteOra\Models\Studio::factory()->orthodontics()->count(15)->create();
$fullServiceStudios = \Modules\SaluteOra\Models\Studio::factory()->fullService()->count(25)->create();
$extendedHoursStudios = \Modules\SaluteOra\Models\Studio::factory()->withExtendedHours()->count(10)->create();

// Studi per città
$cities = ['Milano', 'Roma', 'Napoli', 'Torino', 'Palermo', 'Genova', 'Bologna', 'Firenze', 'Bari', 'Catania'];
foreach ($cities as $city) {
    \Modules\SaluteOra\Models\Studio::factory()->inCity($city)->count(5)->create();
}

$totalStudios = \Modules\SaluteOra\Models\Studio::count();
echo "✅ Creati {$totalStudios} studi dentistici!\n";

// ========================================
// FASE 3: CREAZIONE UTENTI
// ========================================

echo "\n👥 Creazione utenti...\n";

// Admin
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

// Dottori
$doctors = \Modules\SaluteOra\Models\User::factory()
    ->doctor()
    ->active()
    ->count(150)
    ->create();

foreach ($doctors as $doctor) {
    $doctor->assignRole('doctor');
    // Assegna a 1-4 studi casuali
    $randomStudios = \Modules\SaluteOra\Models\Studio::inRandomOrder()->take(rand(1, 4))->get();
    $doctor->tenants()->attach($randomStudios);
}

// Pazienti
$patients = \Modules\SaluteOra\Models\User::factory()
    ->patient()
    ->active()
    ->count(500)
    ->create();

foreach ($patients as $patient) {
    $patient->assignRole('patient');
}

// Pazienti con dati completi
$completePatients = \Modules\SaluteOra\Models\User::factory()
    ->patient()
    ->withCompleteData()
    ->count(100)
    ->create()
    ->each(function ($patient) {
        $patient->assignRole('patient');
    });

$totalUsers = \Modules\SaluteOra\Models\User::count();
echo "✅ Creati {$totalUsers} utenti totali!\n";

// ========================================
// FASE 4: CREAZIONE TEAM
// ========================================

echo "\n👥 Creazione team...\n";

$studios = \Modules\SaluteOra\Models\Studio::all();
$teamCount = 0;

foreach ($studios as $studio) {
    // Team principale per studio
    $team = \Modules\User\Models\Team::factory()
        ->ownedBy($studio->user_id ?? \Modules\SaluteOra\Models\User::first()->id)
        ->create([
            'name' => "Team {$studio->name}",
            'description' => "Team principale dello studio {$studio->name}",
        ]);

    // Aggiungi dottori al team
    $studioDoctors = $studio->doctors()->take(rand(3, 8))->get();
    foreach ($studioDoctors as $doctor) {
        $team->users()->attach($doctor, [
            'role' => 'member',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // Team specializzati
    $specializations = ['Ortodonzia', 'Implantologia', 'Pediatria', 'Chirurgia'];
    foreach ($specializations as $specialization) {
        if (rand(0, 1)) {
            $specializedTeam = \Modules\User\Models\Team::factory()
                ->ownedBy($studio->user_id ?? \Modules\SaluteOra\Models\User::first()->id)
                ->create([
                    'name' => "Team {$specialization} - {$studio->name}",
                    'description' => "Team specializzato in {$specialization}",
                ]);

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

// Team personali per dottori
$users = \Modules\SaluteOra\Models\User::where('type', 'doctor')->take(25)->get();
foreach ($users as $user) {
    \Modules\User\Models\Team::factory()
        ->personal()
        ->ownedBy($user->id)
        ->create();
    $teamCount++;
}

echo "✅ Creati {$teamCount} team!\n";

// ========================================
// FASE 5: CREAZIONE APPUNTAMENTI
// ========================================

echo "\n📅 Creazione appuntamenti...\n";

$studios = \Modules\SaluteOra\Models\Studio::with('doctors')->get();
$patients = \Modules\SaluteOra\Models\User::where('type', 'patient')->get();
$appointmentCount = 0;

foreach ($studios as $studio) {
    $studioDoctors = $studio->doctors;
    
    if ($studioDoctors->isEmpty()) {
        continue;
    }

    // Appuntamenti per studio (50-150)
    $studioAppointments = rand(50, 150);
    
    for ($i = 0; $i < $studioAppointments; $i++) {
        $doctor = $studioDoctors->random();
        $patient = $patients->random();

        \Modules\SaluteOra\Models\Appointment::factory()
            ->forStudio($studio->id)
            ->forDoctor($doctor->id)
            ->forPatient($patient->id)
            ->create();

        $appointmentCount++;
    }
}

// Appuntamenti speciali
$emergencyAppointments = \Modules\SaluteOra\Models\Appointment::factory()->emergency()->count(100)->create();
$completedAppointments = \Modules\SaluteOra\Models\Appointment::factory()->completed()->count(300)->create();
$confirmedAppointments = \Modules\SaluteOra\Models\Appointment::factory()->confirmed()->count(500)->create();
$scheduledAppointments = \Modules\SaluteOra\Models\Appointment::factory()->scheduled()->count(400)->create();
$completeAppointments = \Modules\SaluteOra\Models\Appointment::factory()->withCompleteData()->count(200)->create();

$totalAppointments = $appointmentCount + 100 + 300 + 500 + 400 + 200;
echo "✅ Creati {$totalAppointments} appuntamenti totali!\n";

// ========================================
// FASE 6: DATI AGGIUNTIVI
// ========================================

echo "\n📊 Creazione dati aggiuntivi...\n";

// Appuntamenti storici (ultimi 6 mesi)
$patients = \Modules\SaluteOra\Models\User::where('type', 'patient')->take(100)->get();
$doctors = \Modules\SaluteOra\Models\User::where('type', 'doctor')->take(50)->get();
$studios = \Modules\SaluteOra\Models\Studio::take(30)->get();

$historicalAppointments = 0;

for ($month = 6; $month >= 1; $month--) {
    $date = now()->subMonths($month);
    $daysInMonth = $date->daysInMonth;
    
    for ($day = 1; $day <= $daysInMonth; $day++) {
        if (rand(0, 2)) { // 66% probabilità
            $appointmentsPerDay = rand(5, 20);
            
            for ($i = 0; $i < $appointmentsPerDay; $i++) {
                $appointmentDate = $date->copy()->setDay($day);
                
                \Modules\SaluteOra\Models\Appointment::factory()
                    ->forStudio($studios->random()->id)
                    ->forDoctor($doctors->random()->id)
                    ->forPatient($patients->random()->id)
                    ->onDate($appointmentDate->format('Y-m-d'))
                    ->create();
                
                $historicalAppointments++;
            }
        }
    }
}

echo "✅ Creati {$historicalAppointments} appuntamenti storici!\n";

// ========================================
// STATISTICHE FINALI
// ========================================

echo "\n📊 STATISTICHE FINALI DEL DATABASE:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$totalUsers = \Modules\SaluteOra\Models\User::count();
$totalStudios = \Modules\SaluteOra\Models\Studio::count();
$totalAppointments = \Modules\SaluteOra\Models\Appointment::count();
$totalTeams = \Modules\User\Models\Team::count();

$adminUsers = \Modules\SaluteOra\Models\User::where('type', 'admin')->count();
$doctorUsers = \Modules\SaluteOra\Models\User::where('type', 'doctor')->count();
$patientUsers = \Modules\SaluteOra\Models\User::where('type', 'patient')->count();

echo "👥 UTENTI TOTALI: {$totalUsers}\n";
echo "   ├─ Admin: {$adminUsers}\n";
echo "   ├─ Dottori: {$doctorUsers}\n";
echo "   └─ Pazienti: {$patientUsers}\n";
echo "\n🏥 STUDI DENTISTICI: {$totalStudios}\n";
echo "\n📅 APPUNTAMENTI TOTALI: {$totalAppointments}\n";
echo "\n👥 TEAM CREATI: {$totalTeams}\n";
echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "🎉 Database popolato con successo!\n";
echo "💡 Puoi ora testare tutte le funzionalità del sistema.\n";

// ========================================
// COMANDI UTILI PER VERIFICA
// ========================================

echo "\n🔍 COMANDI UTILI PER VERIFICA:\n";
echo "• \Modules\SaluteOra\Models\User::count() - Conta utenti\n";
echo "• \Modules\SaluteOra\Models\Studio::count() - Conta studi\n";
echo "• \Modules\SaluteOra\Models\Appointment::count() - Conta appuntamenti\n";
echo "• \Modules\User\Models\Team::count() - Conta team\n";
echo "• \Modules\SaluteOra\Models\User::where('type', 'doctor')->count() - Conta dottori\n";
echo "• \Modules\SaluteOra\Models\User::where('type', 'patient')->count() - Conta pazienti\n";
