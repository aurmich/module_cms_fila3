# SaluteOra - Sistema di Gestione per la Salute Orale
# baseSaluteOra

# Base il progetto
# SaluteOra - Sistema di Gestione per la Salute Orale

## 🦷 Panoramica

SaluteOra è un sistema completo e modulare per la gestione e promozione della salute orale per le gestanti in condizioni di vulnerabilità socio-economica. Sviluppato in Laravel con architettura multi-tenant, offre una piattaforma scalabile e sicura per la gestione di pazienti, visite odontoiatriche e reportistica.

### 🎯 Obiettivi Principali

- Promuovere la salute orale nelle fasce più vulnerabili della popolazione
- Facilitare l'accesso alle cure odontoiatriche per le gestanti
- Gestire in modo efficiente pazienti, appuntamenti e trattamenti
- Fornire reportistica dettagliata per monitoraggio e analisi

## 🚀 Quick Start

### Prerequisiti

- PHP 8.2+
- MySQL 8.0+
- Composer 2.0+
- Node.js 18+
- Redis (opzionale, per cache e code)

### Installazione

```bash
# 1. Clonare il repository
git clone https://github.com/tuoorganizzazione/saluteora.git
cd saluteora

# 2. Installare le dipendenze PHP
composer install

# 3. Configurare l'ambiente
cp .env.example .env
php artisan key:generate

# 4. Configurare il database
# Editare .env con le credenziali del database

# 5. Eseguire le migrazioni
php artisan migrate

# 6. Installare i moduli
php artisan module:install

# 7. Installare le dipendenze frontend
npm install && npm run dev

# 8. Avviare il server di sviluppo
php artisan serve
```

## 📁 Struttura del Progetto

```text
base_saluteora/
├── laravel/                  # Applicazione Laravel principale
│   ├── Modules/             # Moduli del sistema
│   │   ├── Xot/            # Core framework
│   │   ├── User/           # Gestione utenti
│   │   ├── Tenant/         # Multi-tenancy
│   │   ├── Patient/        # Gestione pazienti
│   │   ├── Doctor/         # Gestione medici
│   │   └── ...            # Altri moduli
│   ├── config/             # Configurazioni
│   └── resources/          # Risorse frontend
├── docs/                    # Documentazione completa
├── bashscripts/            # Script di automazione
└── tests/                  # Test suite
```

## 🔧 Moduli Core

### Moduli di Sistema

- **[Xot](laravel/Modules/Xot/docs/README.md)**: Framework base con funzionalità core
- **[User](laravel/Modules/User/docs/README.md)**: Autenticazione e autorizzazione
- **[Tenant](laravel/Modules/Tenant/docs/README.md)**: Gestione multi-tenant
- **[Lang](laravel/Modules/Lang/docs/README.md)**: Localizzazione multi-lingua

### Moduli Funzionali

- **[Patient](laravel/Modules/Patient/docs/README.md)**: Gestione pazienti e ISEE
- **[Doctor](laravel/Modules/Doctor/docs/README.md)**: Gestione medici e studi
- **[Dental](laravel/Modules/Dental/docs/README.md)**: Visite e trattamenti
- **[Reporting](laravel/Modules/Reporting/docs/README.md)**: Report e statistiche

### Moduli di Supporto

- **[Cms](laravel/Modules/Cms/docs/README.md)**: Gestione contenuti
- **[UI](laravel/Modules/UI/docs/README.md)**: Componenti interfaccia
- **[Activity](laravel/Modules/Activity/docs/README.md)**: Log e monitoraggio
- **[Notify](laravel/Modules/Notify/docs/README.md)**: Sistema notifiche

## 🎨 Frontend

Il sistema utilizza una combinazione di tecnologie moderne:

- **Laravel Folio** per routing basato su file
- **Livewire** per componenti reattivi
- **Filament** per pannello amministrativo
- **Tailwind CSS** per styling
- **Alpine.js** per interattività

## Sviluppo
- Seguire le [linee guida](laravel/Modules/Xot/docs/DOCUMENTATION-GUIDELINES.md) per la documentazione
- Mantenere la documentazione aggiornata con il codice
- Utilizzare termini generici nella documentazione dei moduli 
# baseSaluteOra

# baseSaluteOra

# :package_description

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laraxot/module_geo_fila3.svg?style=flat-square)](https://packagist.org/packages/laraxot/module_geo_fila3)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/laraxot/module_geo_fila3/run-tests?label=tests)](https://github.com/laraxot/module_geo_fila3/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/laraxot/module_geo_fila3/Check%20&%20fix%20styling?label=code%20style)](https://github.com/laraxot/module_geo_fila3/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/laraxot/module_geo_fila3.svg?style=flat-square)](https://packagist.org/packages/laraxot/module_geo_fila3)
<!--delete-->
---
This repo can be used to scaffold a Laravel package. Follow these steps to get started:

1. Press the "Use template" button at the top of this repo to create a new repo with the contents of this skeleton.
2. Run "php ./configure.php" to run a script that will replace all placeholders throughout all the files.
3. Have fun creating your package.
4. If you need help creating a package, consider picking up our <a href="https://laravelpackage.training">Laravel Package Training</a> video course.
---
<!--/delete-->
This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/:package_name.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/:package_name)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require laraxot/module_geo_fila3
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="module_geo_fila3-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="module_geo_fila3-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="module_geo_fila3-views"
```

## Usage

```php
$variable = new VendorName\Skeleton();
echo $variable->echoPhrase('Hello, VendorName!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [:author_name](https://github.com/:author_username)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
## 📚 Documentazione

### Guide Principali

- 📖 [Documentazione Completa](docs/README.md)
- 🚀 [Guida all'Installazione](docs/installazione.md)
- 🏗️ [Architettura del Sistema](docs/architecture/README.md)
- 📋 [Best Practices](docs/best-practices.md)
- 🗺️ [Roadmap del Progetto](docs/roadmap.md)

### Guide Tecniche

- 🔧 [Configurazione](docs/configuration.md)
- 🌐 [Multi-lingua](docs/translations/README.md)
- 🔒 [Sicurezza](docs/compliance/README.md)
- 🧪 [Testing](docs/testing/README.md)

### Per Sviluppatori

- 💻 [Convenzioni di Codice](docs/conventions.md)
- 📦 [Creazione Moduli](docs/modules/README.md)
- 🎯 [PHPStan Level 9](docs/phpstan/README.md)
- 🔄 [Git Workflow](docs/git.md)

## 🛡️ Sicurezza e Compliance

- Conformità GDPR per la protezione dei dati
- Crittografia end-to-end per dati sensibili
- Multi-tenancy con isolamento completo
- Audit log per tutte le operazioni critiche
- Backup automatici e disaster recovery

## 🧪 Testing

```bash
# Eseguire tutti i test
php artisan test

# Test con coverage
php artisan test --coverage

# Test specifici per modulo
php artisan test --testsuite=Patient

# PHPStan analysis
vendor/bin/phpstan analyse --level=9
```

## 🤝 Contribuire

1. Fork del repository
2. Creare un branch feature (`git checkout -b feature/AmazingFeature`)
3. Commit delle modifiche (`git commit -m 'Add some AmazingFeature'`)
4. Push al branch (`git push origin feature/AmazingFeature`)
5. Aprire una Pull Request

### Standard di Codice

- Seguire PSR-12
- Utilizzare type hints e return types
- Documentare con PHPDoc
- Test per ogni nuova funzionalità
- Mantenere PHPStan level 9

## 📊 Stato del Progetto

### Versione Attuale: 1.0.0-beta

| Modulo | Stato | Completamento |
|--------|-------|---------------|
| Core System | ✅ Stabile | 100% |
| Patient Management | ✅ Stabile | 95% |
| Doctor Management | 🚧 In sviluppo | 80% |
| Dental Module | 🚧 In sviluppo | 75% |
| Reporting | 🚧 In sviluppo | 60% |
| Frontend | ✅ Stabile | 90% |

## 📝 Licenza

Questo progetto è rilasciato sotto licenza proprietaria. Tutti i diritti riservati.

## 🙏 Ringraziamenti

- Team di sviluppo Laravel
- Community Filament
- Contributori open source
- Beta tester e utenti finali

## 📞 Supporto

Per supporto e informazioni:

- 📧 Email: supporto@saluteora.it
- 📚 [Documentazione](docs/README.md)
- 🐛 [Issue Tracker](https://github.com/tuoorganizzazione/saluteora/issues)
- 💬 [Discussioni](https://github.com/tuoorganizzazione/saluteora/discussions)

Sviluppato con ❤️ per migliorare la salute orale delle future mamme
# baseSaluteOra

