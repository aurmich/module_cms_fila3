# FieldOption Model - FormBuilder Module

## Panoramica
Il modello `FieldOption` gestisce le opzioni dei campi del form builder con supporto per traduzioni e type scoping.

## Caratteristiche Principali

### Traduzioni
- Utilizza il trait `HasTranslations` di Spatie
- Campo `name` traducibile in tutte le lingue supportate
- Supporto per array di traduzioni

### Type Scoping
Il modello implementa un sistema di type scoping per filtrare le opzioni per tipo:

```php
// Imposta il tipo per le query successive
FieldOption::setType('select')->where('active', true)->get();

// Pulisce il tipo corrente
FieldOption::clearType();

// Ottiene il tipo corrente
$currentType = FieldOption::getCurrentType();
```

## Struttura del Modello

### Proprietà
- `$translatable`: Array dei campi traducibili
- `$fillable`: Campi che possono essere assegnati in massa
- `$currentType`: Proprietà statica per il type scoping

### Metodi Principali

#### setType(string $type): static
Imposta il tipo corrente per il filtraggio delle query.

#### getCurrentType(): ?string
Restituisce il tipo corrente impostato.

#### clearType(): void
Pulisce il tipo corrente.

## Global Scope

Il modello include un global scope automatico che filtra le query per tipo quando `$currentType` è impostato:

```php
protected static function booted(): void
{
    static::addGlobalScope('type_scope', function (Builder $builder) {
        if (self::$currentType !== null) {
            $builder->where('type', self::$currentType);
        }
    });
}
```

## Esempi di Utilizzo

### Creazione con Type Scoping
```php
// Imposta il tipo e crea una nuova istanza
$option = FieldOption::setType('select');

// Query automaticamente filtrata per tipo
$selectOptions = FieldOption::where('active', true)->get();
```

### Gestione Traduzioni
```php
$option = new FieldOption();
$option->setTranslation('name', 'it', 'Opzione 1');
$option->setTranslation('name', 'en', 'Option 1');
$option->save();
```

## Best Practices

1. **Type Safety**: Utilizzare sempre `declare(strict_types=1);`
2. **Type Scoping**: Pulire sempre il tipo dopo l'uso con `clearType()`
3. **Traduzioni**: Utilizzare sempre i metodi di traduzione invece di assegnazioni dirette
4. **Query Building**: Sfruttare il global scope per filtrare automaticamente

## Collegamenti Correlati

- [FormBuilder Architecture](./architecture.md)
- [Translation System](../Lang/docs/translation-system.md)
- [PHPStan Corrections](../../../docs/phpstan-fixes.md)

## Note di Sviluppo

### Correzioni PHPStan Implementate
- Rimosso accesso statico a proprietà di istanza
- Implementato pattern sicuro per type scoping
- Aggiunti type hints espliciti
- Migliorata gestione delle proprietà statiche

### Architettura
- Estende `BaseModel` del modulo
- Utilizza trait `HasTranslations` per traduzioni
- Implementa global scope per type filtering
- Mantiene separazione delle responsabilità 