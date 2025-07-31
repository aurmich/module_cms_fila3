# Analisi Errori PHPStan Correnti - Gennaio 2025

## Panoramica

Questo documento analizza gli errori PHPStan identificati nel progetto e propone soluzioni strutturate per la loro risoluzione.

## Errori Identificati e Correzioni Implementate

### 1. FormBuilder - FormFieldsDistributionWidget.php ✅ RISOLTO

**Errore**: `Static method Modules\FormBuilder\Models\FormField::where() invoked with 2 parameters, 3 required.`

**Analisi**: Il metodo `where()` di Eloquent richiede 3 parametri ma ne vengono passati solo 2.

**Soluzione Implementata**: Il file era già corretto con il terzo parametro esplicito `'='`.

### 2. FormBuilder - FormBuilderServiceProvider.php ⚠️ DA ANALIZZARE

**Errori multipli**:
- `Parameter #2 $path of function module_path expects string, mixed given.`
- `Cannot call method getExtension() on mixed.`
- `Cannot call method isFile() on mixed.`
- `Cannot call method getPathname() on mixed.`
- `Binary operation "." between non-falsy-string and list<string>|string results in an error.`
- `Parameter #1 $array of function array_replace_recursive expects array, mixed given.`
- `Binary operation "." between mixed and '\\' results in an error.`
- `Argument of an invalid type mixed supplied for foreach, only iterables are supported.`

**Analisi**: Il ServiceProvider ha problemi di tipizzazione con valori `mixed` che non vengono controllati prima dell'uso.

**Stato**: Il file FormBuilderServiceProvider.php attuale è molto breve e non contiene il codice problematico. Gli errori potrebbero essere in un file diverso o in una versione precedente.

### 3. SaluteMo - ListUsers.php ✅ RISOLTO

**Errore**: `Method getTableActions() has invalid return type Modules\Xot\Filament\Traits\Action.`

**Analisi**: Il tipo di ritorno era specificato come trait invece che come array di azioni.

**Soluzione Implementata**:
```php
/**
 * @return array<\Filament\Tables\Actions\Action>
 */
public function getTableActions(): array
{
    return [
        // azioni...
    ];
}
```

### 4. SaluteOra - DoctorAvailabilityResource ✅ RISOLTO

**Errori**: `Class Modules\SaluteOra\Filament\Resources\DoctorAvailabilityResource not found.`

**Analisi**: La classe `DoctorAvailabilityResource` non esisteva.

**Soluzione Implementata**: Creato il file `DoctorAvailabilityResource.php` basandomi sul file `.old` esistente.

### 5. SaluteOra - ListPatients.php ✅ RISOLTO

**Errore**: `Method getHeaderWidgets() should return array<class-string> but returns array<string, Filament\Widgets\WidgetConfiguration>.`

**Analisi**: Il metodo restituiva un array con configurazioni di widget invece di class-string.

**Soluzione Implementata**:
```php
/**
 * @return array<class-string>
 */
public function getHeaderWidgets(): array
{
    return [
        StateOverviewWidget::class,
    ];
}
```

### 6. SaluteOra - ViewReport.php ✅ RISOLTO

**Errori**:
- `Variable $state in empty() always exists and is not falsy.`
- `Call to an undefined method notify().`

**Analisi**: 
1. La variabile `$state` era sempre definita e non falsa
2. Il metodo `notify()` non esisteva nella classe

**Soluzioni Implementate**:
```php
// Aggiunto trait Notifiable
use Illuminate\Notifications\Notifiable;

class ViewReport extends XotBaseViewRecord
{
    use Notifiable;
    
    // Corretto i controlli empty() sempre falsy
    if ($state === null || count($state) === 0) {
        return 'Nessuna malattia specificata';
    }
}
```

### 7. SaluteOra - ListUsers.php ✅ RISOLTO

**Errori**:
- `Method getTableColumns() should return array<string, Filament\Tables\Columns\Column> but returns array<string, Filament\Tables\Columns\Column|Modules\UI\Filament\Tables\Columns\IconStateGroupColumn>.`
- `Method IconStateGroupColumn::stateClass() invoked with 1 parameter, 2 required.`

**Analisi**: 
1. Il tipo di ritorno includeva un tipo union che non era accettato
2. Il metodo `stateClass()` richiedeva 2 parametri ma ne veniva passato solo 1

**Soluzioni Implementate**:
```php
/**
 * @return array<string, \Filament\Tables\Columns\Column>
 */
public function getTableColumns(): array
{
    // ...
}

// Corretto stateClass con 2 parametri
'states'=>IconStateGroupColumn::make('states')->stateClass(UserState::class, User::class),
```

### 8. SaluteOra - Doctor.php ✅ RISOLTO

**Errori**:
- `Class Modules\SaluteOra\Models\DoctorRegistrationWorkflow not found.`
- `Parameter #1 $related of method hasOne() expects class-string<Model>, string given.`
- `Unable to resolve the template type TRelatedModel in call to method hasOne()`

**Analisi**: 
1. La classe `DoctorRegistrationWorkflow` non esisteva
2. Il metodo `hasOne()` riceveva una stringa invece di una class-string
3. PHPStan non riusciva a risolvere il tipo generico

**Soluzioni Implementate**:
1. Creato il modello `DoctorRegistrationWorkflow.php` con PHPDoc completo
2. Aggiunto la relazione corretta nel modello Doctor:
```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\HasOne<\Modules\SaluteOra\Models\DoctorRegistrationWorkflow>
 */
public function registrationWorkflow(): HasOne
{
    return $this->hasOne(DoctorRegistrationWorkflow::class);
}
```

## Pattern di Risoluzione Comuni

### 1. Gestione Mixed Types
```php
// Prima di usare un valore mixed
if (is_string($value)) {
    $result = $value . 'suffix';
} else {
    $result = 'default';
}
```

### 2. Controllo Metodi su Oggetti
```php
// Verificare che l'oggetto abbia il metodo
if (is_object($object) && method_exists($object, 'methodName')) {
    $result = $object->methodName();
}
```

### 3. Tipizzazione Corretta per Relazioni
```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\ModuleName\Models\RelatedModel>
 */
public function relatedModels(): HasMany
{
    return $this->hasMany(RelatedModel::class);
}
```

### 4. Return Types per Metodi Filament
```php
/**
 * @return array<class-string>
 */
public function getHeaderWidgets(): array
{
    return [
        WidgetClass::class,
    ];
}

/**
 * @return array<string, \Filament\Tables\Columns\Column>
 */
public function getTableColumns(): array
{
    return [
        'column_name' => TextColumn::make('name'),
    ];
}
```

## Priorità di Risoluzione

1. **Alta Priorità**: Errori che impediscono la compilazione ✅ RISOLTI
   - Classi mancanti (DoctorAvailabilityResource, DoctorRegistrationWorkflow)
   - Metodi mancanti (notify())

2. **Media Priorità**: Errori di tipizzazione ✅ RISOLTI
   - Return types incorretti
   - Parametri con tipi sbagliati

3. **Bassa Priorità**: Errori di mixed types ⚠️ DA ANALIZZARE
   - Controlli di tipo per valori mixed
   - Gestione sicura di oggetti

## Errori Rimanenti da Analizzare

### FormBuilderServiceProvider.php
Gli errori segnalati per questo file non corrispondono al contenuto attuale. Potrebbe essere necessario:
1. Verificare se esiste una versione diversa del file
2. Controllare se gli errori sono in un file diverso
3. Eseguire un'analisi più approfondita del modulo FormBuilder

## Collegamenti

- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Eloquent Relationships](https://laravel.com/docs/eloquent-relationships)

## Ultimo Aggiornamento
2025-01-06 - Correzioni implementate per la maggior parte degli errori 