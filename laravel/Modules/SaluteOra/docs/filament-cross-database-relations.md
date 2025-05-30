# Gestione Relazioni Cross-Database in Filament

## Problema

Quando si lavora con relazioni cross-database in Filament, si possono verificare errori come:

```sql
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'saluteora_user.studios' doesn't exist
```

Questo accade perché Filament tenta di eseguire query di ricerca utilizzando la connessione del modello di origine, senza considerare che le tabelle correlate potrebbero trovarsi in database diversi.

## Architettura Multi-Database

Nel progetto SaluteOra, utilizziamo un'architettura multi-database deliberata:

1. `user`: Database contenente utenti, dottori, pazienti e ruoli
2. `salute_ora`: Database contenente studi medici, appuntamenti e altre entità di dominio
3. Tabelle pivot: Risiedono nel database appropriato in base all'entità "proprietaria"

## Soluzione per AttachAction in RelationManagers

Per risolvere il problema nelle azioni di Filament (come `AttachAction`), è necessario utilizzare un approccio completamente personalizzato per la gestione delle relazioni cross-database:

```php
Tables\Actions\AttachAction::make()
    ->preloadRecordSelect(false) // Importante: non precaricare tutti i record
    ->label('Associa Dottore')
    // Personalizzazione completa del componente select
    ->recordSelect(fn (Forms\Components\Select $select) => $select
        ->searchable()
        ->getSearchResultsUsing(function (string $search) {
            // Otteniamo lo studio corrente
            $studio = $this->getOwnerRecord();
            
            // Otteniamo gli ID dei dottori già associati a questo studio
            $excludedDoctorIds = \Modules\SaluteOra\Models\DoctorStudio::on('salute_ora')
                ->where('studio_id', $studio->id)
                ->pluck('doctor_id')
                ->toArray();
            
            // Query sui dottori con la connessione corretta
            return Doctor::on('user')
                ->where('type', 'doctor')
                ->where(function (Builder $query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                // Escludiamo manualmente i dottori già associati
                ->whereNotIn('id', $excludedDoctorIds)
                ->limit(50)
                ->get()
                ->mapWithKeys(function (Doctor $doctor) {
                    return [$doctor->getKey() => "{$doctor->name} <{$doctor->email}>"];
                })
                ->toArray();
        })
        ->getOptionLabelsUsing(function (array $values) {
            // Recuperiamo le informazioni dei dottori selezionati per mostrare etichette corrette
            return Doctor::on('user')
                ->whereIn('id', $values)
                ->get()
                ->mapWithKeys(function (Doctor $doctor) {
                    return [$doctor->getKey() => "{$doctor->name} <{$doctor->email}>"];
                })
                ->toArray();
        })
    )
```

### Elementi Chiave della Soluzione

1. `recordSelect`: Personalizzazione completa del componente di selezione
2. `getSearchResultsUsing`: Implementazione personalizzata della logica di ricerca
3. `on('database_name')`: Utilizzo del metodo corretto per specificare la connessione al database
4. `whereNotIn`: Esclusione manuale dei record già associati
5. `getOptionLabelsUsing`: Personalizzazione del formato di visualizzazione delle opzioni selezionate
6. `preloadRecordSelect(false)`: Ottimizzazione delle performance evitando il precaricamento

## Considerazioni per DetachAction e Other Actions

Anche altre azioni che coinvolgono relazioni cross-database potrebbero richiedere configurazioni simili:

```php
Tables\Actions\DetachAction::make()
    // Se necessario, aggiungi configurazioni specifiche
```

## Pattern di Implementazione per Varie Relazioni

### Studio -> Doctor (Many-to-Many)

```php
// In StudioResource/RelationManagers/DoctorsRelationManager.php
Tables\Actions\AttachAction::make()
    ->preloadRecordSelect(false)
    ->label('Associa Dottore')
    ->recordSelect(fn (Forms\Components\Select $select) => $select
        ->searchable()
        ->getSearchResultsUsing(function (string $search) {
            // Otteniamo gli ID dei dottori già associati
            $studio = $this->getOwnerRecord();
            $excludedDoctorIds = \Modules\SaluteOra\Models\DoctorStudio::on('salute_ora')
                ->where('studio_id', $studio->id)
                ->pluck('doctor_id')
                ->toArray();
            
            // Query sui dottori con la connessione corretta
            return Doctor::on('user')
                ->where('type', 'doctor')
                ->where(function (Builder $query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->whereNotIn('id', $excludedDoctorIds)
                ->limit(50)
                ->get()
                ->mapWithKeys(function (Doctor $doctor) {
                    return [$doctor->getKey() => "{$doctor->name} <{$doctor->email}>"];
                })
                ->toArray();
        })
    )
```

### Doctor -> Studio (Many-to-Many)

```php
// In DoctorResource/RelationManagers/StudiosRelationManager.php
Tables\Actions\AttachAction::make()
    ->preloadRecordSelect(false)
    ->label('Associa Studio')
    ->recordSelect(fn (Forms\Components\Select $select) => $select
        ->searchable()
        ->getSearchResultsUsing(function (string $search) {
            // Otteniamo gli ID degli studi già associati
            $doctor = $this->getOwnerRecord();
            $excludedStudioIds = \Modules\SaluteOra\Models\DoctorStudio::on('salute_ora')
                ->where('doctor_id', $doctor->id)
                ->pluck('studio_id')
                ->toArray();
            
            // Query sugli studi con la connessione corretta
            return Studio::on('salute_ora')
                ->where(function (Builder $query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                })
                ->whereNotIn('id', $excludedStudioIds)
                ->limit(50)
                ->get()
                ->mapWithKeys(function (Studio $studio) {
                    return [$studio->getKey() => "{$studio->name} ({$studio->address})"];
                })
                ->toArray();
        })
    )
```

## Prevenzione di Errori

1. **Mai usare `setConnection()` su query builder**: Utilizzare sempre `Model::on('database_name')` per specificare la connessione
2. **Evitare metodi di API non esistenti**: Verificare sempre la documentazione di Filament per i metodi disponibili
3. **Implementare esclusioni manuali**: Gestire manualmente l'esclusione dei record già associati attraverso `whereNotIn()`
4. **Formattare correttamente i risultati**: Utilizzare `mapWithKeys()` per formattare le opzioni di selezione
5. **Limitare i risultati**: Aggiungere sempre un limite ai risultati della ricerca per motivi di performance

## Collegamenti ad Altri Documenti

- [cross-database-relations.md](cross-database-relations.md) - Configurazione generale delle relazioni cross-database
- [migrations.md](migrations.md) - Pattern di migrazione per tabelle pivot
