# Best Practice: composer.json per Moduli Laraxot

## Obiettivi
- Allineare la struttura del composer.json tra tutti i moduli.
- Garantire caricamento automatico di provider, autoload coerente, dipendenze e script utili.

## Checklist
- [x] `name` e `description` coerenti con il modulo
- [x] Provider corretti in `extra.laravel.providers`
- [x] Autoload PSR-4 per app, factories, seeders, tests
- [x] Dipendenze effettivamente usate in `require`
- [x] Repositories locali se necessario
- [x] Scripts utili (analyse, test, format, ecc.)
- [x] Configurazione sorting, plugin, stabilità

## Esempio (ispirato a SaluteOra)

```json
{
    "name": "salutemo/module",
    "description": "SaluteMo Module",
    "authors": [
        {
            "name": "SaluteMo Team",
            "email": "team@salutemo.com"
        }
    ],
    "extra": {
        "laravel": {
            "providers": [
                "Modules\\SaluteMo\\Providers\\SaluteMoServiceProvider",
                "Modules\\SaluteMo\\Providers\\Filament\\AdminPanelProvider"
            ]
        }
    },
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
    },
    "require": {
        "saade/filament-fullcalendar": "^3.2",
        "spatie/laravel-permission": "^6.0"
    },
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
    ],
    "scripts": {
        "analyse": "vendor/bin/phpstan analyse",
        "test": "./vendor/bin/pest --no-coverage",
        "test-coverage": "vendor/bin/pest --coverage-html coverage",
        "format": "vendor/bin/php-cs-fixer fix --allow-risky=yes"
    },
    "config": {
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "dealerdirect/phpcodesniffer-composer-installer": true,
            "wikimedia/composer-merge-plugin": true
        }
    },
    "minimum-stability": "dev",
    "prefer-stable": true
}
```

## Note
- Aggiorna i provider se aggiungi nuovi ServiceProvider.
- Mantieni le dipendenze aggiornate e rimuovi quelle non usate.
- Allinea sempre la struttura a quella dei moduli principali (es. SaluteOra).

## Collegamenti
- [composer.json di SaluteOra](../SaluteOra/composer.json)
- [Regole ServiceProvider](../../Xot/docs/SERVICE_PROVIDER.md)
