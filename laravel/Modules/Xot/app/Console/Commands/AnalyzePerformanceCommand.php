<?php

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class AnalyzePerformanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xot:analyze-performance
                            {--module= : Nome del modulo da analizzare}
                            {--type=all : Tipo di analisi (autoloader, cache, queries, all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analizza le performance del modulo e identifica i colli di bottiglia';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $module = $this->option('module');
        $type = $this->option('type');

        $this->info('Analisi Performance il progetto');
        $this->newLine();

        if ($module) {
            $this->info("Analisi del modulo: {$module}");
        } else {
            $this->info("Analisi di tutti i moduli");
        }

        $this->newLine();

        if ($type === 'all' || $type === 'autoloader') {
            $this->analyzeAutoloader($module);
        }

        if ($type === 'all' || $type === 'cache') {
            $this->analyzeCache($module);
        }

        if ($type === 'all' || $type === 'queries') {
            $this->analyzeQueries($module);
        }

        return Command::SUCCESS;
    }

    /**
     * Analizza le performance dell'autoloader.
     *
     * @param string|null $module
     * @return void
     */
    protected function analyzeAutoloader(?string $module): void
    {
        $this->info('Analisi Autoloader:');
        $this->newLine();

        $basePath = base_path('laravel/Modules');

        if ($module) {
            $modulePath = $basePath . '/' . $module;
            $this->analyzeModuleAutoloader($module, $modulePath);
        } else {
            $modules = File::directories($basePath);

            foreach ($modules as $modulePath) {
                $moduleName = basename($modulePath);
                $this->analyzeModuleAutoloader($moduleName, $modulePath);
            }
        }
    }

    /**
     * Analizza l'autoloader di un modulo specifico.
     *
     * @param string $moduleName
     * @param string $modulePath
     * @return void
     */
    protected function analyzeModuleAutoloader(string $moduleName, string $modulePath): void
    {
        $this->info("Modulo: {$moduleName}");

        // Verifica problemi di case sensitivity
        $caseSensitivityIssues = $this->checkCaseSensitivity($modulePath);

        if (count($caseSensitivityIssues) > 0) {
            $this->error("Problemi di case sensitivity trovati:");

            foreach ($caseSensitivityIssues as $issue) {
                $this->line(" - {$issue}");
            }
        } else {
            $this->info("✓ Nessun problema di case sensitivity trovato");
        }

        // Verifica problemi di namespace
        $namespaceIssues = $this->checkNamespaces($modulePath, $moduleName);

        if (count($namespaceIssues) > 0) {
            $this->error("Problemi di namespace trovati:");

            foreach ($namespaceIssues as $issue) {
                $this->line(" - {$issue}");
            }
        } else {
            $this->info("✓ Nessun problema di namespace trovato");
        }

        $this->newLine();
    }

    /**
     * Verifica problemi di case sensitivity.
     *
     * @param string $modulePath
     * @return array
     */
    protected function checkCaseSensitivity(string $modulePath): array
    {
        $issues = [];

        // Directory standard che dovrebbero essere in lowercase
        $standardDirs = ['app', 'config', 'database', 'resources', 'routes', 'tests', 'views'];

        foreach ($standardDirs as $dir) {
            // Cerca directory con lo stesso nome ma case diversa
            $finder = new Finder();
            $finder->directories()->in($modulePath)->depth('< 2')->name('/^' . preg_quote($dir, '/') . '$/i');

            foreach ($finder as $directory) {
                $dirName = $directory->getRelativePathname();

                if ($dirName !== $dir) {
                    $issues[] = "Directory '{$dirName}' dovrebbe essere '{$dir}' (lowercase)";
                }
            }
        }

        return $issues;
    }

    /**
     * Verifica problemi di namespace.
     *
     * @param string $modulePath
     * @param string $moduleName
     * @return array
     */
    protected function checkNamespaces(string $modulePath, string $moduleName): array
    {
        $issues = [];

        // Cerca tutti i file PHP
        $finder = new Finder();
        $finder->files()->in($modulePath)->name('*.php');

        foreach ($finder as $file) {
            $content = $file->getContents();

            // Estrai il namespace
            if (preg_match('/namespace\s+([^;]+);/', $content, $matches)) {
                $namespace = $matches[1];

                // Verifica se il namespace contiene 'app'
                if (Str::contains($namespace, 'Modules\\' . $moduleName . '\\app\\')) {
                    $issues[] = "File {$file->getRelativePathname()} contiene 'app' nel namespace: {$namespace}";
                }

                // Verifica se il namespace rispetta la struttura delle directory
                $relativePath = $file->getRelativePathname();
                $expectedNamespacePath = str_replace(['/', '.php'], ['\\', ''], $relativePath);

                // Rimuovi il nome del file dal namespace atteso
                $expectedNamespacePath = substr($expectedNamespacePath, 0, strrpos($expectedNamespacePath, '\\'));

                // Costruisci il namespace atteso
                $expectedNamespace = 'Modules\\' . $moduleName . '\\' . $expectedNamespacePath;

                // Normalizza i namespace per il confronto
                $normalizedNamespace = str_replace('\\\\', '\\', $namespace);
                $normalizedExpectedNamespace = str_replace('\\\\', '\\', $expectedNamespace);

                // Confronta i namespace ignorando 'app/'
                $normalizedNamespace = str_replace('\\app\\', '\\', $normalizedNamespace);
                $normalizedExpectedNamespace = str_replace('\\app\\', '\\', $normalizedExpectedNamespace);

                if ($normalizedNamespace !== $normalizedExpectedNamespace && !Str::endsWith($file->getRelativePathname(), 'routes.php')) {
                    $issues[] = "File {$file->getRelativePathname()} ha namespace '{$namespace}' ma dovrebbe essere '{$expectedNamespace}'";
                }
            }
        }

        return $issues;
    }

    /**
     * Analizza le performance della cache.
     *
     * @param string|null $module
     * @return void
     */
    protected function analyzeCache(?string $module): void
    {
        $this->info('Analisi Cache:');
        $this->newLine();

        // Ottieni statistiche della cache
        $cacheDriver = config('cache.default');
        $this->info("Driver cache: {$cacheDriver}");

        if ($cacheDriver === 'redis') {
            $this->analyzeRedisCache();
        } elseif ($cacheDriver === 'file') {
            $this->analyzeFileCache();
        } else {
            $this->info("Analisi non disponibile per il driver {$cacheDriver}");
        }

        // Analizza l'utilizzo della cache nel codice
        $this->analyzeCacheUsage($module);

        $this->newLine();
    }

    /**
     * Analizza la cache Redis.
     *
     * @return void
     */
    protected function analyzeRedisCache(): void
    {
        try {
            $redis = app('redis')->connection();
            $info = $redis->info();

            $this->info("Statistiche Redis:");
            $this->line(" - Memoria utilizzata: " . $this->formatBytes($info['used_memory'] ?? 0));
            $this->line(" - Picco memoria: " . $this->formatBytes($info['used_memory_peak'] ?? 0));
            $this->line(" - Chiavi totali: " . ($info['db0']['keys'] ?? 0));
            $this->line(" - Hit ratio: " . $this->calculateHitRatio($info['keyspace_hits'] ?? 0, $info['keyspace_misses'] ?? 0));

            // Verifica chiavi cache che potrebbero causare problemi
            $keys = $redis->keys('*');
            $largeKeys = [];

            foreach ($keys as $key) {
                $type = $redis->type($key);

                if ($type === 'string') {
                    $size = $redis->strlen($key);

                    if ($size > 1024 * 1024) { // Maggiore di 1MB
                        $largeKeys[] = [
                            'key' => $key,
                            'size' => $this->formatBytes($size),
                            'ttl' => $redis->ttl($key)
                        ];
                    }
                }
            }

            if (count($largeKeys) > 0) {
                $this->warn("Chiavi cache di grandi dimensioni trovate:");

                foreach ($largeKeys as $key) {
                    $this->line(" - {$key['key']} ({$key['size']}, TTL: {$key['ttl']})");
                }
            }
        } catch (\Exception $e) {
            $this->error("Errore nell'analisi Redis: " . $e->getMessage());
        }
    }

    /**
     * Analizza la cache file.
     *
     * @return void
     */
    protected function analyzeFileCache(): void
    {
        $cachePath = config('cache.stores.file.path');

        if (!File::exists($cachePath)) {
            $this->error("Directory cache non trovata: {$cachePath}");
            return;
        }

        $files = File::files($cachePath);
        $totalSize = 0;
        $largeFiles = [];

        foreach ($files as $file) {
            $size = $file->getSize();
            $totalSize += $size;

            if ($size > 1024 * 1024) { // Maggiore di 1MB
                $largeFiles[] = [
                    'file' => $file->getFilename(),
                    'size' => $this->formatBytes($size)
                ];
            }
        }

        $this->info("Statistiche Cache File:");
        $this->line(" - File totali: " . count($files));
        $this->line(" - Dimensione totale: " . $this->formatBytes($totalSize));

        if (count($largeFiles) > 0) {
            $this->warn("File cache di grandi dimensioni trovati:");

            foreach ($largeFiles as $file) {
                $this->line(" - {$file['file']} ({$file['size']})");
            }
        }
    }

    /**
     * Analizza l'utilizzo della cache nel codice.
     *
     * @param string|null $module
     * @return void
     */
    protected function analyzeCacheUsage(?string $module): void
    {
        $this->info("Analisi utilizzo cache nel codice:");

        $basePath = base_path('laravel/Modules');

        if ($module) {
            $modulePath = $basePath . '/' . $module;
            $this->analyzeModuleCacheUsage($module, $modulePath);
        } else {
            $modules = File::directories($basePath);

            foreach ($modules as $modulePath) {
                $moduleName = basename($modulePath);
                $this->analyzeModuleCacheUsage($moduleName, $modulePath);
            }
        }
    }

    /**
     * Analizza l'utilizzo della cache in un modulo specifico.
     *
     * @param string $moduleName
     * @param string $modulePath
     * @return void
     */
    protected function analyzeModuleCacheUsage(string $moduleName, string $modulePath): void
    {
        $this->line("Modulo: {$moduleName}");

        // Cerca tutti i file PHP
        $finder = new Finder();
        $finder->files()->in($modulePath)->name('*.php');

        $cacheUsage = [
            'put' => 0,
            'get' => 0,
            'remember' => 0,
            'forget' => 0,
            'flush' => 0,
            'tags' => 0
        ];

        $flushUsage = [];

        foreach ($finder as $file) {
            $content = $file->getContents();

            // Conta le chiamate ai metodi della cache
            $cacheUsage['put'] += substr_count($content, 'cache()->put') + substr_count($content, 'Cache::put');
            $cacheUsage['get'] += substr_count($content, 'cache()->get') + substr_count($content, 'Cache::get');
            $cacheUsage['remember'] += substr_count($content, 'cache()->remember') + substr_count($content, 'Cache::remember');
            $cacheUsage['forget'] += substr_count($content, 'cache()->forget') + substr_count($content, 'Cache::forget');
            $cacheUsage['flush'] += substr_count($content, 'cache()->flush') + substr_count($content, 'Cache::flush');
            $cacheUsage['tags'] += substr_count($content, 'cache()->tags') + substr_count($content, 'Cache::tags');

            // Trova le chiamate a flush
            if (preg_match_all('/cache\(\)->flush\(\)|Cache::flush\(\)/', $content, $matches)) {
                $flushUsage[] = $file->getRelativePathname();
            }
        }

        $this->line(" - Chiamate put: {$cacheUsage['put']}");
        $this->line(" - Chiamate get: {$cacheUsage['get']}");
        $this->line(" - Chiamate remember: {$cacheUsage['remember']}");
        $this->line(" - Chiamate forget: {$cacheUsage['forget']}");
        $this->line(" - Chiamate flush: {$cacheUsage['flush']}");
        $this->line(" - Chiamate tags: {$cacheUsage['tags']}");

        if (count($flushUsage) > 0) {
            $this->warn("  Chiamate a flush() trovate nei seguenti file:");

            foreach ($flushUsage as $file) {
                $this->line("   - {$file}");
            }
        }

        // Suggerimenti per l'ottimizzazione
        if ($cacheUsage['flush'] > 0 && $cacheUsage['tags'] === 0) {
            $this->warn("  Suggerimento: Utilizzare cache()->tags() invece di cache()->flush() per invalidazioni più mirate");
        }

        if ($cacheUsage['get'] > $cacheUsage['remember'] * 2) {
            $this->warn("  Suggerimento: Considerare l'utilizzo di cache()->remember() invece di cache()->get() per ridurre le cache miss");
        }
    }

    /**
     * Analizza le performance delle query.
     *
     * @param string|null $module
     * @return void
     */
    protected function analyzeQueries(?string $module): void
    {
        $this->info('Analisi Query:');
        $this->newLine();

        // Abilita il log delle query
        DB::enableQueryLog();

        // Esegui alcune operazioni di base per analizzare le query
        $this->simulateBasicOperations($module);

        // Ottieni il log delle query
        $queries = DB::getQueryLog();

        // Analizza le query
        $this->analyzeQueryLog($queries);

        // Disabilita il log delle query
        DB::disableQueryLog();

        $this->newLine();
    }

    /**
     * Simula operazioni di base per analizzare le query.
     *
     * @param string|null $module
     * @return void
     */
    protected function simulateBasicOperations(?string $module): void
    {
        // Implementa simulazioni specifiche per modulo
        if ($module === 'User') {
            // Simula operazioni utente
            if (class_exists('\\Modules\\User\\Models\\User')) {
                $userClass = '\\Modules\\User\\Models\\User';
                $userClass::first();
                $userClass::count();
            }
        } elseif ($module === 'Patient') {
            // Simula operazioni paziente
            if (class_exists('\\Modules\\SaluteOra\\Models\\Patient')) {
                $patientClass = '\\Modules\\SaluteOra\\Models\\Patient';
                $patientClass::first();
                $patientClass::count();
            }
        } else {
            // Simula operazioni generiche
            if (class_exists('\\App\\Models\\User')) {
                \App\Models\User::first();
                \App\Models\User::count();
            }
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
        $this->info("Query eseguite: " . count($queries));

        $slowQueries = [];
        $duplicateQueries = [];
        $queryCount = [];

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

            // Conta query duplicate
            $queryKey = $sql . json_encode($bindings);

            if (!isset($queryCount[$queryKey])) {
                $queryCount[$queryKey] = [
                    'count' => 0,
                    'sql' => $this->interpolateQuery($sql, $bindings)
                ];
            }

            $queryCount[$queryKey]['count']++;
        }

        // Identifica query duplicate
        foreach ($queryCount as $key => $data) {
            if ($data['count'] > 1) {
                $duplicateQueries[] = [
                    'sql' => $data['sql'],
                    'count' => $data['count']
                ];
            }
        }

        // Mostra query lente
        if (count($slowQueries) > 0) {
            $this->warn("Query lente trovate:");

            foreach ($slowQueries as $query) {
                $this->line(" - {$query['time']}ms: {$query['sql']}");
            }
        }

        // Mostra query duplicate
        if (count($duplicateQueries) > 0) {
            $this->warn("Query duplicate trovate:");

            foreach ($duplicateQueries as $query) {
                $this->line(" - {$query['count']} volte: {$query['sql']}");
            }
        }

        // Suggerimenti per l'ottimizzazione
        if (count($duplicateQueries) > 0) {
            $this->info("Suggerimento: Utilizzare il caching per ridurre le query duplicate");
        }

        if (count($slowQueries) > 0) {
            $this->info("Suggerimento: Ottimizzare le query lente con indici appropriati o riscrivendole");
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

        return $sql;
    }

    /**
     * Formatta i bytes in una rappresentazione leggibile.
     *
     * @param int $bytes
     * @return string
     */
    protected function formatBytes(int $bytes): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($bytes, 1024));

        return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
    }

    /**
     * Calcola l'hit ratio della cache.
     *
     * @param int $hits
     * @param int $misses
     * @return string
     */
    protected function calculateHitRatio(int $hits, int $misses): string
    {
        $total = $hits + $misses;

        if ($total === 0) {
            return '0%';
        }

        $ratio = ($hits / $total) * 100;

        return round($ratio, 2) . '%';
    }
}
