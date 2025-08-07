# Best Practices per le Migrazioni

## Introduzione

Le migrazioni sono un sistema di controllo versione per il database che permettono di modificare la struttura del database in modo controllato e riproducibile. In questo modulo, seguiamo un insieme di best practices per garantire che le migrazioni siano robuste, manutenibili e compatibili con il pattern Single Table Inheritance (STI) utilizzato nel progetto.

## Struttura Base di una Migrazione

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Nome della tabella da creare o modificare.
     */
    protected string $table = 'doctor_registration_workflows';
    
    /**
     * Connessione del database da utilizzare.
     */
    protected ?string $connection = 'mysql';
    
    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('doctor_id')->constrained('users')->cascadeOnDelete();
            $table->string('current_step');
            $table->string('status');
            $table->timestamp('started_at');
            $table->timestamp('last_interaction_at');
            $table->timestamp('completed_at')->nullable();
            $table->string('session_id')->nullable();
            $table->text('moderation_notes')->nullable();
            $table->timestamps();
        });
    }
    
    /**
     * Annulla la migrazione.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
```

## Convenzioni di Nomenclatura

### Nomi dei File di Migrazione

I nomi dei file di migrazione dovrebbero seguire il formato:

```
YYYY_MM_DD_HHMMSS_descrizione_della_migrazione.php
```

Esempi:
- `2025_05_15_000001_create_doctor_registration_workflows_table.php`
- `2025_05_15_000002_add_moderation_notes_to_doctor_registration_workflows_table.php`

### Nomi delle Tabelle

I nomi delle tabelle dovrebbero essere:
- Plurali
- Minuscoli
- Separati da underscore
- Descrittivi del contenuto

Esempi:
- `users`
- `doctor_registration_workflows`
- `patient_medical_records`

## Proprietà della Classe di Migrazione

### Proprietà $table

Ogni migrazione dovrebbe dichiarare una proprietà `$table` che specifica il nome della tabella:

```php
protected string $table = 'doctor_registration_workflows';
```

### Proprietà $connection

Se necessario, specificare la connessione del database:

```php
protected ?string $connection = 'mysql';
```

## Tipi di Colonne

### Chiavi Primarie

Utilizzare UUID per le chiavi primarie:

```php
$table->uuid('id')->primary();
```

### Chiavi Esterne

Utilizzare `foreignUuid` per le chiavi esterne che fanno riferimento a colonne UUID:

```php
$table->foreignUuid('doctor_id')->constrained('users')->cascadeOnDelete();
```

### Timestamp

Utilizzare `timestamps()` per aggiungere automaticamente le colonne `created_at` e `updated_at`:

```php
$table->timestamps();
```

Per colonne timestamp specifiche:

```php
$table->timestamp('started_at');
$table->timestamp('completed_at')->nullable();
```

### Enum

Per colonne che rappresentano enum:

```php
$table->string('status');
```

Poi, nel modello, utilizzare il cast per convertire la stringa in un enum:

```php
protected function casts(): array
{
    return [
        'status' => DoctorRegistrationStatus::class,
    ];
}
```

### JSON

Per colonne che contengono dati JSON:

```php
$table->json('certifications')->nullable();
$table->json('availability')->nullable();
```

## Single Table Inheritance (STI)

Quando si utilizza il pattern Single Table Inheritance, è importante ricordare che tutti i campi utilizzati dai modelli specializzati devono essere presenti nella tabella base.

### Aggiunta di Campi per STI

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('type')->nullable();
    $table->string('registration_number')->nullable();
    $table->string('specialization')->nullable();
    $table->json('certifications')->nullable();
    $table->json('availability')->nullable();
});
```

### Discriminatore di Tipo

Il campo discriminatore (solitamente `type`) dovrebbe essere aggiunto alla tabella base:

```php
$table->string('type')->nullable();
```

## Documentazione nelle Migrazioni

### Commenti di Classe

```php
/**
 * Migrazione per creare la tabella doctor_registration_workflows.
 * 
 * Questa tabella tiene traccia del processo di registrazione dei dottori,
 * inclusi i passaggi completati, lo stato corrente e le note di moderazione.
 */
return new class extends Migration
{
    // ...
};
```

### Commenti di Metodo

```php
/**
 * Esegue la migrazione.
 * 
 * Crea la tabella doctor_registration_workflows con le seguenti colonne:
 * - id: UUID, chiave primaria
 * - doctor_id: UUID, chiave esterna alla tabella users
 * - current_step: stringa che rappresenta il passaggio corrente del workflow
 * - status: stringa che rappresenta lo stato del workflow
 * - started_at: timestamp di inizio del workflow
 * - last_interaction_at: timestamp dell'ultima interazione
 * - completed_at: timestamp di completamento del workflow (nullable)
 * - session_id: ID della sessione (nullable)
 * - moderation_notes: note di moderazione (nullable)
 * - created_at, updated_at: timestamp standard
 */
public function up(): void
{
    // ...
}
```

### Commenti di Colonna

```php
Schema::create($this->table, function (Blueprint $table) {
    $table->uuid('id')->primary(); // UUID come chiave primaria
    $table->foreignUuid('doctor_id')->constrained('users')->cascadeOnDelete(); // Riferimento al dottore
    $table->string('current_step'); // Passaggio corrente del workflow
    $table->string('status'); // Stato del workflow (pending, approved, rejected, completed)
    $table->timestamp('started_at'); // Data di inizio del workflow
    $table->timestamp('last_interaction_at'); // Data dell'ultima interazione
    $table->timestamp('completed_at')->nullable(); // Data di completamento del workflow
    $table->string('session_id')->nullable(); // ID della sessione
    $table->text('moderation_notes')->nullable(); // Note di moderazione
    $table->timestamps(); // created_at e updated_at
});
```

## Gestione delle Modifiche al Database

### Aggiunta di Colonne

```php
Schema::table($this->table, function (Blueprint $table) {
    $table->text('moderation_notes')->nullable()->after('session_id');
});
```

### Modifica di Colonne

```php
Schema::table($this->table, function (Blueprint $table) {
    $table->string('status', 50)->change();
});
```

### Rimozione di Colonne

```php
Schema::table($this->table, function (Blueprint $table) {
    $table->dropColumn('old_column');
});
```

### Rinomina di Colonne

```php
Schema::table($this->table, function (Blueprint $table) {
    $table->renameColumn('old_name', 'new_name');
});
```

## Indici

### Creazione di Indici

```php
Schema::table($this->table, function (Blueprint $table) {
    $table->index('email');
    $table->unique(['tenant_id', 'email']);
    $table->fullText('description');
});
```

### Rimozione di Indici

```php
Schema::table($this->table, function (Blueprint $table) {
    $table->dropIndex(['email']);
    $table->dropUnique(['tenant_id', 'email']);
    $table->dropFullText(['description']);
});
```

## Transazioni

Le migrazioni vengono eseguite all'interno di una transazione per garantire l'atomicità delle operazioni. Non è necessario aggiungere manualmente le transazioni.

## Errori Comuni e Come Evitarli

### 1. Mancanza della Proprietà $table

```php
// ❌ ERRATO
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_registration_workflows', function (Blueprint $table) {
            // ...
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('doctor_registration_workflows');
    }
};

// ✅ CORRETTO
return new class extends Migration
{
    protected string $table = 'doctor_registration_workflows';
    
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            // ...
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
```

### 2. Mancanza di Documentazione

```php
// ❌ ERRATO
public function up(): void
{
    Schema::create($this->table, function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('doctor_id')->constrained('users');
        $table->string('current_step');
        $table->string('status');
        // ...
    });
}

// ✅ CORRETTO
/**
 * Esegue la migrazione.
 * 
 * Crea la tabella doctor_registration_workflows con le colonne necessarie
 * per tracciare il processo di registrazione dei dottori.
 */
public function up(): void
{
    Schema::create($this->table, function (Blueprint $table) {
        $table->uuid('id')->primary(); // UUID come chiave primaria
        $table->foreignUuid('doctor_id')->constrained('users')->cascadeOnDelete(); // Riferimento al dottore
        $table->string('current_step'); // Passaggio corrente del workflow
        $table->string('status'); // Stato del workflow
        // ...
    });
}
```

### 3. Mancanza di Gestione delle Chiavi Esterne

```php
// ❌ ERRATO
$table->uuid('doctor_id');

// ✅ CORRETTO
$table->foreignUuid('doctor_id')->constrained('users')->cascadeOnDelete();
```

### 4. Nomi di Tabelle Incoerenti

```php
// ❌ ERRATO
protected string $table = 'DoctorRegistrationWorkflow';

// ✅ CORRETTO
protected string $table = 'doctor_registration_workflows';
```

### 5. Mancanza di Tipi Espliciti

```php
// ❌ ERRATO
protected $table = 'doctor_registration_workflows';
protected $connection = 'mysql';

// ✅ CORRETTO
protected string $table = 'doctor_registration_workflows';
protected ?string $connection = 'mysql';
```

## Migrazioni per Single Table Inheritance (STI)

### Tabella Base

```php
Schema::create('users', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('type')->nullable(); // Discriminatore per STI
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email')->unique();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
    $table->softDeletes();
});
```

### Aggiunta di Campi per Modelli Specializzati

```php
Schema::table('users', function (Blueprint $table) {
    // Campi specifici per il modello Doctor
    $table->string('registration_number')->nullable();
    $table->string('specialization')->nullable();
    $table->json('certifications')->nullable();
    $table->json('availability')->nullable();
    
    // Campi specifici per il modello Patient
    $table->date('birth_date')->nullable();
    $table->string('fiscal_code')->nullable();
    $table->date('isee_expiry_date')->nullable();
});
```

## Conclusione

Seguendo queste best practices per le migrazioni, puoi garantire che il tuo database sia ben strutturato, documentato e manutenibile. Le migrazioni ben progettate sono fondamentali per il successo di un progetto a lungo termine.
