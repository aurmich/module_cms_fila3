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

        // Configure salute_ora database connection for tests
        config(['database.connections.salute_ora' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]]);
        
        // Configure test database connection
        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);
        
        // Set up any module-specific test configuration here
        // $this->artisan('module:migrate', ['module' => 'SaluteMo', '--force' => true]);
    }
}