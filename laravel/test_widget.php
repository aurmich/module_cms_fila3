<?php

require_once __DIR__ . '/vendor/autoload.php';

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

// Get a reflection of the make method to see what it returns
$reflector = new ReflectionClass(FullCalendarWidget::class);
$makeMethod = $reflector->getMethod('make');
echo "make() method return type: " . ($makeMethod->getReturnType() ?? 'none') . "\n";

// Check the actual instance type
$widget = FullCalendarWidget::make();
echo "Actual instance type: " . get_class($widget) . "\n";

// See what methods are available on the returned object
$methods = get_class_methods($widget);
echo "Available methods on returned object:\n";
print_r($methods);

// Check the package version
$composerLock = json_decode(file_get_contents(__DIR__ . '/composer.lock'), true);
$version = 'Unknown';
foreach ($composerLock['packages'] as $package) {
    if ($package['name'] === 'saade/filament-fullcalendar') {
        $version = $package['version'];
        break;
    }
}
echo "\nFilament FullCalendar version: {$version}\n";
