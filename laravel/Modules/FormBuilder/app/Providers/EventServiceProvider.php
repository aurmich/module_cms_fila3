<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Providers;

use Modules\Xot\Providers\XotBaseEventServiceProvider;

class EventServiceProvider extends XotBaseEventServiceProvider
{
    public string $name = 'FormBuilder';
    public string $nameLower = 'formbuilder';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    protected $listen = [
        // Eventi specifici del modulo FormBuilder
        // 'Modules\FormBuilder\Events\FormCreated' => [
        //     'Modules\FormBuilder\Listeners\SendFormNotification',
        // ],
    ];

    protected $subscribe = [
        // Subscriber specifici del modulo FormBuilder
        // 'Modules\FormBuilder\Listeners\FormBuilderEventSubscriber',
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
