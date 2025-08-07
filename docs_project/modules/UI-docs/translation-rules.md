# Regole Critiche per Traduzioni - Modulo UI

## ⚠️ REGOLA ASSOLUTA: MAI usare ->label(), ->placeholder(), ->helperText()

### ❌ VIETATO - MAI FARE
```php
// ❌ ERRATO - Duplicazione traduzioni
Forms\Components\TextInput::make('to')
    ->label(__('ui::pages.s3test.fields.to.label'))
    ->placeholder(__('ui::pages.s3test.fields.to.placeholder'))
    ->helperText(__('ui::pages.s3test.fields.to.helper_text'))
    ->email()
    ->required()
```

### ✅ CORRETTO - Automatico
```php
// ✅ CORRETTO - LangServiceProvider gestisce tutto
Forms\Components\TextInput::make('to')
    ->email()
    ->required()
```

## Struttura File Traduzione Obbligatoria

### File: `Modules/UI/lang/it/pages.php`
```php
<?php

declare(strict_types=1);

return [
    's3test' => [
        'heading' => 'Test Invio Email S3',
        'description' => 'Pagina di test per l\'invio di email tramite S3',
        'fields' => [
            'to' => [
                'label' => 'Destinatario',
                'placeholder' => 'Inserisci l\'indirizzo email del destinatario',
                'helper_text' => 'L\'email verrà inviata a questo indirizzo',
            ],
            'subject' => [
                'label' => 'Oggetto',
                'placeholder' => 'Inserisci l\'oggetto dell\'email',
                'helper_text' => 'L\'oggetto apparirà nella casella di posta del destinatario',
            ],
            'body_html' => [
                'label' => 'Contenuto',
                'placeholder' => 'Inserisci il contenuto dell\'email',
                'helper_text' => 'Il contenuto può includere formattazione HTML',
            ],
        ],
        'actions' => [
            'send_email' => [
                'label' => 'Invia Email',
                'success' => 'Email inviata con successo',
                'error' => 'Errore durante l\'invio dell\'email',
            ],
        ],
    ],
];
```

## Motivazione

1. **Centralizzazione**: Tutte le traduzioni in un unico posto
2. **Consistenza**: Pattern uniforme in tutto il sistema
3. **Manutenibilità**: Cambiare traduzioni senza toccare codice
4. **Override**: Possibilità di override per temi/moduli
5. **Type Safety**: Evita errori di digitazione nelle stringhe

## Checklist Obbligatoria

- [ ] MAI usare `->label()` nei form components
- [ ] MAI usare `->placeholder()` nei form components
- [ ] MAI usare `->helperText()` nei form components
- [ ] SEMPRE strutturare file traduzione con `label`/`placeholder`/`helper_text`
- [ ] SEMPRE usare chiavi che corrispondono al nome del campo
- [ ] SEMPRE includere traduzioni in italiano, inglese e tedesco

## Errori Comuni da Evitare

```php
// ❌ ERRATO - Duplicazione
TextInput::make('email')
    ->label('Email')
    ->placeholder('Inserisci email')

// ✅ CORRETTO - Automatico
TextInput::make('email')
    ->email()
    ->required()
```

## Collegamenti
- [Filament Extension Rules](../../../.cursor/rules/filament-extension-rules.mdc)
- [Translation Memory](../../../.cursor/memories/translation-memory.mdc)
- [UI Module README](./README.md)

*Ultimo aggiornamento: 2025-01-06* 