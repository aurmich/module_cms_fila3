# Patient Registration Wizard

## Overview

Il Patient Registration Wizard è un componente Filament che gestisce il processo di registrazione dei pazienti attraverso una serie di step guidati.

## Struttura

Il wizard è implementato come un widget Filament e utilizza il componente `Wizard` per gestire il flusso di registrazione.

### Step del Wizard

1. **Dati Personali** (`personal_data`)
   - Nome
   - Cognome
   - Codice Fiscale
   - Data di Nascita
   - Email
   - Telefono

2. **Indirizzo** (`address`)
   - Indirizzo
   - Città
   - CAP
   - Provincia
   - Nazione

3. **Stato di Salute** (`health_status`)
   - Condizioni Mediche
   - Allergie
   - Farmaci
   - Note Aggiuntive

4. **Privacy** (`privacy`)
   - Informativa Privacy
   - Accettazione Privacy
   - Newsletter

## Implementazione

### Clean Code Principles

1. **Single Responsibility**
   - Ogni step ha un metodo dedicato per la creazione
   - Lo schema di ogni step è definito in un metodo separato
   - Le traduzioni sono gestite in file dedicati

2. **Naming Conventions**
   - Metodi: `get{StepName}Step` e `get{StepName}StepSchema`
   - Chiavi di traduzione: senza suffisso `_step`
   - Nomi descrittivi e autoesplicativi

3. **Documentazione**
   - PHPDoc per tutti i metodi
   - Spiegazione dello scopo di ogni step
   - Documentazione delle dipendenze

### Esempio di Implementazione

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

## Gestione delle Traduzioni

### Struttura dei File di Traduzione

```php
return [
    'steps' => [
        'personal_data' => [
            'label' => 'Dati Personali',
            'help' => 'Inserisci i tuoi dati personali',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'help' => 'Inserisci il tuo indirizzo',
        ],
        // ...
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il tuo nome',
            'help' => 'Il tuo nome di battesimo',
        ],
        // ...
    ],
];
```

### Best Practices

1. **Naming**
   - Usare nomi descrittivi
   - Evitare suffissi `_step`
   - Mantenere coerenza tra codice e traduzioni

2. **Struttura**
   - Organizzare le traduzioni in sezioni logiche
   - Includere `label`, `placeholder` e `help` per ogni campo
   - Documentare le chiavi di traduzione

3. **Manutenibilità**
   - Centralizzare le traduzioni
   - Evitare duplicazioni
   - Mantenere la documentazione aggiornata

## Validazione

### Regole di Validazione

1. **Dati Personali**
   - Nome e Cognome: obbligatori, max 255 caratteri
   - Codice Fiscale: obbligatorio, formato valido
   - Email: obbligatoria, formato valido, unica
   - Telefono: formato valido

2. **Indirizzo**
   - Tutti i campi obbligatori
   - CAP: formato valido
   - Provincia: formato valido

3. **Privacy**
   - Accettazione Privacy: obbligatoria
   - Newsletter: opzionale

### Implementazione

```php
protected static function getPersonalDataStepSchema(): array
{
    return [
        Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255),
        Forms\Components\TextInput::make('surname')
            ->required()
            ->maxLength(255),
        Forms\Components\TextInput::make('fiscal_code')
            ->required()
            ->maxLength(16)
            ->unique(),
        // ...
    ];
}
```

## Best Practices

1. **Clean Code**
   - Separare le responsabilità
   - Usare nomi descrittivi
   - Documentare il codice
   - Evitare duplicazioni

2. **Performance**
   - Minimizzare le query
   - Ottimizzare le validazioni
   - Usare lazy loading

3. **Manutenibilità**
   - Centralizzare le traduzioni
   - Mantenere la documentazione
   - Seguire le convenzioni

4. **Sicurezza**
   - Validare tutti gli input
   - Proteggere i dati sensibili
   - Gestire gli errori

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

## Sviluppi Futuri

- **Integrazione con sistema di appuntamenti**: Collegare la registrazione del paziente con la prenotazione del primo appuntamento
- **Upload documenti**: Aggiungere la possibilità di caricare documenti (es. ISEE, documenti di identità)
- **Autenticazione integrata**: Creare automaticamente un account utente per il paziente
- **Versione mobile ottimizzata**: Migliorare l'esperienza su dispositivi mobili

## Best Practice per i Wizard Step
- Nei wizard step di registrazione (es. paziente, dottore) usare SEMPRE i campi `first_name`, `last_name`, `email`.
- **Mai** usare `full_name` come campo di input principale.
- La composizione di full_name va fatta solo a livello di model/accessor, mai nel form.
- Motivazione: coerenza, internazionalizzazione, compatibilità, best practice di naming.
- Vedi anche: [naming-user-fields.md](naming-user-fields.md)
