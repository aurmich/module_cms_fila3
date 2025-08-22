#!/usr/bin/env php
<?php
declare(strict_types=1);

$root = realpath(__DIR__ . '/../../laravel/Modules');
if ($root === false) {
    fwrite(STDERR, "Cannot resolve Modules path\n");
    exit(2);
}

/**
 * Scan modules for models, factories, and seeders.
 * Outputs a markdown table per module with coverage and flags missing items.
 */

$modules = array_values(array_filter(scandir($root), function ($f) use ($root) {
    return $f !== '.' && $f !== '..' && is_dir($root . DIRECTORY_SEPARATOR . $f);
}));

$report = [];
foreach ($modules as $module) {
    $modulePath = $root . DIRECTORY_SEPARATOR . $module;
    $modelsDir = $modulePath . '/app/Models';
    if (!is_dir($modelsDir)) {
        continue;
    }

    $models = [];
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($modelsDir));
    foreach ($rii as $file) {
        if ($file->isDir()) continue;
        $path = $file->getPathname();
        if (str_ends_with($path, '.php') === false) continue;
        $basename = basename($path);
        // Skip base/abstracts and legacy .old files and Policies
        if (preg_match('/(^Base|BasePivot|BaseModel|BaseMorphPivot|^Policies$)/', $basename)) continue;
        if (str_ends_with($basename, '.old')) continue;
        if (str_contains($path, '/Policies/')) continue;
        $class = pathinfo($basename, PATHINFO_FILENAME);
        $models[] = ['name' => $class, 'path' => $path];
    }

    // Factories
    $factoriesDir = $modulePath . '/database/factories';
    $factories = [];
    if (is_dir($factoriesDir)) {
        foreach (glob($factoriesDir . '/*Factory.php') as $f) {
            $factories[basename($f)] = $f;
        }
    }

    // Seeders
    $seedersDir = $modulePath . '/database/seeders';
    $seeders = [];
    if (is_dir($seedersDir)) {
        foreach (glob($seedersDir . '/*Seeder.php') as $s) {
            $seeders[] = $s;
        }
    }

    $rows = [];
    foreach ($models as $m) {
        $model = $m['name'];
        $factoryName = $model . 'Factory.php';
        $hasFactory = array_key_exists($factoryName, $factories);

        // Heuristic: consider model seeded if referenced in any seeder file
        $isSeeded = false;
        foreach ($seeders as $s) {
            $content = @file_get_contents($s) ?: '';
            if ($content !== '' && (str_contains($content, $model . '::') || str_contains($content, $model . 'Factory'))) {
                $isSeeded = true;
                break;
            }
        }

        $rows[] = [
            'model' => $model,
            'hasFactory' => $hasFactory,
            'isSeeded' => $isSeeded,
            'factoryPath' => $hasFactory ? $factories[$factoryName] : null,
        ];
    }

    $report[$module] = [
        'module' => $module,
        'models' => $rows,
        'seeders' => $seeders,
    ];
}

// Output markdown summary
foreach ($report as $mod => $data) {
    echo "# Module: {$mod}\n\n";
    echo "| Model | Factory | Seeded |\n|---|---|---|\n";
    foreach ($data['models'] as $row) {
        $f = $row['hasFactory'] ? 'yes' : 'no';
        $s = $row['isSeeded'] ? 'yes' : 'no';
        echo "| {$row['model']} | {$f} | {$s} |\n";
    }
    echo "\nSeeders (files):\n";
    foreach ($data['seeders'] as $s) {
        echo "- " . str_replace($root . '/', '', $s) . "\n";
    }
    echo "\n---\n\n";
}
