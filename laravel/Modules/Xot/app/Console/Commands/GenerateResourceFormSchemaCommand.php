<?php

declare(strict_types=1);

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Modules\Xot\App\Helpers\ResourceFormSchemaGenerator;

class GenerateResourceFormSchemaCommand extends Command
{
    protected $signature = 'xot:generate-resource-form-schema {--module=} {--resource=}';

    protected $description = 'Genera gli schemi dei form per le risorse Filament';

    public function handle(): int
    {
        $module = $this->option('module');
        $resource = $this->option('resource');

        $generator = new ResourceFormSchemaGenerator();

        try {
            if ($module) {
                $generator->generateForModule($module, $resource);
            } else {
                $generator->generateForAllResources($resource);
            }

            $this->info('Schemi dei form generati con successo');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Errore durante la generazione degli schemi: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
