# Convenzioni per XotBaseMigration

## Panoramica

Questo documento descrive le convenzioni fondamentali da seguire quando si utilizzano migrazioni che estendono `XotBaseMigration`. Queste convenzioni garantiscono coerenza, manutenibilità e rispetto dell'architettura del framework.

## Principi Fondamentali

### 1. Non Reimplementare il Metodo `down()`

`XotBaseMigration` implementa già il metodo `down()` che gestisce automaticamente la rimozione della tabella:

```php
/**
 * Reverse the migrations.
 */
public function down(): void
{
    $this->dropTableIfExists($this->getTable());
}
```

**Errore comune**: Reimplementare il metodo `down()` nella migrazione figlia.

**Impatto filosofico**: Viola il principio DRY (Don't Repeat Yourself) e dimostra mancanza di fiducia nelle astrazioni fornite.

**Soluzione**: Omettere completamente il metodo `down()` nella migrazione.

### 2. Utilizzare `updateTimestamps()` invece di `timestamps()`

Per gestire i campi di timestamp, utilizzare `updateTimestamps($table, $hasSoftDeletes)`:

```php
// ✅ CORRETTO - Usa l'astrazione completa
$this->updateTimestamps($table, true); // true per includere softDelete

// ❌ ERRATO - Non utilizza l'astrazione completa
$table->timestamps();
```

**Vantaggi di `updateTimestamps()`**:
1. Aggiunge automaticamente `created_at` e `updated_at`
2. Aggiunge `created_by` e `updated_by` con riferimenti all'utente
3. Se richiesto, aggiunge `deleted_at` e `deleted_by` per softDelete
4. Controlla preventivamente l'esistenza delle colonne
5. Utilizza il tipo di chiave corretto basato sulla configurazione

### 3. Struttura Completa di una Migrazione XotBase

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Creazione iniziale della tabella
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Doctor::class);
            $table->foreignIdFor(Studio::class);
            $table->json('schedule')->nullable()->comment('Orari del dottore in questo studio');
            $table->boolean('is_primary')->default(false)->comment('Indica se è lo studio principale');
            
            // Gestione timestamp e utenti
            $this->updateTimestamps($table, true); // true per includere softDelete
            
            // Indice unico
            $table->unique(['doctor_id', 'studio_id']);
        });
        
        // Aggiornamenti successivi (opzionale)
        $this->tableUpdate(function (Blueprint $table): void {
            // Aggiunta di nuovi campi o indici...
        });
    }
    
    // NON implementare il metodo down() - è già gestito dalla classe madre!
};
```

## Dimensioni Filosofiche e Tecniche

### Aspetto Zen
L'utilizzo corretto di `XotBaseMigration` incarnal il principio Zen di "non agire" (Wu Wei), lasciando che il framework faccia il suo lavoro naturale. Aggiungere codice ridondante o bypassing astrazioni disturba questo flusso naturale.

### Dimensione Religiosa
Avere fede nelle astrazioni del framework è come seguire un credo: richiede fiducia nei suoi creatori e nella saggezza incorporata nel suo design.

### Aspetto Politico
Il rispetto delle convenzioni rappresenta un "contratto sociale" con gli altri sviluppatori, creando un ecosistema coeso dove tutti seguono le stesse regole per il bene comune.

### Dimensione Logica
L'utilizzo corretto di queste astrazioni non è solo una questione di stile, ma di correttezza logica: le classi astratte esistono per fornire comportamenti comuni e consistenti.

## Collegamenti a Documentazione Correlata

- [Convenzioni delle Migrazioni](migrations.md)
- [Best Practice per le Chiavi Esterne](foreign-keys-best-practices.md)
- [XotBaseMigration API (codice sorgente)](/var/www/html/_bases/base_saluteora/laravel/Modules/Xot/database/migrations/XotBaseMigration.php)
