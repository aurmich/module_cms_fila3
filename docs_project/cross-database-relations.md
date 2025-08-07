# Relazioni Cross-Database nel Progetto SaluteOra

## Architettura Multi-Database

Il progetto SaluteOra utilizza un'architettura multi-database deliberata dove diverse entità risiedono in database separati:

1. `user`: Database che contiene utenti, dottori, pazienti e ruoli
2. `salute_ora`: Database che contiene studi medici, appuntamenti e altre entità di dominio
3. Tabelle pivot: Risiedono nello stesso database dell'entità "proprietaria" della relazione

## Pattern di Implementazione Corretto

### 1. Configurazione del Modello Pivot

```php
class DoctorStudio extends BasePivot
{
    /**
     * Definizione esplicita della tabella per relazioni cross-database.
     *
     * @var string
     */
    protected $table = 'doctor_studio';
    
    /**
     * La connection deve essere specificata esplicitamente e deve
     * corrispondere al database dove la tabella pivot risiede.
     *
     * @var string
     */
    protected $connection = 'salute_ora';
    
    // Resto dell'implementazione...
}
```

### 2. Relazioni nei Modelli

```php
// Nel modello Doctor (database 'user')
public function studios(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
{
    return $this->belongsToMany(
        Studio::class,
        'doctor_studio',   // Nome tabella pivot (senza prefisso database)
        'doctor_id',       // Chiave esterna che punta a questo modello
        'studio_id',       // Chiave esterna che punta al modello correlato
        'id',              // Chiave locale di questo modello
        'id'               // Chiave locale del modello correlato
    )->using(DoctorStudio::class)
     ->withPivot(['schedule', 'is_primary'])
     ->withTimestamps();
     
    // NOTA: NON usare ->on('connection_name') - non è supportato da Laravel
    // La connessione deve essere definita nel modello pivot
}

// Nel modello Studio (database 'salute_ora')
public function doctors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
{
    return $this->belongsToMany(
        Doctor::class,
        'doctor_studio',   // Nome tabella pivot
        'studio_id',       // Chiave esterna che punta a questo modello
        'doctor_id',       // Chiave esterna che punta al modello correlato
        'id',              // Chiave locale di questo modello
        'id'               // Chiave locale del modello correlato
    )->using(DoctorStudio::class)
     ->withPivot(['schedule', 'is_primary'])
     ->withTimestamps();
}
```

## Errori Comuni da Evitare

1. **Utilizzo di `->on()`**: Il metodo `on()` non è supportato per relazioni BelongsToMany
2. **Omissione di `$connection` nel pivot**: La connessione DEVE essere specificata nel modello pivot
3. **Utilizzo di `belongsToManyX` per cross-database**: Per relazioni cross-database, usare sempre il metodo standard `belongsToMany` con tutti i parametri espliciti

## Migrazione per Tabelle Pivot Cross-Database

La migrazione per una tabella pivot cross-database deve essere creata nel modulo che "possiede" la relazione, seguendo le convenzioni standard:

```php
// In Modules/SaluteOra/database/migrations/2025_05_30_000001_create_doctor_studio_table.php
public function tableCreate(Blueprint $table): void
{
    $table->id();
    $table->foreignIdFor(Doctor::class); // Riferimento a tabella in altro database
    $table->foreignIdFor(Studio::class); // Riferimento a tabella nello stesso database
    $table->json('schedule')->nullable();
    $table->boolean('is_primary')->default(false);
    
    // Altri campi...
    
    $this->updateTimestamps($table);
}
```

## Considerazioni Filosofiche

L'architettura multi-database riflette una separazione dei domini a livello di persistenza dati:
- Promuove la coesione di dominio
- Facilita la scalabilità separata di componenti del sistema
- Supporta l'evoluzione indipendente dei modelli di dati

Questa architettura richiede però un'attenzione particolare nella configurazione delle relazioni cross-database, come descritto in questo documento.

## AttachAction e RelationManager cross-db

Quando si usano componenti Filament come AttachAction per relazioni molti-a-molti tra modelli su database diversi, **è obbligatorio**:

- Personalizzare la query delle opzioni (`recordSelectOptionsQuery`) forzando la connessione corretta con `Model::on('connection')`.
- Personalizzare la ricerca (`getSearchResultsUsing`) per evitare join cross-db.
- Non usare mai la query Eloquent standard o join implicite.

### Esempio
```php
Tables\Actions\AttachAction::make()
    ->recordSelectOptionsQuery(function () {
        $studio = $this->getOwnerRecord();
        $alreadyAttachedIds = \DB::connection('salute_ora')
            ->table('doctor_studio')
            ->where('studio_id', $studio->id)
            ->pluck('user_id')
            ->toArray();

        return \Modules\User\Models\Doctor::on('user')
            ->where('type', 'doctor')
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

### Motivazione
- Laravel non supporta join cross-db tra connessioni diverse
- Prevenzione di errori SQL (`Base table or view not found`)
- Portabilità e chiarezza architetturale

Vedi esempio in [filament-relation-managers.md](./filament-relation-managers.md).

> **Nota:** La policy AttachAction cross-db va applicata sia in DoctorsRelationManager che in StudiosRelationManager. Vedi dettagli e pattern in [filament-relation-managers.md](./filament-relation-managers.md#policy-attachaction-cross-db-simmetrica-studiodoctor-e-doctorstudio).

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
