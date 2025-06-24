<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use function Laravel\Folio\{name};
use Livewire\Volt\Component;
use Webmozart\Assert\Assert;

/**
 * Power-ups management component for Genesis framework integration.
 * 
 * Gestisce il caricamento, visualizzazione e installazione dei power-ups
 * seguendo i pattern di qualità PHPStan livello 10 e le best practice del modulo User.
 * Implementa la Generic Moderation Strategy con activity logging e error handling robusto.
 * 
 * @property array<int, mixed> $powerups
 * @property array<int, mixed>|null $powerupsJSON
 */
$component = new class extends Component
{
    /** 
     * Lista dei power-ups caricati dal file JSON.
     * 
     * @var array<int, mixed> 
     */
    public array $powerups = [];
    
    /** 
     * Dati JSON raw dei power-ups per debugging.
     * 
     * @var array<int, mixed>|null 
     */
    public ?array $powerupsJSON = null;

    /**
     * Timeout per operazioni HTTP (sicurezza).
     */
    private const HTTP_TIMEOUT = 30;

    /**
     * Path base per i file Genesis.
     */
    private const GENESIS_BASE_PATH = '/genesis';

    /**
     * Inizializza la componente e carica i dati dei power-ups.
     * Implementa error handling robusto e activity logging.
     * 
     * @return void
     */
    public function mount(): void
    {
        try {
            $this->loadPowerupsConfiguration();
            
            // Activity logging per audit trail
            activity()
                ->withProperties([
                    'powerups_count' => count($this->powerups),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ])
                ->log('Power-ups component mounted successfully');
                
        } catch (\Exception $e) {
            Log::error('Power-ups component mount failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => request()->ip(),
            ]);
            
            // Fallback sicuro
            $this->powerups = [];
            $this->powerupsJSON = null;
            
            session()->flash('error', 'Errore nel caricamento dei power-ups: ' . $e->getMessage());
        }
    }

    /**
     * Carica la configurazione dei power-ups dal file JSON.
     * Implementa validazione rigorosa e gestione errori.
     * 
     * @return void
     * @throws \InvalidArgumentException
     */
    private function loadPowerupsConfiguration(): void
    {
        $filePath = public_path(self::GENESIS_BASE_PATH . '/power-ups.json');
        
        if (!File::exists($filePath)) {
            Log::warning('Power-ups JSON file not found', ['path' => $filePath]);
            throw new \InvalidArgumentException("Power-ups configuration file not found at: {$filePath}");
        }

        try {
            $jsonContent = File::get($filePath);
            Assert::string($jsonContent);
            Assert::stringNotEmpty($jsonContent, 'Power-ups JSON file is empty');
            
            $decoded = json_decode($jsonContent, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \InvalidArgumentException('Invalid JSON in power-ups file: ' . json_last_error_msg());
            }
            
            Assert::isArray($decoded, 'Power-ups JSON must decode to an array');
            
            // Validazione struttura JSON
            $this->validatePowerupsStructure($decoded);
            
            /** @var array<int, mixed> $validatedPowerups */
            $validatedPowerups = $decoded;
            
            $this->powerupsJSON = $validatedPowerups;
            $this->powerups = $this->processPowerupsData($validatedPowerups);
            
            Log::info('Power-ups configuration loaded successfully', [
                'count' => count($this->powerups),
                'file_path' => $filePath,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to load power-ups configuration', [
                'error' => $e->getMessage(),
                'file_path' => $filePath,
                'trace' => $e->getTraceAsString(),
            ]);
            
            throw $e;
        }
    }

    /**
     * Valida la struttura dei dati power-ups.
     * Implementa validazione type-safe seguendo PHPStan level 10.
     * 
     * @param array<mixed> $data
     * @return void
     * @throws \InvalidArgumentException
     */
    private function validatePowerupsStructure(array $data): void
    {
        foreach ($data as $index => $powerup) {
            Assert::isArray($powerup, "Power-up at index {$index} must be an array");
            
            // Validazione campi obbligatori
            $requiredFields = ['name', 'description', 'version', 'repository'];
            foreach ($requiredFields as $field) {
                Assert::keyExists($powerup, $field, "Power-up at index {$index} missing required field: {$field}");
                Assert::stringNotEmpty($powerup[$field], "Power-up field {$field} cannot be empty at index {$index}");
            }
            
            // Validazione campi opzionali con tipi corretti
            if (isset($powerup['dependencies'])) {
                Assert::isArray($powerup['dependencies'], "Dependencies must be an array at index {$index}");
            }
            
            if (isset($powerup['commands'])) {
                Assert::isArray($powerup['commands'], "Commands must be an array at index {$index}");
            }
        }
    }

    /**
     * Processa i dati dei power-ups per l'utilizzo nell'interfaccia.
     * Implementa sanitizzazione e arricchimento dati.
     * 
     * @param array<int, mixed> $rawData
     * @return array<int, mixed>
     */
    private function processPowerupsData(array $rawData): array
    {
        /** @var array<int, mixed> $processed */
        $processed = [];
        
        foreach ($rawData as $index => $powerup) {
            try {
                Assert::isArray($powerup);
                
                /** @var array<string, mixed> $processedPowerup */
                $processedPowerup = [
                    'id' => $index,
                    'name' => trim((string)$powerup['name']),
                    'description' => trim((string)$powerup['description']),
                    'version' => trim((string)$powerup['version']),
                    'repository' => trim((string)$powerup['repository']),
                    'dependencies' => $powerup['dependencies'] ?? [],
                    'commands' => $powerup['commands'] ?? [],
                    'status' => 'available',
                    'installed' => false,
                ];
                
                // Verifica se il power-up è già installato
                $processedPowerup['installed'] = $this->checkPowerupInstallation($processedPowerup['name']);
                $processedPowerup['status'] = $processedPowerup['installed'] ? 'installed' : 'available';
                
                $processed[] = $processedPowerup;
                
            } catch (\Exception $e) {
                Log::warning('Failed to process power-up', [
                    'index' => $index,
                    'error' => $e->getMessage(),
                    'powerup' => $powerup,
                ]);
                
                // Continua con il prossimo power-up invece di fallire completamente
                continue;
            }
        }
        
        return $processed;
    }

    /**
     * Verifica se un power-up è già installato nel sistema.
     * Implementa controlli sicuri per evitare false positive.
     * 
     * @param string $powerupName
     * @return bool
     */
    private function checkPowerupInstallation(string $powerupName): bool
    {
        try {
            Assert::stringNotEmpty($powerupName);
            
            // Controlla se esiste una cartella del modulo
            $modulePath = base_path("Modules/{$powerupName}");
            
            if (File::isDirectory($modulePath)) {
                // Verifica ulteriore: controlla se esiste il file composer.json del modulo
                $composerPath = $modulePath . '/composer.json';
                return File::exists($composerPath);
            }
            
            return false;
            
        } catch (\Exception $e) {
            Log::warning('Failed to check power-up installation', [
                'powerup_name' => $powerupName,
                'error' => $e->getMessage(),
            ]);
            
            return false;
        }
    }

    /**
     * Installa un power-up specifico.
     * Implementa processo di installazione sicuro con timeout e rollback.
     * 
     * @param array<string, mixed> $powerup
     * @return void
     */
    public function installPowerup(array $powerup): void
    {
        try {
            Assert::keyExists($powerup, 'name');
            Assert::keyExists($powerup, 'repository');
            
            /** @var string $name */
            $name = $powerup['name'];
            /** @var string $repository */
            $repository = $powerup['repository'];
            
            Assert::stringNotEmpty($name);
            Assert::stringNotEmpty($repository);
            
            // Verifica se già installato
            if ($this->checkPowerupInstallation($name)) {
                session()->flash('warning', "Power-up '{$name}' è già installato.");
                return;
            }
            
            // Configurazione timeout per operazioni
            $originalTimeout = ini_get('default_socket_timeout');
            ini_set('default_socket_timeout', (string)self::HTTP_TIMEOUT);
            
            try {
                // Scarica metadata del repository
                $metadata = $this->fetchRepositoryMetadata($repository);
                
                // Processo di installazione con steps
                $this->executeInstallationSteps($powerup, $metadata);
                
                // Activity logging per audit trail
                activity()
                    ->withProperties([
                        'powerup_name' => $name,
                        'repository' => $repository,
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ])
                    ->log("Power-up '{$name}' installed successfully");
                
                session()->flash('success', "Power-up '{$name}' installato con successo!");
                
                // Ricarica la lista
                $this->mount();
                
            } finally {
                // Ripristina timeout originale
                if ($originalTimeout !== false) {
                    ini_set('default_socket_timeout', $originalTimeout);
                }
            }
            
        } catch (\Exception $e) {
            Log::error('Power-up installation failed', [
                'powerup' => $powerup,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Activity logging per errori
            activity()
                ->withProperties([
                    'powerup_name' => $powerup['name'] ?? 'unknown',
                    'error' => $e->getMessage(),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ])
                ->log('Power-up installation failed');
            
            session()->flash('error', 'Errore durante l\'installazione: ' . $e->getMessage());
        }
    }

    /**
     * Scarica i metadata del repository GitHub.
     * Implementa gestione sicura delle richieste HTTP.
     * 
     * @param string $repository
     * @return array<string, mixed>
     * @throws \Exception
     */
    private function fetchRepositoryMetadata(string $repository): array
    {
        try {
            $response = Http::timeout(self::HTTP_TIMEOUT)
                ->retry(3, 1000)
                ->get("https://api.github.com/repos/{$repository}");
            
            if (!$response->successful()) {
                throw new \Exception("Failed to fetch repository metadata: HTTP {$response->status()}");
            }
            
            /** @var array<string, mixed> $metadata */
            $metadata = $response->json();
            
            Assert::isArray($metadata);
            Assert::keyExists($metadata, 'clone_url');
            
            return $metadata;
            
        } catch (\Exception $e) {
            Log::error('Failed to fetch repository metadata', [
                'repository' => $repository,
                'error' => $e->getMessage(),
            ]);
            
            throw new \Exception("Could not fetch repository metadata for '{$repository}': " . $e->getMessage());
        }
    }

    /**
     * Esegue gli step di installazione del power-up.
     * Implementa processo robusto con gestione errori e rollback.
     * 
     * @param array<string, mixed> $powerup
     * @param array<string, mixed> $metadata
     * @return void
     * @throws \Exception
     */
    private function executeInstallationSteps(array $powerup, array $metadata): void
    {
        /** @var string $name */
        $name = $powerup['name'];
        
        try {
            // Step 1: Clona il repository
            $this->cloneRepository($metadata['clone_url'], $name);
            
            // Step 2: Installa dipendenze
            $this->installDependencies($powerup);
            
            // Step 3: Esegui comandi post-installazione
            $this->executePostInstallCommands($powerup);
            
            // Step 4: Esegui factories se presenti
            $this->executeFactories($name);
            
            Log::info('Power-up installation completed', [
                'name' => $name,
                'steps_completed' => ['clone', 'dependencies', 'commands', 'factories'],
            ]);
            
        } catch (\Exception $e) {
            // Rollback in caso di errore
            $this->rollbackInstallation($name);
            throw $e;
        }
    }

    /**
     * Clona il repository del power-up.
     * 
     * @param string $cloneUrl
     * @param string $name
     * @return void
     * @throws \Exception
     */
    private function cloneRepository(string $cloneUrl, string $name): void
    {
        $targetPath = base_path("Modules/{$name}");
        
        if (File::isDirectory($targetPath)) {
            File::deleteDirectory($targetPath);
        }
        
        $command = "git clone {$cloneUrl} {$targetPath}";
        $result = shell_exec($command . ' 2>&1');
        
        if (!File::isDirectory($targetPath)) {
            throw new \Exception("Failed to clone repository: {$result}");
        }
    }

    /**
     * Installa le dipendenze del power-up.
     * 
     * @param array<string, mixed> $powerup
     * @return void
     */
    private function installDependencies(array $powerup): void
    {
        if (empty($powerup['dependencies'])) {
            return;
        }
        
        foreach ($powerup['dependencies'] as $dependency) {
            if (is_string($dependency)) {
                $this->installSingleDependency($dependency);
            }
        }
    }

    /**
     * Installa una singola dipendenza.
     * 
     * @param string $dependency
     * @return void
     */
    private function installSingleDependency(string $dependency): void
    {
        try {
            $command = "composer require {$dependency}";
            $result = shell_exec($command . ' 2>&1');
            
            Log::info('Dependency installed', [
                'dependency' => $dependency,
                'result' => $result,
            ]);
            
        } catch (\Exception $e) {
            Log::warning('Failed to install dependency', [
                'dependency' => $dependency,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Esegue comandi post-installazione.
     * 
     * @param array<string, mixed> $powerup
     * @return void
     */
    private function executePostInstallCommands(array $powerup): void
    {
        if (empty($powerup['commands'])) {
            return;
        }
        
        foreach ($powerup['commands'] as $command) {
            if (is_string($command)) {
                $this->executeSafeCommand($command);
            }
        }
    }

    /**
     * Esegue un comando in modo sicuro.
     * 
     * @param string $command
     * @return void
     */
    private function executeSafeCommand(string $command): void
    {
        try {
            // Lista comandi sicuri consentiti
            $allowedCommands = [
                'php artisan',
                'composer',
                'npm',
                'yarn',
            ];
            
            $isSafe = false;
            foreach ($allowedCommands as $allowed) {
                if (str_starts_with(trim($command), $allowed)) {
                    $isSafe = true;
                    break;
                }
            }
            
            if (!$isSafe) {
                Log::warning('Command blocked for security', ['command' => $command]);
                return;
            }
            
            Artisan::call($command);
            
            Log::info('Command executed', [
                'command' => $command,
                'output' => Artisan::output(),
            ]);
            
        } catch (\Exception $e) {
            Log::warning('Command execution failed', [
                'command' => $command,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Esegue le factories del power-up.
     * 
     * @param string $name
     * @return void
     */
    private function executeFactories(string $name): void
    {
        try {
            $factoryPath = base_path("Modules/{$name}/database/factories");
            
            if (File::isDirectory($factoryPath)) {
                Artisan::call('db:seed', [
                    '--class' => "Modules\\{$name}\\Database\\Seeders\\DatabaseSeeder",
                ]);
                
                Log::info('Factories executed', [
                    'powerup' => $name,
                    'output' => Artisan::output(),
                ]);
            }
            
        } catch (\Exception $e) {
            Log::warning('Factory execution failed', [
                'powerup' => $name,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Rollback dell'installazione in caso di errore.
     * 
     * @param string $name
     * @return void
     */
    private function rollbackInstallation(string $name): void
    {
        try {
            $targetPath = base_path("Modules/{$name}");
            
            if (File::isDirectory($targetPath)) {
                File::deleteDirectory($targetPath);
                
                Log::info('Installation rolled back', [
                    'powerup' => $name,
                    'path' => $targetPath,
                ]);
            }
            
        } catch (\Exception $e) {
            Log::error('Rollback failed', [
                'powerup' => $name,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Renderizza la componente.
     * 
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('user::pages.genesis.power-ups');
    }
};

name('genesis.power-ups');

?>

<div>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="border-4 border-dashed border-gray-200 rounded-lg p-6">
                
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Genesis Power-ups</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Gestione e installazione dei power-ups per estendere le funzionalità del sistema.
                    </p>
                </div>

                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('warning'))
                    <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                        {{ session('warning') }}
                    </div>
                @endif

                <!-- Power-ups Grid -->
                @if(!empty($powerups))
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($powerups as $powerup)
                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="px-4 py-5 sm:p-6">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                                            {{ $powerup['name'] }}
                                        </h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $powerup['installed'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $powerup['status'] }}
                                        </span>
                                    </div>
                                    
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            {{ $powerup['description'] }}
                                        </p>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <span class="text-xs text-gray-400">
                                            Versione: {{ $powerup['version'] }}
                                        </span>
                                    </div>
                                    
                                    <div class="mt-5">
                                        @if(!$powerup['installed'])
                                            <button 
                                                wire:click="installPowerup({{ json_encode($powerup) }})"
                                                class="w-full bg-blue-600 border border-transparent rounded-md py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                            >
                                                Installa
                                            </button>
                                        @else
                                            <button 
                                                disabled
                                                class="w-full bg-gray-300 border border-transparent rounded-md py-2 px-4 inline-flex justify-center text-sm font-medium text-gray-500 cursor-not-allowed"
                                            >
                                                Installato
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Nessun power-up disponibile</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Non sono stati trovati power-ups da installare.
                        </p>
                    </div>
                @endif

                <!-- Debug Info (solo in modalità sviluppo) -->
                @if(app()->environment('local') && !empty($powerupsJSON))
                    <div class="mt-8 bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Debug Info (Development Only)</h4>
                        <pre class="text-xs text-gray-600 overflow-auto max-h-48">{{ json_encode($powerupsJSON, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</div>