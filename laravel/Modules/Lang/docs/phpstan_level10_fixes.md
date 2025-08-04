# Correzioni PHPStan Livello 10 - Modulo Lang

Questo documento traccia gli errori PHPStan di livello 10 identificati nel modulo Lang e le relative soluzioni implementate.

## Errori Principali e Soluzioni

### 1. Operazioni binarie con mixed

**Problema**: PHPStan segnala errori quando si concatenano stringhe con valori di tipo `mixed`.

**File interessati**:
- `Actions/GetTransPathAction.php`
- `Datas/TranslationData.php`

**Soluzione**:
- Utilizzare `Assert::string()` per verificare che i valori siano stringhe
- Implementare controlli di tipo espliciti prima di utilizzare i valori
- Utilizzare variabili temporanee per memorizzare i valori verificati

### 2. Utilizzo di Str::of() con mixed

**Problema**: PHPStan segnala errori quando si passa un valore `mixed` al metodo `Str::of()` che richiede una stringa.

**File interessati**:
- `Http/Livewire/Lang/Change.php`
- `Http/Livewire/Lang/Switcher.php`

**Soluzione**:
- Verificare che il valore sia una stringa prima di passarlo a `Str::of()`
- Implementare logica di fallback per i casi in cui il valore non è una stringa
- Utilizzare controlli condizionali per gestire diversi tipi di valori

### 3. Parametri di tipo incompatibile

**Problema**: PHPStan segnala errori quando si passano valori di tipo incompatibile ai metodi.

**File interessati**:
- `Providers/LangServiceProvider.php`
- `View/Composers/ThemeComposer.php`

**Soluzione**:
- Convertire gli array generici in array tipizzati correttamente
- Utilizzare controlli di tipo per garantire la compatibilità
- Implementare logica di fallback per i casi in cui i valori non sono del tipo atteso

### 4. Cast a string non sicuri

**Problema**: PHPStan segnala errori quando si utilizza il cast a stringa `(string)` su valori `mixed`.

**File interessati**:
- `View/Composers/ThemeComposer.php`

**Soluzione**:
- Sostituire i cast diretti con controlli di tipo espliciti
- Implementare valori di fallback per i casi in cui i valori non sono stringhe
- Utilizzare metodi più sicuri per la conversione di tipi

### 5. Comandi Console - Tipizzazione Mancante

**Problema**: PHPStan segnala errori nei comandi Console per mancanza di tipizzazione e utilizzo di funzioni non sicure.

**File interessati**:
- `Console/Commands/ConvertTranslations.php`
- `Console/Commands/FindMissingTranslations.php`

**Errori specifici**:
- Metodi senza tipo di ritorno specificato
- Parametri senza tipo specificato
- Utilizzo di funzioni non sicure (`json_encode`, `json_decode`, `shell_exec`)
- Parametri di tipo incompatibile per funzioni come `strtolower()`, `lang_path()`, `File::exists()`

**Soluzione**:
- Aggiungere `declare(strict_types=1);` all'inizio dei file
- Specificare tipi di ritorno per tutti i metodi
- Tipizzare tutti i parametri dei metodi
- Utilizzare funzioni sicure da `thecodingmachine/safe`
- Implementare controlli di tipo per i parametri delle funzioni
- Gestire correttamente i valori nullable e mixed

## Principi Applicati nelle Correzioni

1. **Controlli di tipo espliciti**: Verificare sempre il tipo di un valore prima di utilizzarlo in operazioni che richiedono un tipo specifico.
2. **Valori di fallback**: Implementare valori di default per gestire i casi in cui i valori non sono del tipo atteso.
3. **Documentazione migliorata**: Aggiungere annotazioni PHPDoc corrette per aiutare PHPStan a comprendere i tipi.
4. **Gestione degli errori**: Implementare try/catch o controlli condizionali per gestire potenziali errori.
5. **Asserzioni**: Utilizzare `Assert::string()`, `Assert::isArray()`, ecc. per garantire che i valori siano del tipo corretto.
6. **Funzioni sicure**: Utilizzare le funzioni sicure di `thecodingmachine/safe` invece delle funzioni native PHP.

## Esempi di Correzioni

### Esempio 1: Correzione di operazioni binarie con mixed

```php
// Prima
return $lang_path.'/'.$lang.'/'.$piece[0].'.php';

// Dopo
Assert::string($lang_path, 'Il percorso del modulo deve essere una stringa');
$file_name = $piece[0] ?? '';
Assert::string($file_name, 'Il nome del file deve essere una stringa');

return $lang_path.'/'.$lang.'/'.$file_name.'.php';
```

### Esempio 2: Correzione di Str::of() con mixed

```php
// Prima
$url = Str::of($url)->replace(url(''), '')->toString();

// Dopo
if (!is_string($url)) {
    $url = '/' . $key; // Fallback
} else {
    $url = Str::of($url)->replace(url(''), '')->toString();
}
```

### Esempio 3: Correzione di parametri di tipo incompatibile

```php
// Prima
$component->validationMessages($validationMessages);

// Dopo
$typedMessages = [];
foreach ($validationMessages as $key => $value) {
    if (is_string($key) && (is_string($value) || $value instanceof \Closure)) {
        $typedMessages[$key] = $value;
    }
}
$component->validationMessages($typedMessages);
```

### Esempio 4: Correzione Comandi Console

```php
// Prima
public function handle()
{
    $from = strtolower($this->argument('from'));
    $to = strtolower($this->argument('to'));
    $locale = $this->argument('locale');
    $path = $this->option('path') ?: lang_path($locale);
}

// Dopo
public function handle(): int
{
    $fromArg = $this->argument('from');
    $toArg = $this->argument('to');
    $localeArg = $this->argument('locale');
    $pathOption = $this->option('path');
    
    Assert::string($fromArg, 'Il parametro "from" deve essere una stringa');
    Assert::string($toArg, 'Il parametro "to" deve essere una stringa');
    Assert::string($localeArg, 'Il parametro "locale" deve essere una stringa');
    
    $from = strtolower($fromArg);
    $to = strtolower($toArg);
    $locale = $localeArg;
    $path = $pathOption ?: lang_path($locale);
}
```

### Esempio 5: Correzione Type Hints per Array Annidati

```php
// Prima
protected function flattenArray(array $array, string $prefix = ''): array
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, $this->flattenArray($value, $newKey));
        }
    }
}

// Dopo
protected function flattenArray(array $array, string $prefix = ''): array
{
    foreach ($array as $key => $value) {
        Assert::string($key, 'Le chiavi degli array devono essere stringhe');
        $newKey = $prefix ? "{$prefix}.{$key}" : $key;
        
        if (is_array($value)) {
            Assert::isArray($value, 'I valori annidati devono essere array');
            /** @var array<string, mixed> $value */
            $result = array_merge($result, $this->flattenArray($value, $newKey));
        } else {
            Assert::string($value, 'I valori delle traduzioni devono essere stringhe');
            $result[$newKey] = $value;
        }
    }
}
```

### Esempio 6: Correzione Accesso Offset su Mixed

```php
// Prima
protected function setNestedValue(array &$array, string $key, mixed $value): void
{
    foreach ($keys as $k) {
        if (!isset($current[$k])) {
            $current[$k] = [];
        }
        $current = &$current[$k];
    }
}

// Dopo
protected function setNestedValue(array &$array, string $key, mixed $value): void
{
    foreach ($keys as $k) {
        Assert::string($k, 'Le chiavi annidate devono essere stringhe');
        if (!isset($current[$k]) || !is_array($current[$k])) {
            $current[$k] = [];
        }
        $current = &$current[$k];
    }
}
```

## Correzioni Globali PHPStan - Moduli SaluteOra

### Modules/FormBuilder/app/Models/FieldOption.php

**Problema**: Accesso statico a proprietà di istanza
```php
// ERRORE: Static access to instance property
static::$type = $type;
```

**Soluzione**: Implementazione di un pattern più sicuro per il type scoping
```php
// Corretto: Uso di proprietà statica privata
private static ?string $currentType = null;

public static function setType(string $type): static
{
    self::$currentType = $type;
    return new static();
}
```

**Miglioramenti**:
- Aggiunto `declare(strict_types=1);`
- Proprietà statica rinominata in `$currentType` per chiarezza
- Aggiunti metodi `getCurrentType()` e `clearType()` per gestione completa
- Type hints migliorati per tutti i metodi

## Principi Applicati

### Type Safety
- Uso di `declare(strict_types=1);` in tutti i file
- Type hints espliciti per tutti i parametri e return types
- Gestione corretta dei tipi `mixed` con type casting appropriato

### Best Practices PHPStan
- Evitare accesso statico a proprietà di istanza
- Utilizzare type hints specifici invece di `mixed` quando possibile
- Aggiungere commenti PHPDoc per type casting quando necessario

### Architettura Modulare
- Mantenimento dei confini dei moduli
- Rispetto delle responsabilità di ogni classe
- Documentazione delle decisioni architetturali

## Risultati

Dopo aver implementato tutte le correzioni, PHPStan al livello 10 non riporta più errori nel modulo Lang. Questo garantisce un codice più robusto e tipizzato, riducendo il rischio di errori a runtime.

## Verifica Finale

Tutti i moduli ora passano l'analisi PHPStan livello 10 senza errori:

```bash
./vendor/bin/phpstan analyse Modules
# [OK] No errors
```

## Prossimi Passi

1. Applicare principi simili ad altri moduli che potrebbero avere problemi simili
2. Implementare linee guida di codifica per evitare errori simili in futuro
3. Considerare l'utilizzo di strumenti di analisi statica come parte del processo di CI/CD
4. Aggiornare la documentazione per includere best practices per la tipizzazione
5. Implementare controlli automatici per prevenire regressioni 