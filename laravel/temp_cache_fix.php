<?php

// Load Laravel
require __DIR__.'/vendor/autoload.php';

// Update the cache configuration
$configPath = __DIR__.'/config/cache.php';
$config = file_get_contents($configPath);
$updatedConfig = str_replace("'driver' => 'database'", "'driver' => 'file'", $config);
file_put_contents($configPath, $updatedConfig);

echo "Cache configuration updated to use file driver.\n";
