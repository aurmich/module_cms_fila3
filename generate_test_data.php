<?php

declare(strict_types=1);

/**
 * Test Data Generation Script
 * Creates 100 records for each business model using their factories
 */

require_once __DIR__ . '/laravel/vendor/autoload.php';

$app = require_once __DIR__ . '/laravel/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

class TestDataGenerator
{
    private array $businessModels = [
        'SaluteOra' => [
            'Patient' => 'Modules\SaluteOra\Database\Factories\PatientFactory',
            'Doctor' => 'Modules\SaluteOra\Database\Factories\DoctorFactory',
            'Admin' => 'Modules\SaluteOra\Database\Factories\AdminFactory',
            'Studio' => 'Modules\SaluteOra\Database\Factories\StudioFactory',
            'Appointment' => 'Modules\SaluteOra\Database\Factories\AppointmentFactory',
            'Report' => 'Modules\SaluteOra\Database\Factories\ReportFactory',
            'Profile' => 'Modules\SaluteOra\Database\Factories\ProfileFactory',
            'User' => 'Modules\SaluteOra\Database\Factories\UserFactory',
        ],
        'Cms' => [
            'Conf' => 'Modules\Cms\Database\Factories\ConfFactory',
            'Menu' => 'Modules\Cms\Database\Factories\MenuFactory',
            'Module' => 'Modules\Cms\Database\Factories\ModuleFactory',
            'Page' => 'Modules\Cms\Database\Factories\PageFactory',
            'PageContent' => 'Modules\Cms\Database\Factories\PageContentFactory',
            'Section' => 'Modules\Cms\Database\Factories\SectionFactory',
        ],
        'Gdpr' => [
            'Consent' => 'Modules\Gdpr\Database\Factories\ConsentFactory',
            'Event' => 'Modules\Gdpr\Database\Factories\EventFactory',
            'Profile' => 'Modules\Gdpr\Database\Factories\ProfileFactory',
            'Treatment' => 'Modules\Gdpr\Database\Factories\TreatmentFactory',
        ],
        'Lang' => [
            'Post' => 'Modules\Lang\Database\Factories\PostFactory',
            'Translation' => 'Modules\Lang\Database\Factories\TranslationFactory',
            'TranslationFile' => 'Modules\Lang\Database\Factories\TranslationFileFactory',
        ],
        'Media' => [
            'Media' => 'Modules\Media\Database\Factories\MediaFactory',
            'MediaConvert' => 'Modules\Media\Database\Factories\MediaConvertFactory',
            'TemporaryUpload' => 'Modules\Media\Database\Factories\TemporaryUploadFactory',
        ],
    ];

    private array $results = [];

    public function generateTestData(): void
    {
        echo "🚀 Starting test data generation for business models...\n\n";

        foreach ($this->businessModels as $module => $models) {
            echo "📦 Module: {$module}\n";
            
            foreach ($models as $modelName => $factoryClass) {
                $this->generateModelData($module, $modelName, $factoryClass);
            }
            
            echo "\n";
        }

        $this->printSummary();
    }

    private function generateModelData(string $module, string $modelName, string $factoryClass): void
    {
        try {
            echo "  🔄 Generating {$modelName} records... ";

            // Check if factory class exists
            if (!class_exists($factoryClass)) {
                echo "❌ Factory class not found: {$factoryClass}\n";
                $this->results[$module][$modelName] = ['status' => 'failed', 'reason' => 'Factory not found'];
                return;
            }

            // Create factory instance and generate records
            $factory = new $factoryClass();
            $records = $factory->count(100)->create();
            
            // Ensure we can call count() on the result
            if (!method_exists($records, 'count') && !is_countable($records)) {
                throw new \Exception('Records object does not support count() method');
            }

            $count = is_countable($records) ? count($records) : ($records !== null ? 1 : 0);
            echo "✅ Created {$count} records\n";
            
            $this->results[$module][$modelName] = [
                'status' => 'success', 
                'count' => $count,
                'factory' => $factoryClass
            ];

        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "\n";
            $this->results[$module][$modelName] = [
                'status' => 'failed', 
                'reason' => $e->getMessage(),
                'factory' => $factoryClass
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
                $status = $result['status'] === 'success' ? '✅' : '❌';
                echo "  {$status} {$modelName}";
                
                if ($result['status'] === 'success') {
                    echo " - {$result['count']} records";
                    $totalSuccess++;
                    $totalRecords += $result['count'];
                } else {
                    echo " - Failed: {$result['reason']}";
                    $totalFailed++;
                }
                echo "\n";
            }
            echo "\n";
        }

        echo "TOTALS:\n";
        echo "✅ Successful: {$totalSuccess} models\n";
        echo "❌ Failed: {$totalFailed} models\n";
        echo "📈 Total records created: {$totalRecords}\n";
    }

    public function generateTinkerCommands(): void
    {
        echo "\n🔧 TINKER COMMANDS FOR MANUAL EXECUTION\n";
        echo str_repeat("=", 50) . "\n\n";

        foreach ($this->businessModels as $module => $models) {
            echo "// Module: {$module}\n";
            
            foreach ($models as $modelName => $factoryClass) {
                // Convert factory class to model class
                $modelClassParts = str_replace('\Database\Factories\\', '\Models\\', $factoryClass);
                $modelClass = str_replace('Factory', '', $modelClassParts);
                
                echo "// {$modelName}\n";
                echo "(new {$factoryClass}())->count(100)->create();\n";
                echo "// Alternative: " . $modelClass . "::factory()->count(100)->create(); // if HasFactory trait is added\n\n";
            }
        }
    }
}

// Execute the generator
try {
    $generator = new TestDataGenerator();
    $generator->generateTestData();
    $generator->generateTinkerCommands();
} catch (Exception $e) {
    echo "💥 Fatal Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
