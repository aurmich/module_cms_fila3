<?php

define('LARAVEL_START', microtime(true));

// Set cache to file driver before loading anything
putenv('CACHE_DRIVER=file');
$_ENV['CACHE_DRIVER'] = 'file';
$_SERVER['CACHE_DRIVER'] = 'file';

// Bootstrap Laravel
$app = require_once __DIR__.'/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
