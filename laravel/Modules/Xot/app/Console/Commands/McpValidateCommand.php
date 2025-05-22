<?php

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Modules\Xot\Services\MCPService;

class McpValidateCommand extends Command
{
    protected $signature = 'mcp:validate {model? : Nome del modello da validare}';
    protected $description = 'Valida il contesto dei modelli secondo il Model Context Protocol';

    public function __construct(
        private readonly MCPService $mcpService
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $model = $this->argument('model');

        if ($model) {
            $this->validateModel($model);
        } else {
            $this->validateAllModels();
        }
    }

    protected function validateAllModels(): void
    {
        $this->info('Validazione contesti modelli...');

        foreach (config('mcp.contexts', []) as $model => $context) {
            $this->validateModel($model);
        }
    }

    protected function validateModel(string $model): void
    {
        $this->info("\nValidazione modello: {$model}");

        $result = $this->mcpService->validateModel($model);

        if ($result['valid']) {
            $this->info("✅ {$model} valido");
        } else {
            $this->error("❌ {$model} non valido:");
            foreach ($result['errors'] as $error) {
                $this->line("- {$error}");
            }
        }
    }
}
