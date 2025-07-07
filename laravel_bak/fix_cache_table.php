<?php

// Set cache to array driver
putenv('CACHE_DRIVER=array');
$_ENV['CACHE_DRIVER'] = 'array';

// Include composer autoloader
require __DIR__.'/vendor/autoload.php';

// Create application
$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

// Bind important interfaces
$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

// Create a kernel instance
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Run the migration
$status = $kernel->call('migrate', [
    '--force' => true,
]);

echo $status === 0 ? "Migration completed successfully\n" : "Migration failed\n";
