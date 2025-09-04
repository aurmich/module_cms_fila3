# Modulo CMS
> **Collegamenti correlati**
> - [README.md documentazione generale SaluteOra](../../../../project_docs/README.md)
> - [README.md toolkit bashscripts](../../../../bashscripts/project_docs/README.md)
> - [README.md modulo CMS](../../../../laravel/Modules/Cms/project_docs/README.md)
> - [README.md modulo Dental](../../../../laravel/Modules/Dental/project_docs/README.md)
> - [README.md modulo GDPR](../../../../laravel/Modules/Gdpr/project_docs/README.md)
> - [README.md modulo User](../../../../laravel/Modules/User/project_docs/README.md)
> - [README.md modulo Lang](../../../../laravel/Modules/Lang/project_docs/README.md)
> - [README.md modulo Patient](../../../../laravel/Modules/Patient/project_docs/README.md)
> - [README.md modulo Activity](../../../../laravel/Modules/Activity/project_docs/README.md)
> - [README.md modulo Media](../../../../laravel/Modules/Media/project_docs/README.md)
> - [README.md modulo Notify](../../../../laravel/Modules/Notify/project_docs/README.md)
> - [README.md modulo Reporting](../../../../laravel/Modules/Reporting/project_docs/README.md)
> - [README.md modulo Tenant](../../../../laravel/Modules/Tenant/project_docs/README.md)
> - [README.md modulo UI](../../../../laravel/Modules/UI/project_docs/README.md)
> - [README.md modulo Xot](../../../../laravel/Modules/Xot/project_docs/README.md)
> - [README.md modulo Chart](../../../../laravel/Modules/Chart/project_docs/README.md)
> - [README.md tema One](../../../../laravel/Themes/One/project_docs/README.md)
> - [README.md tema Two](../../../../laravel/Themes/Two/project_docs/README.md)
> - [Collegamenti documentazione centrale](../../../../project_docs/collegamenti-documentazione.md)

> - [README.md documentazione generale SaluteOra](../../../../project_docs/README.md)
> - [README.md toolkit bashscripts](../../../../bashscripts/project_docs/README.md)
> - [README.md modulo CMS](../../../../laravel/Modules/Cms/project_docs/README.md)
> - [README.md modulo Dental](../../../../laravel/Modules/Dental/project_docs/README.md)
> - [README.md modulo GDPR](../../../../laravel/Modules/Gdpr/project_docs/README.md)
> - [README.md modulo User](../../../../laravel/Modules/User/project_docs/README.md)
> - [README.md modulo Lang](../../../../laravel/Modules/Lang/project_docs/README.md)
> - [README.md modulo Media](../../../../laravel/Modules/Media/project_docs/README.md)
> - [README.md modulo Notify](../../../../laravel/Modules/Notify/project_docs/README.md)
> - [README.md modulo Reporting](../../../../laravel/Modules/Reporting/project_docs/README.md)
> - [README.md modulo Tenant](../../../../laravel/Modules/Tenant/project_docs/README.md)
> - [README.md modulo UI](../../../../laravel/Modules/UI/project_docs/README.md)
> - [README.md modulo Xot](../../../../laravel/Modules/Xot/project_docs/README.md)
> - [README.md modulo Chart](../../../../laravel/Modules/Chart/project_docs/README.md)
> - [README.md tema One](../../../../laravel/Themes/One/project_docs/README.md)
> - [Collegamenti documentazione centrale](../../../../project_docs/collegamenti-documentazione.md)

# Jigsaw Docs Starter Template

## Introduzione
Il modulo CMS gestisce i contenuti e i widget del sistema, fornendo un sistema flessibile per la gestione dinamica dei contenuti e l'ottimizzazione per i motori di ricerca.

## Indice
1. [Architettura](#architettura)
   - [Struttura del Modulo](structure.md)
   - [Architettura Generale](architecture.md)
   - [Convenzioni e Standard](module-guidelines.md)

2. [Frontend](#frontend)
   - [Frontoffice](frontoffice.md)
   - [Homepage](homepage.md)
   - [Componenti UI](components.md)
   - [Volt & Folio](volt-web-application.md)

3. [Backend](#backend)
   - [Filament Integration](filament-integration.md)
   - [Content Management](content-management.md)
   - [Filament Components](filament-components.md)
   - [Resources](filament-resources.md)

4. [Contenuti](#contenuti)
   - [Gestione Pagine](page-management.md)
   - [Gestione Sezioni](section-management.md)
   - [Storage dei Contenuti](content-storage.md)
   - [Traduzioni](translations.md)

5. [Sviluppo](#sviluppo)
   - [Getting Started](getting-started.md)
   - [Configurazione](configuration.md)
   - [Testing](testing.md)
   - [PHPStan](phpstan.md)

6. [UX/UI](#ux-ui)
   - [Web Design](webdesign.md)
   - [Componenti Standard](standard_ui_components.md)
   - [Multi-step Forms](multi-step-forms.md)
   - [Wizard](ux-wizard-registrazione-paziente.md)

## Dipendenze Principali
- Laravel Framework ^11.0
- Filament ^3.2
- Livewire ^3.0
- Laravel Folio ^1.0
- Laravel Volt ^1.0
- Tailwind CSS ^3.4
- Alpine.js ^3.0

## Best Practices
1. **Estensione Classi**
   - Estendere sempre le classi base di Xot
   - Non estendere direttamente le classi di Filament
   - Utilizzare i trait forniti dal modulo

2. **Convenzioni**
   - Seguire le [convenzioni di naming](../../../project_docs/standards/file_naming_conventions.md)
   - Documentare tutto il codice con PHPDoc
   - Mantenere la struttura dei file coerente

3. **Performance**
   - Utilizzare il caching dove possibile
   - Ottimizzare le query al database
   - Seguire le [best practices di Laravel](https://laravel.com/project_docs/11.x/best-practices)

## Collegamenti Bidirezionali
- [Modulo User](../User/project_docs/README.md) - Gestione utenti e permessi
- [Modulo Lang](../Lang/project_docs/README.md) - Gestione traduzioni
- [Modulo UI](../UI/project_docs/README.md) - Componenti di interfaccia
- [Modulo Xot](../Xot/project_docs/README.md) - Modulo base e linee guida
- [Documentazione Principale](../../../project_docs/README.md) - Documentazione generale

## Roadmap e Sviluppo
- [Roadmap](roadmap.md) - Piano di sviluppo futuro
- [Issues](phpstan_issues.md) - Problemi noti e soluzioni
- [Upgrade Guide](upgrade.md) - Guida all'aggiornamento

## Supporto
Per domande o problemi, consultare:
1. La [documentazione ufficiale](https://saluteora.com/docs)
2. Il [forum di supporto](https://saluteora.com/forum)
3. Il team di sviluppo via [email](mailto:support@saluteora.com)
> Tip: This configuration file is also where you’ll define any "collections" (for example, a collection of the contributors to your site, or a collection of blog posts). Check out the official [Jigsaw documentation](https://jigsaw.tighten.co/project_docs/collections/) to learn more.

---

### Adding Content

You can write your content using a [variety of file types](http://jigsaw.tighten.co/project_docs/content-other-file-types/). By default, this starter template expects your content to be located in the `source/docs` folder. If you change this, be sure to update the URL references in `navigation.php`.

The first section of each content page contains a YAML header that specifies how it should be rendered. The `title` attribute is used to dynamically generate HTML `title` and OpenGraph tags for each page. The `extends` attribute defines which parent Blade layout this content file will render with (e.g. `_layouts.documentation` will render with `source/_layouts/documentation.blade.php`), and the `section` attribute defines the Blade "section" that expects this content to be placed into it.

```yaml
---
title: Navigation
description: Building a navigation menu for your site
extends: _layouts.documentation
section: content
---
```

[Read more about Jigsaw layouts.](https://jigsaw.tighten.co/project_docs/content-blade/)

---

### Adding Assets

Any assets that need to be compiled (such as JavaScript, Less, or Sass files) can be added to the `source/_assets/` directory, and Laravel Mix will process them when running `npm run dev` or `npm run prod`. The processed assets will be stored in `/source/assets/build/` (note there is no underscore on this second `assets` directory).

Then, when Jigsaw builds your site, the entire `/source/assets/` directory containing your built files (and any other directories containing static assets, such as images or fonts, that you choose to store there) will be copied to the destination build folders (`build_local`, on your local machine).

Files that don't require processing (such as images and fonts) can be added directly to `/source/assets/`.

[Read more about compiling assets in Jigsaw using Laravel Mix.](http://jigsaw.tighten.co/project_docs/compiling-assets/)

---

## Building Your Site

Now that you’ve edited your configuration variables and know how to customize your styles and content, let’s build the site.

```bash
# build static files with Jigsaw
./vendor/bin/jigsaw build

# compile assets with Laravel Mix
# options: dev, prod
npm run dev
```

## Collegamenti tra versioni di README.md
* [README.md](bashscripts/project_docs/README.md)
* [README.md](bashscripts/project_docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/project_docs/README.md)
* [README.md](laravel/Modules/Chart/project_docs/README.md)
* [README.md](laravel/Modules/Reporting/project_docs/README.md)
* [README.md](laravel/Modules/Gdpr/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/project_docs/README.md)
* [README.md](laravel/Modules/Notify/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/project_docs/README.md)
* [README.md](laravel/Modules/Xot/project_docs/filament/README.md)
* [README.md](laravel/Modules/Xot/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/project_docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/project_docs/README.md)
* [README.md](laravel/Modules/Xot/project_docs/standards/README.md)
* [README.md](laravel/Modules/Xot/project_docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/project_docs/development/README.md)
* [README.md](laravel/Modules/Dental/project_docs/README.md)
* [README.md](laravel/Modules/User/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/User/project_docs/README.md)
* [README.md](laravel/Modules/User/resources/views/project_docs/README.md)
* [README.md](laravel/Modules/UI/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/project_docs/README.md)
* [README.md](laravel/Modules/UI/project_docs/standards/README.md)
* [README.md](laravel/Modules/UI/project_docs/themes/README.md)
* [README.md](laravel/Modules/UI/project_docs/components/README.md)
* [README.md](laravel/Modules/Lang/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/project_docs/README.md)
* [README.md](laravel/Modules/Job/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/project_docs/README.md)
* [README.md](laravel/Modules/Media/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/project_docs/README.md)
* [README.md](laravel/Modules/Tenant/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/project_docs/README.md)
* [README.md](laravel/Modules/Activity/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/project_docs/README.md)
* [README.md](laravel/Modules/Patient/project_docs/README.md)
* [README.md](laravel/Modules/Patient/project_docs/standards/README.md)
* [README.md](laravel/Modules/Patient/project_docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/project_docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/project_docs/README.md)
* [README.md](laravel/Modules/Cms/project_docs/standards/README.md)
* [README.md](laravel/Modules/Cms/project_docs/content/README.md)
* [README.md](laravel/Modules/Cms/project_docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/project_docs/components/README.md)
* [README.md](laravel/Themes/Two/project_docs/README.md)
* [README.md](laravel/Themes/One/project_docs/README.md)

