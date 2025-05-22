# Clean Code nel Modulo Patient

## Principi Fondamentali

1. **Single Responsibility Principle**
   - Ogni classe ha una singola responsabilità
   - Ogni metodo fa una sola cosa
   - Separare la logica di business dalla presentazione

2. **Naming Conventions**
   - Nomi descrittivi e autoesplicativi
   - Evitare abbreviazioni
   - Usare il camelCase per variabili e metodi
   - Usare il PascalCase per classi

3. **Documentazione**
   - PHPDoc per tutte le classi e i metodi
   - Spiegare lo scopo e le dipendenze
   - Documentare le eccezioni
   - Mantenere la documentazione aggiornata

## Wizard Steps

### Struttura del Codice

1. **Separazione delle Responsabilità**
   ```php
   /**
    * Get the privacy step for the wizard
    */
   protected static function getPrivacyStep(): Forms\Components\Wizard\Step
   {
       return Forms\Components\Wizard\Step::make('privacy')
           ->schema(self::getPrivacyStepSchema());
   }

   /**
    * Get the schema for the privacy step
    */
   protected static function getPrivacyStepSchema(): array
   {
       return [
           // schema components
       ];
   }
   ```

2. **Naming Conventions**
   - Metodi: `get{StepName}Step` e `get{StepName}StepSchema`
   - Chiavi di traduzione: senza suffissi `_step`
   - Nomi descrittivi e autoesplicativi

3. **Gestione delle Traduzioni**
   ```php
   return [
       'steps' => [
           'privacy' => [
               'label' => 'Privacy e Consensi',
               'help' => 'Leggi e accetta le condizioni di privacy',
           ],
       ],
       'fields' => [
           'privacy_acceptance' => [
               'label' => 'Accetto la Privacy Policy',
               'help' => 'Devi accettare la privacy policy per procedere',
           ],
       ],
   ];
   ```

### Best Practices

1. **Separazione delle Responsabilità**
   - Schema: definizione dei campi e validazioni
   - Step: configurazione dello step (icon, schema, etc.)
   - Traduzioni: gestione delle etichette e descrizioni

2. **Riutilizzo del Codice**
   - Creare componenti riutilizzabili
   - Utilizzare trait per funzionalità comuni
   - Evitare duplicazione di codice

3. **Validazione**
   - Definire le regole di validazione nello schema
   - Utilizzare custom validation rules quando necessario
   - Gestire gli errori in modo appropriato

4. **Performance**
   - Minimizzare le query al database
   - Utilizzare lazy loading quando appropriato
   - Ottimizzare le validazioni

## Errori Comuni

1. **Mixing di Responsabilità**
   - ❌ Definire lo schema direttamente nel metodo dello step
   - ✅ Separare la definizione dello schema in un metodo dedicato

2. **Naming Inconsistente**
   - ❌ Usare suffissi `_step` nelle chiavi di traduzione
   - ✅ Usare nomi descrittivi senza suffissi

3. **Documentazione Mancante**
   - ❌ Omettere la documentazione PHPDoc
   - ✅ Documentare sempre metodi e classi

4. **Hardcoding**
   - ❌ Hardcodare etichette e descrizioni
   - ✅ Utilizzare il sistema di traduzioni

## Esempi di Implementazione

### Corretto
```php
/**
 * Get the privacy step for the wizard
 */
protected static function getPrivacyStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('privacy')
        ->schema(self::getPrivacyStepSchema());
}

/**
 * Get the schema for the privacy step
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

### Non Corretto
```php
protected static function getPrivacyStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('privacy_step')
        ->schema([
            Forms\Components\View::make('patient::privacy-policy')
                ->columnSpanFull(),
            Forms\Components\Checkbox::make('privacy_acceptance')
                ->required()
                ->columnSpanFull(),
            Forms\Components\Checkbox::make('newsletter')
                ->columnSpanFull(),
        ]);
}
```

## Resource e Proprietà/Metodi Vietati (XotBaseResource)
- NON dichiarare mai:
  - `protected static ?string $navigationIcon`
  - `protected static ?string $navigationGroup`
  - `protected static ?string $translationPrefix`
  - `public static function table()`
  - `public static function getListTableColumns(): array`
- Motivazione: centralizzazione, DRY, coerenza, override gestito dalla base.
- Vedi anche: [filament-resources.md](filament-resources.md)

## Troubleshooting: Errore Access to undeclared static property ...$translationPrefix
- **Errore:** Access to undeclared static property ...$translationPrefix
- **Causa:** Dichiarazione della proprietà vietata in un Resource che estende XotBaseResource.
- **Soluzione:** Rimuovere la proprietà, usare la gestione centralizzata delle traduzioni.
- **Motivazione:** Centralizzazione, DRY, coerenza.
- **Vedi anche:** [filament-resources.md](filament-resources.md)

## Conclusione

Seguire queste regole di Clean Code aiuta a:
1. Mantenere il codice più leggibile e manutenibile
2. Ridurre la duplicazione del codice
3. Facilitare i test e il debugging
4. Migliorare la collaborazione tra sviluppatori
5. Ridurre i bug e gli errori 
