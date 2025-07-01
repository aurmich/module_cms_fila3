<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Services\PatientAnalysisService;
use function Safe\preg_match_all;
use function Safe\file_get_contents;
use function Safe\preg_match;
use function Safe\preg_replace;

class AnalyzePatientDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patient:analyze 
                            {--type=all : Tipo di analisi (medical-records, appointments, search, all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analizza le performance del modulo Patient e identifica i colli di bottiglia';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $type = $this->option('type');

        $this->info('Analisi Performance Modulo Patient');
        $this->newLine();

        if ($type === 'all' || $type === 'medical-records') {
            $this->analyzeMedicalRecords();
        }

        if ($type === 'all' || $type === 'appointments') {
            $this->analyzeAppointments();
        }

        if ($type === 'all' || $type === 'search') {
            $this->analyzeSearch();
        }

        return Command::SUCCESS;
    }

    /**
     * Analizza le performance delle cartelle cliniche.
     *
     * @return void
     */
    protected function analyzeMedicalRecords(): void
    {
        $this->info('Analisi Cartelle Cliniche:');
        $this->newLine();

        // Verifica se la tabella esiste
        if (!Schema::hasTable('medical_records')) {
            $this->warn(" - Tabella medical_records non trovata");
            $this->newLine();
            return;
        }

        // Analizza la struttura della tabella
        $this->analyzeTableStructure('medical_records');

        // Analizza le relazioni
        $this->analyzeMedicalRecordRelations();

        // Analizza le query
        $this->analyzeMedicalRecordQueries();

        $this->newLine();
    }

    /**
     * Analizza la struttura di una tabella.
     *
     * @param string $tableName
     * @return void
     */
    protected function analyzeTableStructure(string $tableName): void
    {
        $this->info(" - Struttura Tabella {$tableName}:");

        // Ottieni le colonne della tabella
        $columns = Schema::getColumnListing($tableName);

        // Ottieni gli indici della tabella
        $indexes = DB::select("SHOW INDEXES FROM {$tableName}");
        $indexedColumns = array_map(function ($index) {
            return $index->Column_name;
        }, $indexes);

        // Verifica colonne senza indici
        $columnsWithoutIndex = array_filter($columns, function ($column) use ($indexedColumns) {
            // Colonne che potrebbero necessitare di un indice
            $potentialIndexColumns = ['patient_id', 'doctor_id', 'created_at', 'updated_at', 'date', 'status'];
            return in_array($column, $potentialIndexColumns) && !in_array($column, $indexedColumns);
        });

        // Mostra informazioni sulla tabella
        $this->line("   - Colonne totali: " . count($columns));
        $this->line("   - Indici totali: " . count($indexes));

        // Mostra colonne senza indici
        if (count($columnsWithoutIndex) > 0) {
            $this->warn("   - Colonne che potrebbero necessitare di un indice:");

            foreach ($columnsWithoutIndex as $column) {
                $this->line("     - {$column}");
            }
        }

        // Suggerimenti per l'ottimizzazione
        if (count($columnsWithoutIndex) > 0) {
            $this->info("   - Suggerimento: Aggiungere indici alle colonne frequentemente utilizzate nelle query");
        }
    }

    /**
     * Analizza le relazioni delle cartelle cliniche.
     *
     * @return void
     */
    protected function analyzeMedicalRecordRelations(): void
    {
        $this->info(" - Analisi Relazioni Cartelle Cliniche:");

        // Cerca il modello MedicalRecord
        $finder = new Finder();
        $basePath = base_path('laravel/Modules/Patient');
        $finder->files()->in($basePath)->path('Models')->name('MedicalRecord.php');

        if (!$finder->hasResults()) {
            $this->warn("   - Modello MedicalRecord non trovato");
            return;
        }

        $relations = [];
        $eagerLoadingIssues = [];

        foreach ($finder as $file) {
            $content = $file->getContents();

            // Estrai le relazioni
            preg_match_all('/public\s+function\s+([a-zA-Z0-9_]+)\s*\(\s*\)\s*{.*?return\s+\$this->(hasMany|hasOne|belongsTo|belongsToMany|morphTo|morphMany|morphToMany)\s*\(/s', $content, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $relationName = $match[1];
                $relationType = $match[2];

                $relations[] = [
                    'first_name' => $relationName,
                    'type' => $relationType
                ];
            }

            // Verifica problemi di eager loading
            $controllers = $this->findControllers();

            foreach ($controllers as $controller) {
                $controllerContent = file_get_contents($controller);

                // Cerca query che potrebbero causare N+1
                if (preg_match('/MedicalRecord::find\(|MedicalRecord::where\(|MedicalRecord::first\(/', $controllerContent) &&
                    !preg_match('/with\([\'"]' . implode('[\'"]|[\'"]', array_column($relations, 'first_name')) . '[\'"]/', $controllerContent)) {
                    $eagerLoadingIssues[] = $controller;
                }
            }
        }

        // Mostra informazioni sulle relazioni
        $this->line("   - Relazioni totali: " . count($relations));

        foreach ($relations as $relation) {
            $this->line("     - {$relation['first_name']} ({$relation['type']})");
        }

        // Mostra problemi di eager loading
        if (count($eagerLoadingIssues) > 0) {
            $this->warn("   - Controller con potenziali problemi N+1:");

            foreach ($eagerLoadingIssues as $controller) {
                $this->line("     - " . basename($controller));
            }
        }

        // Suggerimenti per l'ottimizzazione
        if (count($eagerLoadingIssues) > 0) {
            $this->info("   - Suggerimento: Utilizzare eager loading (with()) per caricare le relazioni necessarie");
        }

        if (count($relations) > 5) {
            $this->info("   - Suggerimento: Considerare l'utilizzo di lazy loading selettivo per relazioni pesanti");
        }
    }

    /**
     * Trova i controller nel modulo Patient.
     *
     * @return array
     */
    protected function findControllers(): array
    {
        $finder = new Finder();
        $basePath = base_path('laravel/Modules/Patient');
        $finder->files()->in($basePath)->path('Http/Controllers')->name('*Controller.php');

        $controllers = [];

        foreach ($finder as $file) {
            $controllers[] = $file->getRealPath();
        }

        return $controllers;
    }

    /**
     * Analizza le query delle cartelle cliniche.
     *
     * @return void
     */
    protected function analyzeMedicalRecordQueries(): void
    {
        $this->info(" - Analisi Query Cartelle Cliniche:");

        // Abilita il log delle query
        DB::enableQueryLog();

        // Simula alcune query tipiche
        $this->simulateMedicalRecordQueries();

        // Ottieni il log delle query
        $queries = DB::getQueryLog();

        // Analizza le query
        $this->analyzeQueryLog($queries);

        // Disabilita il log delle query
        DB::disableQueryLog();
    }

    /**
     * Simula query tipiche per le cartelle cliniche.
     *
     * @return void
     */
    protected function simulateMedicalRecordQueries(): void
    {
        // Verifica se la tabella esiste
        if (!Schema::hasTable('medical_records')) {
            return;
        }

        // Simula query di base
        DB::table('medical_records')->limit(1)->get();
        DB::table('medical_records')->orderBy('created_at', 'desc')->limit(10)->get();

        // Simula query con join
        if (Schema::hasTable('patients') && Schema::hasTable('doctors')) {
            DB::table('medical_records')
                ->join('patients', 'medical_records.patient_id', '=', 'patients.id')
                ->join('doctors', 'medical_records.doctor_id', '=', 'doctors.id')
                ->select('medical_records.*', 'patients.first_name as patient_first_name', 'doctors.first_name as doctor_first_name')
                ->limit(10)
                ->get();
        }

        // Simula query con where
        DB::table('medical_records')
            ->where('created_at', '>=', now()->subDays(30))
            ->get();
    }

    /**
     * Analizza le performance degli appuntamenti.
     *
     * @return void
     */
    protected function analyzeAppointments(): void
    {
        $this->info('Analisi Appuntamenti:');
        $this->newLine();

        // Verifica se la tabella esiste
        if (!Schema::hasTable('appointments')) {
            $this->warn(" - Tabella appointments non trovata");
            $this->newLine();
            return;
        }

        // Analizza la struttura della tabella
        $this->analyzeTableStructure('appointments');

        // Analizza le query
        $this->analyzeAppointmentQueries();

        // Analizza i conflitti di orario
        $this->analyzeTimeConflicts();

        $this->newLine();
    }

    /**
     * Analizza le query degli appuntamenti.
     *
     * @return void
     */
    protected function analyzeAppointmentQueries(): void
    {
        $this->info(" - Analisi Query Appuntamenti:");

        // Abilita il log delle query
        DB::enableQueryLog();

        // Simula alcune query tipiche
        $this->simulateAppointmentQueries();

        // Ottieni il log delle query
        $queries = DB::getQueryLog();

        // Analizza le query
        $this->analyzeQueryLog($queries);

        // Disabilita il log delle query
        DB::disableQueryLog();
    }

    /**
     * Simula query tipiche per gli appuntamenti.
     *
     * @return void
     */
    protected function simulateAppointmentQueries(): void
    {
        // Verifica se la tabella esiste
        if (!Schema::hasTable('appointments')) {
            return;
        }

        // Simula query di base
        DB::table('appointments')->limit(1)->get();
        DB::table('appointments')->orderBy('appointment_date', 'desc')->limit(10)->get();

        // Simula query con join
        if (Schema::hasTable('patients') && Schema::hasTable('doctors')) {
            DB::table('appointments')
                ->join('patients', 'appointments.patient_id', '=', 'patients.id')
                ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
                ->select('appointments.*', 'patients.first_name as patient_first_name', 'doctors.first_name as doctor_first_name')
                ->limit(10)
                ->get();
        }

        // Simula query per disponibilità
        DB::table('appointments')
            ->where('doctor_id', 1)
            ->where('appointment_date', '=', now()->format('Y-m-d'))
            ->get();
    }

    /**
     * Analizza i conflitti di orario negli appuntamenti.
     *
     * @return void
     */
    protected function analyzeTimeConflicts(): void
    {
        $this->info(" - Analisi Conflitti di Orario:");

        // Verifica se la tabella esiste
        if (!Schema::hasTable('appointments')) {
            $this->warn("   - Tabella appointments non trovata");
            return;
        }

        // Cerca potenziali conflitti di orario
        $conflicts = DB::table('appointments as a1')
            ->join('appointments as a2', function ($join) {
                $join->on('a1.doctor_id', '=', 'a2.doctor_id')
                    ->on('a1.appointment_date', '=', 'a2.appointment_date')
                    ->on('a1.id', '<>', 'a2.id');
            })
            ->whereRaw('(a1.start_time < a2.end_time AND a1.end_time > a2.start_time)')
            ->select('a1.id as id1', 'a2.id as id2', 'a1.doctor_id', 'a1.appointment_date', 'a1.start_time', 'a1.end_time', 'a2.start_time as start_time2', 'a2.end_time as end_time2')
            ->limit(10)
            ->get();

        // Mostra informazioni sui conflitti
        $this->line("   - Conflitti potenziali trovati: " . count($conflicts));

        if (count($conflicts) > 0) {
            $this->warn("   - Dettagli conflitti:");

            foreach ($conflicts as $conflict) {
                $this->line("     - Doctor ID: {$conflict->doctor_id}, Data: {$conflict->appointment_date}");
                $this->line("       Appuntamento 1: {$conflict->start_time} - {$conflict->end_time}");
                $this->line("       Appuntamento 2: {$conflict->start_time2} - {$conflict->end_time2}");
            }
        }

        // Verifica se esistono vincoli di unicità
        $hasUniqueConstraint = false;
        $indexes = DB::select("SHOW INDEXES FROM appointments");

        foreach ($indexes as $index) {
            if ($index->Key_name === 'doctor_date_time_unique' || $index->Key_name === 'doctor_date_time') {
                $hasUniqueConstraint = true;
                break;
            }
        }

        if (!$hasUniqueConstraint) {
            $this->warn("   - Nessun vincolo di unicità trovato per prevenire conflitti di orario");
        }

        // Suggerimenti per l'ottimizzazione
        if (count($conflicts) > 0 || !$hasUniqueConstraint) {
            $this->info("   - Suggerimento: Implementare un vincolo di unicità o un lock per prevenire conflitti di orario");
            $this->info("   - Suggerimento: Utilizzare una transazione durante la prenotazione per verificare la disponibilità");
        }
    }

    /**
     * Analizza le performance della ricerca pazienti.
     *
     * @return void
     */
    protected function analyzeSearch(): void
    {
        $this->info('Analisi Ricerca Pazienti:');
        $this->newLine();

        // Verifica se la tabella esiste
        if (!Schema::hasTable('patients')) {
            $this->warn(" - Tabella patients non trovata");
            $this->newLine();
            return;
        }

        // Analizza gli indici di ricerca
        $this->analyzeSearchIndexes();

        // Analizza le query di ricerca
        $this->analyzeSearchQueries();

        $this->newLine();
    }

    /**
     * Analizza gli indici di ricerca.
     *
     * @return void
     */
    protected function analyzeSearchIndexes(): void
    {
        $this->info(" - Analisi Indici di Ricerca:");

        // Ottieni gli indici della tabella
        $indexes = DB::select("SHOW INDEXES FROM patients");
        $fullTextIndexes = array_filter($indexes, function ($index) {
            return $index->Index_type === 'FULLTEXT';
        });

        // Verifica colonne comunemente cercate
        $searchableColumns = ['first_name', 'last_name', 'fiscal_code', 'email', 'phone'];
        $indexedColumns = array_map(function ($index) {
            return $index->Column_name;
        }, $indexes);

        $nonIndexedSearchColumns = array_filter($searchableColumns, function ($column) use ($indexedColumns) {
            return !in_array($column, $indexedColumns);
        });

        // Mostra informazioni sugli indici
        $this->line("   - Indici totali: " . count($indexes));
        $this->line("   - Indici FULLTEXT: " . count($fullTextIndexes));

        // Mostra colonne di ricerca senza indici
        if (count($nonIndexedSearchColumns) > 0) {
            $this->warn("   - Colonne di ricerca senza indici:");

            foreach ($nonIndexedSearchColumns as $column) {
                $this->line("     - {$column}");
            }
        }

        // Verifica se esiste un indice FULLTEXT combinato
        $hasFullTextCombined = false;

        foreach ($fullTextIndexes as $index) {
            if (count(array_intersect([$index->Column_name], $searchableColumns)) > 0) {
                $hasFullTextCombined = true;
                break;
            }
        }

        if (!$hasFullTextCombined && count($fullTextIndexes) === 0) {
            $this->warn("   - Nessun indice FULLTEXT combinato trovato per le colonne di ricerca");
        }

        // Suggerimenti per l'ottimizzazione
        if (count($nonIndexedSearchColumns) > 0) {
            $this->info("   - Suggerimento: Aggiungere indici alle colonne di ricerca frequentemente utilizzate");
        }

        if (!$hasFullTextCombined) {
            $this->info("   - Suggerimento: Implementare un indice FULLTEXT combinato per migliorare le performance di ricerca");
            $this->line("     ALTER TABLE patients ADD FULLTEXT search_index (first_name, last_name, fiscal_code, email)");
        }
    }

    /**
     * Analizza le query di ricerca.
     *
     * @return void
     */
    protected function analyzeSearchQueries(): void
    {
        $this->info(" - Analisi Query di Ricerca:");

        // Abilita il log delle query
        DB::enableQueryLog();

        // Simula alcune query di ricerca tipiche
        $this->simulateSearchQueries();

        // Ottieni il log delle query
        $queries = DB::getQueryLog();

        // Analizza le query
        $this->analyzeQueryLog($queries);

        // Disabilita il log delle query
        DB::disableQueryLog();

        // Analizza i controller per verificare l'uso di ricerca ottimizzata
        $this->analyzeSearchControllers();
    }

    /**
     * Simula query di ricerca tipiche.
     *
     * @return void
     */
    protected function simulateSearchQueries(): void
    {
        // Verifica se la tabella esiste
        if (!Schema::hasTable('patients')) {
            return;
        }

        // Simula ricerca base (potenzialmente inefficiente)
        DB::table('patients')
            ->where('first_name', 'like', '%test%')
            ->orWhere('last_name', 'like', '%test%')
            ->orWhere('fiscal_code', 'like', '%test%')
            ->limit(10)
            ->get();

        // Simula ricerca con FULLTEXT (più efficiente)
        try {
            DB::table('patients')
                ->whereRaw("MATCH(first_name, last_name, fiscal_code) AGAINST(? IN BOOLEAN MODE)", ['test'])
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            // Ignora errori se l'indice FULLTEXT non esiste
        }
    }

    /**
     * Analizza i controller per verificare l'uso di ricerca ottimizzata.
     *
     * @return void
     */
    protected function analyzeSearchControllers(): void
    {
        // Cerca controller con funzionalità di ricerca
        $finder = new Finder();
        $basePath = base_path('laravel/Modules/Patient');
        $finder->files()->in($basePath)->path('Http/Controllers')->name('*Controller.php');

        $controllers = [];
        $inefficientSearches = [];
        $hasScoutIntegration = false;

        foreach ($finder as $file) {
            $content = $file->getContents();
            $controllerName = $file->getRelativePathname();

            // Verifica se il controller contiene funzionalità di ricerca
            if (preg_match('/search|find|filter/i', $content)) {
                $controllers[] = $controllerName;

                // Verifica se utilizza ricerca inefficiente
                if (preg_match('/like\s*\(\s*[\'"]%.*?%[\'"]\s*\)/', $content)) {
                    $inefficientSearches[] = $controllerName;
                }

                // Verifica se utilizza Laravel Scout
                if (preg_match('/use Laravel\\\\Scout|Searchable/', $content)) {
                    $hasScoutIntegration = true;
                }
            }
        }

        // Mostra informazioni sui controller
        $this->line("   - Controller con funzionalità di ricerca: " . count($controllers));

        // Mostra controller con ricerca inefficiente
        if (count($inefficientSearches) > 0) {
            $this->warn("   - Controller con ricerca potenzialmente inefficiente:");

            foreach ($inefficientSearches as $controller) {
                $this->line("     - {$controller}");
            }
        }

        // Verifica integrazione con Laravel Scout
        if (!$hasScoutIntegration && count($controllers) > 0) {
            $this->warn("   - Nessuna integrazione con Laravel Scout trovata");
        }

        // Suggerimenti per l'ottimizzazione
        if (count($inefficientSearches) > 0) {
            $this->info("   - Suggerimento: Utilizzare FULLTEXT o Laravel Scout invece di LIKE con wildcards");
        }

        if (!$hasScoutIntegration && count($controllers) > 0) {
            $this->info("   - Suggerimento: Considerare l'integrazione con Laravel Scout per ricerche più efficienti");
        }
    }

    /**
     * Analizza il log delle query.
     *
     * @param array $queries
     * @return void
     */
    protected function analyzeQueryLog(array $queries): void
    {
        $this->line("   - Query eseguite: " . count($queries));

        $slowQueries = [];
        $nonOptimizedQueries = [];

        foreach ($queries as $query) {
            $sql = $query['query'];
            $bindings = $query['bindings'];
            $time = $query['time'];

            // Identifica query lente
            if ($time > 100) { // Più di 100ms
                $slowQueries[] = [
                    'sql' => $this->interpolateQuery($sql, $bindings),
                    'time' => $time
                ];
            }

            // Identifica query non ottimizzate
            if (strpos($sql, 'like ?') !== false && strpos($bindings[0] ?? '', '%') === 0) {
                $nonOptimizedQueries[] = $this->interpolateQuery($sql, $bindings);
            }
        }

        // Mostra query lente
        if (count($slowQueries) > 0) {
            $this->warn("   - Query lente trovate:");

            foreach ($slowQueries as $query) {
                $this->line("     - {$query['time']}ms: {$query['sql']}");
            }
        }

        // Mostra query non ottimizzate
        if (count($nonOptimizedQueries) > 0) {
            $this->warn("   - Query potenzialmente non ottimizzate:");

            foreach ($nonOptimizedQueries as $query) {
                $this->line("     - {$query}");
            }
        }

        // Suggerimenti per l'ottimizzazione
        if (count($nonOptimizedQueries) > 0) {
            $this->info("   - Suggerimento: Evitare LIKE con wildcard all'inizio ('%text') poiché non può utilizzare gli indici");
        }

        if (count($slowQueries) > 0) {
            $this->info("   - Suggerimento: Ottimizzare le query lente con indici appropriati o riscrivendole");
        }
    }

    /**
     * Interpola i parametri nella query SQL.
     *
     * @param string $query
     * @param array $bindings
     * @return string
     */
    protected function interpolateQuery(string $query, array $bindings): string
    {
        $sql = $query;

        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }

        return $sql ?? $query;
    }
}
