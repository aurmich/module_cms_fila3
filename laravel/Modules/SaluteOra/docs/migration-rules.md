# Regole per le Migrazioni nel Modulo SaluteOra

## Panoramica

Questo documento definisce le regole specifiche per l'implementazione delle migrazioni nel modulo SaluteOra, seguendo le convenzioni del framework Laraxot e XotBaseMigration.

## Regole Fondamentali

### 1. Estensione delle Classi Base

**NON estendere MAI direttamente le classi Laravel. Utilizzare SEMPRE le classi XotBase:**

```php
// ❌ ERRATO
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->create('table', function (Blueprint $table) {
            // ...
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table');
    }
};

// ✅ CORRETTO
use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            // Definizione struttura base
        });
        
        $this->tableUpdate(function (Blueprint $table): void {
            // Modifiche e aggiornamenti
            $this->updateTimestamps($table, true);
        });
    }
};
```

### 2. Gestione dei Timestamp

**REGOLA CRITICA**: I timestamp devono essere gestiti SOLO nella sezione `tableUpdate`:

```php
// ❌ ERRATO - Timestamp in tableCreate
$this->tableCreate(function (Blueprint $table): void {
    $table->id();
    $table->string('name');
    $table->timestamps(); // ERRORE: non usare qui
    $table->softDeletes(); // ERRORE: non usare qui
});

// ✅ CORRETTO - Timestamp in tableUpdate
$this->tableCreate(function (Blueprint $table): void {
    $table->id();
    $table->string('name');
    // NON aggiungere timestamps qui
});

$this->tableUpdate(function (Blueprint $table): void {
    // Aggiunta dei timestamp e soft delete
    $this->updateTimestamps($table, true);
});
```

### 3. Calcolo Automatico delle Proprietà

**XotBaseMigration calcola automaticamente:**
- `$table_name` dal nome del file di migrazione
- `$model_class` dal nome del file di migrazione

**NON definire manualmente:**
```php
// ❌ ERRATO - Non definire manualmente
protected string $table = 'appointments';
protected ?string $model_class = Appointment::class;

// ✅ CORRETTO - Lasciare che XotBaseMigration calcoli automaticamente
// Nessuna definizione manuale necessaria
```

### 4. Struttura Completa di una Migrazione

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Studio;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Chiavi esterne
            $table->foreignIdFor(Patient::class, 'patient_id')
                ->nullable()
                ->constrained((new Patient())->getTable())
                ->nullOnDelete();
                
            $table->foreignIdFor(Doctor::class, 'doctor_id')
                ->nullable()
                ->constrained((new Doctor())->getTable())
                ->nullOnDelete();
                
            $table->foreignIdFor(Studio::class, 'studio_id')
                ->nullable()
                ->constrained((new Studio())->getTable())
                ->nullOnDelete();
            
            // Campi specifici
            $table->string('title')->nullable();
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->string('type')->default('consultation');
            $table->string('state')->default('scheduled');
            $table->boolean('emergency')->default(false);
            $table->text('notes')->nullable();
            
            // NON aggiungere timestamps qui
        });
        
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Aggiunta dei timestamp e soft delete
            $this->updateTimestamps($table, true);
            
            // Indici per performance
            if (!$this->hasIndex('appointments_starts_at_index')) {
                $table->index('starts_at', 'appointments_starts_at_index');
            }
            
            if (!$this->hasIndex('appointments_ends_at_index')) {
                $table->index('ends_at', 'appointments_ends_at_index');
            }
            
            // Altri indici...
        });
    }
};
```

## Regole Specifiche per SaluteOra

### 1. Gestione degli Appuntamenti

Per le tabelle degli appuntamenti, seguire sempre questo pattern:

```php
// Campi obbligatori per appuntamenti
$table->foreignIdFor(Patient::class, 'patient_id')->nullable();
$table->foreignIdFor(Doctor::class, 'doctor_id')->nullable();
$table->foreignIdFor(Studio::class, 'studio_id')->nullable();
$table->dateTime('starts_at')->nullable();
$table->dateTime('ends_at')->nullable();
$table->string('type')->default('consultation');
$table->string('state')->default('scheduled');
$table->boolean('emergency')->default(false);
```

### 2. Indici per Performance

Sempre aggiungere indici per le query del calendario:

```php
// Indici singoli
$table->index('starts_at', 'appointments_starts_at_index');
$table->index('ends_at', 'appointments_ends_at_index');
$table->index('type', 'appointments_type_index');
$table->index('state', 'appointments_state_index');
$table->index('emergency', 'appointments_emergency_index');

// Indici compositi
$table->index(['studio_id', 'starts_at'], 'appointments_studio_starts_at_index');
$table->index(['doctor_id', 'starts_at'], 'appointments_doctor_starts_at_index');
$table->index(['patient_id', 'starts_at'], 'appointments_patient_starts_at_index');
```

### 3. Verifica Esistenza

Sempre verificare l'esistenza prima di aggiungere:

```php
if (!$this->hasIndex('index_name')) {
    $table->index('column_name', 'index_name');
}

if (!$this->hasColumn('column_name')) {
    $table->string('column_name')->nullable();
}
```

## Anti-pattern da Evitare

### ❌ Timestamp in tableCreate
```php
$this->tableCreate(function (Blueprint $table): void {
    $table->timestamps(); // ERRORE
    $table->softDeletes(); // ERRORE
});
```

### ❌ updateTimestamps in tableCreate
```php
$this->tableCreate(function (Blueprint $table): void {
    $this->updateTimestamps($table, true); // ERRORE
});
```

### ❌ Definizione manuale delle proprietà
```php
protected string $table = 'appointments'; // ERRORE
protected ?string $model_class = Appointment::class; // ERRORE
```

### ❌ Metodo down()
```php
public function down(): void // ERRORE - gestito automaticamente
{
    Schema::dropIfExists('table');
}
```

## Best Practice

1. **Sempre usare `declare(strict_types=1);`**
2. **Sempre usare classi anonime**
3. **Sempre verificare esistenza prima di aggiungere**
4. **Sempre documentare le modifiche significative**
5. **Sempre testare le migrazioni in ambiente di sviluppo**
6. **Sempre aggiornare la documentazione**

## Collegamenti

- [XotBaseMigration Documentation](../../Xot/docs/migration_base_rules.md)
- [Migration Best Practices](../../Xot/docs/database-guidelines.md)
- [Timestamp Management](../../Xot/docs/architecture/timestamps-management.md)

*Ultimo aggiornamento: 2025-01-06* 