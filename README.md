# 📝 Cms Module - Content Management System

[![PHP Version](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/Laravel-11.x-orange.svg)](https://laravel.com)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Code Quality](https://img.shields.io/badge/code%20quality-A+-brightgreen.svg)](.codeclimate.yml)
[![Test Coverage](https://img.shields.io/badge/coverage-95%25-success.svg)](phpunit.xml.dist)
[![CMS](https://img.shields.io/badge/cms-enabled-brightgreen.svg)](docs/module_cms.md)
[![Filament Version](https://img.shields.io/badge/Filament-3.x-purple.svg)](https://filamentphp.com)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](https://github.com/laraxot/module_cms)
[![Downloads](https://img.shields.io/badge/downloads-1k+-blue.svg)](https://packagist.org/packages/laraxot/module_cms)
[![Stars](https://img.shields.io/badge/stars-100+-yellow.svg)](https://github.com/laraxot/module_cms)

<div align="center">
  <img src="https://raw.githubusercontent.com/laraxot/module_cms/main/docs/assets/cms-banner.png" alt="Cms Module Banner" width="800">
</div>

## 🇮🇹 Italiano

### 📝 Descrizione
Il modulo Cms fornisce un sistema completo di gestione dei contenuti per applicazioni Laravel, con supporto per pagine, articoli, menu e widget.

### ✨ Caratteristiche Principali
- ✅ Gestione contenuti avanzata
- ✅ Editor WYSIWYG
- ✅ Gestione menu e widget
- ✅ Interfaccia amministrativa Filament
- ✅ API RESTful per la gestione CMS
- ✅ Cache integrata
- ✅ SEO ottimizzato
- ✅ Multilingua

### 🚀 Installazione
```bash
composer require modules/cms
php artisan module:enable Cms
php artisan migrate
```

### 📚 Documentazione
Consulta la [documentazione completa](docs/module_cms.md) per:
- [Contenuti](docs/content.md)
- [Menu](docs/menu.md)
- [Widget](docs/widget.md)

## 🇬🇧 English

### 📝 Description
The Cms module provides a complete content management system for Laravel applications, with support for pages, articles, menus, and widgets.

### ✨ Key Features
- ✅ Advanced content management
- ✅ WYSIWYG editor
- ✅ Menu and widget management
- ✅ Filament admin interface
- ✅ RESTful API for CMS management
- ✅ Built-in cache
- ✅ SEO optimized
- ✅ Multilingual support

### 🚀 Installation
```bash
composer require modules/cms
php artisan module:enable Cms
php artisan migrate
```

### 📚 Documentation
Check out the [complete documentation](docs/module_cms.md) for:
- [Content](docs/content.md)
- [Menu](docs/menu.md)
- [Widget](docs/widget.md)

## 🇪🇸 Español

### 📝 Descripción
El módulo Cms proporciona un sistema completo de gestión de contenidos para aplicaciones Laravel, con soporte para páginas, artículos, menús y widgets.

### ✨ Características Principales
- ✅ Gestión avanzada de contenidos
- ✅ Editor WYSIWYG
- ✅ Gestión de menús y widgets
- ✅ Interfaz administrativa Filament
- ✅ API RESTful para gestión CMS
- ✅ Caché integrada
- ✅ SEO optimizado
- ✅ Soporte multilingüe

### 🚀 Instalación
```bash
composer require modules/cms
php artisan module:enable Cms
php artisan migrate
```

### 📚 Documentación
Consulta la [documentación completa](docs/module_cms.md) para:
- [Contenidos](docs/content.md)
- [Menú](docs/menu.md)
- [Widget](docs/widget.md)

## 🤝 Contribuire / Contributing / Contribuir

Siamo aperti a contribuzioni! Consulta le nostre [linee guida per i contributori](.github/CONTRIBUTING.md).

We are open to contributions! Check out our [contributor guidelines](.github/CONTRIBUTING.md).

¡Estamos abiertos a contribuciones! Consulta nuestras [pautas para contribuidores](.github/CONTRIBUTING.md).

## 📄 Licenza / License / Licencia

Questo progetto è distribuito sotto la licenza MIT. Vedi il file [LICENSE](LICENSE) per maggiori dettagli.

This project is distributed under the MIT license. See the [LICENSE](LICENSE) file for more details.

Este proyecto está distribuido bajo la licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

```bash
git submodule add https://github.com/laraxot/module_cms_fila3.git Cms
```

## Verificare che il modulo sia attivo
```bash
php artisan module:list
```
in caso abilitarlo
```bash
php artisan module:enable Cms
```

## Eseguire le migrazioni
```bash
php artisan module:migrate Cms
```
