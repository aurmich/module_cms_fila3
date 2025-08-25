<?php

// Validation script to check factories for example.com usage

echo "🔍 Checking factories for @example.com usage...\n\n";

$modules = [
    'Activity', 'Cms', 'Gdpr', 'Geo', 'Job', 'Lang', 'Media', 
    'Notify', 'Tenant', 'UI', 'User', 'Xot', 'SaluteMo', 'SaluteOra'
];

$hasIssues = false;

foreach ($modules as $module) {
    $factoryPath = "/var/www/html/_bases/base_saluteora/laravel/Modules/$module/database/factories";
    
    if (!is_dir($factoryPath)) {
        continue;
    }
    
    $files = glob("$factoryPath/*.php");
    
    foreach ($files as $file) {
        $content = file_get_contents($file);
        
        if (preg_match('/@example\.com/', $content)) {
            echo "❌ ISSUE FOUND: $file uses @example.com\n";
            $hasIssues = true;
            
            // Show the problematic line
            $lines = file($file);
            foreach ($lines as $lineNumber => $line) {
                if (strpos($line, '@example.com') !== false) {
                    echo "   Line " . ($lineNumber + 1) . ": " . trim($line) . "\n";
                }
            }
            echo "\n";
        }
    }
}

if (!$hasIssues) {
    echo "✅ All factories are clean - no @example.com usage found!\n";
    echo "✓ Factories follow proper Faker practices\n";
} else {
    echo "❌ Please fix the above issues before proceeding.\n";
    exit(1);
}

echo "\n🎯 Ready to populate database with realistic Faker data!\n";

?>