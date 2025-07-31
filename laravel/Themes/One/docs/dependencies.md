# Sistema di Gestione Dipendenze

## Introduzione

Questo documento descrive il sistema di gestione delle dipendenze del tema "One", inclusi i package manager, le configurazioni e le best practices per la gestione delle librerie.

## Package Manager

### Composer
```json
// composer.json
{
    "name": "theme-one/core",
    "description": "Tema One - Tema Frontend Moderno",
    "type": "project",
    "require": {
        "php": "^8.1",
        "laravel/framework": "^10.0",
        "laravel/sanctum": "^3.2",
        "laravel/tinker": "^2.8"
    },
    "require-dev": {
        "fakerphp/faker": "^1.9.1",
        "laravel/pint": "^1.0",
        "laravel/sail": "^1.18",
        "mockery/mockery": "^1.4.4",
        "nunomaduro/collision": "^7.0",
        "phpunit/phpunit": "^10.1",
        "spatie/laravel-ignition": "^2.0"
    },
    "autoload": {
        "psr-4": {
            "ThemeOne\\": "app/",
            "ThemeOne\\Database\\Factories\\": "database/factories/",
            "ThemeOne\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "ThemeOne\\Tests\\": "tests/"
        }
    },
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi"
        ],
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi"
        ]
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}
```

### NPM
```json
// package.json
{
    "name": "theme-one",
    "version": "1.0.0",
    "private": true,
    "scripts": {
        "dev": "npm run development",
        "development": "mix",
        "watch": "mix watch",
        "watch-poll": "mix watch -- --watch-options-poll=1000",
        "hot": "mix watch --hot",
        "prod": "npm run production",
        "production": "mix --production",
        "lint": "eslint resources/js",
        "lint:css": "stylelint resources/css",
        "test": "jest"
    },
    "dependencies": {
        "alpinejs": "^3.0.0",
        "autoprefixer": "^10.0.0",
        "postcss": "^8.0.0",
        "tailwindcss": "^3.0.0"
    },
    "devDependencies": {
        "@babel/core": "^7.0.0",
        "@babel/preset-env": "^7.0.0",
        "babel-loader": "^8.0.0",
        "css-loader": "^6.0.0",
        "eslint": "^8.0.0",
        "jest": "^27.0.0",
        "laravel-mix": "^6.0.0",
        "sass": "^1.0.0",
        "sass-loader": "^12.0.0",
        "style-loader": "^3.0.0",
        "stylelint": "^14.0.0",
        "webpack": "^5.0.0"
    }
}
```

## Gestione Versioni

### Versionamento Semantico
```php
// app/Providers/ThemeServiceProvider.php
class ThemeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('theme.version', function () {
            return '1.0.0';
        });
    }
}
```

### Aggiornamento Dipendenze
```bash
# Aggiornamento Composer
composer update --no-dev
composer update --with-dependencies

# Aggiornamento NPM
npm update
npm audit fix
```

## Best Practices

### Installazione
- Utilizzare versioni specifiche
- Verificare compatibilità
- Documentare dipendenze
- Gestire ambienti
- Testare installazione

### Manutenzione
- Aggiornare regolarmente
- Monitorare vulnerabilità
- Gestire conflitti
- Documentare cambiamenti
- Testare aggiornamenti

### Sicurezza
- Verificare sorgenti
- Scansionare vulnerabilità
- Gestire permessi
- Monitorare accessi
- Documentare procedure

## Metriche di Successo

### Qualità
- Stabilità dipendenze
- Tempo risoluzione
- Documentazione
- Test coverage
- Manutenibilità

### Performance
- Tempo installazione
- Utilizzo risorse
- Scalabilità
- Automazione
- Monitoraggio

## Collegamenti

- [Sistema di Design](../design_system.md)
- [Componenti](../components.md)
- [Guida allo Stile](../style_guide.md)
- [Best Practices](../best_practices.md) 
