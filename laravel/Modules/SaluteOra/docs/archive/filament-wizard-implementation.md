# Implementazione di Wizard in Filament

> **NOTA IMPORTANTE**: Questo documento è un riferimento specifico per il modulo Patient. La documentazione completa sulle best practices per i wizard si trova nel [modulo UI](../../UI/docs/filament/wizard-best-practices.md).

## Differenze tra Tabs e Wizard

Un errore comune nell'implementazione di form complessi in Filament è confondere le API e le strutture di componenti simili ma distinti, come `Tabs` e `Wizard`.

### Problema: Utilizzo errato di `Tabs` invece di `Wizard`

Quando si implementa un form a più step, è fondamentale utilizzare il componente corretto:

- `Tabs`: Utilizzato per organizzare contenuti in schede accessibili in qualsiasi ordine
- `Wizard`: Utilizzato per guidare l'utente attraverso un processo sequenziale con step numerati

**Errore comune**: Implementare un processo sequenziale utilizzando `Tabs` invece di `Wizard`.

### Differenze chiave tra Tabs e Wizard

| Caratteristica | Tabs | Wizard |
|----------------|------|--------|
| Navigazione | Libera (qualsiasi ordine) | Sequenziale (avanti/indietro) |
| Metodo `description()` | Non disponibile su `Tab` | Disponibile su `Step` |
| Validazione | Indipendente per tab | Progressiva (blocca avanzamento) |
| Indicatore di progresso | No | Sì (step numerati) |
| Pulsanti di navigazione | No | Sì (avanti/indietro) |

## Implementazione corretta di Wizard

### Regola fondamentale: Estrazione degli Step in Metodi Dedicati

**Non inserire mai direttamente** gli step all'interno del metodo `make()`, ma **sempre utilizzare metodi dedicati** che restituiscano un oggetto `Forms\Components\Wizard\Step`.

```php
// ✅ CORRETTO: Step estratti in metodi dedicati
public static function getFormSchemaWidget(): array
{
    return [
        Forms\Components\Wizard::make([
            self::getStep1(),
            self::getStep2(),
            self::getStep3(),
        ])
        ->skippable(false)
        ->submitAction(new HtmlString('...'))
    ];
}

// Metodo per definire uno step del wizard
protected static function getStep1(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('Nome Step')
        ->icon('heroicon-o-user')
        ->description('Descrizione dello step')
        ->schema([
            // Componenti del form per questo step
        ]);
}
```

```php
// ❌ ERRATO: Step definiti direttamente nel wizard
public static function getFormSchemaWidget(): array
{
    return [
        Forms\Components\Wizard::make([
            Forms\Components\Wizard\Step::make('Step 1')
                ->icon('heroicon-o-user')
                ->description('Descrizione dello step 1')
                ->schema([
                    // Componenti del form per questo step
                ]),
            Forms\Components\Wizard\Step::make('Step 2')
                // ...
        ])
        ->skippable(false)
    ];
}
```

## Esempio dal PatientResource

Il `PatientResource` utilizza correttamente il pattern Wizard:

1. Il metodo `getFormSchemaWidget()` restituisce un array con un singolo componente `Wizard`
2. Il wizard è composto da step definiti in metodi separati (`getPersonalDataStep()`, `getDocumentsStep()`, ecc.)
3. Ogni step è creato con `Forms\Components\Wizard\Step::make()` e ha una propria descrizione e schema

## Refactoring Privacy Step Separation

### Problema
Lo step privacy è definito inline con uno schema direttamente in `getPrivacyStep()`, violando il principio di separazione delle responsabilità e la manutenibilità del codice.

### Soluzione
Estrazione dello schema in un metodo dedicato:

```php
/**
 * Get the privacy step for the wizard
 */
protected static function getPrivacyStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('privacy_step')
        ->schema(self::getPrivacyStepSchema());
}

/**
 * Get privacy step schema
 *
 * @return array
 */
protected static function getPrivacyStepSchema(): array
{
    return [
        Forms\Components\View::make('patient::privacy-policy')
            ->columnSpanFull(),
        Forms\Components\Checkbox::make('privacy_acceptance')
            ->required()
            ->columnSpanFull(),
        Forms\Components\Checkbox::make('newsletter')
            ->columnSpanFull(),
    ];
}
```

Collegamenti:
- [Clean Code Wizard Steps](./filament-wizard-structure.md)
- [Wizard Best Practices in UI Module](../../UI/docs/filament-wizard-best-practices.md)

## Errori da evitare

1. **Non** utilizzare `Tabs` per processi sequenziali
2. **Non** tentare di utilizzare `description()` su un `Tabs\Tab`
3. **Non** mischiare componenti di Tabs e Wizard

## Collegamenti Bidirezionali

- [Best Practices per i Wizard in Filament](../../UI/docs/filament/wizard-best-practices.md)
- [API dei Componenti Filament](./filament-components-api.md)
- [Documentazione Filament](../../Xot/docs/filament/README.md)
- [PatientResource Reference](../app/Filament/Resources/PatientResource.php)
