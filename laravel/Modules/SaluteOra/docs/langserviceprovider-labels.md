# LangServiceProvider: Label automatiche nei Filament Forms (modulo Patient)

## Nota
In questo modulo le label dei campi sono gestite esclusivamente tramite LangServiceProvider e i file di traduzione. Non va mai usato il metodo `->label()` nei componenti Filament.

## Esempio pratico
```php
TextInput::make('first_name') // la label viene risolta automaticamente
```

## Motivazione e dettagli
Vedi la [doc generale in Xot](../../Xot/docs/langserviceprovider-labels.md) per motivazione, vantaggi e struttura dei file di lingua.

## Collegamenti
- [Doc generale LangServiceProvider in Xot](../../Xot/docs/langserviceprovider-labels.md)

**Questa regola è obbligatoria per tutti i moduli.**

## Collegamenti tra versioni di langserviceprovider-labels.md
* [langserviceprovider-labels.md](../../Xot/docs/langserviceprovider-labels.md)

# Gestione Label con LangServiceProvider

## Regola Fondamentale
NON utilizzare mai il metodo `->label()` nei componenti Filament. Le etichette vengono gestite automaticamente dal `LangServiceProvider`.

## Struttura Corretta
```php
// Nel componente Filament
Forms\Components\TextInput::make('first_name')
    ->required()
    ->maxLength(255);

// Nel file di traduzione (lang/it/patient-resource.php)
return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'tooltip' => 'Il tuo nome di battesimo'
        ]
    ]
];
```

## Vantaggi
1. Gestione centralizzata delle traduzioni
2. Supporto multilingua nativo
3. Manutenzione semplificata
4. Performance ottimizzate

## Collegamenti
- [Documentazione Traduzioni](translations.md)
- [Best Practices Filament](filament-wizard-best-practices.md)
- [Guida Sviluppatori](guida-sviluppatori.md)

