<?php

namespace App\Zeus\DataSources;

use LaraZeus\Bolt\DataSources\DataSourceContract;

class FieldOption extends DataSourceContract
{
    public function title(): string
    {
        return static::class;
    }

    public function getValuesUsing(): string
    {
        return 'name';
    }

    public function getKeysUsing(): string
    {
        return 'key';
    }

    public function getModel(): string
    {
        
        return \Modules\UI\Models\FieldOption::class::setType('pippo');
    }
}

