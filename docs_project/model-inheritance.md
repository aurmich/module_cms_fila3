# Convenzione di Ereditarietà dei Modelli

## Principio Fondamentale

Ogni modello in un modulo **deve** estendere la classe base del proprio modulo, non direttamente `Illuminate\Database\Eloquent\Model`.

## Implementazione Corretta

```php
// ✓ Corretto
class Studio extends \Modules\SaluteOra\Models\BaseModel
{
    // ...
}

// ✗ Errato
class Studio extends \Illuminate\Database\Eloquent\Model
{
    // ...
}
```

## Motivazione

1. **Coerenza**: Mantiene un'architettura coerente in tutto il progetto
2. **Riutilizzo del Codice**: Le classi base dei moduli possono implementare funzionalità comuni
3. **Estensibilità**: Facilita modifiche globali ai modelli di un modulo
4. **Manutenibilità**: Semplifica il refactoring e l'evoluzione del codice

## Classi Base dei Moduli

Ogni modulo deve definire la propria classe `BaseModel` che può estendere altre classi base o implementare funzionalità specifiche:

```php
namespace Modules\SaluteOra\Models;

use Modules\Xot\Models\XotBaseModel;

abstract class BaseModel extends XotBaseModel
{
    // Funzionalità specifiche del modulo SaluteOra
}
```

## Eccezioni

Non ci sono eccezioni a questa regola. Tutti i modelli devono seguire questa convenzione.

## Verifica e Correzione

Prima di effettuare commit, verificare sempre che:

1. Nessun modello estenda direttamente `Illuminate\Database\Eloquent\Model`
2. Tutti i modelli estendano la classe base appropriata del loro modulo

## Collegamenti Correlati

- [class-inheritance-pattern.md](../class-inheritance-pattern.md)
- [architectural-principles.md](../../Xot/docs/architectural-principles.md)
