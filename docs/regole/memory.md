# Regole Fondamentali Base

## XotBaseResource
- ✅ SEMPRE estendere `XotBaseResource` invece di `Resource`
- ✅ SEMPRE usare `getFormSchema(): array` invece di `form(Form $form): Form`
- ❌ NON definire `$navigationIcon`, `$navigationGroup`, `$navigationSort`
- ❌ NON definire `table()`, `getTableColumns()`, `getTableFilters()`
- ✅ SEMPRE definire `protected static ?string $model`
- ❌ NON sovrascrivere metodi `final`
- ✅ SEMPRE usare file di traduzione per le label

## XotBaseListRecords
- ✅ SEMPRE estendere `XotBaseListRecords` invece di `ListRecords`
- ✅ SEMPRE usare `getListTableColumns()` invece di `getTableColumns()`
- ✅ SEMPRE usare `getListTableFilters()` invece di `getTableFilters()`
- ✅ SEMPRE usare `getListTableActions()` invece di `getTableActions()`
- ✅ SEMPRE usare `getListTableBulkActions()` invece di `getTableBulkActions()`

## Traduzioni
- ❌ NON usare `->label()` nei componenti
- ✅ SEMPRE definire le traduzioni nei file di lingua
- ✅ SEMPRE seguire la struttura standard delle traduzioni

## Namespace
- ✅ SEMPRE usare `Modules\{Module}\Filament\Resources`
- ✅ SEMPRE importare da `Modules\Xot\Filament\Resources`
- ❌ NON includere `app` nel namespace
- ✅ SEMPRE estendere `BaseModel` dallo stesso namespace

## Metodi Statici
- ✅ `getFormSchema()` deve essere `public static`
- ✅ `$model` deve essere `protected static ?string`
- ❌ NON usare `$this` nei metodi statici

## ServiceProvider
- ✅ SEMPRE estendere `XotBaseServiceProvider`
- ✅ SEMPRE definire `public string $name`
- ❌ NON modificare la visibilità delle proprietà ereditate
- ✅ SEMPRE chiamare `parent::boot()` e `parent::register()`

## Modelli
- ✅ SEMPRE estendere `BaseModel` dallo stesso namespace
- ✅ SEMPRE usare il metodo `casts()` invece della proprietà `$casts`
- ✅ SEMPRE mantenere i cast del modello base con `parent::casts()`
- ❌ NON estendere direttamente `Illuminate\Database\Eloquent\Model`

## Collegamenti
- [Regole Namespace](namespace.md)
- [Regole ServiceProvider](service-providers.md)
- [Regole Modelli](modelli-eloquent.md)
- [Regole Filament](filament-resources.md)

## Regole per l'Estensione dei Modelli

### Regola Fondamentale
I modelli di ogni modulo DEVONO estendere il BaseModel del proprio modulo, NON direttamente Illuminate\Database\Eloquent\Model.

### Motivazione
1. **Coerenza del Sistema**
   - Ogni modulo ha il suo BaseModel con configurazioni specifiche
   - Le funzionalità comuni sono centralizzate
   - La manutenzione è semplificata

2. **Ereditarietà Corretta**
   ```php
   // ✅ CORRETTO
   use Modules\ModuleName\Models\BaseModel;
   class MyModel extends BaseModel { }

   // ❌ SBAGLIATO
   use Illuminate\Database\Eloquent\Model;
   class MyModel extends Model { }
   ```

3. **Vantaggi**
   - Cast comuni automatici
   - Configurazioni di connessione unificate
   - Traits e funzionalità condivise
   - Facilità di aggiornamento
   - Riduzione della duplicazione del codice

### Verifica
Prima di creare un nuovo modello:
1. Verificare l'esistenza di BaseModel nel modulo
2. Controllare le funzionalità ereditate
3. Non duplicare configurazioni già presenti in BaseModel 

# Memoria Tecnica

## Filament

### Metodi Deprecati
- ❌ NON usare `getListTableColumns()` - DEPRECATO
- ❌ NON usare `getGridTableColumns()` - DEPRECATO
- ✅ SEMPRE usare `getTableColumns()` con layout appropriato

### Metodi Standard
- ✅ SEMPRE usare array associativi con chiavi stringa
- ✅ SEMPRE usare file di traduzioni
- ✅ SEMPRE estendere XotBaseResource
- ✅ SEMPRE implementare SOLO getFormSchema()

### Anti-pattern
- ❌ NON estendere direttamente classi Filament
- ❌ NON implementare metodi non necessari
- ❌ NON usare hardcoding di traduzioni
- ❌ NON duplicare codice

### Best Practices
1. **Responsabilità**
   - XotBaseResource gestisce la logica comune
   - Resources specifici gestiscono SOLO lo schema form
   - Traduzioni gestite tramite file di lingua
   - Layout gestito tramite configurazione

2. **Manutenzione**
   - Verificare aggiornamenti Filament
   - Controllare metodi deprecati
   - Aggiornare documentazione
   - Mantenere codice pulito

3. **Performance**
   - Minimizzare codice
   - Evitare duplicazioni
   - Usare cache quando possibile
   - Ottimizzare query

4. **Sicurezza**
   - Validare input
   - Gestire permessi
   - Proteggere dati sensibili
   - Logging appropriato 