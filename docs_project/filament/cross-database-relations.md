# Gestione Relazioni Cross-Database in Filament

## Problema

Quando si utilizzano relazioni tra tabelle che risiedono in database diversi, si possono verificare errori come:

```sql
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'saluteora_user.studios' doesn't exist
```

Questo accade perché Laravel non gestisce automaticamente le connessioni cross-database nelle subquery, in particolare nel contesto di Filament.

In SaluteOra, questo problema si manifesta specificamente nella relazione many-to-many tra `Doctor` (database 'user') e `Studio` (database 'salute_ora').

## Architettura Multi-Database

Nel progetto SaluteOra utilizziamo una struttura multi-database:

- **user**: Contiene i dati degli utenti, inclusi i dottori (`users` table)
- **salute_ora**: Contiene i dati specifici dell'applicazione (`studios`, `doctor_studio`, ecc.)

## Relazione Bidirezionale Doctor-Studio

### Struttura della Relazione

La relazione tra Doctor e Studio è bidirezionale (many-to-many) con caratteristiche specifiche:

1. **Eredità Single Table Inheritance (STI)**: Doctor estende User, quindi non esiste una tabella `doctors` separata
2. **Cambio del Nome delle Chiavi**: Nella tabella pivot, usiamo `user_id` invece di `doctor_id` perché il dottore è effettivamente un record nella tabella `users`
3. **Database Differenti**: User/Doctor sono nel database 'user', mentre Studio e la tabella pivot sono nel database 'salute_ora'

### Configurazione del Modello Pivot

```php
class DoctorStudio extends BasePivot
{
    protected $connection = 'salute_ora';
    protected $table = 'doctor_studio';
    
    protected $fillable = [
        'user_id',      // Nota: user_id invece di doctor_id
        'studio_id',
        'schedule',
        'is_primary',
    ];
    
    // Relazioni...
}
```

## Errori Comuni

### 1. Uso Errato di setConnection() su Builder

```php
// ❌ ERRATO: Builder non ha il metodo setConnection()
Doctor::query()->setConnection('user')->where('type', 'doctor')

// ✅ CORRETTO: Utilizzare il metodo on() sul modello
Doctor::on('user')->where('type', 'doctor')
```

### 2. Metodi Inesistenti di Filament

```php
// ❌ ERRATO: getOptionsToExclude() non esiste
$recordsToExclude = $select->getOptionsToExclude();

// ✅ CORRETTO: Ottenere manualmente i record da escludere
$excludedDoctorIds = DoctorStudio::on('salute_ora')
    ->where('studio_id', $studio->id)
    ->pluck('doctor_id')
    ->toArray();
```

```php
// ❌ ERRATO: getOptionLabelUsing() non è disponibile in AttachAction
->getOptionLabelUsing(fn ($value): ?string => Doctor::on('user')->where('id', $value)->value('name'))

// ✅ CORRETTO: Utilizzare getOptionLabelsUsing() sul componente Select
->getOptionLabelsUsing(function (array $values) {
    return Doctor::on('user')
        ->whereIn('id', $values)
        ->get()
        ->mapWithKeys(fn ($doctor) => [$doctor->getKey() => $doctor->name])
        ->toArray();
})
```

## Soluzioni per Filament RelationManagers

### 1. Configurazione Modello Pivot

Il modello pivot deve specificare esplicitamente la connessione:

```php
class DoctorStudio extends BasePivot
{
    protected $connection = 'salute_ora';
    protected $table = 'doctor_studio';
    
    // Relazioni e altro codice...
}
```

### 2. Definizione Corretta delle Relazioni nei Modelli

```php
// Nel modello Doctor
public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class);
}

// Nel modello Studio
public function doctors(): BelongsToMany
{
    return $this->belongsToManyX(Doctor::class);
}
```

Il metodo `belongsToManyX()` del nostro framework gestisce automaticamente la configurazione corretta per le relazioni cross-database.

### 3. Implementazione AttachAction in Filament

Per una corretta implementazione dell'AttachAction in relazioni cross-database:

```php
Tables\Actions\AttachAction::make()
    ->preloadRecordSelect(false) // Importante: non precaricare tutti i record
    ->label('Associa Dottore')
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

## Implementazione Bidirezionale della Relazione in Filament

Nella nostra applicazione, la relazione Doctor-Studio deve essere gestita in entrambe le direzioni:

1. `DoctorsRelationManager`: Mostra e gestisce i dottori associati a uno studio
2. `StudiosRelationManager`: Mostra e gestisce gli studi associati a un dottore

Entrambi i RelationManager devono gestire correttamente la relazione cross-database, ma in modo specularmente inverso.

### Implementazione in DoctorsRelationManager

```php
public function getTableHeaderActions(): array
{
    return [
        Tables\Actions\AttachAction::make()
            ->preloadRecordSelect(false)
            ->recordSelect(fn (Forms\Components\Select $select) => $select
                ->searchable()
                ->getSearchResultsUsing(function (string $search): array {
                    // Query sui dottori con la connessione implicita del modello
                    return Doctor::where(function (Builder $query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    // Utilizzo di modelKeys() per ottenere gli ID già associati
                    ->whereNotIn('id', $this->getOwnerRecord()->doctors->modelKeys())
                    ->limit(10)
                    ->get()
                    ->mapWithKeys(function (Doctor $doctor) {
                        return [$doctor->getKey() => "{$doctor->full_name} <{$doctor->email}>"];
                    })
                    ->toArray();
                })
            )
    ];
}
```

### Implementazione in StudiosRelationManager

```php
public function getTableHeaderActions(): array
{
    return [
        Tables\Actions\AttachAction::make()
            ->preloadRecordSelect(false)
            ->recordSelect(fn (Forms\Components\Select $select) => $select
                ->searchable()
                ->getSearchResultsUsing(function (string $search): array {
                    // Query sugli studi con la connessione corretta
                    return \Modules\SaluteOra\Models\Studio::on('salute_ora')
                        ->where(function (Builder $query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        })
                        // Utilizzo di modelKeys() per ottenere gli ID già associati
                        ->whereNotIn('id', $this->getOwnerRecord()->studios->modelKeys())
                        ->limit(10)
                        ->get()
                        ->mapWithKeys(function ($studio) {
                            return [$studio->getKey() => "{$studio->name} <{$studio->email}>"];
                        })
                        ->toArray();
                })
            )
    ];
}
```

### Considerazioni sulla Relazione Bidirezionale

1. **Cambio del Nome della Chiave**: Nella direzione Doctor->Studios, la chiave esterna nella tabella pivot è `user_id` (non `doctor_id`)
2. **Connessione Implicita vs Esplicita**:
   - Nel caso di `Doctor`, spesso la connessione è implicita nel contesto dell'applicazione
   - Nel caso di `Studio`, dobbiamo usare esplicitamente `on('salute_ora')` se non siamo già in quel contesto
3. **Gestione Coerente**: In entrambe le direzioni usiamo `modelKeys()` per ottenere gli ID già associati, evitando JOIN problematici

## Punti Chiave da Ricordare

1. **Mai usare query JOIN automatiche** tra database diversi
2. **Specificare sempre la connection con `on()`** quando si lavora con database multipli
3. **Utilizzare query manuali** per escludere record già associati invece di affidarsi alle subquery automatiche
4. **Limitare i risultati** per evitare problemi di performance
5. **Formattare i risultati** in modo appropriato per l'interfaccia utente

## Debugging Relazioni Cross-Database

Se si verificano errori nelle relazioni cross-database:

1. Verificare che il modello pivot specifichi la connessione corretta
2. Controllare che le query non stiano tentando di unire tabelle attraverso database diversi
3. Esaminare le query SQL generate (utilizzare `DB::enableQueryLog()` e `DB::getQueryLog()`)
4. Assicurarsi che le configurazioni delle connessioni siano corrette in `config/database.php`

## Riferimenti API Filament 3.x

- Il componente `Select` supporta i metodi `getSearchResultsUsing()` e `getOptionLabelsUsing()`
- L'azione `AttachAction` supporta il metodo `recordSelect()` per personalizzare il componente select
- In relazioni cross-database, evitare di usare `recordSelectOptionsQuery()` che può generare JOIN problematici

## AttachAction simmetrico obbligatorio

Ogni RelationManager che gestisce relazioni cross-db (es. Studio-Doctor) deve implementare AttachAction personalizzato su entrambi i lati, con query manuali e connessione esplicita tramite on().

Esempio:

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
