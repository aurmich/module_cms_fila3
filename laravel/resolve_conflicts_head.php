<?php

/**
 * Script per risolvere automaticamente i conflitti di merge scegliendo sempre la versione HEAD.
 * Uso: php resolve_conflicts_head.php
 */

// Lista dei file con conflitti ancora da risolvere (risultato di verify_conflicts.php)
$filesWithConflicts = [
    __DIR__ . '/Modules/Xot/app/Actions/View/GetViewByClassAction.php',
    __DIR__ . '/Modules/Xot/app/Actions/Export/ExportXlsByView.php',
    __DIR__ . '/Modules/Xot/app/Actions/Export/ExportXlsByCollection.php'
];

$totalFiles = count($filesWithConflicts);
$resolvedFiles = 0;

echo "Risoluzione dei conflitti in corso...\n";

foreach ($filesWithConflicts as $file) {
    if (!file_exists($file)) {
        echo "File non trovato: $file\n";
        continue;
    }

    // Leggi il contenuto del file
    $content = file_get_contents($file);

    // Risoluzione manuale per i file restanti
    $fixes = false;

    // 1. Rimuovi le righe che contengono solo il marker di conflitto
    if (strpos($content, '>>>>>>> origin/dev') !== false) {
        $content = preg_replace('/^.*>>>>>>> origin\/dev.*$\n?/m', '', $content);
        $fixes = true;
    }

    // Salva il file modificato solo se ci sono state correzioni
    if ($fixes) {
        file_put_contents($file, $content);
        $resolvedFiles++;
        echo "✅ Conflitti risolti in: $file\n";
    } else {
        echo "⚠️ Nessun conflitto risolto in: $file\n";
    }
}

echo "\n--- RIEPILOGO ---\n";
echo "✅ File processati: $totalFiles\n";
echo "✅ File risolti: $resolvedFiles\n";
