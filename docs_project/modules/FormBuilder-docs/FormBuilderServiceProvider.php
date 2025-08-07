<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class FormBuilderServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'FormBuilder';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
