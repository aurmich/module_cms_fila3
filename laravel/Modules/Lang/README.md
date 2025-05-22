# Module Lang

Modulo dedicato alla gestione delle traduzioni e localizzazione in applicazioni Laravel.

## 📚 Documentazione Traduzioni

### Guide Disponibili

1. [Strategie di Traduzione](docs/TRANSLATION_STRATEGIES.md) - Panoramica su PHP vs JSON, best practice e linee guida
2. [Guida Rapida](docs/QUICK_REFERENCE.md) - Riferimento veloce per lo sviluppo
3. [Guida mcamara/laravel-localization](docs/MCAMARA_IMPLEMENTATION_GUIDE.md) - Implementazione della localizzazione avanzata

### Strumenti Utili

#### Conversione Formati

```bash
# Converti da PHP a JSON
php artisan translations:convert php json it

# Converti da JSON a PHP
php artisan translations:convert json php it
```

#### Comandi Artisan

```bash
# Pubblicare file di lingua Laravel
php artisan lang:publish

# Cercare traduzioni mancanti
php artisan translation:show-missing

# Estrarre stringhe traducibili
php artisan translation:extract

# Pulire la cache delle traduzioni
php artisan view:clear
php artisan config:clear
```

### Best Practice

1. **Struttura**
   - Usa file PHP per le traduzioni di sistema
   - Organizza le traduzioni per moduli/funzionalità
   - Usa la notazione puntata per le gerarchie

2. **Sicurezza**
   - Usa `{{ }}` per evitare XSS
   - Non inserire mai dati utente non validati nelle chiavi di traduzione

3. **Performance**
   - Abilita la cache in produzione
   - Usa `route:trans:cache` invece di `route:cache`

---

*Il resto del documento originale continua qui sotto...*

## Aggiungere Modulo nella base del progetto
Dentro la cartella laravel/Modules
### Versione HEAD


### Versione Incoming

# 🌐 Lang Module - Gestione Multilingua

[![PHP Version](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/Laravel-11.x-orange.svg)](https://laravel.com)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Code Quality](https://img.shields.io/badge/code%20quality-A+-brightgreen.svg)](.codeclimate.yml)
[![Test Coverage](https://img.shields.io/badge/coverage-95%25-success.svg)](phpunit.xml.dist)
[![Multilingual](https://img.shields.io/badge/multilingual-enabled-brightgreen.svg)](docs/module_lang.md)
[![Filament Version](https://img.shields.io/badge/Filament-3.x-purple.svg)](https://filamentphp.com)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](https://github.com/laraxot/module_lang)
[![Downloads](https://img.shields.io/badge/downloads-1k+-blue.svg)](https://packagist.org/packages/laraxot/module_lang)
[![Stars](https://img.shields.io/badge/stars-100+-yellow.svg)](https://github.com/laraxot/module_lang)

<div align="center">
  <img src="https://raw.githubusercontent.com/laraxot/module_lang/main/docs/assets/lang-banner.png" alt="Lang Module Banner" width="800">
</div>

## 🇮🇹 Italiano

### 📝 Descrizione
Il modulo Lang fornisce un sistema completo di gestione multilingua per applicazioni Laravel, con supporto per traduzioni, localizzazione e gestione delle lingue.

### ✨ Caratteristiche Principali
- ✅ Gestione lingue avanzata
- ✅ Traduzioni automatiche
- ✅ Editor traduzioni integrato
- ✅ Interfaccia amministrativa Filament
- ✅ API RESTful per la gestione lingue
- ✅ Cache delle traduzioni
- ✅ Rilevamento automatico lingua
- ✅ Supporto RTL

### 🚀 Installazione
```bash
composer require modules/lang
php artisan module:enable Lang
php artisan migrate
```

### 📚 Documentazione
Consulta la [documentazione completa](docs/module_lang.md) per:
- [Lingue](docs/languages.md)
- [Traduzioni](docs/translations.md)
- [API](docs/api.md)

## 🇬🇧 English

### 📝 Description
The Lang module provides a complete multilingual management system for Laravel applications, with support for translations, localization, and language management.

### ✨ Key Features
- ✅ Advanced language management
- ✅ Automatic translations
- ✅ Integrated translation editor
- ✅ Filament admin interface
- ✅ RESTful API for language management
- ✅ Translation caching
- ✅ Automatic language detection
- ✅ RTL support

### 🚀 Installation
```bash
composer require modules/lang
php artisan module:enable Lang
php artisan migrate
```

### 📚 Documentation
Check out the [complete documentation](docs/module_lang.md) for:
- [Languages](docs/languages.md)
- [Translations](docs/translations.md)
- [API](docs/api.md)

## 🇪🇸 Español

### 📝 Descripción
El módulo Lang proporciona un sistema completo de gestión multilingüe para aplicaciones Laravel, con soporte para traducciones, localización y gestión de idiomas.

### ✨ Características Principales
- ✅ Gestión avanzada de idiomas
- ✅ Traducciones automáticas
- ✅ Editor de traducciones integrado
- ✅ Interfaz administrativa Filament
- ✅ API RESTful para gestión de idiomas
- ✅ Caché de traducciones
- ✅ Detección automática de idioma
- ✅ Soporte RTL

### 🚀 Instalación
```bash
composer require modules/lang
php artisan module:enable Lang
php artisan migrate
```

### 📚 Documentación
Consulta la [documentación completa](docs/module_lang.md) para:
- [Idiomas](docs/languages.md)
- [Traducciones](docs/translations.md)
- [API](docs/api.md)

## 🤝 Contribuire / Contributing / Contribuir

Siamo aperti a contribuzioni! Consulta le nostre [linee guida per i contributori](.github/CONTRIBUTING.md).

We are open to contributions! Check out our [contributor guidelines](.github/CONTRIBUTING.md).

¡Estamos abiertos a contribuciones! Consulta nuestras [pautas para contribuidores](.github/CONTRIBUTING.md).

## 📄 Licenza / License / Licencia

Questo progetto è distribuito sotto la licenza MIT. Vedi il file [LICENSE](LICENSE) per maggiori dettagli.

This project is distributed under the MIT license. See the [LICENSE](LICENSE) file for more details.

Este proyecto está distribuido bajo la licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

---


```bash
git submodule add https://github.com/laraxot/module_lang_fila3.git Lang
```

## Verificare che il modulo sia attivo
```bash
php artisan module:list
```
in caso abilitarlo
```bash
php artisan module:enable Lang
```

## Eseguire le migrazioni
```bash
php artisan module:migrate Lang
### Versione HEAD

```

### Versione Incoming

```
```

---

