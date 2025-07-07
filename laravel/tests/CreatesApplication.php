<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        // Configura il database di test DOPO il bootstrap
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);

        // Configura anche le connessioni specifiche dei moduli per i test
        $app['config']->set('database.connections.user', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);
        
        $app['config']->set('database.connections.user_sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);

        // Configura il modello User corretto per i test
        $app['config']->set('auth.providers.users.model', 'Modules\\User\\Models\\User');
        
        // Disabilita configurazioni problematiche per i test
        $app['config']->set('tenant.enabled', false);
        
        // Disabilita View Composers problematici per i test
        $app['config']->set('view.composers', []);
        
        // Configura asset URL per evitare errori null
        $app['config']->set('app.asset_url', 'http://localhost');
        
        return $app;
    }
} 