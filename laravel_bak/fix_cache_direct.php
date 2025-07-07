<?php

// Load Laravel
require __DIR__.'/vendor/autoload.php';

// Create application
$app = require_once __DIR__.'/bootstrap/app.php';

// Run the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Disable cache for this request
$app['config']->set('cache.default', 'array');

// Run the migration
try {
    $exitCode = $kernel->call('migrate:install');
    echo "Migration table created successfully\n";
    
    $exitCode = $kernel->call('migrate', ['--force' => true]);
    echo "Migrations completed successfully\n";
    
    exit(0);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
