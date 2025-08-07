# Convenzioni per le Migrazioni in XotBaseMigration

## Principi Fondamentali

Quando si estende la classe `XotBaseMigration` è essenziale rispettare le seguenti convenzioni:

1. **NON implementare il metodo `down()`**
   - Il rollback è gestito automaticamente dalla classe base
   - Evita duplicazione di codice e potenziali incongruenze
   - Garantisce coerenza nell'applicazione

2. **Utilizzo corretto dei timestamp**
   - NON utilizzare `$table->timestamps()`
   - Utilizzare invece la sezione `tableUpdate`:
   ```php
   $this->tableUpdate(
       function (Blueprint $table): void {
           // Aggiunta dei timestamp e soft delete
           $this->updateTimestamps($table, true); // true per includere softDeletes
       }
   );
   ```

3. **Struttura corretta delle migrazioni**
   ```php
   public function up(): void
   {
       // Creazione della tabella
       $this->tableCreate(function (Blueprint $table): void {
           $table->id();
           // Altre colonne
       });

       // Aggiunta di timestamp e altre modifiche
       $this->tableUpdate(function (Blueprint $table): void {
           $this->updateTimestamps($table, true);
       });
   }
   ```

## Motivazioni Filosofiche e Tecniche

### DRY (Don't Repeat Yourself)
- Evitare la duplicazione di logica è un principio cardine
- `XotBaseMigration` centralizza la gestione del rollback
- Rimuove la necessità di implementare manualmente il `down()`

### Manutenibilità
- Approccio consistente in tutte le migrazioni
- Facilità nel refactoring globale delle migrazioni
- Riduzione del debito tecnico

### Sicurezza
- Il meccanismo di rollback centralizzato garantisce maggiore affidabilità
- Riduce il rischio di errori umani nelle operazioni delicate

## Pattern per i Diversi Tipi di Migrazioni

### 1. Creazione di Tabella
```php
public function up(): void
{
    $this->tableCreate(function (Blueprint $table): void {
        $table->id();
        $table->string('name');
        // ...
    });

    $this->tableUpdate(function (Blueprint $table): void {
        $this->updateTimestamps($table, true);
    });
}
```

### 2. Aggiunta di Colonna a Tabella Esistente
```php
public function up(): void
{
    $this->tableUpdate(function (Blueprint $table): void {
        if (! $this->hasColumn('new_column')) {
            $table->string('new_column')->nullable();
        }
    });
}
```

### 3. Aggiunta di Indice
```php
public function up(): void
{
    $this->tableUpdate(function (Blueprint $table): void {
        if (! $this->hasIndex('index_name')) {
            $table->index('column_name', 'index_name');
        }
    });
}
```

## Collegamenti
- [Migration Best Practices](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/database/migrations.md)
- [XotBaseMigration API](/var/www/html/_bases/base_saluteora/laravel/Modules/Xot/database/migrations/XotBaseMigration.php)
