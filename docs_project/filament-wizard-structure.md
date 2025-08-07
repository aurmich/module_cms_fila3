# Struttura dei Wizard in Filament

## Clean Code: Separazione degli Step

### ❌ Errato
```php
Forms\Components\Wizard::make([
    Forms\Components\Wizard\Step::make('personal_info')
        ->label('Informazioni Personali')
        ->schema([...]),
    Forms\Components\Wizard\Step::make('contacts')
        ->label('Contatti')
        ->schema([...]),
]);
```

### ✅ Corretto
```php
Forms\Components\Wizard::make([
    self::getPersonalInfoStep(),
    self::getContactsStep(),
]);

protected static function getPersonalInfoStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('personal_info')
        ->label('Informazioni Personali')
        ->schema([...]);
}

protected static function getContactsStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('contacts')
        ->label('Contatti')
        ->schema([...]);
}
```

## Motivazioni

1. **Manutenibilità**
   - Ogni step è una funzione separata
   - Più facile da modificare e testare
   - Riduce la complessità del codice principale

2. **Riutilizzabilità**
   - Gli step possono essere riutilizzati
   - Facilita la composizione di wizard diversi
   - Migliora la modularità del codice

3. **Leggibilità**
   - Codice più pulito e organizzato
   - Migliore separazione delle responsabilità
   - Più facile da comprendere e debuggare

4. **Testabilità**
   - Funzioni separate sono più facili da testare
   - Migliore isolamento delle funzionalità
   - Più semplice implementare unit test

## Best Practices

1. **Naming delle Funzioni**
   - Usare prefisso `get` per le funzioni che restituiscono step
   - Seguire il pattern `get{StepName}Step`
   - Mantenere coerenza nel naming

2. **Organizzazione**
   - Raggruppare le funzioni degli step
   - Mantenere ordine logico
   - Aggiungere commenti per sezioni complesse

3. **Validazione**
   - Implementare validazione per ogni step
   - Gestire errori in modo appropriato
   - Fornire feedback utente

4. **Traduzioni**
   - Usare file di traduzione
   - Mantenere coerenza linguistica
   - Evitare testo hardcoded

## Esempio di Implementazione
```php
public static function getFormSchemaWidget(): array
{
    return [
        'wizard' => Forms\Components\Wizard::make([
            self::getPersonalInfoStep(),
            self::getContactsStep(),
            self::getProfessionalStep(),
            self::getAvailabilityStep(),
        ]),
    ];
}

protected static function getPersonalInfoStep(): Forms\Components\Wizard\Step
{
    $prefix = static::$translationPrefix;
    
    return Forms\Components\Wizard\Step::make('personal_info')
        ->label(trans("$prefix.steps.personal_info.label"))
        ->description(trans("$prefix.steps.personal_info.description"))
        ->schema([...]);
}
```

## Collegamenti
- [README](README.md)
- [Wizard vs Tabs](wizard-vs-tabs.md)
- [Wizard Best Practices](filament-wizard-best-practices.md)
- [Form Components](filament-form-components.md)

## Vedi Anche
- [Filament Wizard Documentation](https://filamentphp.com/docs/forms/layout#wizard)
- [Best Practices](../../Xot/docs/filament-best-practices.md) 