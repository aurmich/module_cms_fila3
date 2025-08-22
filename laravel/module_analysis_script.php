<?php

declare(strict_types=1);

/**
 * Module Analysis Script
 * Analyzes each module for model-factory-seeder completeness and identifies unused models
 */

class ModuleAnalyzer
{
    private array $results = [];
    private string $basePath;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    public function analyzeModule(string $moduleName): array
    {
        $modulePath = $this->basePath . '/Modules/' . $moduleName;
        
        if (!is_dir($modulePath)) {
            return ['error' => "Module {$moduleName} not found"];
        }

        $analysis = [
            'module' => $moduleName,
            'models' => [],
            'factories' => [],
            'seeders' => [],
            'missing_factories' => [],
            'missing_seeders' => [],
            'unused_models' => []
        ];

        // Find all models
        $models = $this->findFiles($modulePath . '/app/Models', '*.php');
        foreach ($models as $model) {
            $modelName = basename($model, '.php');
            if ($modelName !== 'BaseModel') {
                $analysis['models'][] = $modelName;
            }
        }

        // Find all factories
        $factories = $this->findFiles($modulePath . '/database/factories', '*.php');
        foreach ($factories as $factory) {
            $factoryName = basename($factory, 'Factory.php');
            $analysis['factories'][] = $factoryName;
        }

        // Find all seeders
        $seeders = $this->findFiles($modulePath . '/database/seeders', '*.php');
        foreach ($seeders as $seeder) {
            $seederName = basename($seeder, '.php');
            if (str_contains($seederName, 'Seeder')) {
                $modelName = str_replace('Seeder', '', $seederName);
                $analysis['seeders'][] = $modelName;
            }
        }

        // Check for missing factories
        foreach ($analysis['models'] as $model) {
            if (!in_array($model, $analysis['factories'])) {
                $analysis['missing_factories'][] = $model;
            }
        }

        // Check for missing seeders
        foreach ($analysis['models'] as $model) {
            if (!in_array($model, $analysis['seeders'])) {
                $analysis['missing_seeders'][] = $model;
            }
        }

        return $analysis;
    }

    private function findFiles(string $directory, string $pattern): array
    {
        if (!is_dir($directory)) {
            return [];
        }

        $files = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && fnmatch($pattern, $file->getFilename())) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    public function analyzeAllModules(array $moduleNames): array
    {
        foreach ($moduleNames as $moduleName) {
            $this->results[$moduleName] = $this->analyzeModule($moduleName);
        }
        return $this->results;
    }

    public function generateReport(): string
    {
        $report = "# MODULE ANALYSIS REPORT\n\n";
        $report .= "Generated on: " . date('Y-m-d H:i:s') . "\n\n";

        foreach ($this->results as $moduleName => $analysis) {
            if (isset($analysis['error'])) {
                $report .= "## {$moduleName}: ERROR - {$analysis['error']}\n\n";
                continue;
            }

            $report .= "## {$moduleName}\n\n";
            $report .= "- **Models found**: " . count($analysis['models']) . "\n";
            $report .= "- **Factories found**: " . count($analysis['factories']) . "\n";
            $report .= "- **Seeders found**: " . count($analysis['seeders']) . "\n\n";

            if (!empty($analysis['missing_factories'])) {
                $report .= "### ❌ Missing Factories:\n";
                foreach ($analysis['missing_factories'] as $model) {
                    $report .= "  - {$model}\n";
                }
                $report .= "\n";
            }

            if (!empty($analysis['missing_seeders'])) {
                $report .= "### ❌ Missing Seeders:\n";
                foreach ($analysis['missing_seeders'] as $model) {
                    $report .= "  - {$model}\n";
                }
                $report .= "\n";
            }

            if (empty($analysis['missing_factories']) && empty($analysis['missing_seeders'])) {
                $report .= "### ✅ Complete: All models have factories and seeders\n\n";
            }

            $report .= "---\n\n";
        }

        return $report;
    }
}

// Usage
$analyzer = new ModuleAnalyzer('/var/www/html/_bases/base_saluteora/laravel');
$modules = ['Activity', 'Cms', 'Gdpr', 'Geo', 'Job', 'Lang', 'Media', 'Notify', 'SaluteMo', 'SaluteOra', 'Tenant', 'UI', 'User', 'Xot'];

$results = $analyzer->analyzeAllModules($modules);
$report = $analyzer->generateReport();

echo $report;

// Save report to file
file_put_contents('/var/www/html/_bases/base_saluteora/laravel/module_analysis_report.md', $report);

echo "Report generated: /var/www/html/_bases/base_saluteora/laravel/module_analysis_report.md\n";
