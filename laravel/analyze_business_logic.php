<?php

declare(strict_types=1);

/**
 * Business Logic Analysis Script
 * Analizza tutti i moduli per verificare factory e seeder per ogni modello
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\File;

class BusinessLogicAnalyzer
{
    private array $modules = [];
    private array $analysis = [];

    public function __construct()
    {
        $this->loadModules();
    }

    private function loadModules(): void
    {
        $modulesPath = __DIR__ . '/Modules';
        if (!is_dir($modulesPath)) {
            throw new Exception("Modules directory not found: {$modulesPath}");
        }

        $this->modules = array_filter(
            scandir($modulesPath),
            fn($item) => $item !== '.' && $item !== '..' && is_dir($modulesPath . '/' . $item)
        );
    }

    public function analyze(): array
    {
        foreach ($this->modules as $module) {
            $this->analyzeModule($module);
        }

        return $this->analysis;
    }

    private function analyzeModule(string $module): void
    {
        $modulePath = __DIR__ . '/Modules/' . $module;
        $modelsPath = $modulePath . '/app/Models';
        $factoriesPath = $modulePath . '/database/factories';
        $seedersPath = $modulePath . '/database/seeders';

        $this->analysis[$module] = [
            'models' => [],
            'factories' => [],
            'seeders' => [],
            'missing_factories' => [],
            'missing_seeders' => [],
            'has_database_dir' => is_dir($modulePath . '/database'),
        ];

        // Analizza modelli
        if (is_dir($modelsPath)) {
            $this->analyzeModels($module, $modelsPath);
        }

        // Analizza factory
        if (is_dir($factoriesPath)) {
            $this->analyzeFactories($module, $factoriesPath);
        }

        // Analizza seeder
        if (is_dir($seedersPath)) {
            $this->analyzeSeeders($module, $seedersPath);
        }

        // Identifica factory e seeder mancanti
        $this->identifyMissing($module);
    }

    private function analyzeModels(string $module, string $modelsPath): void
    {
        $files = glob($modelsPath . '/*.php');
        
        foreach ($files as $file) {
            $filename = basename($file, '.php');
            
            // Escludi file base e pivot
            if (in_array($filename, ['BaseModel', 'BasePivot', 'BaseMorphPivot'])) {
                continue;
            }

            // Escludi file .old
            if (str_ends_with($file, '.old')) {
                continue;
            }

            $this->analysis[$module]['models'][] = $filename;
        }
    }

    private function analyzeFactories(string $module, string $factoriesPath): void
    {
        $files = glob($factoriesPath . '/*.php');
        
        foreach ($files as $file) {
            $filename = basename($file, '.php');
            
            // Rimuovi il suffisso Factory
            if (str_ends_with($filename, 'Factory')) {
                $modelName = substr($filename, 0, -7);
                $this->analysis[$module]['factories'][] = $modelName;
            }
        }
    }

    private function analyzeSeeders(string $module, string $seedersPath): void
    {
        $files = glob($seedersPath . '/*.php');
        
        foreach ($files as $file) {
            $filename = basename($file, '.php');
            $this->analysis[$module]['seeders'][] = $filename;
        }
    }

    private function identifyMissing(string $module): void
    {
        $models = $this->analysis[$module]['models'];
        $factories = $this->analysis[$module]['factories'];
        $seeders = $this->analysis[$module]['seeders'];

        // Factory mancanti
        foreach ($models as $model) {
            if (!in_array($model, $factories)) {
                $this->analysis[$module]['missing_factories'][] = $model;
            }
        }

        // Seeder mancanti (più complesso, non sempre 1:1 con i modelli)
        // Per ora identifichiamo solo se mancano seeder generali
        if (empty($seeders) && !empty($models)) {
            $this->analysis[$module]['missing_seeders'][] = $module . 'DatabaseSeeder';
        }
    }

    public function generateReport(): string
    {
        $report = "# Business Logic Analysis Report\n\n";
        $report .= "Generated: " . date('Y-m-d H:i:s') . "\n\n";

        foreach ($this->analysis as $module => $data) {
            $report .= "## Module: {$module}\n\n";
            
            $report .= "### Models (" . count($data['models']) . ")\n";
            foreach ($data['models'] as $model) {
                $report .= "- {$model}\n";
            }
            $report .= "\n";

            $report .= "### Factories (" . count($data['factories']) . ")\n";
            foreach ($data['factories'] as $factory) {
                $report .= "- {$factory}Factory\n";
            }
            $report .= "\n";

            $report .= "### Seeders (" . count($data['seeders']) . ")\n";
            foreach ($data['seeders'] as $seeder) {
                $report .= "- {$seeder}\n";
            }
            $report .= "\n";

            if (!empty($data['missing_factories'])) {
                $report .= "### ❌ Missing Factories\n";
                foreach ($data['missing_factories'] as $missing) {
                    $report .= "- {$missing}Factory\n";
                }
                $report .= "\n";
            }

            if (!empty($data['missing_seeders'])) {
                $report .= "### ❌ Missing Seeders\n";
                foreach ($data['missing_seeders'] as $missing) {
                    $report .= "- {$missing}\n";
                }
                $report .= "\n";
            }

            $report .= "---\n\n";
        }

        return $report;
    }

    public function generateTinkerScript(): string
    {
        $script = "<?php\n\n";
        $script .= "/**\n";
        $script .= " * Tinker script per generare 100 record per ogni modello\n";
        $script .= " * Eseguire con: php artisan tinker < generate_test_data.php\n";
        $script .= " */\n\n";

        foreach ($this->analysis as $module => $data) {
            if (empty($data['models'])) {
                continue;
            }

            $script .= "// Module: {$module}\n";
            $script .= "echo \"Generating data for module {$module}...\\n\";\n\n";

            foreach ($data['models'] as $model) {
                if (in_array($model, $data['factories'])) {
                    $script .= "// {$model}\n";
                    $script .= "try {\n";
                    $script .= "    \\Modules\\{$module}\\Models\\{$model}::factory()->count(100)->create();\n";
                    $script .= "    echo \"✅ Created 100 {$model} records\\n\";\n";
                    $script .= "} catch (Exception \$e) {\n";
                    $script .= "    echo \"❌ Error creating {$model}: \" . \$e->getMessage() . \"\\n\";\n";
                    $script .= "}\n\n";
                } else {
                    $script .= "// {$model} - Factory missing\n";
                    $script .= "echo \"⚠️  {$model} factory not found, skipping...\\n\";\n\n";
                }
            }

            $script .= "\n";
        }

        $script .= "echo \"Data generation completed!\\n\";\n";

        return $script;
    }
}

// Esecuzione
try {
    $analyzer = new BusinessLogicAnalyzer();
    $analysis = $analyzer->analyze();
    
    // Genera report
    $report = $analyzer->generateReport();
    file_put_contents(__DIR__ . '/business_logic_report.md', $report);
    echo "Report generato: business_logic_report.md\n";
    
    // Genera script tinker
    $tinkerScript = $analyzer->generateTinkerScript();
    file_put_contents(__DIR__ . '/generate_test_data.php', $tinkerScript);
    echo "Script tinker generato: generate_test_data.php\n";
    
    // Mostra summary
    echo "\n=== SUMMARY ===\n";
    foreach ($analysis as $module => $data) {
        echo "{$module}: " . count($data['models']) . " models, " . count($data['factories']) . " factories, " . count($data['seeders']) . " seeders\n";
        echo "  Missing factories: " . count($data['missing_factories']) . "\n";
        echo "  Missing seeders: " . count($data['missing_seeders']) . "\n\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
