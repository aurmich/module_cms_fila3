# Migrazioni del Database nel Modulo Patient

## Panoramica

Questo documento descrive la struttura delle migrazioni del database per il modulo Patient, con particolare attenzione all'implementazione del pattern Single Table Inheritance (STI) e alla gestione dei campi per i diversi tipi di utenti.

## Single Table Inheritance (STI)

### Principio Fondamentale

> **Nota importante:**
> Con Single Table Inheritance (STI), **tutti i campi usati dai modelli specializzati devono essere presenti nella tabella base** (`users`).
> Se aggiungi un campo specifico per un tipo di utente (es. `certifications` per i dottori), devi aggiornare la migration della tabella `users` e documentare la modifica.

### Errori Comuni

- **Errore tipico**: `Unknown column 'certifications' in 'field list'`
- **Causa**: Il campo è stato utilizzato nel modello ma non è stato aggiunto alla tabella base
- **Soluzione**: Creare una migration per aggiungere il campo alla tabella `users`

## Struttura delle Migrazioni

### 1. Tabella Users (Base per STI)

La tabella `users` è la tabella base per tutti i tipi di utenti (Doctor, Patient, ecc.) e contiene:

- Campi comuni a tutti gli utenti (id, name, email, password, ecc.)
- Campi specifici per ogni tipo di utente (certifications, specialization, ecc.)
- Campo `type` per distinguere i diversi tipi di utenti

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('type')->nullable(); // Utilizzato da Parental per STI
    $table->foreignIdFor(Tenant::class)->constrained()
        ->onDelete('cascade')->onUpdate('cascade');
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    
    // Campi specifici per Doctor
    $table->string('phone')->nullable();
    $table->string('address')->nullable();
    $table->string('city')->nullable();
    $table->string('registration_number')->nullable();
    $table->string('specialization')->nullable();
    $table->json('certifications')->nullable();
    $table->json('availability')->nullable();
    $table->string('status')->nullable();
    
    // Campi specifici per Patient
    $table->date('date_of_birth')->nullable();
    $table->string('gender')->nullable();
    $table->string('fiscal_code')->nullable();
    $table->boolean('is_pregnant')->default(false)->nullable();
    $table->string('isee_code')->nullable();
    $table->decimal('isee_value', 10, 2)->nullable();
    $table->date('isee_expiry_date')->nullable();
    
    $table->timestamps();
    $table->softDeletes();
});
```

### 2. Aggiunta di Campi Specifici

Quando è necessario aggiungere nuovi campi specifici per un tipo di utente, creare una nuova migration:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     *
     * @var string
     */
    protected string $table = 'users';
    
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Verifica se la colonna esiste già prima di aggiungerla
                if (! $this->hasColumn('new_doctor_field')) {
                    $table->string('new_doctor_field')->nullable()->after('specialization');
                }
            }
        );
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->tableUpdate(
            function (Blueprint $table): void {
                if ($this->hasColumn('new_doctor_field')) {
                    $table->dropColumn('new_doctor_field');
                }
            }
        );
    }
};
```

### 3. Tabelle Correlate

Per le tabelle correlate ai modelli STI, utilizzare chiavi esterne che puntano alla tabella `users`:

```php
Schema::create('doctor_registration_workflows', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->foreignUuid('doctor_id')->constrained('users')->onDelete('cascade');
    $table->string('current_step');
    $table->string('status');
    $table->timestamp('started_at');
    $table->timestamp('last_interaction_at');
    $table->timestamp('completed_at')->nullable();
    $table->string('session_id')->nullable();
    $table->text('moderation_notes')->nullable();
    $table->timestamps();
});
```

## Best Practices

### 1. Controllo dell'Esistenza delle Colonne

Sempre verificare se una colonna esiste già prima di tentare di aggiungerla:

```php
if (! $this->hasColumn('column_name')) {
    $table->string('column_name')->nullable();
}
```

### 2. Utilizzo di XotBaseMigration

Utilizzare la classe `XotBaseMigration` per le migrazioni, che fornisce metodi utili come `hasColumn()`, `tableCreate()` e `tableUpdate()`:

```php
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    // ...
};
```

### 3. Ordine delle Migrazioni

Assicurarsi che le migrazioni vengano eseguite nell'ordine corretto:

1. Prima creare la tabella base `users`
2. Poi aggiungere i campi specifici per i diversi tipi di utenti
3. Infine creare le tabelle correlate

### 4. Documentazione delle Modifiche

Documentare sempre le modifiche alle migrazioni, specialmente quando si aggiungono campi per i modelli STI:

```php
/**
 * Aggiunge il campo 'certifications' alla tabella users per il modello Doctor.
 *
 * @return void
 */
public function up(): void
{
    // ...
}
```

## Collegamenti
- [Modello Doctor](../Models/Doctor.md)
- [Modello Patient](../Models/Patient.md)
- [Single Table Inheritance](../SINGLE_TABLE_INHERITANCE.md)
- [Best Practices per l'Ereditarietà](../INHERITANCE_BEST_PRACTICES.md)

## Policy sulle migration XotBaseMigration

- Chi estende `XotBaseMigration` **non deve mai** dichiarare il metodo `down()`.
- La gestione del rollback è centralizzata e automatica nella base Xot, per evitare duplicazione, errori e conflitti.
- Motivazione: DRY, coerenza, nessun lock-in, manutenzione semplificata.
- Filosofia: un solo punto di verità, nessuna duplicazione, serenità del codice.
- Politica: rollback sicuro, refactoring semplice, policy multi-tenant.
- Zen: codice pulito, nessun errore di override.

**Esempio corretto:**
```php
return new class() extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            // ...
        });
    }
    // NIENTE metodo down()
};
```

## Policy su timestamp e soft delete nelle migration XotBaseMigration

- Per aggiungere timestamp e soft delete, usare **solo** `$this->updateTimestamps($table, true)` dentro il blocco `tableUpdate`.
- Non usare mai `$table->timestamps()` direttamente: si rischia di perdere coerenza, duplicare logica e rompere la policy di centralizzazione Xot.
- Motivazione: DRY, coerenza, nessun lock-in, manutenzione semplificata.
- Filosofia: un solo punto di verità, nessuna duplicazione, serenità del codice.
- Politica: gestione centralizzata, refactoring semplice, policy multi-tenant.
- Zen: codice pulito, nessun errore di override.

**Esempio corretto:**
```php
$this->tableUpdate(function (Blueprint $table): void {
    $this->updateTimestamps($table, true);
});
```
