<?php

declare(strict_types=1);

// Modules/SaluteOra/Tests/TestCase.php

namespace Modules\SaluteOra\Tests;

use Tests\TestCase as BaseTestCase;

/**
 * TestCase base per il modulo SaluteOra.
 * 
 * Questo TestCase fornisce il setup base per tutti i test del modulo,
 * inclusi trait per database refresh e setup specifico del modulo.
 */
abstract class TestCase extends BaseTestCase
{
    
    /**
     * Setup eseguito prima di ogni test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup specifico per il modulo SaluteOra
        $this->setupSaluteOraEnvironment();
    }
    
    /**
     * Setup specifico per l'ambiente SaluteOra.
     */
    protected function setupSaluteOraEnvironment(): void
    {
        // Modalità test per servizi esterni
        config(['saluteora.test_mode' => true]);
        
        // Mock servizi di notifica SMS/Email in test
        config(['mail.default' => 'log']);
        config(['sms.default' => 'log']);
        
        // Configurazione privacy/GDPR per test
        config(['saluteora.gdpr.encryption' => false]); // Per facilitare test
        config(['saluteora.audit.enabled' => true]);
        
        // Setup timezone sanitario
        config(['app.timezone' => 'Europe/Rome']);
    }
    
    /**
     * Teardown eseguito dopo ogni test.
     */
    protected function tearDown(): void
    {
        // Cleanup specifico del modulo (se necessario)
        
        parent::tearDown();
    }
}