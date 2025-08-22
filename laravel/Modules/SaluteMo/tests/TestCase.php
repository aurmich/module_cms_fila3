<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure 'user' connection exists (global tests/Pest.php sets others)
        if (! config('database.connections.user')) {
            config(['database.connections.user' => [
                'driver' => 'sqlite',
                'database' => base_path('database/testing.sqlite'),
                'prefix' => '',
                'foreign_key_constraints' => true,
            ]]);
        }

        // Minimal Spatie Event Sourcing bindings for tests
        app()->when(\Spatie\EventSourcing\StoredEvents\EventSubscriber::class)
            ->needs('$storedEventRepository')
            ->give(\Spatie\EventSourcing\StoredEvents\Repositories\EloquentStoredEventRepository::class);

        // Configure an in-memory session for tests and start it to satisfy consumers
        if (! config('session.driver')) {
            config(['session.driver' => 'array']);
        }
        try {
            /** @var \Illuminate\Contracts\Session\Session $session */
            $session = app('session');
            if (method_exists($session, 'start')) {
                $session->start();
            }
        } catch (\Throwable $e) {
            // If session cannot be resolved yet, defer silently. Pest beforeAll/beforeEach will also try.
        }

        // Safety: ensure Eloquent has a resolver and dispatcher in test runtime
        \Illuminate\Database\Eloquent\Model::setConnectionResolver(app('db'));
        \Illuminate\Database\Eloquent\Model::setEventDispatcher(app('events'));
    }
}