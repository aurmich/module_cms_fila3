# PHPStan Corrections - Lang Module

## Panoramica
Questo documento registra le correzioni PHPStan implementate nel modulo Lang.

## Correzioni Implementate

### ConvertTranslations Command

**Problema**: Type hints inadeguati per array mixed
```php
// ERRORE: Parameter expects array<string, mixed>, array<mixed, mixed> given
protected function flattenArray(array $array, string $prefix = ''): array
```

**Soluzione**: Aggiunta di type hints specifici e gestione corretta dei tipi
```php
// Corretto: Type hints appropriati
if (is_array($value)) {
    /** @var array<string, mixed> $value */
    $result = array_merge($result, $this->flattenArray($value, $newKey));
}
```

**Miglioramenti**:
- Aggiunti commenti PHPDoc per type casting
- Migliorata gestione degli array annidati
- Verifica aggiuntiva per array in `setNestedValue()`

### FindMissingTranslations Command

**Problema**: Type hints inadeguati per array mixed
```php
// ERRORE: Parameter expects array<string, mixed>, array<mixed, mixed> given
protected function checkArrayForMissing(array $array, string $namespace, string $file, string $parentKey = ''): array
```

**Soluzione**: Aggiunta di type hints specifici
```php
// Corretto: Type hints appropriati
if (is_array($value)) {
    /** @var array<string, mixed> $value */
    $missing = array_merge(
        $missing,
        $this->checkArrayForMissing($value, $namespace, $file, $currentKey)
    );
}
```

## Principi Applicati

### Type Safety
- Uso di `declare(strict_types=1);` in tutti i file
- Type hints espliciti per tutti i parametri e return types
- Gestione corretta dei tipi `mixed` con type casting appropriato

### Best Practices PHPStan
- Evitare accesso statico a proprietà di istanza
- Utilizzare type hints specifici invece di `mixed` quando possibile
- Aggiungere commenti PHPDoc per type casting quando necessario

### Gestione Array
- Type hints specifici per array associativi
- Commenti PHPDoc per type casting quando necessario
- Validazione delle chiavi come stringhe
- Gestione sicura degli array annidati

## Collegamenti Correlati

- [Console Commands](./console-commands.md)
- [Translation System](./translation-system.md)
- [FormBuilder Module PHPStan Corrections](../FormBuilder/docs/phpstan-corrections.md)

## Note per Sviluppo Futuro

1. **Type Hints**: Utilizzare sempre type hints espliciti
2. **Mixed Types**: Gestire sempre i tipi `mixed` con type casting
3. **Assertions**: Validare i tipi con assertions appropriate
4. **Documentation**: Documentare sempre i parametri e return types 