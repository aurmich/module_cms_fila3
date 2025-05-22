<?php

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class AnalyzeNamingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xot:analyze-naming 
                            {--module= : Nome del modulo da analizzare}
                            {--type=all : Tipo di analisi (database, models, controllers, all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analizza la conformità alle convenzioni di naming in il progetto';

    /**
     * Convenzioni di naming da verificare.
     *
     * @var array
     */
    protected $namingConventions = [
        'person_fields' => [
            'incorrect' => ['name', 'surname'],
            'correct' => ['first_name', 'last_name'],
            'message' => 'I campi per i nomi delle persone devono essere first_name e last_name (mai name o surname)'
        ],
        'temporal_fields' => [
            'incorrect' => ['creation_date', 'update_date', 'deletion_date', 'date_of_birth', 'birthday'],
            'correct' => ['created_at', 'updated_at', 'deleted_at', 'birth_date'],
            'message' => 'I campi temporali devono seguire le convenzioni standard (created_at, birth_date, ecc.)'
        ],
        'foreign_keys' => [
            'incorrect' => ['/^id_[a-z]+/'],
            'correct' => ['/^[a-z]+_id$/'],
            'message' => 'Le chiavi esterne devono essere nel formato table_id (mai id_table)'
        ]
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $module = $this->option('module');
        $type = $this->option('type');

        $this->info('Analisi Convenzioni di Naming il progetto');
        $this->newLine();

        if ($module) {
            $this->info("Analisi del modulo: {$module}");
        } else {
            $this->info("Analisi di tutti i moduli");
        }

        $this->newLine();

        if ($type === 'all' || $type === 'database') {
            $this->analyzeDatabaseNaming($module);
        }

        if ($type === 'all' || $type === 'models') {
            $this->analyzeModelsNaming($module);
        }

        if ($type === 'all' || $type === 'controllers') {
            $this->analyzeControllersNaming($module);
        }

        return Command::SUCCESS;
    }

    /**
     * Analizza le convenzioni di naming nel database.
     *
     * @param string|null $module
     * @return void
     */
    protected function analyzeDatabaseNaming(?string $module): void
    {
        $this->info('Analisi Convenzioni di Naming nel Database:');
        $this->newLine();

        // Ottieni tutte le tabelle
        $tables = DB::select('SHOW TABLES');
        $tableColumn = 'Tables_in_' . config('database.connections.mysql.database');
        
        $moduleTables = [];
        
        // Filtra le tabelle per modulo se specificato
        if ($module) {
            foreach ($tables as $table) {
                $tableName = $table->$tableColumn;
                if (Str::startsWith($tableName, strtolower($module) . '_')) {
                    $moduleTables[] = $tableName;
                }
            }
        } else {
            foreach ($tables as $table) {
                $moduleTables[] = $table->$tableColumn;
            }
        }
        
        $this->line(" - Tabelle da analizzare: " . count($moduleTables));
        
        $issuesFound = [];
        
        foreach ($moduleTables as $table) {
            if (!Schema::hasTable($table)) {
                continue;
            }
            
            $columns = Schema::getColumnListing($table);
            $tableIssues = [];
            
            foreach ($columns as $column) {
                foreach ($this->namingConventions as $convention => $rules) {
                    // Verifica campi non conformi
                    if (in_array($column, $rules['incorrect'])) {
                        $tableIssues[] = [
                            'column' => $column,
                            'issue' => $rules['message'],
                            'correct' => $this->getCorrectField($column, $rules)
                        ];
                    }
                    
                    // Verifica pattern regex
                    foreach ($rules['incorrect'] as $pattern) {
                        if (Str::startsWith($pattern, '/') && preg_match($pattern, $column)) {
                            $tableIssues[] = [
                                'column' => $column,
                                'issue' => $rules['message'],
                                'correct' => $this->getCorrectFieldPattern($column, $rules)
                            ];
                        }
                    }
                }
            }
            
            if (count($tableIssues) > 0) {
                $issuesFound[$table] = $tableIssues;
            }
        }
        
        // Mostra problemi trovati
        if (count($issuesFound) > 0) {
            $this->warn(" - Problemi di naming trovati:");
            
            foreach ($issuesFound as $table => $issues) {
                $this->line("   Tabella: {$table}");
                
                foreach ($issues as $issue) {
                    $this->line("     - Colonna: {$issue['column']}");
                    $this->line("       Problema: {$issue['issue']}");
                    $this->line("       Correzione suggerita: {$issue['correct']}");
                }
            }
            
            // Suggerimenti per la correzione
            $this->info(" - Suggerimento: Creare una migrazione per rinominare le colonne non conformi");
            $this->line("   Esempio:");
            $this->line("   ```php");
            $this->line("   Schema::table('table_name', function (Blueprint \$table) {");
            $this->line("       \$table->renameColumn('name', 'first_name');");
            $this->line("       \$table->renameColumn('surname', 'last_name');");
            $this->line("   });");
            $this->line("   ```");
        } else {
            $this->info(" - Nessun problema di naming trovato nelle tabelle analizzate");
        }
        
        $this->newLine();
    }

    /**
     * Analizza le convenzioni di naming nei modelli.
     *
     * @param string|null $module
     * @return void
     */
    protected function analyzeModelsNaming(?string $module): void
    {
        $this->info('Analisi Convenzioni di Naming nei Modelli:');
        $this->newLine();

        $basePath = base_path('laravel/Modules');
        
        if ($module) {
            $modulePath = $basePath . '/' . $module;
            $this->analyzeModuleModelsNaming($module, $modulePath);
        } else {
            $modules = File::directories($basePath);
            
            foreach ($modules as $modulePath) {
                $moduleName = basename($modulePath);
                $this->analyzeModuleModelsNaming($moduleName, $modulePath);
            }
        }
    }

    /**
     * Analizza le convenzioni di naming nei modelli di un modulo specifico.
     *
     * @param string $moduleName
     * @param string $modulePath
     * @return void
     */
    protected function analyzeModuleModelsNaming(string $moduleName, string $modulePath): void
    {
        $this->info(" - Modulo: {$moduleName}");
        
        // Cerca tutti i file dei modelli
        $finder = new Finder();
        $modelsPath = $modulePath . '/Models';
        
        if (!File::exists($modelsPath)) {
            $this->line("   - Directory Models non trovata");
            $this->newLine();
            return;
        }
        
        $finder->files()->in($modelsPath)->name('*.php');
        
        if (!$finder->hasResults()) {
            $this->line("   - Nessun modello trovato");
            $this->newLine();
            return;
        }
        
        $issuesFound = [];
        
        foreach ($finder as $file) {
            $content = $file->getContents();
            $modelName = $file->getRelativePathname();
            $modelIssues = [];
            
            // Verifica fillable e casts
            foreach ($this->namingConventions as $convention => $rules) {
                foreach ($rules['incorrect'] as $incorrect) {
                    // Salta i pattern regex
                    if (Str::startsWith($incorrect, '/')) {
                        continue;
                    }
                    
                    // Cerca nei fillable
                    if (preg_match('/protected\s+\$fillable\s*=\s*\[(.*?)\]/s', $content, $matches)) {
                        $fillable = $matches[1];
                        
                        if (preg_match('/[\'"]' . preg_quote($incorrect, '/') . '[\'"]/', $fillable)) {
                            $modelIssues[] = [
                                'field' => $incorrect,
                                'location' => 'fillable',
                                'issue' => $rules['message'],
                                'correct' => $this->getCorrectField($incorrect, $rules)
                            ];
                        }
                    }
                    
                    // Cerca nei casts
                    if (preg_match('/protected\s+\$casts\s*=\s*\[(.*?)\]/s', $content, $matches)) {
                        $casts = $matches[1];
                        
                        if (preg_match('/[\'"]' . preg_quote($incorrect, '/') . '[\'"]/', $casts)) {
                            $modelIssues[] = [
                                'field' => $incorrect,
                                'location' => 'casts',
                                'issue' => $rules['message'],
                                'correct' => $this->getCorrectField($incorrect, $rules)
                            ];
                        }
                    }
                    
                    // Cerca negli accessors e mutators
                    $accessorPattern = '/function\s+get(' . ucfirst($incorrect) . ')Attribute/';
                    $mutatorPattern = '/function\s+set(' . ucfirst($incorrect) . ')Attribute/';
                    
                    if (preg_match($accessorPattern, $content) || preg_match($mutatorPattern, $content)) {
                        $modelIssues[] = [
                            'field' => $incorrect,
                            'location' => 'accessor/mutator',
                            'issue' => $rules['message'],
                            'correct' => $this->getCorrectField($incorrect, $rules)
                        ];
                    }
                }
            }
            
            if (count($modelIssues) > 0) {
                $issuesFound[$modelName] = $modelIssues;
            }
        }
        
        // Mostra problemi trovati
        if (count($issuesFound) > 0) {
            $this->warn("   - Problemi di naming trovati:");
            
            foreach ($issuesFound as $model => $issues) {
                $this->line("     Modello: {$model}");
                
                foreach ($issues as $issue) {
                    $this->line("       - Campo: {$issue['field']} ({$issue['location']})");
                    $this->line("         Problema: {$issue['issue']}");
                    $this->line("         Correzione suggerita: {$issue['correct']}");
                }
            }
            
            // Suggerimenti per la correzione
            $this->info("   - Suggerimento: Aggiornare i modelli per utilizzare i nomi dei campi corretti");
        } else {
            $this->info("   - Nessun problema di naming trovato nei modelli analizzati");
        }
        
        $this->newLine();
    }

    /**
     * Analizza le convenzioni di naming nei controller.
     *
     * @param string|null $module
     * @return void
     */
    protected function analyzeControllersNaming(?string $module): void
    {
        $this->info('Analisi Convenzioni di Naming nei Controller:');
        $this->newLine();

        $basePath = base_path('laravel/Modules');
        
        if ($module) {
            $modulePath = $basePath . '/' . $module;
            $this->analyzeModuleControllersNaming($module, $modulePath);
        } else {
            $modules = File::directories($basePath);
            
            foreach ($modules as $modulePath) {
                $moduleName = basename($modulePath);
                $this->analyzeModuleControllersNaming($moduleName, $modulePath);
            }
        }
    }

    /**
     * Analizza le convenzioni di naming nei controller di un modulo specifico.
     *
     * @param string $moduleName
     * @param string $modulePath
     * @return void
     */
    protected function analyzeModuleControllersNaming(string $moduleName, string $modulePath): void
    {
        $this->info(" - Modulo: {$moduleName}");
        
        // Cerca tutti i file dei controller
        $finder = new Finder();
        $controllersPath = $modulePath . '/Http/Controllers';
        
        if (!File::exists($controllersPath)) {
            $this->line("   - Directory Controllers non trovata");
            $this->newLine();
            return;
        }
        
        $finder->files()->in($controllersPath)->name('*Controller.php');
        
        if (!$finder->hasResults()) {
            $this->line("   - Nessun controller trovato");
            $this->newLine();
            return;
        }
        
        $issuesFound = [];
        
        foreach ($finder as $file) {
            $content = $file->getContents();
            $controllerName = $file->getRelativePathname();
            $controllerIssues = [];
            
            // Verifica utilizzo di campi non conformi
            foreach ($this->namingConventions as $convention => $rules) {
                foreach ($rules['incorrect'] as $incorrect) {
                    // Salta i pattern regex
                    if (Str::startsWith($incorrect, '/')) {
                        continue;
                    }
                    
                    // Cerca nei parametri dei metodi e nelle variabili
                    $paramPattern = '/function\s+\w+\s*\([^)]*\$' . preg_quote($incorrect, '/') . '[,\s\)]/';
                    $varPattern = '/\$' . preg_quote($incorrect, '/') . '\s*=/';
                    $requestPattern = '/\$request\s*->\s*' . preg_quote($incorrect, '/') . '/';
                    
                    if (preg_match($paramPattern, $content) || 
                        preg_match($varPattern, $content) || 
                        preg_match($requestPattern, $content)) {
                        $controllerIssues[] = [
                            'field' => $incorrect,
                            'issue' => $rules['message'],
                            'correct' => $this->getCorrectField($incorrect, $rules)
                        ];
                    }
                }
            }
            
            if (count($controllerIssues) > 0) {
                $issuesFound[$controllerName] = $controllerIssues;
            }
        }
        
        // Mostra problemi trovati
        if (count($issuesFound) > 0) {
            $this->warn("   - Problemi di naming trovati:");
            
            foreach ($issuesFound as $controller => $issues) {
                $this->line("     Controller: {$controller}");
                
                foreach ($issues as $issue) {
                    $this->line("       - Campo: {$issue['field']}");
                    $this->line("         Problema: {$issue['issue']}");
                    $this->line("         Correzione suggerita: {$issue['correct']}");
                }
            }
            
            // Suggerimenti per la correzione
            $this->info("   - Suggerimento: Aggiornare i controller per utilizzare i nomi dei campi corretti");
        } else {
            $this->info("   - Nessun problema di naming trovato nei controller analizzati");
        }
        
        $this->newLine();
    }

    /**
     * Ottiene il campo corretto per un campo non conforme.
     *
     * @param string $incorrectField
     * @param array $rules
     * @return string
     */
    protected function getCorrectField(string $incorrectField, array $rules): string
    {
        $index = array_search($incorrectField, $rules['incorrect']);
        
        if ($index !== false && isset($rules['correct'][$index])) {
            return $rules['correct'][$index];
        }
        
        // Casi specifici
        if ($incorrectField === 'name') {
            return 'first_name';
        } elseif ($incorrectField === 'surname') {
            return 'last_name';
        }
        
        return 'campo conforme alle convenzioni';
    }

    /**
     * Ottiene il campo corretto per un pattern non conforme.
     *
     * @param string $incorrectField
     * @param array $rules
     * @return string
     */
    protected function getCorrectFieldPattern(string $incorrectField, array $rules): string
    {
        // Casi specifici per pattern regex
        if (preg_match('/^id_([a-z]+)$/', $incorrectField, $matches)) {
            return $matches[1] . '_id';
        }
        
        return 'campo conforme alle convenzioni';
    }
}
