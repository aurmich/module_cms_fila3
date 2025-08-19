<?php

declare(strict_types=1);

/**
 * Script rapido per seeding con Artisan
 * 
 * Esegui con: php artisan tinker < scripts/quick_seed.php
 */

echo "🚀 Seeding rapido del database...\n";

// Esegui il seeder principale
Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\DatabaseSeeder']);
echo Artisan::output();

echo "\n✅ Seeding base completato!\n";
echo "🔥 Per popolare con MOLTI MOLTI record, esegui:\n";
echo "php artisan tinker < scripts/populate_database.php\n\n";
