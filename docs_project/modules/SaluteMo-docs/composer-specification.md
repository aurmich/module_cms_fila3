# Specifica Tecnica Composer.json

## Struttura File
Il file deve essere posizionato in:
```
/composer.json
```

## Requisiti Tecnici

### Configurazione Base
```json
{
    "name": "salutemo/module",
    "description": "SaluteMo Module",
    "authors": [
        {
            "name": "SaluteOra Team",
            "email": "team@saluteora.com"
        }
    ]
}
```

### Providers
```json
"extra": {
    "laravel": {
        "providers": [
            "Modules\\SaluteMo\\Providers\\SaluteMoServiceProvider",
            "Modules\\SaluteMo\\Providers\\Filament\\AdminPanelProvider"
        ]
    }
}
```

### Autoload
```json
"autoload": {
    "psr-4": {
        "Modules\\SaluteMo\\": "app/",
        "Modules\\SaluteMo\\Database\\Factories\\": "database/factories/",
        "Modules\\SaluteMo\\Database\\Seeders\\": "database/seeders/"
    }
},
"autoload-dev": {
    "psr-4": {
        "Modules\\SaluteMo\\Tests\\": "tests/"
    }
}
```

### Dipendenze
```json
"require": {
    "saade/filament-fullcalendar": "^3.2",
    "spatie/laravel-permission": "^6.0"
}
```

### Repository
```json
"repositories": [
    {
        "type": "path",
        "url": "../Xot"
    },
    {
        "type": "path",
        "url": "../Tenant"
    },
    {
        "type": "path",
        "url": "../UI"
    }
]
```

### Scripts
```json
"scripts": {
    "post-autoload-dump1": [
        "@php artisan vendor:publish --provider='Statikbe\\CookieConsent\\CookieConsentServiceProvider' --tag='cookie-public'"
    ],
    "post-update-cmd": [
        "Illuminate\\Foundation\\ComposerScripts::postUpdate"
    ],
    "analyse": "vendor/bin/phpstan analyse",
    "test": "./vendor/bin/pest --no-coverage",
    "test-coverage": "vendor/bin/pest --coverage-html coverage",
    "format": "vendor/bin/php-cs-fixer fix --allow-risky=yes"
}
```

### Configurazione
```json
"config": {
    "sort-packages": true,
    "allow-plugins": {
        "pestphp/pest-plugin": true,
        "dealerdirect/phpcodesniffer-composer-installer": true,
        "wikimedia/composer-merge-plugin": true
    }
}
```

### Stabilità
```json
"minimum-stability": "dev",
"prefer-stable": true
```

## Best Practices

### 1. Naming
- Usare il nome del modulo in lowercase
- Seguire il formato `modulename/module`
- Mantenere coerenza con altri moduli

### 2. Providers
- Includere tutti i provider necessari
- Mantenere l'ordine corretto
- Documentare lo scopo di ogni provider

### 3. Autoload
- Seguire PSR-4
- Includere tutti i namespace necessari
- Separare autoload e autoload-dev

### 4. Dipendenze
- Specificare versioni esatte
- Evitare dipendenze non necessarie
- Mantenere aggiornate le dipendenze

### 5. Repository
- Includere tutti i moduli correlati
- Usare path relativi
- Mantenere coerenza con altri moduli

### 6. Scripts
- Includere script di test
- Includere script di analisi
- Includere script di formattazione

### 7. Configurazione
- Abilitare sort-packages
- Configurare correttamente i plugin
- Mantenere la stabilità appropriata

## Note di Implementazione
- Priorità alta
- Fondamentale per l'integrazione
- Coerenza con altri moduli
- Manutenibilità del codice 
