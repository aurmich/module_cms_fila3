# Regole per le Traduzioni

## Regola Fondamentale

Le label e i testi dell'interfaccia devono essere gestiti tramite file di traduzione, mai hardcoded nel codice.

## Struttura dei File

```
Modules/
└── ModuleName/
    └── lang/
        ├── it/
        │   ├── fields.php
        │   ├── messages.php
        │   └── navigation.php
        └── en/
            ├── fields.php
            ├── messages.php
            └── navigation.php
```

## Formato delle Traduzioni

### ✅ FARE QUESTO

```php
// lang/it/fields.php
return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'help' => 'Il nome completo dell\'utente',
        'tooltip' => 'Questo campo è obbligatorio',
    ],
];

// Nel codice
Forms\Components\TextInput::make('name')
    // Non usare ->label() o altri metodi di testo
```

### ❌ NON FARE QUESTO

```php
Forms\Components\TextInput::make('name')
    ->label('Nome')
    ->placeholder('Inserisci il nome')
    ->helperText('Il nome completo dell\'utente')
```

## Struttura delle Chiavi

### Campi
```php
'field_name' => [
    'label' => 'Etichetta',
    'placeholder' => 'Testo placeholder',
    'help' => 'Testo di aiuto',
    'tooltip' => 'Testo tooltip',
    'validation' => [
        'required' => 'Il campo è obbligatorio',
        'min' => 'Il campo deve contenere almeno :min caratteri',
    ],
],
```

### Navigazione
```php
'navigation' => [
    'label' => 'Etichetta menu',
    'group' => 'Gruppo menu',
    'icon' => 'heroicon-o-users',
],
```

### Messaggi
```php
'messages' => [
    'success' => [
        'created' => 'Elemento creato con successo',
        'updated' => 'Elemento aggiornato con successo',
        'deleted' => 'Elemento eliminato con successo',
    ],
    'errors' => [
        'not_found' => 'Elemento non trovato',
        'unauthorized' => 'Non autorizzato',
    ],
],
```

## Best Practices

1. **Organizzazione**
   - Separare le traduzioni per contesto
   - Mantenere una struttura coerente
   - Usare nomi di chiavi descrittivi

2. **Formato**
   - Usare array associativi per i campi
   - Includere tutte le proprietà di testo
   - Mantenere coerenza tra le lingue

3. **Manutenzione**
   - Aggiornare tutte le lingue insieme
   - Rimuovere traduzioni non utilizzate
   - Documentare le modifiche

## Collegamenti Bidirezionali

### Collegamenti nella Root
- [Architettura delle Traduzioni](../architecture/translations.md)
- [Gestione Lingue](../architecture/languages.md)

### Collegamenti ai Moduli
- [LangServiceProvider](../../laravel/Modules/Lang/docs/service-provider.md)
- [Traduzioni Notify](../../laravel/Modules/Notify/docs/translations.md)

## Note Importanti

1. Mai usare testo hardcoded nel codice
2. Mantenere le traduzioni aggiornate
3. Seguire la struttura standard
4. Documentare le modifiche
5. Testare tutte le lingue 