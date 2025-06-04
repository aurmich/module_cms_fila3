<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Providers;

use Illuminate\Support\Facades\Event;
use Modules\Xot\Providers\XotBaseEventServiceProvider;

/**
 * Event service provider for the SaluteMo module.
 *
 * This class manages event discovery and registration for the SaluteMo module.
 * It extends XotBaseEventServiceProvider to inherit common event handling functionality.
 *
 * @package Modules\SaluteMo\Providers
 */
class EventServiceProvider extends XotBaseEventServiceProvider
{
    /**
     * The module name for event discovery.
     *
     * @var string
     */
    protected string $moduleName = 'SaluteMo';

    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Example:
        // 'Modules\SaluteMo\Events\ExampleEvent' => [
        //     'Modules\SaluteMo\Listeners\ExampleListener',
        // ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array<int, string>
     */
    protected $subscribe = [
        // 'Modules\SaluteMo\Listeners\ExampleEventSubscriber',
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Get the listener directories that should be used to discover events.
     *
     * @return array<int, string>
     */
    protected function discoverEventsWithin(): array
    {
        return [
            app_path('Listeners'),
            module_path($this->moduleName, 'app/Listeners'),
        ];
    }

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        // Register any manual event listeners here
        // Event::listen('event.name', function ($foo, $bar) {
        //     //
        // });
    }
}
