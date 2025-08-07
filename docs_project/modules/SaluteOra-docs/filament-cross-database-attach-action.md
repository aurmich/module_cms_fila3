# Gestione Ottimizzata delle Azioni Attach in Relazioni Cross-Database

## Contesto Architetturale

Nel progetto SaluteOra, utilizziamo un'architettura multi-database dove:

1. `Doctor` (estensione di `User`) risiede nel database `user`
2. `Studio` risiede nel database `salute_ora`
3. La tabella pivot `doctor_studio` risiede nel database `salute_ora`

## Pattern di Implementazione Ottimizzato

Dopo varie iterazioni, abbiamo identificato il pattern più efficiente per gestire l'azione `AttachAction` in relazioni cross-database:

### 1. Implementazione Semplificata

```php
Tables\Actions\AttachAction::make()
    ->preloadRecordSelect(false) // Evita il precaricamento per performance
    ->recordSelect(
        fn (Forms\Components\Select $select) => $select
            ->searchable()
            ->getSearchResultsUsing(
                function (string $search): array {
                    // Utilizziamo la relazione già caricata per ottenere gli ID
                    // escludendo così la necessità di query esplicite con on()
                    $excludedIds = $this->getOwnerRecord()->relation->modelKeys();
                    
                    return Model::where(function (Builder $query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                  ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->whereNotIn('id', $excludedIds)
                        ->limit(10)
                        ->get()
                        ->mapWithKeys(
                            function (Model $model) {
                                return [$model->getKey() => "{$model->display_name} <{$model->email}>"];
                            }
                        )
                        ->toArray();
                }
            )
    )
```

### 2. Vantaggi dell'Approccio

- **Sfrutta le relazioni Eloquent**: Utilizza `$this->getOwnerRecord()->relation->modelKeys()` per ottenere gli ID già associati
- **Evita query multiple su database diversi**: Non utilizza query esplicite con `on()` se non necessario
- **Migliore leggibilità del codice**: Struttura più chiara e intenti espliciti
- **Performance ottimizzate**: Limita i risultati e non precarica tutte le opzioni

## Implementazione per le Due Direzioni della Relazione

### 1. Da Studio a Doctor (DoctorsRelationManager)

```php
// In DoctorsRelationManager
function (string $search): array {
    return Doctor::where(function (Builder $query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })
        ->whereNotIn('id', $this->getOwnerRecord()->doctors->modelKeys())
        ->limit(10)
        ->get()
        ->mapWithKeys(
            function (Doctor $doctor) {
                return [$doctor->getKey() => "{$doctor->full_name} <{$doctor->email}>"];
            }
        )
        ->toArray();
}
```

### 2. Da Doctor a Studio (StudiosRelationManager)

```php
// In StudiosRelationManager
function (string $search): array {
    return Studio::where(function (Builder $query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
        })
        ->whereNotIn('id', $this->getOwnerRecord()->studios->modelKeys())
        ->limit(10)
        ->get()
        ->mapWithKeys(
            function (Studio $studio) {
                return [$studio->getKey() => "{$studio->name} ({$studio->address})"];
            }
        )
        ->toArray();
}
```

## Considerazioni Sulla Tabella Pivot

La tabella pivot `doctor_studio` utilizza:

- `user_id` (non `doctor_id`) perché Doctor estende User (pattern STI)
- `studio_id` per il riferimento allo Studio

Questo è riflesso nei `fillable` del modello `DoctorStudio`:

```php
protected $fillable = [
    'user_id',      // Invece di doctor_id
    'studio_id',
    'schedule',
    'is_primary',
];
```

## Best Practices

1. **Evitare query esplicite cross-database** quando possibile
2. **Utilizzare le relazioni Eloquent già caricate** per recuperare gli ID
3. **Limitare il numero di risultati** per prestazioni ottimali
4. **Formattare chiaramente i risultati** per una migliore esperienza utente
5. **Documentare chiaramente il pattern** con riferimenti alla documentazione
