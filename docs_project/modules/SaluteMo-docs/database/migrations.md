# Convenzioni per le Migrazioni in SaluteMo

## Pattern "Un File Per Tabella"

Nel modulo SaluteMo, come nel resto del progetto SaluteOra, utilizziamo un approccio specifico per le migrazioni del database:

1. **Un solo file di migrazione per tabella**: Ogni tabella ha un unico file di migrazione
2. **Nome standardizzato**: `YYYY_MM_DD_HHMMSS_create_oggetto_contesto_table.php`
3. **Suffisso numerico sequenziale**: Utilizziamo spesso `000001` nella parte del timestamp
4. **Modifiche incrementali**: Le modifiche successive vengono aggiunte allo stesso file di migrazione nella sezione `tableUpdate`

## Implementazione

Il pattern si basa sulla classe `XotBaseMigration` che separa chiaramente:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateMobileUsersTable extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Creazione iniziale
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('device_token')->nullable();
            $table->string('device_type')->nullable();
            $table->string('app_version')->nullable();
            $table->jsonb('preferences')->nullable();
            $table->timestamps();
        });

        // Modifiche successive
        $this->tableUpdate(function (Blueprint $table): void {
            // Aggiunta di nuovi campi, indici, ecc.
            $table->string('last_login_ip')->nullable()->after('app_version');
            $table->timestamp('last_active_at')->nullable()->after('last_login_ip');
        });
    }
}
```

## Vantaggi

- **Coesione**: Tutte le modifiche a una tabella sono in un unico file
- **Visibilità**: Facile vedere la struttura completa della tabella
- **Manutenibilità**: Riduzione della frammentazione delle migrazioni
- **Tracciabilità**: Il versionamento Git gestisce la storia delle modifiche

## Naming Convention

### Nome File
```
2025_05_28_000001_create_mobile_users_table.php
```

### Struttura Nome
- Anno_Mese_Giorno: Data di creazione
- 000001: Numerazione sequenziale
- create_: Prefisso per indicare creazione
- mobile_users: Nome tabella (snake_case)
- _table.php: Suffisso standard

## Errori Comuni da Evitare

### Multiple Migrazioni per Tabella
❌ **ERRATO**:
```
2025_05_28_000001_create_mobile_users_table.php
2025_06_15_000001_add_last_login_to_mobile_users_table.php
```

✅ **CORRETTO**:
Aggiungere le modifiche nel metodo `tableUpdate` della migrazione originale.

### Nome Migrazione Non Standard
❌ **ERRATO**:
```
2025_05_28_000001_MobileUsers.php
```

✅ **CORRETTO**:
```
2025_05_28_000001_create_mobile_users_table.php
```

## Esempi di Riferimento

- `2025_05_28_000001_create_mobile_users_table.php` (Modulo SaluteMo)
- `2025_05_17_000001_create_mobile_device_tokens_table.php` (Modulo SaluteMo)

## Collegamenti Correlati
- [Convenzioni dei Modelli](../models/best-practices.md)
- [Struttura del Modulo](../structure/namespace-conventions.md)
- [Seeder del Database](./seeders.md)
