# Standard per le Migrazioni

Questo documento descrive gli standard e le best practice per la creazione e gestione delle migrazioni nel progetto SaluteOra.

## Struttura Base

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected string $table = 'table_name';
    
    protected $connection = null; // Usa la connessione di default
    
    public function up(): void
    {
        // Implementazione della migrazione
    }
};
```

## Convenzioni

1. **Namespace**: Le migrazioni devono essere nel namespace del modulo di appartenenza
2. **Nomi dei file**: `YYYY_MM_DD_HHMMSS_descriptive_name.php`
3. **Nomi delle classi**: PascalCase, descrittivi del contenuto
4. **Tabelle**: Nomi in snake_case, plurale
5. **Colonne**: snake_case
6. **Chiavi esterne**: `{related_table}_id`

## Best Practice

- Usare sempre `XotBaseMigration` come classe base
- Documentare lo scopo della migrazione
- Implementare sempre il metodo `down()` per il rollback
- Usare le costanti per i valori fissi
- Aggiungere commenti esplicativi per logica complessa
- Inserire i dati di configurazione nelle seeder

## Gestione delle Connessioni

Per specificare una connessione al database diversa da quella di default:

```php
protected $connection = 'connection_name';
```

## Documentazione Aggiuntiva

- [Documentazione ufficiale Laravel Migrations](https://laravel.com/docs/migrations)
- [Standard PSR-4](https://www.php-fig.org/psr/psr-4/)
