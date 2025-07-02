<?php

namespace Modules\SaluteOra\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function Safe\preg_match;

class CheckDirectoryStructure extends Command
{
    protected $signature = 'saluteora:check-structure';
    protected $description = 'Verifica la struttura delle directory del modulo SaluteOra';

    public function handle(): int
    {
        $this->info('Verifica struttura directory SaluteOra...');

        $basePath = module_path('SaluteOra');
        $errors = [];

        // Verifica directory Filament
        $filamentPath = $basePath . '/app/Filament';
        if (!File::isDirectory($filamentPath)) {
            $errors[] = "Directory mancante: {$filamentPath}";
        }

        // Verifica directory Resources
        $resourcesPath = $filamentPath . '/Resources';
        if (!File::isDirectory($resourcesPath)) {
            $errors[] = "Directory mancante: {$resourcesPath}";
        }

        // Verifica namespace nei file
        $this->checkNamespaces($basePath, $errors);

        if (empty($errors)) {
            $this->info('✓ Struttura directory corretta!');
            return 0;
        }

        $this->error('❌ Errori trovati:');
        foreach ($errors as $error) {
            $this->line("  - {$error}");
        }

        return 1;
    }

    protected function checkNamespaces(string $basePath, array &$errors): void
    {
        $files = File::allFiles($basePath . '/app');
        foreach ($files as $file) {
            if ($file->getExtension() === 'php') {
                $content = File::get($file->getPathname());
                $relativePath = str_replace($basePath . '/', '', $file->getPathname());
                
                // Verifica namespace corretto
                if (strpos($relativePath, 'Filament') !== false) {
                    $expectedNamespace = 'Modules\\SaluteOra\\' . str_replace('/', '\\', dirname($relativePath));
                    if (!preg_match("/namespace\s+{$expectedNamespace}/", $content)) {
                        $errors[] = "Namespace errato in {$relativePath}. Dovrebbe essere: {$expectedNamespace}";
                    }
                }
            }
        }
    }
} 