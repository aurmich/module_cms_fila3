# Filament RelationManager in SaluteOra

## Panoramica

I RelationManager sono componenti Filament che permettono di gestire le relazioni tra entità del sistema direttamente dall'interfaccia di amministrazione. Questo documento descrive l'implementazione corretta dei RelationManager nel modulo SaluteOra.

## Proprietà Essenziali

### Tipi di Proprietà

Le proprietà statiche nei RelationManager devono rispettare i tipi definiti nelle classi base di Filament:

```php
// Corretto
protected static ?string $inverseRelationship = 'doctors';

// Errato
protected static string $inverseRelationship = 'doctors';
```

### Proprietà Principali

| Proprietà | Tipo | Descrizione |
|-----------|------|-------------|
| `$relationship` | `string` | Nome della relazione nel modello "genitore" |
| `$inverseRelationship` | `?string` | Nome della relazione inversa (può essere null) |
| `$recordTitleAttribute` | `?string` | Attributo usato per il titolo dei record |
| `$modelLabel` | `?string` | Etichetta personalizzata per il modello |
| `$pluralModelLabel` | `?string` | Etichetta plurale personalizzata |

## Implementazione Corretta

```php
class DoctorsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'doctors';
    protected static ?string $inverseRelationship = 'studio';
    
    // Altri metodi...
}
```

## Errori Comuni

1. **Tipo non corrispondente**: Le proprietà devono avere lo stesso tipo delle classi base
2. **Proprietà mancanti**: Assicurarsi di dichiarare tutte le proprietà necessarie
3. **Metodi non implementati**: I RelationManager richiedono implementazioni di getTableColumns()

## Implicazioni nelle Relazioni Bidirezionali

Nelle relazioni bidirezionali come Studio-Doctor:

1. Studio ha molti Doctor (`doctors()`)
2. Doctor appartiene a uno Studio (`studio()` o tramite `tenant_id`)

Per implementare correttamente questa relazione, entrambi i RelationManager devono indicare la relazione inversa usando la proprietà `$inverseRelationship`.

## Collegamenti ad Altri Documenti

- [Documentazione generale RelationManager](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/relationmanagers.md)
- [Studio Model](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/models/studio.md)
- [Doctor Model](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/models/doctor.md)

## Gestione AttachAction in Relazioni Cross-Database

### Problema
Quando si utilizza un RelationManager Filament per una relazione molti-a-molti tra modelli su database diversi (es. Studio su `salute_ora`, Doctor su `user`), la ricerca standard di AttachAction genera errori SQL (`Base table or view not found`) perché tenta join cross-db non supportate da Laravel.

### Soluzione architetturale
**Mai** usare la query Eloquent standard per AttachAction in questi casi. **Sempre** personalizzare la ricerca e la query delle opzioni, forzando la connessione corretta e filtrando manualmente i record.

#### Pattern definitivo (simmetrico)
```php
// StudioResource/RelationManagers/DoctorsRelationManager.php
Tables\Actions\AttachAction::make()
    ->preloadRecordSelect(false)
    ->recordSelect(fn (Forms\Components\Select $select) => $select
        ->searchable()
        ->getSearchResultsUsing(function (string $search) {
            return Doctor::on('user')
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->whereNotIn('id', $this->getOwnerRecord()->doctors->modelKeys())
                ->limit(10)
                ->get()
                ->mapWithKeys(fn ($doctor) => [
                    $doctor->getKey() => "{$doctor->full_name} <{$doctor->email}>"
                ])
                ->toArray();
        })
    );

// DoctorResource/RelationManagers/StudiosRelationManager.php
Tables\Actions\AttachAction::make()
    ->preloadRecordSelect(false)
    ->recordSelect(fn (Forms\Components\Select $select) => $select
        ->searchable()
        ->getSearchResultsUsing(function (string $search) {
            return Studio::on('salute_ora')
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                })
                ->whereNotIn('id', $this->getOwnerRecord()->studios->modelKeys())
                ->limit(10)
                ->get()
                ->mapWithKeys(fn ($studio) => [
                    $studio->getKey() => "{$studio->name} ({$studio->address})"
                ])
                ->toArray();
        })
    );
```

#### Policy sulla connessione
- Per forzare la connessione su query Eloquent si usa sempre `Model::on('connection')`, **mai** `setConnection()` su Builder.

#### Applicazione
- Tutti i RelationManager che gestiscono relazioni cross-db devono seguire questo pattern su **entrambi i lati** della relazione.
- Aggiornare la documentazione locale e globale ogni volta che si applica questa regola.

#### Motivazione filosofica, logica, religiosa, politica
- **Filosofia**: La simmetria è fondamentale per la coerenza architetturale e la manutenibilità.
- **Logica**: Se la relazione è molti-a-molti, la gestione cross-db va implementata in entrambi i sensi, non solo da una parte.
- **Religione**: "Non avrai altro AttachAction all'infuori di quello simmetrico."
- **Politica**: Nessun lock-in, nessuna asimmetria, nessun punto cieco nella gestione delle relazioni.
- **Zen**: Serenità del codice, nessuna sorpresa, tutto è esplicito e simmetrico.

## Policy AttachAction cross-db simmetrica (Studio→Doctor e Doctor→Studio)

La gestione AttachAction cross-db va SEMPRE applicata in modo simmetrico:
- In `DoctorsRelationManager` (Studio → Doctor) si filtra sui dottori disponibili, forzando la connessione `user` e recuperando gli ID già associati tramite la tabella pivot.
- In `StudiosRelationManager` (Doctor → Studio) si filtra sugli studi disponibili, forzando la connessione `salute_ora` e recuperando gli ID già associati tramite la tabella pivot.

### Pattern per StudiosRelationManager
```php
Tables\Actions\AttachAction::make()
    ->recordSelectOptionsQuery(function () {
        $doctor = $this->getOwnerRecord();
        $alreadyAttachedIds = \DB::connection('salute_ora')
            ->table('doctor_studio')
            ->where('user_id', $doctor->id)
            ->pluck('studio_id')
            ->toArray();

        return \Modules\SaluteOra\Models\Studio::on('salute_ora')
            ->whereNotIn('id', $alreadyAttachedIds)
            ->limit(50)
            ->get()
            ->mapWithKeys(fn ($record) => [
                $record->getKey() => "{$record->name} <{$record->email}>"
            ])
            ->toArray();
    })
    ->preloadRecordSelect(false);
```

### Ricerca live (opzionale)
```php
->recordSelect(fn (Forms\Components\Select $select) => $select
    ->getSearchResultsUsing(function (string $search) {
        $doctor = $this->getOwnerRecord();
        $alreadyAttachedIds = \DB::connection('salute_ora')
            ->table('doctor_studio')
            ->where('user_id', $doctor->id)
            ->pluck('studio_id')
            ->toArray();

        return \Modules\SaluteOra\Models\Studio::on('salute_ora')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->whereNotIn('id', $alreadyAttachedIds)
            ->limit(50)
            ->get()
            ->mapWithKeys(fn ($record) => [
                $record->getKey() => "{$record->name} <{$record->email}>"
            ])
            ->toArray();
    })
)
```

> **Nota:** La policy va applicata in entrambi i RelationManager per garantire simmetria, coerenza e assenza di errori SQL.
