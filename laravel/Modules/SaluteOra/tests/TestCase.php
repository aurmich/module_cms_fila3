<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Ensure we only migrate once for the entire test process.
     */
    private static bool $migrated = false;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configure test environment for optimal performance
        Config::set('database.default', 'sqlite');
        Config::set('database.connections.sqlite.database', ':memory:');
        Config::set('database.connections.sqlite.foreign_key_constraints', true);

        // Some models use a dedicated connection name: 'salute_ora'. Point it to the same in-memory sqlite.
        Config::set('database.connections.salute_ora', array_merge(
            config('database.connections.sqlite'),
            ['database' => ':memory:']
        ));
        
        // Ensure minimal database operations for tests
        Config::set('app.env', 'testing');
        Config::set('cache.default', 'array');
        Config::set('session.driver', 'array');
        Config::set('queue.default', 'sync');

        // Run migrations once on the in-memory database to support factories
        if (! self::$migrated) {
            // In memory DB is per connection; re-migrate when app is rebooted
            Artisan::call('migrate', [
                '--force' => true,
            ]);
            // Migrate the salute_ora connection as well, if present
            Artisan::call('migrate', [
                '--force' => true,
                '--database' => 'salute_ora',
            ]);
            self::$migrated = true;
        }
    }

    protected function tearDown(): void
    {
        // Clean up any database connections
        if (app('db')->connection()->getPdo()) {
            app('db')->connection()->disconnect();
        }
        
        parent::tearDown();
    }
}