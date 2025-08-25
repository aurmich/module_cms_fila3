<?php

// Simple tinker script to run the mass population seeder
// Usage: php artisan tinker --execute="require 'populate_with_tinker.php'"

use Database\\Seeders\\DatabaseMassPopulationSeeder;

$seeder = new DatabaseMassPopulationSeeder();
$seeder->run();

echo "Database population completed via tinker!\n";

?>