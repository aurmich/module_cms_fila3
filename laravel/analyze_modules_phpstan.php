<?php

/**
 * Script per analizzare i moduli Laravel con PHPStan.
 *
 * Questo script:
 * - Trova automaticamente tutti i moduli Laravel
 * - Usa PHPStan per analizzare la directory app di ogni modulo
 * - Salva i risultati in Modules/*/docs/phpstan/
 * - Crea file JSON e MD con rapporti dettagliati
 *
 * @author Claude
 * @version 1.0.0
 */

declare(strict_types=1);

// Impostazioni configurabili
$maxLevel = 8; // Livello massimo di analisi PHPStan
$modulesDir = __DIR__ . '/Modules'; // Directory dei moduli
$phpstanBin = __DIR__ . '/vendor/bin/phpstan'; // Percorso del binario PHPStan

// Verifica che PHPStan sia installato
if (!file_exists($phpstanBin)) {
    die("Errore: PHPStan non trovato in {$phpstanBin}. Assicurati che sia installato.\n");
}

// Verifica che la directory dei moduli esista
if (!is_dir($modulesDir)) {
    die("Errore: Directory dei moduli non trovata in {$modulesDir}.\n");
}

// Funzione per creare una directory se non esiste
function createDirIfNotExists(string $dir): bool {
    if (!is_dir($dir)) {
        return mkdir($dir, 0755, true);
    }
    return true;
}

// Funzione per generare un file markdown con suggerimenti per correggere gli errori
function generateMarkdownReport(array $errors, string $moduleDir, int $level): string {
    $output = "# Rapporto PHPStan Livello {$level}\n\n";
    $output .= "Data analisi: " . date('Y-m-d H:i:s') . "\n\n";

    if (empty($errors)) {
        $output .= "🎉 **Congratulazioni!** Nessun errore trovato a questo livello.\n";
        return $output;
    }

    $output .= "## Riepilogo\n\n";
    $output .= "Trovati " . count($errors) . " errori al livello {$level}.\n\n";
    $output .= "## Errori e suggerimenti\n\n";

    // Raggruppa gli errori per file
    $fileErrors = [];
    foreach ($errors as $error) {
        $file = $error['file'] ?? 'Sconosciuto';
        if (!isset($fileErrors[$file])) {
            $fileErrors[$file] = [];
        }
        $fileErrors[$file][] = $error;
    }

    // Elabora gli errori per file
    foreach ($fileErrors as $file => $fileErrorList) {
        $relativePath = str_replace($moduleDir . '/', '', $file);
        $output .= "### File: `{$relativePath}`\n\n";

        foreach ($fileErrorList as $error) {
            $line = $error['line'] ?? 'N/A';
            $message = $error['message'] ?? 'Errore sconosciuto';

            $output .= "#### Linea {$line}: {$message}\n\n";

            // Suggerimenti basati sul tipo di errore
            if (strpos($message, 'undefined method') !== false) {
                $output .= "**Suggerimento**: Questo metodo non esiste o non è accessibile. Verifica:\n";
                $output .= "- Se il metodo è definito nella classe\n";
                $output .= "- Se il metodo ha la visibilità corretta (public/protected/private)\n";
                $output .= "- Se stai importando la classe corretta\n";
                $output .= "- Se ci sono errori di digitazione nel nome del metodo\n\n";
            } elseif (strpos($message, 'undefined property') !== false) {
                $output .= "**Suggerimento**: Questa proprietà non esiste o non è accessibile. Verifica:\n";
                $output .= "- Se la proprietà è definita nella classe\n";
                $output .= "- Se la proprietà ha la visibilità corretta\n";
                $output .= "- Se stai usando un trait che definisce questa proprietà\n";
                $output .= "- Se la proprietà è impostata nel costruttore o in altri metodi\n\n";
            } elseif (strpos($message, 'typehint') !== false || strpos($message, 'return type') !== false) {
                $output .= "**Suggerimento**: C'è un problema con i type hint. Considera:\n";
                $output .= "- Aggiungere type hints espliciti ai parametri\n";
                $output .= "- Aggiungere il tipo di ritorno al metodo\n";
                $output .= "- Usare union types (e.g., `string|int`) o nullable types (e.g., `?string`) se necessario\n";
                $output .= "- Verificare che i tipi siano coerenti con la documentazione PHPDoc\n\n";
            } elseif (strpos($message, 'docblock') !== false || strpos($message, 'PHPDoc') !== false) {
                $output .= "**Suggerimento**: C'è un problema con la documentazione PHPDoc. Considera:\n";
                $output .= "- Aggiornare i tag @param e @return con i tipi corretti\n";
                $output .= "- Assicurarsi che la documentazione sia coerente con la firma del metodo\n";
                $output .= "- Aggiungere documentazione per tutti i parametri e valori di ritorno\n\n";
            } else {
                $output .= "**Suggerimento generale**: Rivedi il codice per assicurarti che:\n";
                $output .= "- Tutte le classi/interfacce utilizzate siano importate correttamente\n";
                $output .= "- I tipi siano dichiarati e utilizzati in modo coerente\n";
                $output .= "- Le variabili siano inizializzate prima dell'uso\n";
                $output .= "- I nomi di metodi e proprietà siano corretti\n\n";
            }
        }
    }

    $output .= "## Risorse utili\n\n";
    $output .= "- [Documentazione PHPStan](https://phpstan.org/user-guide/getting-started)\n";
    $output .= "- [Tipi in PHP](https://www.php.net/manual/en/language.types.declarations.php)\n";
    $output .= "- [PSR-12: Standard di codifica](https://www.php-fig.org/psr/psr-12/)\n";

    return $output;
}

// Ottenere tutti i moduli
$modules = glob($modulesDir . '/*', GLOB_ONLYDIR);

if (empty($modules)) {
    die("Nessun modulo trovato in {$modulesDir}.\n");
}

echo "Analisi PHPStan sui moduli Laravel\n";
echo "==================================\n";

// Avviare l'analisi per ogni modulo
foreach ($modules as $moduleDir) {
    $moduleName = basename($moduleDir);
    $appDir = $moduleDir . '/app';

    // Salta se la directory app non esiste
    if (!is_dir($appDir)) {
        echo "⚠️ Modulo {$moduleName}: Directory app non trovata. Saltato.\n";
        continue;
    }

    echo "\n📂 Analisi del modulo: {$moduleName}\n";

    // Crea la directory per i report PHPStan
    $phpstanDir = $moduleDir . '/docs/phpstan';
    if (!createDirIfNotExists($phpstanDir)) {
        echo "❌ Impossibile creare la directory {$phpstanDir}. Saltato.\n";
        continue;
    }

    // Analizza il modulo per ogni livello
    for ($level = 1; $level <= $maxLevel; $level++) {
        echo "  🔍 Livello {$level}... ";

        // File di output
        $outputJson = $phpstanDir . "/level_{$level}.json";
        $outputMd = $phpstanDir . "/level_{$level}.md";

        // Comando PHPStan
        $command = sprintf(
            '%s analyse --level=%d --error-format=json %s > %s 2>&1',
            escapeshellcmd($phpstanBin),
            $level,
            escapeshellarg($appDir),
            escapeshellarg($outputJson)
        );

        // Esegui PHPStan
        exec($command, $output, $returnCode);

        // Verifica il risultato
        if ($returnCode !== 0 && $returnCode !== 1) {
            // Il codice 1 indica che ci sono errori, che è normale
            echo "❌ Errore nell'esecuzione di PHPStan. Codice {$returnCode}.\n";
            continue;
        }

        // Leggi il file JSON generato
        if (!file_exists($outputJson)) {
            echo "❌ File di output non generato.\n";
            continue;
        }

        $jsonContent = file_get_contents($outputJson);
        $jsonData = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "❌ Errore nella decodifica del JSON: " . json_last_error_msg() . "\n";
            continue;
        }

        // Numero di errori trovati
        $errorCount = $jsonData['totals']['file_errors'] ?? 0;

        if ($errorCount === 0) {
            echo "✅ Nessun errore trovato.\n";
        } else {
            echo "⚠️ Trovati {$errorCount} errori.\n";

            // Genera il report markdown
            $errors = $jsonData['files'] ?? [];
            $flatErrors = [];

            // Appiattisci l'array di errori
            foreach ($errors as $file => $fileData) {
                foreach ($fileData['messages'] ?? [] as $message) {
                    $flatErrors[] = [
                        'file' => $file,
                        'line' => $message['line'] ?? 0,
                        'message' => $message['message'] ?? ''
                    ];
                }
            }

            $markdownReport = generateMarkdownReport($flatErrors, $moduleDir, $level);
            file_put_contents($outputMd, $markdownReport);

            // Cerca file con lo stesso errore e aggiorna la documentazione più vicina
            $docsDirs = [];
            foreach ($flatErrors as $error) {
                $file = $error['file'] ?? '';
                if (!empty($file) && file_exists($file)) {
                    $fileDir = dirname($file);
                    $docDir = null;

                    // Risali le directory fino a trovare una cartella docs
                    $currentDir = $fileDir;
                    while ($currentDir && $currentDir !== '/' && basename($currentDir) !== basename($modulesDir)) {
                        $possibleDocsDir = $currentDir . '/docs';
                        if (is_dir($possibleDocsDir)) {
                            $docDir = $possibleDocsDir;
                            break;
                        }
                        $currentDir = dirname($currentDir);
                    }

                    if ($docDir && !isset($docsDirs[$docDir])) {
                        $docsDirs[$docDir] = true;
                        $errorDoc = $docDir . '/phpstan_issues.md';

                        // Aggiungi o aggiorna il file di documentazione
                        $docContent = '';
                        if (file_exists($errorDoc)) {
                            $docContent = file_get_contents($errorDoc);
                        }

                        $docContent .= "\n## PHPStan Livello {$level} - " . date('Y-m-d') . "\n\n";
                        $docContent .= "Controlla il report completo in: `" . str_replace($moduleDir, "Modules/{$moduleName}", $outputMd) . "`\n\n";

                        file_put_contents($errorDoc, $docContent);
                    }
                }
            }
        }
    }

    echo "✅ Analisi completata per il modulo {$moduleName}.\n";
}

echo "\n🎉 Analisi PHPStan completata per tutti i moduli!\n";
echo "I report sono disponibili nelle rispettive directory docs/phpstan/\n";
