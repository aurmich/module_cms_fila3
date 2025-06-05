<?php

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Modules\Xot\Actions\File\GetComponentsAction;

class AnalyzeComponentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xot:analyze-components {--module=} {--type=} {--prefix=} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analizza i componenti del sistema';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(GetComponentsAction $getComponentsAction)
    {
        $module = $this->option('module');
        $type = $this->option('type');
        $prefix = $this->option('prefix') ?? '';
        $force = $this->option('force') ?? false;

        $path = $module ? base_path("laravel/Modules/{$module}") : base_path('laravel/Modules');
        $namespace = $module ? "Modules\\{$module}" : 'Modules';

        $components = $getComponentsAction->execute($path, $namespace, $prefix, $force);

        $this->table(
            ['Componente', 'Tipo', 'Modulo', 'Path'],
            collect($components)->map(function ($component) {
                return [
                    $component['comp_name'],
                    $component['type'],
                    $component['module'],
                    $component['path'],
                ];
            })
        );

        return Command::SUCCESS;
    }
}
