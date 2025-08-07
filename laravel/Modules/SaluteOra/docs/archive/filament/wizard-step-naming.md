# Convenzioni di Naming per i Wizard Step

> **NOTA IMPORTANTE**: Questo documento è un riferimento specifico per il modulo Patient. 
> La documentazione principale e completa si trova nel [modulo UI](../../../UI/docs/filament/wizard-step-naming.md).

## Regola nel Modulo Patient

Nel modulo Patient, quando si implementano wizard step (ad esempio in PatientResource, DoctorResource, o altri), è obbligatorio seguire le seguenti convenzioni:

1. **Utilizzare stringhe semplici con suffisso '_step'** come identificatori degli step
2. **NON utilizzare `->description()` o `->label()`** sui wizard step
3. **NON utilizzare funzioni di traduzione come `__()`** nell'identificatore dello step

## Esempio Corretto per il Modulo Patient

```php
// ✅ CORRETTO
protected static function getDocumentsStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('documents_step')
        ->schema([
            // Schema del form per documenti
        ]);
}
```

## Riferimenti

- [Convenzioni di Naming per Wizard Step (UI)](../../../UI/docs/filament/wizard-step-naming.md)
- [Best Practices per i Wizard](../../../UI/docs/filament/wizard-best-practices.md)
- [Implementazione Wizard in Patient](./patient-wizard-implementation.md)
