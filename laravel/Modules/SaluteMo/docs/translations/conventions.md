# Convenzioni per le Traduzioni nel Modulo SaluteMo

## Regola Fondamentale
**MAI utilizzare il metodo `->label()` nei componenti Filament**.

Le etichette sono gestite automaticamente dal LangServiceProvider e devono essere definite nei file di traduzione specifici del modulo.

## Struttura dei File di Traduzione

### Posizione Corretta
```
/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteMo/lang/{locale}/
```

### Organizzazione dei File
- `general.php`: Traduzioni generali del modulo
- `resources.php`: Traduzioni per le risorse Filament
- `pages.php`: Traduzioni per le pagine
- `widgets.php`: Traduzioni per i widget
- `validation.php`: Messaggi di validazione personalizzati

## Pattern per le Chiavi di Traduzione

### Risorse
```php
// In lang/it/resources.php
return [
    'resource_name' => [
        'label' => 'Etichetta Risorsa',
        'fields' => [
            'field_name' => [
                'label' => 'Etichetta Campo',
                'placeholder' => 'Placeholder Campo',
                'helper_text' => 'Testo di aiuto',
            ],
        ],
        'actions' => [
            'create' => 'Crea',
            'edit' => 'Modifica',
            'delete' => 'Elimina',
        ],
    ],
];
```

### Widget
```php
// In lang/it/widgets.php
return [
    'widget_name' => [
        'title' => 'Titolo Widget',
        'steps' => [
            'step_name' => 'Etichetta Step',
        ],
        'fields' => [
            'field_name' => 'Etichetta Campo',
        ],
        'messages' => [
            'message_key' => 'Testo messaggio',
        ],
    ],
];
```

## Utilizzo Corretto in Filament

### Modalità Errata (da NON utilizzare)
```php
TextInput::make('name')
    ->label('Nome')
    ->placeholder('Inserisci il nome')
```

### Modalità Corretta
```php
TextInput::make('name')
// La traduzione viene gestita automaticamente dal LangServiceProvider
```

## Gestione delle Traduzioni nei Widget

Per widget specifici del modulo SaluteMo, utilizzare le seguenti convenzioni:

```php
// Nel file widget
TextInput::make('location')
    ->required()
    // NON utilizzare ->label() perché la traduzione viene gestita dal LangServiceProvider
    
// Nel file di traduzione (lang/it/widgets.php)
'find_doctor_widget' => [
    'title' => 'Trova Dottore',
    'fields' => [
        'location' => 'Posizione',
    ],
],
```

## Struttura Espansa per i Campi

Utilizzare sempre la struttura espansa per i campi nei file di traduzione:

### Pattern Corretto
```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Placeholder Campo',
    'helper' => 'Testo di aiuto',
],
```

### Convenzione di Naming per le Chiavi
Seguire la convenzione:
```
modulo::risorsa.fields.campo.label
```

Ad esempio:
```
salutemo::mobile_user.fields.device_token.label
```

## Verifica LangServiceProvider

Assicurarsi sempre che il LangServiceProvider sia registrato correttamente in:
```php
// In Modules/SaluteMo/Providers/SaluteMoServiceProvider.php
$this->app->register(LangServiceProvider::class);
```

## Collegamenti Correlati
- [Service Provider](../providers/service-provider.md)
- [Filament Structure](../filament/structure.md)
- [Widget Translation](../filament/widgets.md)
