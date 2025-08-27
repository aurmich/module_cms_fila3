<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Report;

/**
 * Comando per il popolamento del database del modulo SaluteOra.
 * 
 * Questo comando crea un dataset completo per testing e sviluppo,
 * includendo utenti, dottori, pazienti, studi, appuntamenti e report.
 */
class PopulateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saluteora:populate-database 
                            {--doctors=25 : Numero di dottori da creare}
                            {--patients=100 : Numero di pazienti da creare}
                            {--appointments=200 : Numero di appuntamenti da creare}
                            {--reports=150 : Numero di report da creare}
                            {--force : Forza la creazione anche se i dati esistono già}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Popola il database del modulo SaluteOra con dati di test';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Avvio popolamento database modulo SaluteOra...');
        $this->newLine();

        try {
            // 1. Creazione dottori
            $this->createDoctors();
            
            // 2. Creazione pazienti
            $this->createPatients();
            
            // 3. Creazione relazioni dottore-studio
            $this->createDoctorStudioRelations();
            
            // 4. Creazione relazioni paziente-studio
            $this->createPatientStudioRelations();
            
            // 5. Creazione appuntamenti
            $this->createAppointments();
            
            // 6. Creazione report
            $this->createReports();
            
            // 7. Verifica finale
            $this->verifyPopulation();
            
            $this->newLine();
            $this->info('✅ Popolamento database completato con successo!');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Errore durante il popolamento: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            
            return Command::FAILURE;
        }
    }

    /**
     * Crea dottori per il sistema sanitario.
     */
    private function createDoctors(): void
    {
        $this->info('1. Creazione dottori...');
        
        $targetDoctors = (int) $this->option('doctors');
        $existingDoctors = Doctor::count();
        
        if ($existingDoctors >= $targetDoctors && !$this->option('force')) {
            $this->line("   ℹ️  Dottori sufficienti già presenti ({$existingDoctors})");
            return;
        }
        
        $doctorsToCreate = $targetDoctors - $existingDoctors;
        if ($doctorsToCreate > 0) {
            $bar = $this->output->createProgressBar($doctorsToCreate);
            $bar->start();
            
            for ($i = 0; $i < $doctorsToCreate; $i++) {
                Doctor::create([
                    'name' => fake()->firstName(),
                    'last_name' => 'Dr. ' . fake()->lastName(),
                    'email' => fake()->unique()->safeEmail(),
                    'phone' => fake()->phoneNumber(),
                    'type' => 'doctor',
                    'status' => 'approved'
                ]);
                $bar->advance();
            }
            
            $bar->finish();
            $this->newLine();
            $this->line("   ✅ {$doctorsToCreate} dottori aggiuntivi creati");
        } else {
            $this->line("   ℹ️  Dottori sufficienti già presenti ({$existingDoctors})");
        }
    }

    /**
     * Crea pazienti per il sistema sanitario.
     */
    private function createPatients(): void
    {
        $this->info('2. Creazione pazienti...');
        
        $targetPatients = (int) $this->option('patients');
        $existingPatients = Patient::count();
        
        if ($existingPatients >= $targetPatients && !$this->option('force')) {
            $this->line("   ℹ️  Pazienti sufficienti già presenti ({$existingPatients})");
            return;
        }
        
        $patientsToCreate = $targetPatients - $existingPatients;
        if ($patientsToCreate > 0) {
            $bar = $this->output->createProgressBar($patientsToCreate);
            $bar->start();
            
            for ($i = 0; $i < $patientsToCreate; $i++) {
                Patient::create([
                    'name' => fake()->firstName(),
                    'last_name' => fake()->lastName(),
                    'email' => fake()->unique()->safeEmail(),
                    'phone' => fake()->phoneNumber(),
                    'type' => 'patient',
                    'date_of_birth' => fake()->dateTimeBetween('-80 years', '-18 years'),
                    'gender' => fake()->randomElement(['M', 'F'])
                ]);
                $bar->advance();
            }
            
            $bar->finish();
            $this->newLine();
            $this->line("   ✅ {$patientsToCreate} pazienti aggiuntivi creati");
        } else {
            $this->line("   ℹ️  Pazienti sufficienti già presenti ({$existingPatients})");
        }
    }

    /**
     * Crea relazioni tra dottori e studi.
     */
    private function createDoctorStudioRelations(): void
    {
        $this->info('3. Creazione relazioni dottore-studio...');
        
        $doctors = Doctor::all();
        $studios = Studio::all();
        $relations = 0;
        
        foreach ($studios as $studio) {
            $studioDoctors = $doctors->random(rand(2, 5));
            foreach ($studioDoctors as $doctor) {
                // Verifica se la relazione esiste già
                $exists = DB::table('studio_user')
                    ->where('studio_id', $studio->id)
                    ->where('user_id', $doctor->id)
                    ->exists();
                
                if (!$exists) {
                    DB::table('studio_user')->insert([
                        'studio_id' => $studio->id,
                        'user_id' => $doctor->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $relations++;
                }
            }
        }
        
        $this->line("   ✅ {$relations} nuove relazioni dottore-studio create");
    }

    /**
     * Crea relazioni tra pazienti e studi.
     */
    private function createPatientStudioRelations(): void
    {
        $this->info('4. Creazione relazioni paziente-studio...');
        
        $patients = Patient::all();
        $studios = Studio::all();
        $relations = 0;
        
        foreach ($studios as $studio) {
            $studioPatients = $patients->random(rand(10, 30));
            foreach ($studioPatients as $patient) {
                // Verifica se la relazione esiste già
                $exists = DB::table('studio_user')
                    ->where('studio_id', $studio->id)
                    ->where('user_id', $patient->id)
                    ->exists();
                
                if (!$exists) {
                    DB::table('studio_user')->insert([
                        'studio_id' => $studio->id,
                        'user_id' => $patient->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $relations++;
                }
            }
        }
        
        $this->line("   ✅ {$relations} nuove relazioni paziente-studio create");
    }

    /**
     * Crea appuntamenti per il sistema.
     */
    private function createAppointments(): void
    {
        $this->info('5. Creazione appuntamenti...');
        
        $targetAppointments = (int) $this->option('appointments');
        $existingAppointments = Appointment::count();
        
        if ($existingAppointments >= $targetAppointments && !$this->option('force')) {
            $this->line("   ℹ️  Appuntamenti sufficienti già presenti ({$existingAppointments})");
            return;
        }
        
        $appointmentsToCreate = $targetAppointments - $existingAppointments;
        if ($appointmentsToCreate > 0) {
            $doctors = Doctor::all();
            $patients = Patient::all();
            $studios = Studio::all();
            
            $bar = $this->output->createProgressBar($appointmentsToCreate);
            $bar->start();
            
            for ($i = 0; $i < $appointmentsToCreate; $i++) {
                $startsAt = fake()->dateTimeBetween('now', '+30 days');
                $endsAt = (clone $startsAt)->modify('+1 hour');
                
                Appointment::create([
                    'doctor_id' => $doctors->random()->id,
                    'patient_id' => $patients->random()->id,
                    'studio_id' => $studios->random()->id,
                    'title' => fake()->sentence(3),
                    'starts_at' => $startsAt,
                    'ends_at' => $endsAt,
                    'type' => fake()->randomElement(['consultation', 'cleaning', 'treatment', 'followup']),
                    'state' => fake()->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
                    'emergency' => fake()->boolean(10),
                    'notes' => fake()->optional(0.7)->sentence()
                ]);
                $bar->advance();
            }
            
            $bar->finish();
            $this->newLine();
            $this->line("   ✅ {$appointmentsToCreate} appuntamenti aggiuntivi creati");
        } else {
            $this->line("   ℹ️  Appuntamenti sufficienti già presenti ({$existingAppointments})");
        }
    }

    /**
     * Crea report per il sistema.
     */
    private function createReports(): void
    {
        $this->info('6. Creazione report...');
        
        $targetReports = (int) $this->option('reports');
        $existingReports = Report::count();
        
        if ($existingReports >= $targetReports && !$this->option('force')) {
            $this->line("   ℹ️  Report sufficienti già presenti ({$existingReports})");
            return;
        }
        
        $reportsToCreate = $targetReports - $existingReports;
        if ($reportsToCreate > 0) {
            $doctors = Doctor::all();
            $patients = Patient::all();
            
            $bar = $this->output->createProgressBar($reportsToCreate);
            $bar->start();
            
            for ($i = 0; $i < $reportsToCreate; $i++) {
                Report::create([
                    'patient_id' => $patients->random()->id,
                    'doctor_id' => $doctors->random()->id,
                    'type' => fake()->randomElement(['consultation', 'treatment', 'followup', 'emergency']),
                    'content' => fake()->paragraphs(3, true),
                    'date' => fake()->dateTimeBetween('-6 months', 'now')
                ]);
                $bar->advance();
            }
            
            $bar->finish();
            $this->newLine();
            $this->line("   ✅ {$reportsToCreate} report aggiuntivi creati");
        } else {
            $this->line("   ℹ️  Report sufficienti già presenti ({$existingReports})");
        }
    }

    /**
     * Verifica il popolamento finale del database.
     */
    private function verifyPopulation(): void
    {
        $this->info('7. Verifica finale...');
        
        $counts = [
            'Studi' => Studio::count(),
            'Dottori' => Doctor::count(),
            'Pazienti' => Patient::count(),
            'Appuntamenti' => Appointment::count(),
            'Report' => Report::count(),
            'Relazioni Studio-User' => DB::table('studio_user')->count()
        ];
        
        $this->table(['Entità', 'Conteggio'], collect($counts)->map(fn($count, $entity) => [$entity, $count]));
        
        $this->line("   ✅ Verifica completata");
    }
}
