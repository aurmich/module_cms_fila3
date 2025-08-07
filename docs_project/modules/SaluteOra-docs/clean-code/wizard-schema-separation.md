# Separazione dello Schema dagli Step nei Wizard Filament

> **NOTA IMPORTANTE**: Questo documento è un riferimento specifico per il modulo Patient. 
> La documentazione principale e completa si trova nel [modulo UI](../../../UI/docs/clean-code/wizard-schema-separation.md).

## Regola per il Modulo Patient

Nel modulo Patient, quando si implementano wizard step (come in PatientResource, DoctorResource, ecc.), è obbligatorio seguire il principio di separazione dello schema dallo step:

1. **Ogni step deve utilizzare un metodo separato per definire lo schema**
2. **Ogni schema deve essere dichiarato in un metodo dedicato con nome descrittivo**
3. **Il nome del metodo dello schema deve seguire la convenzione `get{StepName}Schema()`**

## Esempio Corretto per il Modulo Patient

```php
// ✅ CORRETTO
protected static function getPrivacyStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('privacy_step')
        ->schema(self::getPrivacyStepSchema());
}

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

## Motivazione nel Contesto del Modulo

L'applicazione di questo principio nel modulo Patient è particolarmente importante perché:

1. **Le form dei pazienti e dei medici sono complesse**: La separazione mantiene il codice organizzato
2. **Gli schemi potrebbero essere condivisi tra diverse risorse**: Per esempio, i campi di contatto potrebbero essere gli stessi per pazienti e medici
3. **La manutenzione è frequente**: Campi e validazioni vengono spesso aggiornati, quindi è cruciale avere una struttura modulare

## Riferimenti

- [Separazione dello Schema dagli Step nei Wizard (documentazione principale)](../../../UI/docs/clean-code/wizard-schema-separation.md)
- [Principi Clean Code nel modulo Patient](../clean-code-principles.md)
- [Best Practices per i Form](../form-best-practices.md)
