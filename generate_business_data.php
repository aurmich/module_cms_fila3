<?php

declare(strict_types=1);

/**
 * Business Data Generation Script
 * Creates 100 records for each core business model using Tinker commands
 */

require_once __DIR__ . '/laravel/vendor/autoload.php';

$app = require_once __DIR__ . '/laravel/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

class BusinessDataGenerator
{
    private array $coreBusinessModels = [
        'SaluteOra' => [
            'Patient',
            'Doctor', 
            'Studio',
            'Appointment',
            'Report',
            'Profile',
            'User',
        ]
    ];

    private array $results = [];

    public function generateData(): void
    {
        echo "🚀 Generating business data for SaluteOra core models...\n\n";

        foreach ($this->coreBusinessModels as $module => $models) {
            echo "📦 Module: {$module}\n";
            
            foreach ($models as $modelName) {
                $this->generateModelRecords($module, $modelName);
            }
            
            echo "\n";
        }

        $this->printSummary();
        $this->generateTinkerScript();
    }

    private function generateModelRecords(string $module, string $modelName): void
    {
        try {
            echo "  🔄 Generating {$modelName} records... ";

            $factoryClass = "\\Modules\\{$module}\\Database\\Factories\\{$modelName}Factory";
            
            if (!class_exists($factoryClass)) {
                echo "❌ Factory not found\n";
                $this->results[$module][$modelName] = ['status' => 'no_factory'];
                return;
            }

            // Use Artisan Tinker approach for better compatibility
            $command = "\\Modules\\{$module}\\Models\\{$modelName}::factory()->count(100)->create();";
            
            // Try to execute via eval in a safe way
            try {
                $modelClass = "\\Modules\\{$module}\\Models\\{$modelName}";
                
                if (!class_exists($modelClass)) {
                    echo "❌ Model not found\n";
                    $this->results[$module][$modelName] = ['status' => 'no_model'];
                    return;
                }

                // Create factory directly and generate records
                $factory = $factoryClass::new();
                $records = $factory->count(100)->create();
                
                $count = is_countable($records) ? count($records) : 100;
                echo "✅ Created {$count} records\n";
                
                $this->results[$module][$modelName] = [
                    'status' => 'success',
                    'count' => $count,
                    'command' => $command
                ];

            } catch (\Exception $e) {
                echo "❌ Error: " . substr($e->getMessage(), 0, 60) . "...\n";
                $this->results[$module][$modelName] = [
                    'status' => 'error',
                    'error' => $e->getMessage(),
                    'command' => $command
                ];
            }

        } catch (\Exception $e) {
            echo "❌ Fatal error: " . substr($e->getMessage(), 0, 60) . "...\n";
            $this->results[$module][$modelName] = [
                'status' => 'fatal_error',
                'error' => $e->getMessage()
            ];
        }
    }

    private function printSummary(): void
    {
        echo "📊 GENERATION SUMMARY\n";
        echo str_repeat("=", 50) . "\n\n";

        $totalSuccess = 0;
        $totalFailed = 0;
        $totalRecords = 0;

        foreach ($this->results as $module => $models) {
            echo "Module: {$module}\n";
            
            foreach ($models as $modelName => $result) {
                $status = match($result['status']) {
                    'success' => '✅',
                    'no_factory' => '⚠️',
                    'no_model' => '⚠️',
                    default => '❌'
                };
                
                echo "  {$status} {$modelName}";
                
                if ($result['status'] === 'success') {
                    echo " - {$result['count']} records";
                    $totalSuccess++;
                    $totalRecords += $result['count'];
                } else {
                    echo " - " . ucfirst(str_replace('_', ' ', $result['status']));
                    $totalFailed++;
                }
                echo "\n";
            }
            echo "\n";
        }

        echo "TOTALS:\n";
        echo "✅ Successful: {$totalSuccess} models\n";
        echo "❌ Failed/Missing: {$totalFailed} models\n";
        echo "📈 Total records created: {$totalRecords}\n";
    }

    private function generateTinkerScript(): void
    {
        $scriptPath = __DIR__ . '/tinker_commands.php';
        
        $content = "<?php\n\n";
        $content .= "/**\n";
        $content .= " * Tinker commands to generate 100 records for each business model\n";
        $content .= " * Run with: php artisan tinker < tinker_commands.php\n";
        $content .= " */\n\n";

        foreach ($this->results as $module => $models) {
            $content .= "// Module: {$module}\n";
            
            foreach ($models as $modelName => $result) {
                if (isset($result['command'])) {
                    $content .= "echo \"Generating {$modelName}...\";\n";
                    $content .= $result['command'] . "\n";
                    $content .= "echo \"✅ {$modelName} completed\\n\";\n\n";
                } else {
                    $content .= "// ❌ {$modelName} - " . ($result['status'] ?? 'unknown error') . "\n\n";
                }
            }
        }

        file_put_contents($scriptPath, $content);
        echo "\n📝 Tinker script generated: tinker_commands.php\n";
        echo "Run with: php artisan tinker < tinker_commands.php\n";
    }
}

// Execute the generator
try {
    $generator = new BusinessDataGenerator();
    $generator->generateData();
} catch (Exception $e) {
    echo "💥 Fatal Error: " . $e->getMessage() . "\n";
}
