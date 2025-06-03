<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Module;

use Webmozart\Assert\Assert;

class GetModulePathByGeneratorAction
{
    public function execute(string $moduleName, string $generatorPath): string
    {
        $relativePath = config('modules.paths.generator.'.$generatorPath.'.path');
        try{
            $res = module_path($moduleName, $relativePath);
        }catch(\Error $e){
            throw new \Exception($e->getMessage()."\n module name: [".$moduleName."]\n generator path: [". $generatorPath."]\n relative path: [". $relativePath."]");
        }
        Assert::string($res);

        return $res;
    }
}
