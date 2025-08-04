# PHPStan Corrections - FormBuilder Module

## Panoramica
Questo documento registra le correzioni PHPStan implementate nel modulo FormBuilder.

## Correzioni Implementate

### FieldOption Model

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

## Collegamenti Correlati

- [FieldOption Model](./field-option-model.md)
- [FormBuilder Architecture](./architecture.md)
- [Lang Module PHPStan Corrections](../Lang/docs/phpstan-corrections.md)

## Note per Sviluppo Futuro

1. **Type Safety**: Mantenere sempre type hints espliciti
2. **Static Properties**: Evitare accesso statico a proprietà di istanza
3. **Mixed Types**: Gestire sempre i tipi `mixed` con type casting appropriato
4. **Documentation**: Aggiornare sempre la documentazione dopo correzioni significative 