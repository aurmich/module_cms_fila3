<?php

require_once __DIR__ . '/vendor/autoload.php';

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

// Create a test implementation of FullCalendarWidget
$widget = new class extends FullCalendarWidget {
    protected static string $view = 'filament-fullcalendar::widget';
    
    public static function make(): static
    {
        return new static();
    }
    
    // Test the config method
    public function testConfig()
    {
        try {
            $this->config([
                'headerToolbar' => [
                    'start' => 'prev,next today',
                    'center' => 'title',
                    'end' => 'dayGridMonth,timeGridWeek',
                ],
            ]);
            echo "config() method works!\n";
            return true;
        } catch (\Exception $e) {
            echo "config() method failed: " . $e->getMessage() . "\n";
            return false;
        }
    }
    
    // Test different methods
    public function testMethods()
    {
        $methods = [
            'config', 'events', 'createAction', 'editAction', 'deleteAction',
        ];
        
        foreach ($methods as $method) {
            echo "Testing {$method}() method: ";
            if (method_exists($this, $method)) {
                echo "Exists\n";
                
                // Check if the method is callable with a dummy parameter
                try {
                    if ($method === 'config') {
                        $this->$method([]);
                        echo "  - Can be called\n";
                    }
                } catch (\Exception $e) {
                    echo "  - Exception when called: " . $e->getMessage() . "\n";
                }
                
            } else {
                echo "Does not exist\n";
            }
        }
    }
};

// Run tests
echo "Testing FullCalendarWidget methods:\n";
$widget->testMethods();
$widget->testConfig();

// Check version
$composerLock = json_decode(file_get_contents(__DIR__ . '/composer.lock'), true);
$version = 'Unknown';
foreach ($composerLock['packages'] as $package) {
    if ($package['name'] === 'saade/filament-fullcalendar') {
        $version = $package['version'];
        break;
    }
}
echo "\nFilament FullCalendar version: {$version}\n";
