<?php

declare(strict_types=1);

/**
 * Populate Business Models Script
 * Creates test data for all business models with proper constraint handling
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

class BusinessModelPopulator
{
    private array $businessModels = [
        'SaluteOra' => [
            'User' => ['count' => 50, 'dependencies' => []],
            'Studio' => ['count' => 20, 'dependencies' => []],
            'Patient' => ['count' => 100, 'dependencies' => ['User']],
            'Doctor' => ['count' => 30, 'dependencies' => ['User']],
            'Admin' => ['count' => 10, 'dependencies' => ['User']],
            'Profile' => ['count' => 100, 'dependencies' => ['User']],
            'Appointment' => ['count' => 200, 'dependencies' => ['Patient', 'Doctor', 'Studio']],
            'Report' => ['count' => 150, 'dependencies' => ['Appointment']],
        ],
        'Cms' => [
            'Page' => ['count' => 50, 'dependencies' => []],
            'Section' => ['count' => 100, 'dependencies' => []],
            'PageContent' => ['count' => 200, 'dependencies' => ['Page']],
        ],
        'Gdpr' => [
            'Consent' => ['count' => 100, 'dependencies' => []],
            'Treatment' => ['count' => 50, 'dependencies' => []],
            'Event' => ['count' => 200, 'dependencies' => ['Consent']],
        ],
        'Lang' => [
            'Translation' => ['count' => 500, 'dependencies' => []],
            'Post' => ['count' => 100, 'dependencies' => []],
        ],
        'Media' => [
            'Media' => ['count' => 200, 'dependencies' => []],
            'TemporaryUpload' => ['count' => 50, 'dependencies' => []],
        ],
    ];

    private array $results = [];

    public function populate(): void
    {
        echo "🚀 Starting business model population...\n\n";

        // Clear existing test data first
        $this->clearTestData();

        foreach ($this->businessModels as $module => $models) {
            echo "📦 Module: {$module}\n";
            
            foreach ($models as $modelName => $config) {
                $this->populateModel($module, $modelName, $config);
            }
            
            echo "\n";
        }

        $this->printSummary();
    }

    private function clearTestData(): void
    {
        echo "🧹 Clearing existing test data...\n";
        
        try {
            // Clear in reverse dependency order to avoid foreign key constraints
            DB::statement('PRAGMA foreign_keys = OFF');
            
            $clearOrder = [
                'SaluteOra' => ['Report', 'Appointment', 'Profile', 'Admin', 'Doctor', 'Patient', 'Studio', 'User'],
                'Cms' => ['PageContent', 'Section', 'Page'],
                'Gdpr' => ['Event', 'Treatment', 'Consent'],
                'Lang' => ['Post', 'Translation'],
                'Media' => ['TemporaryUpload', 'Media'],
            ];

            foreach ($clearOrder as $module => $models) {
                foreach ($models as $model) {
                    $modelClass = "\\Modules\\{$module}\\Models\\{$model}";
                    if (class_exists($modelClass)) {
                        try {
                            $modelClass::truncate();
                            echo "  ✅ Cleared {$model}\n";
                        } catch (\Exception $e) {
                            echo "  ⚠️ Could not clear {$model}: " . substr($e->getMessage(), 0, 50) . "...\n";
                        }
                    }
                }
            }
            
            DB::statement('PRAGMA foreign_keys = ON');
            echo "✅ Test data cleared\n\n";
            
        } catch (\Exception $e) {
            echo "⚠️ Warning during cleanup: " . $e->getMessage() . "\n\n";
        }
    }

    private function populateModel(string $module, string $modelName, array $config): void
    {
        try {
            echo "  🔄 Creating {$config['count']} {$modelName} records... ";

            $modelClass = "\\Modules\\{$module}\\Models\\{$modelName}";
            $factoryClass = "\\Modules\\{$module}\\Database\\Factories\\{$modelName}Factory";

            if (!class_exists($modelClass)) {
                echo "❌ Model not found\n";
                $this->results[$module][$modelName] = ['status' => 'model_not_found'];
                return;
            }

            if (!class_exists($factoryClass)) {
                echo "❌ Factory not found\n";
                $this->results[$module][$modelName] = ['status' => 'factory_not_found'];
                return;
            }

            // Create records using factory
            $factory = new $factoryClass();
            $records = $factory->count($config['count'])->create();

            $count = is_countable($records) ? count($records) : $config['count'];
            echo "✅ Created {$count} records\n";

            $this->results[$module][$modelName] = [
                'status' => 'success',
                'count' => $count,
                'requested' => $config['count']
            ];

        } catch (\Exception $e) {
            $error = substr($e->getMessage(), 0, 100);
            echo "❌ Error: {$error}...\n";
            
            $this->results[$module][$modelName] = [
                'status' => 'error',
                'error' => $e->getMessage()
            ];
        }
    }

    private function printSummary(): void
    {
        echo "📊 POPULATION SUMMARY\n";
        echo str_repeat("=", 50) . "\n\n";

        $totalSuccess = 0;
        $totalFailed = 0;
        $totalRecords = 0;

        foreach ($this->results as $module => $models) {
            echo "Module: {$module}\n";
            
            foreach ($models as $modelName => $result) {
                $status = $result['status'] === 'success' ? '✅' : '❌';
                echo "  {$status} {$modelName}";
                
                if ($result['status'] === 'success') {
                    echo " - {$result['count']}/{$result['requested']} records";
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
        echo "❌ Failed: {$totalFailed} models\n";
        echo "📈 Total records created: {$totalRecords}\n\n";

        if ($totalRecords > 0) {
            echo "🎉 Business logic populated successfully!\n";
            echo "You can now test the application with realistic data.\n";
        }
    }
}

// Execute the populator
try {
    $populator = new BusinessModelPopulator();
    $populator->populate();
} catch (Exception $e) {
    echo "💥 Fatal Error: " . $e->getMessage() . "\n";
}
