# Localizzazione

## Best Practices

### Gestione delle Lingue

1. **Utilizzo dei Componenti**
   - Utilizzare il componente `language-switcher` per il cambio lingua
   - La localizzazione viene gestita automaticamente da Filament e Folio
   - Non è necessario creare controller o rotte specifiche

2. **File di Traduzione**
   - Mantenere i file di traduzione in `resources/lang/{locale}`
   - Utilizzare chiavi in inglese per le traduzioni
   - Organizzare le traduzioni in file per modulo

3. **Configurazione**
   - La configurazione viene gestita attraverso il file `config/laravel-localization.php`
   - Non è necessario modificare file di routing o creare controller

4. **Middleware**
   - Il middleware di localizzazione viene gestito automaticamente da Filament e Folio
   - Non è necessario creare middleware personalizzati

## Componente Language Switcher

### Utilizzo Base

```blade
<x-ui::language-switcher />
```

### Personalizzazione

```blade
<x-ui::language-switcher
    :languages="['it', 'en']"
    :show-flags="true"
    :show-names="true"
/>
```

### Funzionalità

Il componente gestisce automaticamente:
- Cambio lingua
- Persistenza della selezione
- Traduzioni
- UI/UX

Non è necessario:
- Creare controller
- Aggiungere rotte
- Gestire la logica di cambio lingua

## Configurazione

### File di Configurazione

```php
// config/laravel-localization.php
return [
    'languages' => [
        'it' => [
            'name' => 'Italiano',
            'script' => 'Latn',
            'native' => 'Italiano',
            'regional' => 'it_IT',
        ],
        'en' => [
            'name' => 'English',
            'script' => 'Latn',
            'native' => 'English',
            'regional' => 'en_GB',
        ],
    ],
    'detect' => [
        'browser' => true,
        'session' => true,
        'cookie' => true,
    ],
    'selection' => [
        'default' => 'it',
        'fallback' => 'en',
    ],
];
```

### File di Traduzione

```php
// resources/lang/it/auth.php
return [
    'login' => 'Accedi',
    'register' => 'Registrati',
    'logout' => 'Esci',
];

// resources/lang/en/auth.php
return [
    'login' => 'Login',
    'register' => 'Register',
    'logout' => 'Logout',
];
```

## Best Practices per le Traduzioni

1. **Chiavi di Traduzione**
   - Utilizzare chiavi in inglese
   - Seguire la convenzione `namespace.key`
   - Mantenere le chiavi in minuscolo con underscore

2. **Organizzazione**
   - Organizzare le traduzioni in file per modulo
   - Mantenere i file di traduzione in `resources/lang/{locale}`
   - Utilizzare file di traduzione per ogni lingua supportata

3. **Utilizzo**
   - Utilizzare la funzione `__()` per le traduzioni
   - Utilizzare la funzione `trans()` per le traduzioni
   - Utilizzare la funzione `Lang::get()` per le traduzioni

4. **Esempi**

```php
// Corretto
__('auth.login')
trans('auth.login')
Lang::get('auth.login')

// Non Corretto
__('Accedi')
trans('Accedi')
Lang::get('Accedi')
```

## Integrazione con Filament e Folio

1. **Filament**
   - La localizzazione viene gestita automaticamente
   - Non è necessario creare controller o rotte
   - Utilizzare i componenti UI per la gestione delle lingue

2. **Folio**
   - La localizzazione viene gestita automaticamente
   - Non è necessario creare controller o rotte
   - Utilizzare i componenti UI per la gestione delle lingue

3. **Componenti**
   - I componenti UI sono compatibili con Filament e Folio
   - Non è necessario creare componenti personalizzati
   - Utilizzare i componenti esistenti per la gestione delle lingue 
