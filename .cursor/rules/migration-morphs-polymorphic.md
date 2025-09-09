# Regole per Morphs Polymorphic e Migrazioni Laraxot

## Principio Fondamentale: Morphs e Flessibilità ID

### REGOLA CRITICA: causer_id DEVE essere string
```php
// ✅ CORRETTO - Supporta tutti i tipi di ID
$table->string('causer_id')->nullable()->change();

// ❌ ERRATO - Funziona solo con ID numerici
$table->unsignedBigInteger('causer_id')->nullable()->change();
```

## Motivazioni Architetturali

### 1. Supporto Universal ID Types
```php
// UUID (User)
causer_id = "550e8400-e29b-41d4-a716-446655440000"
causer_type = "Modules\User\Models\User"

// Integer (Admin) 
causer_id = "123"
causer_type = "Modules\Admin\Models\Admin"

// Custom ID (System)
causer_id = "SYSTEM_001"
causer_type = "Modules\System\Models\SystemUser"
```

### 2. Evoluzione Futura
- Sistema preparato per qualsiasi cambio di strategia ID
- Moduli indipendenti possono usare formati ID diversi
- Polimorfismo reale senza vincoli tecnici

### 3. Compatibilità Multi-Modulo
- Ogni modulo può definire la sua strategia ID
- Activity log funziona con tutti i moduli
- Zero accoppiamento tra moduli

## Regola Migrazioni: Copia e Timestamp

### PROCESSO CORRETTO
1. **NON** creare `update_table_name.php`
2. **COPIARE** migrazione originale `create_table_name.php`
3. **MODIFICARE** contenuto (tableCreate + tableUpdate)
4. **CAMBIARE** solo timestamp nel nome file
5. **ELIMINARE** file originale

### Esempio Pratico
```bash
# PRIMA
2023_03_31_103351_create_activity_table.php

# DOPO (correzione causer nullable)
2024_01_15_103351_create_activity_table.php  # stesso nome, solo timestamp
```

## Pattern XotBaseMigration
```php
return new class extends XotBaseMigration
{
    public function up(): void
    {
        // Struttura completa aggiornata
        $this->tableCreate(function (Blueprint $table): void {
            // Definizione completa tabella con modifiche
        });
        
        // Gestione DB esistenti
        $this->tableUpdate(function (Blueprint $table): void {
            // Solo modifiche per tabelle già esistenti
            if ($this->hasColumn('causer_id')) {
                $table->string('causer_id')->nullable()->change();
            }
        });
    }
};
```

## Filosofia Laraxot

### Principi
- **Una tabella = Una migrazione**
- **Evoluzione temporale = Cambio timestamp**
- **Polimorfismo universale = string per morphs**
- **Idempotenza assoluta = tableCreate + tableUpdate**

### Anti-Pattern
- ❌ Multiple migrazioni per stessa tabella
- ❌ unsignedBigInteger per morphs
- ❌ Migrazioni `update_` separate
- ❌ Duplicazione logica database

## Collegamenti
- [migration-complete-rules.mdc](migration-complete-rules.mdc)
- [models.md](models.md)
- [Modules/Activity/docs/database/migrations.md](../../laravel/Modules/Activity/docs/database/migrations.md)

*Ultimo aggiornamento: 2025-01-06*
*Motivazione: Comprensione profonda morphs polymorphic e strategia migrazioni Laraxot*

