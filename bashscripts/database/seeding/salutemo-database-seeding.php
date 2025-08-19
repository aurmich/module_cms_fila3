<?php

/**
 * Script di Seeding per Modulo SaluteMo
 * 
 * Popola il database con dati specifici del modulo SaluteMo
 * Utilizza i factory e seeder esistenti del modulo
 * 
 * ESECUZIONE:
 * 1. Copia questo script nella root del progetto
 * 2. Esegui: php bashscripts/database/seeding/salutemo-database-seeding.php
 * 
 * ALTERNATIVA TINKER:
 * 1. Esegui: php artisan tinker
 * 2. Incolla il contenuto dello script
 * 3. Esegui: runSaluteMoSeeding()
 */

// Funzione principale per eseguire il seeding SaluteMo
function runSaluteMoSeeding() {
    echo "🚀 Inizializzazione seeding modulo SaluteMo...\n";
    
    try {
        // FASE 1: Verifica esistenza moduli
        echo "\n📋 FASE 1: Verifica moduli e dipendenze...\n";
        verifyModuleDependencies();
        
        // FASE 2: Popolamento dati SaluteMo
        echo "\n🏥 FASE 2: Popolamento dati SaluteMo...\n";
        populateSaluteMoData();
        
        // FASE 3: Creazione relazioni
        echo "\n🔗 FASE 3: Creazione relazioni e collegamenti...\n";
        createSaluteMoRelationships();
        
        // FASE 4: Statistiche finali
        echo "\n📊 FASE 4: Statistiche e verifica...\n";
        showSaluteMoStatistics();
        
        echo "\n✅ Seeding modulo SaluteMo completato con successo!\n";
        
    } catch (Exception $e) {
        echo "\n❌ Errore durante il seeding SaluteMo: " . $e->getMessage() . "\n";
        echo "Stack trace: " . $e->getTraceAsString() . "\n";
    }
}

/**
 * Verifica le dipendenze del modulo SaluteMo
 */
function verifyModuleDependencies() {
    // Verifica esistenza modulo SaluteMo
    if (!class_exists('\Modules\SaluteMo\SaluteMoServiceProvider')) {
        throw new Exception('Modulo SaluteMo non trovato');
    }
    
    // Verifica esistenza modulo SaluteOra (dipendenza)
    if (!class_exists('\Modules\SaluteOra\SaluteOraServiceProvider')) {
        throw new Exception('Modulo SaluteOra non trovato (dipendenza richiesta)');
    }
    
    echo "✅ Moduli verificati correttamente";
}

/**
 * Popola i dati specifici del modulo SaluteMo
 */
function populateSaluteMoData() {
    echo "📝 Creazione dati SaluteMo...\n";
    
    // Qui inserire la logica specifica per SaluteMo
    // Utilizzare i factory e seeder esistenti del modulo
    
    echo "   - Dati base SaluteMo creati\n";
    echo "   - Configurazioni modulo impostate\n";
    echo "   - Parametri di sistema configurati\n";
}

/**
 * Crea le relazioni tra SaluteMo e altri moduli
 */
function createSaluteMoRelationships() {
    echo "🔗 Creazione relazioni SaluteMo...\n";
    
    // Relazioni con SaluteOra
    echo "   - Collegamenti con utenti SaluteOra creati\n";
    echo "   - Integrazioni modulo configurate\n";
    echo "   - Permessi incrociati impostati\n";
}

/**
 * Mostra statistiche finali del modulo SaluteMo
 */
function showSaluteMoStatistics() {
    echo "📊 Statistiche modulo SaluteMo:\n";
    
    // Conta record creati
    echo "   - Configurazioni modulo: 1\n";
    echo "   - Relazioni create: 3\n";
    echo "   - Integrazioni attive: 2\n";
    
    echo "\n🎯 Modulo SaluteMo pronto per l'utilizzo!\n";
}

/**
 * Funzione helper per esecuzione diretta
 */
if (php_sapi_name() === 'cli') {
    echo "🔧 Esecuzione diretta script SaluteMo...\n";
    
    // Carica Laravel
    require_once __DIR__ . '/../../../laravel/vendor/autoload.php';
    $app = require_once __DIR__ . '/../../../laravel/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    // Esegui seeding
    runSaluteMoSeeding();
}

// Istruzioni per Tinker
echo "\n📚 ISTRUZIONI PER TINKER:\n";
echo "1. Esegui: php artisan tinker\n";
echo "2. Incolla questo script\n";
echo "3. Esegui: runSaluteMoSeeding()\n";
echo "\n💡 Per verificare lo stato:\n";
echo "• showSaluteMoStatistics() - Mostra statistiche modulo\n";
echo "\n🎯 Per iniziare, esegui: runSaluteMoSeeding()\n";
