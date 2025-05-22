# Best Practices per le Migrazioni nel Modulo Patient

## Introduzione

Questo documento descrive le best practices da seguire quando si creano o si modificano migrazioni nel modulo Patient. Seguire queste linee guida è fondamentale per garantire la coerenza e la correttezza delle migrazioni.

## Struttura delle Migrazioni

### 1. Estensione della Classe Base

Tutte le migrazioni devono estendere `XotBaseMigration` invece di `Migration`:

```php
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    // ...
}
```

### 2. Proprietà Obbligatorie

Ogni migrazione deve definire le seguenti proprietà:

```php
/**
 * Nome della tabella.
 *
 * @var string
 */
protected string $table = 'nome_tabella';

/**
 * Connessione al database.
 *
 * @var string|null
 */
protected ?string $connection = 'mysql'; // o 'user', 'tenant', ecc.
```

### 3. Documentazione

Ogni migrazione deve includere una documentazione completa che descriva lo scopo della tabella e i suoi campi principali:

```php
/**
 * Migrazione per la creazione della tabella example_table.
 * 
 * Questa tabella gestisce [descrizione dello scopo].
 * 
 * @see docs/standards/migrations.md
 * @see docs/standards/single-table-inheritance.md
 */
```

## Implementazione del Metodo `up()`

### 1. Creazione della Tabella

Utilizzare il metodo `tableCreate` per creare la tabella:

```php
public function up(): void
{
    $this->tableCreate(function (Blueprint $table) {
        $table->id();
        // Definizione dei campi
        
        // Utilizziamo updateTimestamps per gestire created_at, updated_at e deleted_at
        $this->updateTimestamps($table, true); // true per includere soft delete
    });
}
```

### 2. Aggiornamento della Tabella

Utilizzare il metodo `tableUpdate` per aggiornare una tabella esistente:

```php
public function up(): void
{
    $this->tableUpdate(function (Blueprint $table) {
        if (! $this->hasColumn('nuovo_campo')) {
            $table->string('nuovo_campo')->nullable()->after('campo_esistente');
        }
    });
}
```

### 3. Verifica dell'Esistenza di Tabelle Correlate

Prima di creare foreign keys, verificare sempre l'esistenza della tabella correlata:

```php
// Verifica se la tabella correlata esiste nella stessa connessione
if (Schema::connection($this->getConnection())->hasTable('tabella_correlata')) {
    $table->foreign('campo_id')
        ->references('id')
        ->on('tabella_correlata')
        ->onDelete('cascade');
} else {
    $this->outputWarning("La tabella 'tabella_correlata' non esiste nella connessione '{$this->getConnection()}'. La foreign key non è stata creata.");
    // Creiamo solo l'indice senza la foreign key
    $table->index('campo_id');
}
```

## Gestione delle Costanti

Se la tabella utilizza campi con valori predefiniti o enumerati, definire le costanti nella migrazione:

```php
// Costanti per gli stati
public const STATUS_DRAFT = 'draft';
public const STATUS_PENDING = 'pending';
public const STATUS_COMPLETED = 'completed';

// Utilizzo nelle definizioni dei campi
$table->string('status')->default(self::STATUS_DRAFT);
```

## Connessioni al Database

### 1. Modelli Utente

I modelli che estendono `User` devono utilizzare la connessione `user`:

```php
protected $connection = 'user';
```

### 2. Altri Modelli

I modelli che estendono `BaseModel` devono utilizzare la connessione appropriata, di solito `mysql` o quella definita in `BaseModel`:

```php
protected $connection = 'mysql'; // o altra connessione appropriata
```

## Esempi Pratici

### Esempio 1: Migrazione per Creare una Tabella

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migrazione per la creazione della tabella doctor_registration_workflows.
 * 
 * Questa tabella tiene traccia del processo di registrazione dei dottori.
 * 
 * @see docs/standards/migrations.md
 */
return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     *
     * @var string
     */
    protected string $table = 'doctor_registration_workflows';
    
    /**
     * Connessione al database.
     *
     * @var string
     */
    protected ?string $connection = 'mysql';
    
    /**
     * Costanti per gli stati del workflow.
     */
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PENDING_MODERATION = 'pending_moderation';
    public const STATUS_COMPLETED = 'completed';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('doctor_id');
            $table->string('status')->default(self::STATUS_DRAFT);
            
            // Utilizziamo updateTimestamps per gestire created_at, updated_at e deleted_at
            $this->updateTimestamps($table, true);
            
            // Verifica se la tabella doctors esiste nella stessa connessione
            if (Schema::connection($this->getConnection())->hasTable('doctors')) {
                $table->foreign('doctor_id')
                    ->references('id')
                    ->on('doctors')
                    ->onDelete('cascade');
            }
            
            $table->index('doctor_id');
            $table->index('status');
        });
    }
};
```

### Esempio 2: Migrazione per Aggiornare una Tabella

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migrazione per aggiungere campi alla tabella doctors.
 * 
 * @see docs/standards/migrations.md
 */
return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     *
     * @var string
     */
    protected string $table = 'doctors';
    
    /**
     * Connessione al database.
     *
     * @var string
     */
    protected ?string $connection = 'user';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table) {
            if (! $this->hasColumn('certifications')) {
                $table->json('certifications')->nullable()->after('registration_number');
            }
            
            if (! $this->hasColumn('status')) {
                $table->string('status')->nullable()->after('registration_number');
            }
        });
    }
};
```

## Checklist per le Migrazioni

Prima di inviare una migrazione, verificare che:

- [ ] La migrazione estenda `XotBaseMigration`
- [ ] Siano definite le proprietà `$table` e `$connection`
- [ ] La documentazione sia completa e descriva lo scopo della tabella
- [ ] I campi abbiano commenti che ne descrivono lo scopo
- [ ] Le foreign keys verifichino l'esistenza delle tabelle correlate
- [ ] I valori predefiniti utilizzino costanti definite nella classe
- [ ] I timestamp siano gestiti con `$this->updateTimestamps()`
- [ ] Il soft delete sia abilitato se necessario

## Collegamenti

- [Documentazione generale sulle migrazioni](/docs/database-connections-and-migrations.md)
- [Pattern di ereditarietà dei modelli](MODEL_INHERITANCE_PATTERN.md)
- [Regole base per le migrazioni](/laravel/Modules/Xot/docs/MIGRATION_BASE_RULES.md)
- [Documentazione del modello DoctorRegistrationWorkflow](Models/DoctorRegistrationWorkflow.md)
