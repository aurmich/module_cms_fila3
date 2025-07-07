<?php

// Script to check available methods in FullCalendarWidget
require_once __DIR__ . '/vendor/autoload.php';

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use ReflectionClass;

// Get all methods of the class
$reflector = new ReflectionClass(FullCalendarWidget::class);
$methods = $reflector->getMethods();

echo "Available methods in FullCalendarWidget:\n";
foreach ($methods as $method) {
    if ($method->class === FullCalendarWidget::class) {
        echo "- " . $method->name . "\n";
    }
}

// Check if specific methods exist
$methodsToCheck = ['config', 'options', 'configuration'];
echo "\nChecking specific methods:\n";
foreach ($methodsToCheck as $methodName) {
    echo "- Method '{$methodName}' exists: " . 
         (method_exists(FullCalendarWidget::class, $methodName) ? 'Yes' : 'No') . "\n";
}

// Get FullCalendarWidget version
$composerLock = json_decode(file_get_contents(__DIR__ . '/composer.lock'), true);
$version = 'Unknown';

foreach ($composerLock['packages'] as $package) {
    if ($package['name'] === 'saade/filament-fullcalendar') {
        $version = $package['version'];
        break;
    }
}

echo "\nFilament FullCalendar version: {$version}\n";
