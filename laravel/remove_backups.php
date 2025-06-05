<?php

/**
 * Script per eliminare tutti i file di backup creati durante la risoluzione dei conflitti.
 * Uso: php remove_backups.php
 */

echo "Eliminazione file di backup in corso...\n";

// Utilizza il comando find per trovare tutti i file di backup
$command = 'find ' . escapeshellarg(__DIR__ . '/Modules') . ' -name "*.backup-*"';
exec($command, $backupFiles, $returnCode);

$count = 0;

if ($returnCode === 0 && !empty($backupFiles)) {
    foreach ($backupFiles as $file) {
        if (file_exists($file)) {
            unlink($file);
            echo "✅ Eliminato: $file\n";
            $count++;
        }
    }
} else {
    echo "⚠️ Nessun file di backup trovato o errore durante la ricerca.\n";
}

echo "\n--- RIEPILOGO ---\n";
echo "✅ File di backup eliminati: $count\n";
