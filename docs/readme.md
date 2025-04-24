<<<<<<< HEAD
# Jigsaw Docs Starter Template

This is a starter template for creating a beautiful, customizable documentation site for your project with minimal effort. You’ll only have to change a few settings and you’re ready to go.

[View a preview of the docs template.](http://jigsaw-docs-template.tighten.co/)

## Installation

After installing Jigsaw, run the following command from your project directory:

```bash
./vendor/bin/jigsaw init docs
```

This starter template includes samples of common page types, and comes pre-configured with:

- A fully responsive navigation bar
- A sidebar navigation menu
- [Tailwind CSS](https://tailwindcss.com/), a utility CSS framework that allows you to customize your design without touching a line of CSS
- [Purgecss](https://www.purgecss.com/) to remove unused selectors from your CSS, resulting in smaller CSS files
- Syntax highlighting using [highlight.js](https://highlightjs.org/)
- A script that automatically generates a `sitemap.xml` file
- A search bar powered by [Algolia DocSearch](https://community.algolia.com/docsearch/), and instructions on how to get started with their free indexing service
- A custom 404 page

---

![Docs starter template screenshot](https://user-images.githubusercontent.com/357312/50345478-40170c00-04fd-11e9-856c-ad46d1ac45cb.png)

---

### Configuring your new site

As with all Jigsaw sites, configuration settings can be found in `config.php`; you can update the variables in that file with settings specific to your project. You can also add new configuration variables there to use across your site; take a look at the [Jigsaw documentation](http://jigsaw.tighten.co/docs/site-variables/) to learn more.

```php
// config.php
return [
    'baseUrl' => 'https://my-awesome-jigsaw-site.com/',
    'production' => false,
    'siteName' => 'My Site',
    'siteDescription' => 'Give your documentation a boost with Jigsaw.',
    'docsearchApiKey' => '',
    'docsearchIndexName' => '',
    'navigation' => require_once('navigation.php'),
];
```

> Tip: This configuration file is also where you’ll define any "collections" (for example, a collection of the contributors to your site, or a collection of blog posts). Check out the official [Jigsaw documentation](https://jigsaw.tighten.co/docs/collections/) to learn more.

---

### Adding Content

You can write your content using a [variety of file types](http://jigsaw.tighten.co/docs/content-other-file-types/). By default, this starter template expects your content to be located in the `source/docs` folder. If you change this, be sure to update the URL references in `navigation.php`.

The first section of each content page contains a YAML header that specifies how it should be rendered. The `title` attribute is used to dynamically generate HTML `title` and OpenGraph tags for each page. The `extends` attribute defines which parent Blade layout this content file will render with (e.g. `_layouts.documentation` will render with `source/_layouts/documentation.blade.php`), and the `section` attribute defines the Blade "section" that expects this content to be placed into it.

```yaml
---
title: Navigation
description: Building a navigation menu for your site
extends: _layouts.documentation
section: content
---
```

[Read more about Jigsaw layouts.](https://jigsaw.tighten.co/docs/content-blade/)

---

### Adding Assets

Any assets that need to be compiled (such as JavaScript, Less, or Sass files) can be added to the `source/_assets/` directory, and Laravel Mix will process them when running `npm run dev` or `npm run prod`. The processed assets will be stored in `/source/assets/build/` (note there is no underscore on this second `assets` directory).

Then, when Jigsaw builds your site, the entire `/source/assets/` directory containing your built files (and any other directories containing static assets, such as images or fonts, that you choose to store there) will be copied to the destination build folders (`build_local`, on your local machine).

Files that don't require processing (such as images and fonts) can be added directly to `/source/assets/`.

[Read more about compiling assets in Jigsaw using Laravel Mix.](http://jigsaw.tighten.co/docs/compiling-assets/)

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
=======
# Documentazione del Modulo CMS

## Struttura della Documentazione

```
docs/
├── README.md                    # Questo file
├── architecture.md             # Architettura generale del modulo
├── best-practices/            # Best practices e linee guida
│   └── page-rendering.md     # Best practices per il rendering delle pagine
├── migrations/               # Guide per le migrazioni e aggiornamenti
│   └── 01_theme_to_components.md  # Migrazione da ThemeComposer a Componenti
├── content-storage.md        # Gestione e storage dei contenuti
├── homepage_architecture.md  # Architettura della homepage
└── page-resource.md         # Documentazione PageResource
```

## Indice dei Documenti

### Guide Principali

1. [Architettura](architecture.md)
   - Panoramica dell'architettura del modulo CMS
   - Componenti principali e loro interazioni
   - Flusso dei dati e delle richieste

2. [Best Practices](best-practices/page-rendering.md)
   - Linee guida per il rendering delle pagine
   - Utilizzo dei componenti Blade
   - Pattern raccomandati

3. [Guide di Migrazione](migrations/01_theme_to_components.md)
   - Processo di migrazione da ThemeComposer a Componenti Blade
   - Istruzioni passo-passo
   - Piano di rollback

### Documentazione Tecnica

4. [Content Storage](content-storage.md)
   - Sistema di storage dei contenuti
   - Struttura dei file JSON
   - Gestione delle traduzioni

5. [Homepage Architecture](homepage_architecture.md)
   - Struttura della homepage
   - Gestione dei blocchi di contenuto
   - Rendering e caching

6. [Page Resource](page-resource.md)
   - Documentazione del PageResource
   - Integrazione con Filament
   - Gestione dei blocchi di contenuto

## Collegamenti alla Documentazione Generale

La documentazione in questa cartella è collegata alla documentazione generale del progetto in `/docs`. I file principali hanno riferimenti bidirezionali per facilitare la navigazione.

### Collegamenti Principali

- [Documentazione Generale CMS](/docs/cms/README.md)
- [Documentazione dei Temi](/docs/themes/README.md)
- [Documentazione API](/docs/api/README.md)

## Convenzioni di Documentazione

1. **Struttura dei File**
   - Utilizzare nomi file in kebab-case
   - Aggiungere il suffisso `.md` a tutti i file
   - Mantenere una struttura gerarchica logica

2. **Contenuto**
   - Iniziare ogni file con un titolo principale
   - Includere una breve descrizione del contenuto
   - Utilizzare sezioni e sottosezioni con titoli appropriati
   - Aggiungere esempi di codice quando necessario

3. **Collegamenti**
   - Utilizzare percorsi relativi per i collegamenti interni
   - Aggiungere tag `@see` per i riferimenti ai file di codice
   - Mantenere i collegamenti bidirezionali aggiornati

4. **Esempi di Codice**
   - Utilizzare blocchi di codice con sintassi evidenziata
   - Specificare il linguaggio del codice
   - Includere commenti esplicativi

## Manutenzione

La documentazione dovrebbe essere aggiornata ogni volta che:

1. Vengono implementate nuove funzionalità
2. Vengono modificati comportamenti esistenti
3. Vengono deprecate o rimosse funzionalità
4. Vengono identificati errori o imprecisioni

## Contribuire

Per contribuire alla documentazione:

1. Creare un nuovo branch
2. Aggiungere o modificare la documentazione
3. Assicurarsi che i collegamenti siano corretti
4. Aprire una pull request

---
@see /docs/README.md
@see /docs/cms/README.md
>>>>>>> cb39031 (.)
