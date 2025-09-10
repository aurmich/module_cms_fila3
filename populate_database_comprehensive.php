<?php

declare(strict_types=1);

/**
 * Comprehensive Database Population Script
 * 
 * This script populates the database with realistic business data
 * following the proper dependency order and handling schema issues.
 */

require_once __DIR__ . '/laravel/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Bootstrap Laravel
$app = require_once __DIR__ . '/laravel/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

class DatabasePopulator
{
    private array $results = [];
    private int $totalRecords = 0;

    public function run(): void
    {
        echo "🚀 Starting comprehensive database population...\n\n";
        
        $startTime = microtime(true);
        
        try {
            // Phase 1: Core System Data
            $this->populateSystemData();
            
            // Phase 2: Geographic Data  
            $this->populateGeographicData();
            
            // Phase 3: User Management
            $this->populateUserData();
            
            // Phase 4: Business Logic (SaluteOra)
            $this->populateBusinessData();
            
            // Phase 5: Content Management
            $this->populateContentData();
            
            $endTime = microtime(true);
            $executionTime = round($endTime - $startTime, 2);
            
            $this->displaySummary($executionTime);
            
        } catch (\Exception $e) {
            echo "❌ Critical error: " . $e->getMessage() . "\n";
            echo "Stack trace: " . $e->getTraceAsString() . "\n";
        }
    }

    private function populateSystemData(): void
    {
        echo "📊 Phase 1: System Data\n";
        echo "=" . str_repeat("=", 50) . "\n";
        
        // Create basic system records using factories
        $this->createRecords('System Users', function() {
            return \Modules\User\Models\User::factory(10)->create();
        });
        
        $this->createRecords('System Roles', function() {
            // Create basic roles
            $roles = ['admin', 'doctor', 'patient', 'staff'];
            $created = [];
            foreach ($roles as $role) {
                $created[] = \Spatie\Permission\Models\Role::firstOrCreate(['name' => $role]);
            }
            return collect($created);
        });
        
        $this->createRecords('System Permissions', function() {
            // Create basic permissions
            $permissions = [
                'view_patients', 'create_patients', 'edit_patients', 'delete_patients',
                'view_appointments', 'create_appointments', 'edit_appointments', 'delete_appointments',
                'view_reports', 'create_reports', 'edit_reports', 'delete_reports',
                'manage_studios', 'manage_users', 'manage_system'
            ];
            $created = [];
            foreach ($permissions as $permission) {
                $created[] = \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
            }
            return collect($created);
        });
    }

    private function populateGeographicData(): void
    {
        echo "\n🌍 Phase 2: Geographic Data\n";
        echo "=" . str_repeat("=", 50) . "\n";
        
        // Create addresses using the working factory
        $this->createRecords('Addresses', function() {
            return \Modules\Geo\Models\Address::factory(200)->create();
        });
        
        $this->createRecords('Locations', function() {
            return \Modules\Geo\Models\Location::factory(100)->create();
        });
    }

    private function populateUserData(): void
    {
        echo "\n👥 Phase 3: User Management\n";
        echo "=" . str_repeat("=", 50) . "\n";
        
        // Create teams without problematic fields
        $this->createRecords('Teams', function() {
            $teams = [];
            $teamData = [
                ['name' => 'Sistema', 'description' => 'Team di sistema'],
                ['name' => 'Amministratori', 'description' => 'Team amministratori'],
                ['name' => 'Medici', 'description' => 'Team medici'],
                ['name' => 'Staff', 'description' => 'Team staff clinico'],
            ];
            
            foreach ($teamData as $data) {
                $teams[] = \Modules\User\Models\Team::firstOrCreate(
                    ['name' => $data['name']], 
                    $data
                );
            }
            return collect($teams);
        });
    }

    private function populateBusinessData(): void
    {
        echo "\n🏥 Phase 4: Business Logic (SaluteOra)\n";
        echo "=" . str_repeat("=", 50) . "\n";
        
        // Studios - DISABLED: Model no longer exists
        // $this->createRecords('Studios', function() {
        //     return \Modules\TechPlanner\Models\Studio::factory(25)->create();
        // });
        
        // Patients with unique email handling - DISABLED: Model no longer exists
        // $this->createRecords('Patients', function() {
        //     DB::statement('DELETE FROM users WHERE type = "patient"');
        //     return \Modules\TechPlanner\Models\Patient::factory(500)->create();
        // });
        
        // Doctors with unique email handling - DISABLED: Model no longer exists
        // $this->createRecords('Doctors', function() {
            DB::statement('DELETE FROM users WHERE type = "doctor"');
        //     return \Modules\TechPlanner\Models\Doctor::factory(50)->create();
        // });
        
        // Appointments
        $this->createRecords('Appointments', function() {
            $appointmentClass = '\Modules\TechPlanner\Models\Appointment';
            if (class_exists($appointmentClass) && method_exists($appointmentClass, 'factory')) {
                return $appointmentClass::factory(1000)->create();
            }
            throw new \Exception('Appointment class or factory method not found');
        });
        
        // Reports
        $this->createRecords('Reports', function() {
            $reportClass = '\Modules\TechPlanner\Models\Report';
            if (class_exists($reportClass) && method_exists($reportClass, 'factory')) {
                return $reportClass::factory(300)->create();
            }
            throw new \Exception('Report class or factory method not found');
        });
        
        // Profiles
        $this->createRecords('Profiles', function() {
            return \Modules\TechPlanner\Models\Profile::factory(600)->create();
        });
    }

    private function populateContentData(): void
    {
        echo "\n📄 Phase 5: Content Management\n";
        echo "=" . str_repeat("=", 50) . "\n";
        
        // Activity logs
        $this->createRecords('Activities', function() {
            return \Modules\Activity\Models\Activity::factory(2000)->create();
        });
        
        // Skip CMS for now due to schema issues
        echo "⚠️  Skipping CMS data due to schema incompatibilities\n";
    }

    private function createRecords(string $name, callable $factory): void
    {
        echo "  🔄 Creating {$name}... ";
        
        try {
            $records = $factory();
            $count = is_countable($records) ? count($records) : 0;
            
            $this->results[$name] = [
                'status' => 'success',
                'count' => $count
            ];
            $this->totalRecords += $count;
            
            echo "✅ Created {$count} records\n";
            
        } catch (\Exception $e) {
            $this->results[$name] = [
                'status' => 'error',
                'error' => $e->getMessage()
            ];
            echo "❌ Error: " . substr($e->getMessage(), 0, 100) . "...\n";
        }
    }

    private function displaySummary(float $executionTime): void
    {
        echo "\n📊 POPULATION SUMMARY\n";
        echo "=" . str_repeat("=", 60) . "\n";
        
        $successful = 0;
        $failed = 0;
        
        foreach ($this->results as $name => $result) {
            $status = match($result['status']) {
                'success' => '✅',
                default => '❌'
            };
            
            echo "{$status} {$name}";
            
            if ($result['status'] === 'success') {
                echo " - {$result['count']} records";
                $successful++;
            } else {
                echo " - Error";
                $failed++;
            }
            echo "\n";
        }
        
        echo "\nTOTALS:\n";
        echo "✅ Successful: {$successful} categories\n";
        echo "❌ Failed: {$failed} categories\n";
        echo "📈 Total records created: {$this->totalRecords}\n";
        echo "⏱️  Execution time: {$executionTime} seconds\n";
        
        if ($this->totalRecords > 0) {
            echo "\n🎉 Database population completed successfully!\n";
            echo "💡 You can now test the application with realistic data.\n";
        }
    }
}

// Execute the population
$populator = new DatabasePopulator();
$populator->run();
