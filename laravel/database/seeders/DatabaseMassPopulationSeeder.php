<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseMassPopulationSeeder extends Seeder
{
    /**
     * Run the database population with factories and seeders from all modules.
     */
    public function run(): void
    {
        $this->command->info('Starting mass database population using module factories and seeders...');
        
        // Track execution time
        $startTime = microtime(true);
        
        try {
            DB::beginTransaction();
            
            $this->populateActivityModule();
            $this->populateCmsModule();
            $this->populateGdprModule();
            $this->populateGeoModule();
            $this->populateJobModule();
            $this->populateLangModule();
            $this->populateMediaModule();
            $this->populateNotifyModule();
            $this->populateTenantModule();
            $this->populateUserModule();
            $this->populateXotModule();
            $this->populateSaluteOraModule();
            
            $this->runModuleSeeders();
            
            DB::commit();
            
            $executionTime = round(microtime(true) - $startTime, 2);
            $this->command->info("Database population completed successfully in {$executionTime} seconds!");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Database population failed: ' . $e->getMessage());
            Log::error('Database population error', ['exception' => $e]);
        }
    }
    
    /**
     * Create multiple records using factory with error handling
     */
    protected function createMultiple(string $factoryClass, int $count = 10, array $attributes = []): void
    {
        if (!class_exists($factoryClass)) {
            $this->command->warn("Factory {$factoryClass} not found - skipping");
            return;
        }
        
        try {
            $factory = new $factoryClass();
            $factory->count($count)->create($attributes);
            $this->command->info("✓ Created {$count} records with {$factoryClass}");
        } catch (\Exception $e) {
            $this->command->error("✗ Failed to create records with {$factoryClass}: " . $e->getMessage());
        }
    }
    
    /**
     * Run a seeder class with error handling
     */
    protected function runSeeder(string $seederClass): void
    {
        if (!class_exists($seederClass)) {
            $this->command->warn("Seeder {$seederClass} not found - skipping");
            return;
        }
        
        try {
            $this->call($seederClass);
            $this->command->info("✓ {$seederClass} executed successfully");
        } catch (\Exception $e) {
            $this->command->error("✗ Failed to run {$seederClass}: " . $e->getMessage());
        }
    }
    
    // Module-specific population methods
    
    protected function populateActivityModule(): void
    {
        $this->command->info('Populating Activity module...');
        $this->createMultiple('Modules\\Activity\\Database\\Factories\\ActivityFactory', 20);
        $this->createMultiple('Modules\\Activity\\Database\\Factories\\SnapshotFactory', 15);
        $this->createMultiple('Modules\\Activity\\Database\\Factories\\StoredEventFactory', 25);
    }
    
    protected function populateCmsModule(): void
    {
        $this->command->info('Populating CMS module...');
        $this->createMultiple('Modules\\Cms\\Database\\Factories\\PageFactory', 10);
        $this->createMultiple('Modules\\Cms\\Database\\Factories\\SectionFactory', 8);
        $this->createMultiple('Modules\\Cms\\Database\\Factories\\PageContentFactory', 15);
    }
    
    protected function populateGdprModule(): void
    {
        $this->command->info('Populating GDPR module...');
        $this->createMultiple('Modules\\Gdpr\\Database\\Factories\\ConsentFactory', 12);
        $this->createMultiple('Modules\\Gdpr\\Database\\Factories\\ProfileFactory', 8);
    }
    
    protected function populateGeoModule(): void
    {
        $this->command->info('Populating Geo module...');
        $this->createMultiple('Modules\\Geo\\Database\\Factories\\AddressFactory', 15);
        $this->createMultiple('Modules\\Geo\\Database\\Factories\\ComuneFactory', 20);
        $this->createMultiple('Modules\\Geo\\Database\\Factories\\LocationFactory', 10);
    }
    
    protected function populateJobModule(): void
    {
        $this->command->info('Populating Job module...');
        $this->createMultiple('Modules\\Job\\Database\\Factories\\JobFactory', 15);
        $this->createMultiple('Modules\\Job\\Database\\Factories\\ImportFactory', 8);
    }
    
    protected function populateLangModule(): void
    {
        $this->command->info('Populating Lang module...');
        $this->createMultiple('Modules\\Lang\\Database\\Factories\\PostFactory', 10);
        $this->createMultiple('Modules\\Lang\\Database\\Factories\\TranslationFactory', 20);
    }
    
    protected function populateMediaModule(): void
    {
        $this->command->info('Populating Media module...');
        $this->createMultiple('Modules\\Media\\Database\\Factories\\MediaFactory', 25);
        $this->createMultiple('Modules\\Media\\Database\\Factories\\TemporaryUploadFactory', 10);
    }
    
    protected function populateNotifyModule(): void
    {
        $this->command->info('Populating Notify module...');
        $this->createMultiple('Modules\\Notify\\Database\\Factories\\ContactFactory', 15);
        $this->createMultiple('Modules\\Notify\\Database\\Factories\\MailTemplateFactory', 8);
    }
    
    protected function populateTenantModule(): void
    {
        $this->command->info('Populating Tenant module...');
        $this->createMultiple('Modules\\Tenant\\Database\\Factories\\TenantFactory', 5);
        $this->createMultiple('Modules\\Tenant\\Database\\Factories\\DomainFactory', 8);
    }
    
    protected function populateUserModule(): void
    {
        $this->command->info('Populating User module...');
        $this->createMultiple('Modules\\User\\Database\\Factories\\UserFactory', 30);
        $this->createMultiple('Modules\\User\\Database\\Factories\\RoleFactory', 5);
        $this->createMultiple('Modules\\User\\Database\\Factories\\ProfileFactory', 25);
    }
    
    protected function populateXotModule(): void
    {
        $this->command->info('Populating Xot module...');
        $this->createMultiple('Modules\\Xot\\Database\\Factories\\ModuleFactory', 6);
        $this->createMultiple('Modules\\Xot\\Database\\Factories\\CacheFactory', 10);
    }
    
    protected function populateSaluteOraModule(): void
    {
        $this->command->info('Populating SaluteOra module...');
        $this->createMultiple('Modules\\SaluteOra\\Database\\Factories\\UserFactory', 20);
        $this->createMultiple('Modules\\SaluteOra\\Database\\Factories\\PatientFactory', 25);
        $this->createMultiple('Modules\\SaluteOra\\Database\\Factories\\DoctorFactory', 15);
        $this->createMultiple('Modules\\SaluteOra\\Database\\Factories\\AppointmentFactory', 30);
    }
    
    protected function runModuleSeeders(): void
    {
        $this->command->info('Running module seeders...');
        
        $seeders = [
            'Modules\\Activity\\Database\\Seeders\\ActivityDatabaseSeeder',
            'Modules\\Cms\\Database\\Seeders\\CmsDatabaseSeeder',
            'Modules\\Gdpr\\Database\\Seeders\\GdprDatabaseSeeder',
            'Modules\\Geo\\Database\\Seeders\\GeoDatabaseSeeder',
            'Modules\\Job\\Database\\Seeders\\JobDatabaseSeeder',
            'Modules\\Lang\\Database\\Seeders\\LangDatabaseSeeder',
            'Modules\\Media\\Database\\Seeders\\MediaDatabaseSeeder',
            'Modules\\Notify\\Database\\Seeders\\NotifyDatabaseSeeder',
            'Modules\\Tenant\\Database\\Seeders\\TenantDatabaseSeeder',
            'Modules\\User\\Database\\Seeders\\UserDatabaseSeeder',
            'Modules\\Xot\\Database\\Seeders\\XotDatabaseSeeder',
            'Modules\\SaluteOra\\Database\\Seeders\\SaluteOraDatabaseSeeder',
        ];
        
        foreach ($seeders as $seeder) {
            $this->runSeeder($seeder);
        }
        
        // Run mass seeders if available
        $massSeeders = [
            'Modules\\Activity\\Database\\Seeders\\ActivityMassSeeder',
            'Modules\\Cms\\Database\\Seeders\\CmsMassSeeder',
            'Modules\\User\\Database\\Seeders\\UserMassSeeder',
            'Modules\\SaluteOra\\Database\\Seeders\\MassDataSeeder',
        ];
        
        foreach ($massSeeders as $seeder) {
            if (class_exists($seeder)) {
                $this->runSeeder($seeder);
            }
        }
    }
}