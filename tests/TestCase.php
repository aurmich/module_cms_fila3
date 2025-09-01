<?php

declare(strict_types=1);

namespace Modules\Cms\Tests;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase as BaseTestCase;

/**
 * TestCase base per il modulo Cms.
 */
abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        /*
        // Configurazione base per i test Cms
        config(['app.env' => 'testing']);

        // Map 'user' connection to same MySQL connection used by default to ensure factories work
        config(['database.connections.user' => config('database.connections.mysql')]);

        // Disabilita i View Composer che creano problemi (es. metatags)
        \Illuminate\Support\Facades\View::composer('*', function () {
            // no-op per test
        });


            // Esegui le migrazioni sul database di default (mysql test)
        Artisan::call('migrate:fresh', [
            '--force' => true,
        ]);

        // Esegui le migrazioni anche sulla connessione 'user'
        Artisan::call('migrate:fresh', [
            '--database' => 'user',
            '--force' => true,
        ]);
        */
    }
}
