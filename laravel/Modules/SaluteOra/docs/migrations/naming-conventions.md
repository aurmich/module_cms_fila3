# Convenzioni di Naming per le Migrazioni

## Principi di Base

Le migrazioni nel progetto SaluteOra seguono convenzioni specifiche per garantire ordine, coerenza e manutenibilità. Questa guida definisce le regole da seguire per la creazione e la denominazione delle migrazioni.

## Formato del Nome File

### Pattern Corretto
```
YYYY_MM_DD_IIIIII_description_table.php
```

Dove:
- `YYYY_MM_DD`: Data di creazione della migrazione (non data futura)
- `IIIIII`: Numero sequenziale a 6 cifre (generalmente l'ora in formato HHMMSS)
- `description`: Descrizione dell'operazione (create, add, update, remove, ecc.)
- `table`: Nome della tabella interessata

### Esempi Corretti
```
2024_05_28_000001_create_addresses_table.php
2024_05_28_000002_add_calendar_fields_to_appointments_table.php
2024_05_28_000003_update_doctor_fields_in_users_table.php
```

## Regole Fondamentali

1. **Mai usare date future**
   - ❌ `2025_05_26_121800_add_calendar_fields_to_appointments_table.php`
   - ✅ `2024_05_28_000001_add_calendar_fields_to_appointments_table.php`

2. **Mantenere sequenzialità all'interno dello stesso giorno**
   - Utilizzare incrementi sequenziali come `000001`, `000002`, ecc.
   - Se si generano automaticamente, usare l'ora corrente (HHMMSS)

3. **Descrizioni esplicative e coerenti**
   - Iniziare con un verbo che descrive l'operazione (`create`, `add`, `update`, `remove`, `drop`)
   - Utilizzare il nome della tabella al plurale e in snake_case
   - Terminare con `_table` per le migrazioni che creano o modificano tabelle

4. **Organizzazione sequenziale**
   - Tabelle base prima di tabelle relazionali
   - Colonne di base prima di foreign keys
   - Foreign keys prima di indici

## Struttura del File

### Estensione Corretta
Tutte le migrazioni devono estendere `XotBaseMigration`, non la classe Laravel standard `Migration`:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\SaluteOra\Models\Appointment;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = Appointment::class;
    
    // Implementazione...
};
```

### Metodi di XotBaseMigration
Utilizzare i metodi forniti da `XotBaseMigration`:

- `tableCreate()`: Per creare nuove tabelle
- `tableUpdate()`: Per aggiornare tabelle esistenti
- `hasColumn()`: Per verificare l'esistenza di colonne
- `hasIndex()`: Per verificare l'esistenza di indici
- `updateTimestamps()`: Per gestire i campi timestamp e soft delete

### No Referenze Dirette a Schema::connection
Evitare di utilizzare direttamente `Schema::connection()`. Utilizzare i metodi di astrazione forniti da `XotBaseMigration`.

## Migrazione vs Modello

Il nome del file di migrazione e il nome del modello devono seguire queste convenzioni:

| Migrazione | Modello |
|------------|---------|
| `YYYY_MM_DD_IIIIII_create_appointments_table.php` | `Appointment.php` |
| `YYYY_MM_DD_IIIIII_create_doctor_teams_table.php` | `DoctorTeam.php` |

## Ordine di Esecuzione

Le migrazioni vengono eseguite in ordine alfabetico, quindi è fondamentale che il timestamp nel nome del file rifletta l'ordine logico di esecuzione:

1. Tabelle di base prima (es. `users`, `doctors`)
2. Tabelle di relazione dopo (es. `doctor_teams`)
3. Tabelle di pivot alla fine (es. `doctor_patient`)

## Risoluzione Problemi Comuni

### Migrazione con Nome Errato
Se una migrazione ha un nome che non segue le convenzioni (es. data futura):

1. Creare una nuova migrazione con nome corretto
2. Copiare e adattare il contenuto
3. Eliminare la vecchia migrazione
4. Se la migrazione è già stata eseguita in produzione, creare una nuova migrazione che corregge eventuali problemi