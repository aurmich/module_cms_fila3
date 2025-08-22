<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Reinforce DB connection mapping after the app boots to counteract
        // any provider that may have overwritten configuration.
        $dbPath = '/var/www/html/_bases/base_saluteora/laravel/database/testing.sqlite';

        Config::set('database.default', 'sqlite');
        foreach ([
            'sqlite',
            'user',
            'salute_ora',
            'job',
            'tenant',
            'activity',
            'media',
            'xot',
            'notify',
        ] as $name) {
            Config::set("database.connections.$name", [
                'driver' => 'sqlite',
                'database' => $dbPath,
                'prefix' => '',
                'foreign_key_constraints' => true,
            ]);
            try {
                DB::purge($name);
                DB::reconnect($name);
            } catch (\Throwable $e) {
                // ignore
            }
        }
    }
}
