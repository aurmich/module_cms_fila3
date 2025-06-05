<?php

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class McpCheckCommand extends Command
{
    protected $signature = 'mcp:check {--fix : Correggi automaticamente le violazioni}';
    protected $description = 'Controlla le regole MCP nel progetto';

    protected $rules = [
        'filament' => [
            'pattern' => '/extends\s+Resource/',
            'correct' => 'extends XotBaseResource',
            'message' => 'Le classi Resource devono estendere XotBaseResource',
        ],
        'parental' => [
            'pattern' => '/class\s+(\w+)\s+(?!extends\s+User)/',
            'correct' => 'class $1 extends User\nuse HasParent;',
            'message' => 'I modelli devono estendere User e usare HasParent',
        ],
        'translations' => [
            'pattern' => '/->label\([\'"]\w+[\'"]\)/',
            'correct' => "->label(__('module.key'))",
            'message' => 'Usare LangServiceProvider per le traduzioni',
        ],
    ];

    public function handle()
    {
        $this->info('Controllo regole MCP...');

        $violations = $this->checkRules();

        if (empty($violations)) {
            $this->info('Nessuna violazione trovata.');
            return 0;
        }

        $this->displayViolations($violations);

        if ($this->option('fix')) {
            $this->fixViolations($violations);
        }

        return count($violations);
    }

    protected function checkRules(): array
    {
        $violations = [];

        foreach ($this->rules as $type => $rule) {
            $files = $this->findFiles($type);

            foreach ($files as $file) {
                $content = File::get($file);

                if (preg_match($rule['pattern'], $content)) {
                    $violations[] = [
                        'type' => $type,
                        'file' => $file,
                        'rule' => $rule,
                    ];
                }
            }
        }

        return $violations;
    }

    protected function findFiles(string $type): array
    {
        $paths = [
            'filament' => 'app/Filament/**/*.php',
            'parental' => 'app/Models/**/*.php',
            'translations' => 'lang/**/*.php',
        ];

        $finder = new Finder();
        $finder->files()
            ->in(base_path())
            ->name('*.php')
            ->path($paths[$type]);

        return array_map(fn($file) => $file->getPathname(), iterator_to_array($finder));
    }

    protected function displayViolations(array $violations): void
    {
        $this->error(sprintf('Trovate %d violazioni:', count($violations)));

        foreach ($violations as $violation) {
            $this->line(sprintf(
                "\n- %s\n  File: %s\n  Messaggio: %s",
                $violation['type'],
                $violation['file'],
                $violation['rule']['message']
            ));
        }
    }

    protected function fixViolations(array $violations): void
    {
        $this->info('Correzione violazioni...');

        foreach ($violations as $violation) {
            $content = File::get($violation['file']);
            $fixed = preg_replace(
                $violation['rule']['pattern'],
                $violation['rule']['correct'],
                $content
            );

            File::put($violation['file'], $fixed);
            $this->line(sprintf('Corretto: %s', $violation['file']));
        }
    }
}
