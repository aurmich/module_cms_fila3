<?php

namespace App\Zeus\DataSources;

use Illuminate\Support\Str;
use LaraZeus\Bolt\DataSources\DataSourceContract;

class QuadranteOption extends DataSourceContract
{
    public function title(): string
    {
        return class_basename(static::class);
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
        $slug=Str::of($this->title())->before('Option')->slug()->toString();
        return \Modules\FormBuilder\Models\FieldOption::class::setType($slug);
    }
}

