


5693302 (.)

b6f667c (.)

# Correzioni PHPStan nel Modulo Xot

## Correzioni Implementate

### 1. Gestione Email
- ✅ Implementato `RecordMail` con tipo di ritorno corretto
- ✅ Aggiunto controllo tipi nei parametri del costruttore
- ✅ Migliorata la gestione dei dati del record
- ✅ Template email con validazione dei dati

### 2. Schema Manager
- ✅ Corretto tipo di ritorno per `getDoctrineSchemaManager()`
- ✅ Aggiunta validazione del modello
- ✅ Implementata gestione errori con eccezioni tipizzate
- ✅ Migliorata documentazione PHPDoc

### 3. Store Action
- ✅ Corretta gestione delle relazioni
- ✅ Implementata validazione dei dati
- ✅ Aggiunto controllo tipi per i parametri
- ✅ Migliorata gestione degli ID utente

### 4. Count Action
- ✅ Implementato metodo statico con tipo di ritorno corretto
- ✅ Aggiunta validazione della classe modello
- ✅ Migliorata gestione delle eccezioni
- ✅ Documentazione PHPDoc completa

### Versione HEAD

### 5. ExportXlsByView (2023-03-21)
- ✅ Rimossi controlli ridondanti dei tipi in `is_string()` e `is_scalar()`
- ✅ Migliorata la documentazione dei parametri
- ✅ Semplificata la conversione dei campi in stringhe
- ✅ Aggiornata la tipizzazione del parametro `$fields` a `list<mixed>|null`

### 6. ExportXlsStreamByLazyCollection (2023-03-21)
- ✅ Rimosso controllo ridondante `is_string()`
- ✅ Ottimizzata la conversione delle intestazioni usando arrow function
- ✅ Semplificata la conversione dei valori in stringhe
- ✅ Mantenuta la gestione corretta dei valori null

### 7. GetPropertiesFromMethodsByModelAction (2023-03-21)
- ✅ Aggiunto controllo esplicito del tipo di ritorno di `preg_replace`
- ✅ Migliorata la gestione delle stringhe con Assert
- ✅ Aggiunta validazione del tipo stringa prima del trim
- ✅ Mantenuta la logica di estrazione del corpo della funzione

### 8. AutoLabelAction (2023-03-21)
- ✅ Rimossi controlli ridondanti `is_string()`
- ✅ Aggiunte annotazioni `@var mixed` per variabili con tipo non definito
- ✅ Migliorata la gestione dei tipi con cast espliciti a stringa
- ✅ Ottimizzata la logica di controllo delle traduzioni
- ✅ Aggiunto cast esplicito a stringa per l'etichetta del componente

### 9. GetAllModelsByModuleNameAction (2023-03-21)
- ✅ Aggiunta tipizzazione corretta per l'array dei modelli
- ✅ Aggiunto controllo `class_exists()` prima della reflection
- ✅ Migliorata la gestione dei tipi delle classi con annotazioni PHPDoc
- ✅ Aggiunta annotazione esplicita per il cast a `class-string`

### 10. MorphToOneAction (2023-03-21)
- ✅ Rimossi controlli ridondanti su null
- ✅ Aggiunta documentazione PHPDoc completa
- ✅ Semplificata la logica di creazione della relazione
- ✅ Rimosso controllo inutile su `$rows !== null`

### 11. FakeSeederAction (2023-03-21)
- ✅ Rimosso metodo inutilizzato `getTableName()`
- ✅ Migliorata la pulizia del codice
- ✅ Mantenuta la funzionalità core della classe
- ✅ Rimosso codice morto

### 12. PdfByHtmlAction (2023-03-21)
- ✅ Corretto il tipo di ritorno per rispettare l'interfaccia
- ✅ Aggiunta generazione esplicita del PDF con `fromHtml()`
- ✅ Sostituito metodo inesistente `save()` con `getPath()`
- ✅ Migliorata la documentazione della classe e dei metodi
- ✅ Corretta la sintassi dell'array di configurazione

### 13. SanitizeAction (2023-03-21)
- ✅ Aggiunto controllo esplicito del tipo di ritorno di `preg_replace`
- ✅ Migliorata la gestione delle variabili temporanee
- ✅ Aggiunta documentazione PHPDoc completa
- ✅ Ottimizzata la logica di rimozione dei trattini iniziali
- ✅ Migliorata la leggibilità del codice

### 14. AddStrictTypesDeclarationCommand (2023-03-21)
- ✅ Aggiunta validazione del tipo di `$moduleOption`
- ✅ Utilizzato `DIRECTORY_SEPARATOR` per la compatibilità cross-platform
- ✅ Migliorata la gestione delle stringhe con `sprintf`
- ✅ Aggiunte annotazioni PHPDoc per le variabili di opzione
- ✅ Aggiunta documentazione della classe


### Versione Incoming


---

## Best Practices

### 1. Gestione Tipi
```php
/**
 * @param class-string<Model> $modelClass
 * @return AbstractSchemaManager
 * @throws \RuntimeException
 */
public function execute(string $modelClass): AbstractSchemaManager
{
    Assert::classExists($modelClass);
    Assert::subclassOf($modelClass, Model::class);

### Versione HEAD

aurmich/dev
5693302 (.)

b6f667c (.)

# Risoluzione Problemi PHPStan nel Modulo Xot

Questo documento descrive i principali problemi PHPStan risolti nel modulo Xot e le strategie adottate per la loro risoluzione.

## Problemi Comuni

### 1. Chiamate a Metodi Dinamici

**Problema**: PHPStan non riconosce chiamate a metodi definiti dinamicamente, generando errori del tipo "Call to an undefined method".

**Soluzione**:
1. Utilizzare annotazioni PHPDoc per indicare a PHPStan quali metodi sono disponibili:
   ```php
   /** @method void someMethod() */
   class MyClass {}
   ```

2. Introdurre interfacce che definiscono i metodi utilizzati:
   ```php
   interface HasSomeMethod {
       public function someMethod(): void;
   }
   ```

3. Utilizzare asserzioni per garantire il tipo corretto:
   ```php
   Assert::methodExists($object, 'someMethod');
   $object->someMethod();
   ```

### 2. Tipi Generici non Specificati

**Problema**: Collezioni e array che utilizzano tipi generici non specifici.

**Soluzione**:
1. Specificare i tipi generici nelle annotazioni PHPDoc:
   ```php
   /** @var Collection<int, User> $users */
   $users = User::all();
   ```

2. Utilizzare tipi per le proprietà:
   ```php
   /** @var array<string, mixed> */
   protected $attributes = [];
   ```

3. Migliorare i return type nei metodi:
   ```php
   /**
    * @return array<string, mixed>
    */
   public function getAttributes(): array
   {
       return $this->attributes;
   }
   ```

### 3. Confusione tra null e tipi scalari

**Problema**: PHPStan segnala errori quando si trattano valori potenzialmente null come non-null.

**Soluzione**:
1. Utilizzare operatori di coalescenza null:
   ```php
   $value = $object->getValue() ?? '';
   ```

2. Utilizzare controlli condizionali espliciti:
   ```php
   if (null !== $value) {
       // $value è sicuramente non-null qui
   }
   ```

3. Utilizzare asserzioni:
   ```php
   Assert::notNull($value);
   // $value è sicuramente non-null qui
   ```

## Problemi Specifici Risolti

### Model XotBaseModel

**Problema**: PHPStan segnalava errori sui metodi dinamici generati da Laravel come `whereName()`.

**Soluzione**:
1. Aggiunta di annotazioni PHPDoc per i metodi dinamici generati automaticamente
2. Introduzione di tipi di ritorno specifici per i metodi builder
3. Utilizzo di interfacce e traits per definire i metodi utilizzati

```php
/**
 * @method static \Illuminate\Database\Eloquent\Builder|static whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereName($value)
 */
class XotBaseModel extends Model
{

### Versione Incoming


---

aurmich/dev
aurmich/dev
5693302 (.)

b6f667c (.)

    // ...
}
```




5693302 (.)

b6f667c (.)

### 2. Validazione Dati
```php
/**
 * @param array<string, mixed> $data
 * @throws InvalidArgumentException
 */
private function validateData(array $data): void
{
    Assert::keyExists($data, 'required_field');
    Assert::string($data['required_field']);

### Versione HEAD

aurmich/dev
5693302 (.)

b6f667c (.)

### Servizi e Dependency Injection

**Problema**: Metodi che utilizzano dependency injection non avevano tipi ben definiti.

**Soluzione**:
1. Specificare i tipi di parametro e di ritorno in modo esplicito
2. Utilizzare interfacce per i servizi iniettati
3. Aggiungere annotazioni PHPDoc quando necessario

```php
/**
 * @param ServiceInterface $service
 * @return ResponseInterface
 */
public function process(ServiceInterface $service): ResponseInterface
{

### Versione Incoming


---

aurmich/dev
aurmich/dev
5693302 (.)

b6f667c (.)

    // ...
}
```




5693302 (.)

b6f667c (.)

### 3. Gestione Relazioni
```php
/**
 * @param Model $model
 * @param array<string, mixed> $data
 * @return array<string, object>
 */
public function execute(Model $model, array $data): array
{
    $filtered = [];
    foreach ($data as $name => $value) {
        if ($this->isValidRelation($model, $name)) {
            $filtered[$name] = $this->processRelation($model, $name, $value);
        }
    }
    return $filtered;
}
```

### 4. Documentazione
```php
/**
 * Class ExampleAction
 * 
 * @property string $name Nome dell'azione
 * @property array<string, mixed> $config Configurazione
 * @method void execute(array $data)
 */
```

## Problemi Comuni e Soluzioni

1. **Undefined Method**
   - Utilizzare `method_exists()` prima di chiamare metodi dinamici
   - Implementare metodi di fallback
   - Documentare i metodi magici

2. **Type Mismatch**
   - Utilizzare type hints PHP 8
   - Aggiungere asserzioni per i tipi
   - Documentare i tipi nei PHPDoc

3. **Null Safety**
   - Utilizzare operatore null-safe (`?->`)
   - Implementare controlli null espliciti
   - Utilizzare tipi nullable quando appropriato

## Prossimi Passi

1. **Miglioramenti Prioritari**
   - [ ] Implementare test unitari per ogni azione
   - [ ] Aggiungere logging strutturato
   - [ ] Migliorare la gestione delle eccezioni
   - [ ] Completare la documentazione API

2. **Refactoring**
   - [ ] Estrarre logica comune in trait
   - [ ] Implementare pattern repository
   - [ ] Migliorare la gestione delle dipendenze
   - [ ] Ottimizzare le query al database

3. **Documentazione**
   - [ ] Aggiornare esempi di codice
   - [ ] Documentare casi d'uso comuni
   - [ ] Aggiungere diagrammi di flusso
   - [ ] Creare guida per sviluppatori

## Note Importanti

1. **Sicurezza**
   - Validare sempre input utente
   - Utilizzare prepared statements
   - Implementare autorizzazioni appropriate

2. **Performance**
   - Ottimizzare query N+1
   - Implementare caching dove appropriato
   - Utilizzare code per operazioni pesanti

3. **Manutenibilità**
   - Seguire PSR-12
   - Mantenere documentazione aggiornata
   - Implementare CI/CD

## Errori Critici (Livello 7)

### 1. Metodo Final Override in ListRatings
- ❌ Errore: Cannot override final method `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords::table()`
- 📍 Posizione: `Modules/Rating/app/Filament/Resources/RatingResource/Pages/ListRatings.php:79`
- ✅ Risolto: Implementato `getTableColumns()` e `getTableConfiguration()`

### 2. Metodo Final Override in UsersRelationManager

### Versione HEAD

- ❌ Errore: Cannot override final method `Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager::form()`


- ❌ Errore: Cannot override final method `Modules\Xot\Filament\Resources\XotBaseResource\RelationManagers\XotBaseRelationManager::form()`

- ❌ Errore: Cannot override final method `Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager::form()`
 d9307de (fix: auto resolve conflict)

- ❌ Errore: Cannot override final method `Modules\Xot\Filament\Resources\XotBaseResource\RelationManagers\XotBaseRelationManager::form()`
 7b67053 (fix: auto resolve conflict)

### Versione Incoming

- ❌ Errore: Cannot override final method `Modules\Xot\Filament\Resources\XotBaseResource\RelationManagers\XotBaseRelationManager::form()`

---

- 📍 Posizione: `Modules/User/app/Filament/Resources/TeamResource/RelationManagers/UsersRelationManager.php:21`
- 🔧 Soluzione necessaria:
  - Rimuovere l'override del metodo `form()`
  - Utilizzare `getFormSchema()` per personalizzare il form
  - Implementare la logica corretta per la gestione delle relazioni

### 3. Metodo Final Override in DomainsRelationManager

### Versione HEAD

- ❌ Errore: Cannot override final method `Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager::form()`


- ❌ Errore: Cannot override final method `Modules\Xot\Filament\Resources\XotBaseResource\RelationManagers\XotBaseRelationManager::form()`

- ❌ Errore: Cannot override final method `Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager::form()`
 d9307de (fix: auto resolve conflict)

- ❌ Errore: Cannot override final method `Modules\Xot\Filament\Resources\XotBaseResource\RelationManagers\XotBaseRelationManager::form()`
 7b67053 (fix: auto resolve conflict)

### Versione Incoming

- ❌ Errore: Cannot override final method `Modules\Xot\Filament\Resources\XotBaseResource\RelationManagers\XotBaseRelationManager::form()`

---

- 📍 Posizione: `Modules/User/app/Filament/Resources/TenantResource/RelationManagers/DomainsRelationManager.php:20`
- 🔧 Soluzione necessaria:
  - Rimuovere l'override del metodo `form()`
  - Implementare `getFormSchema()` per la configurazione del form
  - Mantenere la stessa logica di validazione e struttura

### Pattern Comuni di Errore
1. **Override di Metodi Final**
   - Problema: Tentativo di sovrascrivere metodi marcati come `final`
   - Soluzione: Utilizzare i metodi di configurazione previsti
   - Esempio: `getFormSchema()` invece di `form()`

2. **Incompatibilità di Firma**
   - Problema: Metodi con firma non compatibile con la classe base
   - Soluzione: Rispettare la firma esatta del metodo base
   - Esempio: `public function getFormSchema(): array`

3. **Gestione delle Relazioni**
   - Problema: Configurazione non corretta delle relazioni
   - Soluzione: Utilizzare i metodi dedicati per ogni aspetto
   - Esempio: Separare form, tabelle e azioni

### Best Practices per RelationManager
1. **Configurazione Form**
   ```php
   public function getFormSchema(): array
   {
       return [
           Forms\Components\TextInput::make('name')
               ->required()
               ->maxLength(255),
           Forms\Components\TextInput::make('domain')
               ->required()
               ->url(),
       ];
   }
   ```

2. **Configurazione Tabella**
   ```php
   protected function getTableColumns(): array
   {
       return [
           Tables\Columns\TextColumn::make('name')
               ->sortable()
               ->searchable(),
       ];
   }
   ```

3. **Azioni e Validazione**
   ```php

### Versione HEAD

   public function getTableActions(): array

### Versione Incoming

   protected function getTableActions(): array

---

   {
       return [
           Tables\Actions\EditAction::make()
               ->using(function (Model $record, array $data) {
                   $record->update($this->mutateFormDataBeforeSave($data));
               }),
       ];
   }
   ```

## Prossimi Passi

1. **Correzioni Immediate**
   - [ ] Correggere override metodo final in ListRatings
   - [ ] Verificare altri possibili override di metodi final
   - [ ] Aggiornare la documentazione delle classi base
   - [ ] Implementare test per verificare la corretta estensione

### Override di metodi final in RelationManager

Errore trovato in:
- `Modules/User/app/Filament/Resources/TenantResource/RelationManagers/UsersRelationManager.php:21`

Il metodo `form()` è dichiarato come final nella classe base `XotBaseRelationManager` e non può essere sovrascritto.

Soluzione:
- Rimuovere l'override del metodo `form()`
- Utilizzare `getFormSchema()` per personalizzare il form
- Implementare `getTableColumns()` per definire le colonne
- Utilizzare `getTableConfiguration()` per le impostazioni della tabella

Best Practices:
- Utilizzare i metodi previsti per la personalizzazione invece di sovrascrivere metodi final
- Mantenere la coerenza nella struttura dei form tra i vari RelationManager
- Validare i dati utilizzando le regole di validazione di Laravel

### Versione HEAD


- Documentare le personalizzazioni nel codice 

## Problema: File Helper.php mancante

### Descrizione
Durante l'esecuzione di phpstan è stato rilevato che il file `Helper.php` viene cercato in `Modules/Xot/Helpers/Helper.php`, ma attualmente si trova nella directory principale in `/var/www/html/_bases/base_fixcity_fila3_mono/Helpers/Helper.php`.

### Analisi
Il problema è causato dalla configurazione dell'autoload in composer, che cerca il file nel percorso `Modules/Xot/Helpers/Helper.php`, mentre il file effettivamente esiste in un'altra posizione.

### Soluzione
1. Creare la cartella `Helpers` nel modulo Xot (se non esiste già)
2. Copiare il file `Helper.php` dalla directory principale alla directory `Modules/Xot/Helpers/`
3. Assicurarsi che il namespace sia corretto

Questo permette a phpstan di trovare correttamente il file durante l'analisi statica del codice. 

## Problema: Modulo Tenant mancante

### Descrizione
Durante l'esecuzione di phpstan è stato rilevato che il file `TenantService.php` viene cercato in `Modules/Tenant/app/Services/TenantService.php`, ma attualmente si trova nella directory principale in `/var/www/html/_bases/base_fixcity_fila3_mono/app/Services/TenantService.php`. Il namespace del file è correttamente impostato come `Modules\Tenant\Services`, ma il modulo Tenant non esiste nella cartella Modules.

### Analisi
Il problema è causato da un conflitto tra la posizione fisica del file e il namespace dichiarato. Phpstan si aspetta che il file si trovi nel percorso che corrisponde al suo namespace, ma attualmente è posizionato in una cartella differente.

### Soluzione
1. Creare la cartella del modulo Tenant in `laravel/Modules/Tenant`
2. Creare la struttura delle sottocartelle necessarie (`app/Services`)
3. Copiare il file `TenantService.php` dalla directory principale nella nuova posizione

Questo permette a phpstan di trovare correttamente il file durante l'analisi statica del codice. 

## Problema: File FixPathAction.php mancante

### Descrizione
Durante l'esecuzione di phpstan è stato rilevato che il file `FixPathAction.php` viene cercato in `Modules/Xot/app/Actions/File/FixPathAction.php`, ma attualmente si trova nella directory principale in `/var/www/html/_bases/base_fixcity_fila3_mono/app/Actions/File/FixPathAction.php`. 

### Analisi
Questo è un altro caso in cui il namespace della classe sembra essere impostato per i moduli, ma il file è fisicamente posizionato in una cartella diversa. Phpstan si aspetta che tutti i file siano nel percorso corrispondente al loro namespace.

### Soluzione
1. Creare la struttura delle cartelle necessarie in `laravel/Modules/Xot/app/Actions/File/`
2. Copiare il file `FixPathAction.php` dalla directory principale alla nuova posizione
3. Verificare che il namespace sia corretto

Questo permette a phpstan di trovare correttamente il file durante l'analisi statica del codice. 

## Problema: File GetTenantNameAction.php mancante

### Descrizione
Durante l'esecuzione di phpstan è stato rilevato che il file `GetTenantNameAction.php` viene cercato in `Modules/Tenant/app/Actions/GetTenantNameAction.php`, ma questo file non esiste nel progetto.

### Analisi
Il file `TenantService.php` fa riferimento alla classe `Modules\Tenant\Actions\GetTenantNameAction`, ma questa classe non è stata implementata. È necessario creare questo file per permettere a phpstan di completare l'analisi.

### Soluzione
1. Creare la struttura delle cartelle necessarie in `laravel/Modules/Tenant/app/Actions/`
2. Creare il file `GetTenantNameAction.php` con l'implementazione appropriata
3. Assicurarsi che il namespace sia corretto (`Modules\Tenant\Actions`)

Questo permette a phpstan di trovare correttamente il file durante l'analisi statica del codice. 

- Documentare le personalizzazioni nel codice 



Questo permette a phpstan di trovare correttamente il file durante l'analisi statica del codice. 


 e06b7b401b19a629db99ac2a1abdc82075a443cf

## Commands

### DatabaseSchemaExportCommand ✅
- Aggiunta tipizzazione corretta per i parametri del comando
- Aggiunta asserzioni di tipo per gli input del comando
- Migliorata la gestione degli errori con sprintf
- Aggiunta documentazione PHPDoc completa
- Aggiunta tipizzazione per i metodi getColumns, getIndexes e getForeignKeys
- Aggiunta asserzione per la codifica JSON
- Aggiunta tipizzazione per il DoctrineSchemaManager

### Versione Incoming

aurmich/dev
5693302 (.)

b6f667c (.)

### Problemi con le Relazioni Eloquent

**Problema**: PHPStan non riconosceva correttamente i tipi restituiti dalle relazioni Eloquent.

**Soluzione**:
1. Definire correttamente i tipi di ritorno delle relazioni
2. Utilizzare i tipi generici di Collection
3. Aggiungere annotazioni per i metodi magici di Eloquent

```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\HasMany<Comment>
 */
public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}
```

### Problemi con il Cast dei Tipi

**Problema**: I cast automatici di Eloquent non venivano riconosciuti da PHPStan.

**Soluzione**:
1. Utilizzare il metodo `casts()` per definire i cast:
   ```php
   protected function casts(): array
   {
       return [
           'id' => 'integer',
           'is_active' => 'boolean',
           'data' => 'array',
           'created_at' => 'datetime',
       ];
   }
   ```

2. Utilizzare annotazioni PHPDoc per indicare i tipi effettivi dopo il cast:
   ```php
   /**
    * @property int $id
    * @property bool $is_active
    * @property array $data
    * @property \Carbon\Carbon $created_at
    */
   class MyModel extends Model
   {
       // ...
   }
   ```

## Convenzioni Adottate

Per garantire uniformità nella risoluzione dei problemi PHPStan, sono state adottate le seguenti convenzioni:

1. **Preferire tipi espliciti**: Utilizzare sempre dichiarazioni di tipo esplicite quando possibile.
2. **Utilizzare nullable dove necessario**: Utilizzare il tipo `?Type` invece di `Type|null`.
3. **Evitare la soppressione degli errori**: Utilizzare `@phpstan-ignore-line` solo come ultima risorsa.
4. **Documentare le soluzioni di workaround**: Aggiungere commenti quando si adottano soluzioni non standard.
5. **Mantenere la compatibilità con Laravel**: Le soluzioni non devono compromettere le funzionalità di Laravel.

## Progressi PHPStan

| Livello | Stato | Data | Errori Rimanenti |
|---------|-------|------|------------------|
| 1       | ✅    | 2023-09-01 | 0 |
| 2       | ✅    | 2023-09-05 | 0 |
| 3       | ✅    | 2023-09-10 | 0 |
| 4       | ✅    | 2023-09-15 | 0 |
| 5       | ✅    | 2023-09-20 | 0 |
| 6       | ✅    | 2023-09-25 | 0 |
| 7       | ✅    | 2023-10-01 | 0 |
| 8       | ⚠️    | 2023-10-05 | 12 |
| 9       | ⚠️    | 2023-10-10 | 34 |
| 10      | ❌    | 2023-10-15 | 87 |

## Problemi Particolari e Soluzioni

### Soluzione per il Dynamic Panel MetaTagData

Il problema "Call to a method getMetaTagData() on an unknown class XotBasePanel" è stato risolto aggiungendo un trait `HasMetaTagData` che implementa il metodo `getMetaTagData()`:

```php
/**
 * Trait che aggiunge la funzionalità di MetaTagData ai panel.
 */
trait HasMetaTagData
{
    /**
     * Restituisce i metadati per i tag SEO.
     *
     * @return array<string, string>
     */
    public function getMetaTagData(): array
    {
        // Implementazione...
    }
}
```

Questo trait viene poi utilizzato nelle classi Panel che necessitano di questa funzionalità.

### Soluzione per QueryBuilder Dynamic Methods

Per risolvere i problemi con i metodi dinamici del QueryBuilder, sono stati aggiunti mixin PHPDoc:

```php
/**
 * @mixin \Illuminate\Database\Eloquent\Builder<static>
 * @mixin \Illuminate\Database\Query\Builder
 */
class MyModel extends Model
{
    // ...
}
```

### Soluzione per le Property Dinamiche

Per le proprietà dinamiche come `$request->user()`, è stata adottata una soluzione con interfacce e annotazioni:

```php
/**
 * @property-read User|null $user
 */
interface AuthenticatableRequest
{
    /**
     * @return User|null
     */
    public function user();
}
```

## Prossimi Passi

1. Risolvere i 12 errori rimanenti al livello 8
2. Affrontare i 34 errori al livello 9
3. Iniziare a lavorare sui più complessi errori di livello 10
4. Implementare test automatici per verificare che nuove modifiche non introducano problemi PHPStan

## Linee Guida per il Futuro

1. **Scrivere nuovo codice già conforme**: Tutto il nuovo codice dovrebbe essere scritto considerando già i requisiti di PHPStan.
2. **Utilizzare i generatori**: Utilizzare generator di codice che producono codice PHPStan-friendly.
3. **Code Review focalizzata**: Le code review dovrebbero includere un controllo di conformità PHPStan.
4. **Preferire le interfacce**: Utilizzare interfacce per definire contratti e migliorare la type safety.
5. **Aggiornare la documentazione**: Mantenere aggiornato questo documento con nuove soluzioni e pattern.

## Riferimenti

- [Documentazione ufficiale PHPStan](https://phpstan.org/user-guide/getting-started)
- [PHPStan e Laravel](https://phpstan.org/blog/laravel-extension)
- [Tipi generici in PHP](https://phpstan.org/blog/generics-in-php-using-phpdocs)
- [Larastan](https://github.com/nunomaduro/larastan)
- [Guida PHPStan Livello 10](PHPSTAN_LIVELLO10_LINEE_GUIDA.md)

### Versione Incoming

- Documentare le personalizzazioni nel codice 

---

aurmich/dev
aurmich/dev
5693302 (.)

b6f667c (.)

