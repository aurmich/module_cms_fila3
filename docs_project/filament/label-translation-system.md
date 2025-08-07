# Sistema di Traduzione Automatica delle Etichette in Filament

> **NOTA IMPORTANTE**: Questo documento è un riferimento specifico per il modulo Patient. 
> La documentazione principale e completa si trova nel [modulo UI](../../../UI/docs/filament/label-translation-system.md).

## Regola per il modulo Patient

Nel modulo Patient, come in tutti gli altri moduli del progetto, è vietato utilizzare il metodo `->label()` nei componenti Filament. Le etichette devono essere gestite esclusivamente tramite i file di traduzione e il LangServiceProvider.

## Esempi corretti nel contesto di Patient

```php
// ERRATO ❌
Forms\Components\TextInput::make('first_name')
    ->label('Nome')
    ->required();

// CORRETTO ✅
Forms\Components\TextInput::make('first_name')
    ->required();
```

## File di traduzione per Patient

Le traduzioni per il modulo Patient devono essere definite nei file:

- `/var/www/html/[progetto]/laravel/Modules/Patient/resources/lang/it/patient.php`
- `/var/www/html/[progetto]/laravel/Modules/Patient/resources/lang/en/patient.php`

Con una struttura come:

```php
return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'help' => 'Inserisci il nome del paziente',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'help' => 'Inserisci il cognome del paziente',
        ],
        // altri campi...
    ],
];
```

## Errori comuni nel modulo Patient

- Uso diretto di `->label()` negli schemi dei form e nelle wizard step
- Traduzione hardcoded direttamente nel codice con `__()` o stringhe letterali
- Mancanza dei file di traduzione o struttura non corretta delle chiavi

## Collegamenti

- [Documentazione principale sul sistema di traduzione](/var/www/html/base_saluteora/laravel/Modules/UI/docs/filament/label-translation-system.md)
- [Implementazione delle risorse nel modulo Patient](/var/www/html/base_saluteora/laravel/Modules/Patient/app/Filament/Resources)
