<?php

declare(strict_types=1);

/**
 * @see https://github.com/paulvl/backup/blob/master/src/Console/Commands/MysqlDump.php
 */

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class GenerateFormCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected string $signature = 'xot:generate-form {module}';

    /**
     * The console command description.
     */
    protected string $description = 'fill form with inputs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $module_name = $this->argument('module');
        $module_path = Module::getModulePath($module_name);
        if (! Str::endsWith($module_path, '/')) {
            $module_path .= '/';
        }
        $filament_resources_path = $module_path.'Filament/Resources';

        $this->info($module_name); // = Progressioni
        $this->info($module_path); // = /var/www/html/ptvx/laravel/Modules/Progressioni/
        $this->info($filament_resources_path);

        $files = File::files($filament_resources_path);
        foreach ($files as $file) {
            app(\Modules\Xot\Actions\Filament\GenerateFormByFileAction::class)->execute($file);
        }
    }
}
