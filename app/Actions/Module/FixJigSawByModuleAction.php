<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Module;

use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Laravel\Module;
<<<<<<< HEAD
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\Finder\SplFileInfo;

use function Safe\realpath;

=======

use function Safe\realpath;

use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\Finder\SplFileInfo;

>>>>>>> bc33217 (.)
final class FixJigSawByModuleAction
{
    use QueueableAction;

    public function execute(Module $module): array
    {
        $res = [];
<<<<<<< HEAD
        $stubs_dir = realpath(__DIR__ . '/../../Console/Commands/stubs/docs');
=======
        $stubs_dir = realpath(__DIR__.'/../../Console/Commands/stubs/docs');
>>>>>>> bc33217 (.)
        // if ($stubs_dir === false) {
        //    throw new Exception('['.__LINE__.']['.__FILE__.']');
        // }

        $stubs = File::allFiles($stubs_dir);
        foreach ($stubs as $stub) {
<<<<<<< HEAD
            if (!$stub->isFile()) {
=======
            if (! $stub->isFile()) {
>>>>>>> bc33217 (.)
                continue;
            }

            if ('stub' !== $stub->getExtension()) {
                continue;
            }

            $res[] = $this->publish($stub, $module);
        }

        return $res;
    }

    public function publish(SplFileInfo $stub, Module $module): string
    {
        $filename = str_replace('.stub', '', $stub->getRelativePathname());
<<<<<<< HEAD
        $file_path = $module->getPath() . '/docs/' . $filename;
        $file_path = app(\Modules\Xot\Actions\File\FixPathAction::class)->execute($file_path);
        /*
         * //mkdir(): Permission denied
         * if (! is_dir(dirname($file_path))) {
         * (new Filesystem())->makeDirectory(dirname($file_path));
         * }
         */
=======
        $file_path = $module->getPath().'/docs/'.$filename;
        $file_path = app(\Modules\Xot\Actions\File\FixPathAction::class)->execute($file_path);
        /*
        //mkdir(): Permission denied
        if (! is_dir(dirname($file_path))) {
            (new Filesystem())->makeDirectory(dirname($file_path));
        }
        */
>>>>>>> bc33217 (.)

        $replace = [
            'ModuleName' => $module->getName(),
        ];

<<<<<<< HEAD
        $file_content = str_replace(array_keys($replace), array_values($replace), $stub->getContents());
=======
        $file_content = str_replace(
            array_keys($replace),
            array_values($replace),
            $stub->getContents(),
        );
>>>>>>> bc33217 (.)
        File::put($file_path, $file_content);

        return $file_path;
    }
}
