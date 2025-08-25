<?php

// Simple tinker script to populate database using factories
// Usage: php artisan tinker --execute="require 'tinker_populate.php'"

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

function createWithFactory($factoryClass, $count = 10) {
    if (!class_exists($factoryClass)) {
        echo "Factory {$factoryClass} not found\n";
        return;
    }
    
    try {
        $factory = new $factoryClass();
        $factory->count($count)->create();
        echo "✓ Created {$count} records with {$factoryClass}\n";
    } catch (Exception $e) {
        echo "✗ Failed with {$factoryClass}: " . $e->getMessage() . "\n";
    }
}

echo "Starting database population with factories...\n\n";

// SaluteOra module - main application
echo "=== SALUTEORA MODULE ===\n";
createWithFactory('Modules\\SaluteOra\\Database\\Factories\\UserFactory', 20);
createWithFactory('Modules\\SaluteOra\\Database\\Factories\\PatientFactory', 25);
createWithFactory('Modules\\SaluteOra\\Database\\Factories\\DoctorFactory', 15);
createWithFactory('Modules\\SaluteOra\\Database\\Factories\\AppointmentFactory', 30);
createWithFactory('Modules\\SaluteOra\\Database\\Factories\\StudioFactory', 8);

// User module
echo "\n=== USER MODULE ===\n";
createWithFactory('Modules\\User\\Database\\Factories\\UserFactory', 15);
createWithFactory('Modules\\User\\Database\\Factories\\RoleFactory', 5);
createWithFactory('Modules\\User\\Database\\Factories\\ProfileFactory', 20);

// Activity module
echo "\n=== ACTIVITY MODULE ===\n";
createWithFactory('Modules\\Activity\\Database\\Factories\\ActivityFactory', 20);
createWithFactory('Modules\\Activity\\Database\\Factories\\SnapshotFactory', 10);

// CMS module
echo "\n=== CMS MODULE ===\n";
createWithFactory('Modules\\Cms\\Database\\Factories\\PageFactory', 8);
createWithFactory('Modules\\Cms\\Database\\Factories\\SectionFactory', 6);

// Geo module
echo "\n=== GEO MODULE ===\n";
createWithFactory('Modules\\Geo\\Database\\Factories\\AddressFactory', 15);
createWithFactory('Modules\\Geo\\Database\\Factories\\LocationFactory', 10);

echo "\n=== POPULATION COMPLETED ===\n";
echo "Database populated with realistic Faker data (no @example.com emails)!\n";

?>