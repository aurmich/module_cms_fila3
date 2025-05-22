<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class GetViewByClassAction
{
    use QueueableAction;

    /**
     * Risolve il percorso della view basato sul namespace della classe.
     *
     * @param string $class Il nome completo della classe
     * @return string Il percorso della view
     */
    public function execute(string $class): string
    {
        $arr = explode('\\', $class);
        Assert::isArray($arr);

        // Verifica che la classe sia nel namespace Modules
        if ('Modules' !== $arr[0]) {
            throw new \InvalidArgumentException('Class must be in Modules namespace');
        }

        $module = $arr[1];
        $module_low = Str::lower($module);
        
        // Estrai il nome della classe e convertilo in kebab-case
        $class_name = Str::kebab(class_basename($class));
        
        // Costruisci il percorso della view
        return $module_low.'::pages.'.$class_name;
    }
} 