> **Collegamenti correlati**
> - [README.md documentazione generale SaluteOra](../../../../docs/README.md)
> - [README.md toolkit bashscripts](../../../../bashscripts/docs/README.md)
> - [README.md modulo CMS](../../../../laravel/Modules/Cms/docs/README.md)
> - [README.md modulo Dental](../../../../laravel/Modules/Dental/docs/README.md)
> - [README.md modulo GDPR](../../../../laravel/Modules/Gdpr/docs/README.md)
> - [README.md modulo User](../../../../laravel/Modules/User/docs/README.md)
> - [README.md modulo Lang](../../../../laravel/Modules/Lang/docs/README.md)
> - [README.md modulo Media](../../../../laravel/Modules/Media/docs/README.md)
> - [README.md modulo Notify](../../../../laravel/Modules/Notify/docs/README.md)
> - [README.md modulo Reporting](../../../../laravel/Modules/Reporting/docs/README.md)
> - [README.md modulo Tenant](../../../../laravel/Modules/Tenant/docs/README.md)
> - [README.md modulo UI](../../../../laravel/Modules/UI/docs/README.md)
> - [README.md modulo Xot](../../../../laravel/Modules/Xot/docs/README.md)
> - [README.md modulo Chart](../../../../laravel/Modules/Chart/docs/README.md)
> - [README.md tema One](../../../../laravel/Themes/One/docs/README.md)
> - [Collegamenti documentazione centrale](../../../../docs/collegamenti-documentazione.md)

> - [README.md documentazione generale SaluteOra](../../../../docs/README.md)
> - [README.md toolkit bashscripts](../../../../bashscripts/docs/README.md)
> - [README.md modulo CMS](../../../../laravel/Modules/Cms/docs/README.md)
> - [README.md modulo Dental](../../../../laravel/Modules/Dental/docs/README.md)
> - [README.md modulo GDPR](../../../../laravel/Modules/Gdpr/docs/README.md)
> - [README.md modulo User](../../../../laravel/Modules/User/docs/README.md)

## Note sul Tema

Il tema "laraxot/theme_one_fila3" è un pacchetto riutilizzabile e multiprogetto. Non è esclusivo per il progetto; tutti i riferimenti a il progetto sono stati rimossi o resi generici.

# Tema One (laraxot/theme_one_fila3)

## Introduzione

Questo tema è un pacchetto riutilizzabile sviluppato da Laraxot e utilizzato in diversi progetti, incluso il progetto. Il nome del pacchetto è `laraxot/theme_one_fila3` e non deve essere modificato poiché è utilizzato anche in altri progetti.

---

### Attenzione: struttura delle directory

**Errore storico:**
Il file `register.blade.php` era stato erroneamente posizionato in `/Themes/One/resources/views/pages/auth/` invece che nel percorso corretto `/laravel/Themes/One/resources/views/pages/auth/`.

**Motivazione e impatto:**
- Tutti i temi e le relative viste in il progetto devono risiedere sotto la root `/laravel` per rispettare la struttura PSR-4, le convenzioni Laravel e garantire funzionamento di autoload, override e pubblicazione asset.
- Un file fuori da `/laravel` non viene caricato correttamente da Laravel, rischia collisioni tra progetti e causa bug difficili da tracciare.

**Regola aggiornata:**
- Prima di creare, spostare o modificare file Blade, verificare sempre che il percorso sia sotto `/laravel/Themes/<NomeTema>/resources/views/...`.
- Non lasciare mai file di viste, asset o config fuori da `/laravel`.

**Azione correttiva:**
- Il file è stato spostato nella posizione corretta.
- Questa regola è ora parte delle best practice interne e della documentazione del tema.

---


## Struttura del Tema

```
laravel/Themes/One/
├── resources/
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
├── package.json
├── postcss.config.js
├── tailwind.config.js
└── vite.config.js
```

## Installazione

1. Installare le dipendenze:
```bash
npm install
```

2. Eseguire il build:
```bash
npm run build
```

3. Copiare gli asset nella directory pubblica:
```bash
npm run copy
```

## Personalizzazione

Per personalizzare il tema per un progetto specifico:

1. Non modificare il nome del pacchetto in `package.json`
2. Utilizzare le variabili CSS per personalizzare i colori
3. Estendere i componenti base invece di modificarli direttamente
4. Documentare tutte le personalizzazioni specifiche del progetto

## Link Utili

- [Documentazione Root](../../../docs/README.md)
- [Documentazione Temi](../../../docs/theme-links.md)
- [Documentazione CMS](../../../laravel/Modules/Cms/docs/README.md)
- [Documentazione Best Practices](../../../docs/best-practices.md)

# Laraxot Theme One Fila3

Questo tema è un tema Laravel/Filament riutilizzabile, pensato per essere usato in più progetti differenti. NON è legato a un singolo progetto o dominio. Tutti gli esempi e le istruzioni sono generici e multiprogetto.

## Requisiti di Versione
- PHP 8.1+
- Laravel 10+
- Filament 3.x
- Node.js 16+
- NPM 8+
- tailwindcss@3.x (richiesto per compatibilità con Filament 3.x)

## Dipendenze CSS
```bash
# Installazione dipendenze Filament
npm install tailwindcss@3 @tailwindcss/forms @tailwindcss/typography postcss postcss-nesting autoprefixer --save-dev
```

## Documentazione

- [Struttura e Componenti](./THEME.md)
- [Componenti UI](./COMPONENTS.md)
- [Gestione Asset](./ASSETS.md)
- [Gestione Contenuti JSON](./JSON_CONTENT.md)

## Installazione

```bash
composer require laraxot/theme_one_fila3
```

## Configurazione

```bash
php artisan theme:install one
php artisan theme:publish
```

> **Nota:** Sostituisci `one` con il nome assegnato al tema nel tuo progetto, se necessario.

## Sviluppo

```bash
npm install
npm run dev
```

## Build

```bash
npm run build
npm run copy
```

Lo script `copy` pubblica gli asset compilati nella cartella pubblica del progetto. Consulta la sezione "Gestione Asset" per dettagli.

## Testing

```bash
php artisan test --testsuite=theme-one
```

## Note Importanti
1. **Versioni**
   - Usare SOLO tailwindcss@3
   - Seguire esattamente le dipendenze di Filament
   - Non aggiungere dipendenze CSS non necessarie
2. **Riutilizzabilità**
   - Questo tema è multiprogetto: non inserire riferimenti a progetti, domini o brand specifici.
   - Aggiorna la documentazione locale quando usi il tema in un nuovo progetto.

2. **Dipendenze**
   - tailwindcss@3
   - @tailwindcss/forms
   - @tailwindcss/typography
   - postcss
   - postcss-nesting
   - autoprefixer

3. **Aggiornamenti**
   - Verificare la documentazione Filament
   - Mantenere le versioni allineate
   - Testare la compatibilità

## Collegamenti
- [Documentazione Filament](https://filamentphp.com/docs/3.x/notifications/installation#installing-tailwind-css)
- [Documentazione Tailwind v3](https://v3.tailwindcss.com/docs)
- [Guida Stili Filament](https://filamentphp.com/docs/3.x/support/style-customization)
- [Documentazione CMS](../../Modules/Cms/docs/README.md)
- [Root Docs](../../docs/INDEX.md)

# Tema One per il progetto

## Introduzione

Il Tema One è il tema predefinito per il progetto, basato su Filament 3.3. Questo tema fornisce un'interfaccia moderna e responsive per il frontend del sito.

## Requisiti

- PHP 8.1+
- Laravel 10+
- Filament 3.3+
- Node.js 16+
- NPM 8+

## Struttura del Tema

```
Themes/One/
├── app/
│   └── providers/
│       └── ThemeServiceProvider.php
├── config/
│   └── theme.php
├── database/
│   └── content/
├── resources/
│   └── views/
│       ├── components/
│       │   ├── sections/
│       │   │   ├── header.blade.php
│       │   │   └── footer.blade.php
│       │   └── blocks/
│       ├── layouts/
│       └── pages/
└── assets/
    ├── css/
    └── js/
```

## Gestione dei Contenuti

### Struttura dei Dati
I contenuti sono organizzati in tre livelli principali:

1. **Sezioni** (`/config/local/saluteora/database/content/sections/`)
   - File numerati: `1.json`, `2.json`, ecc.
   - Ogni sezione ha un ID univoco
   - Contiene blocchi e attributi

2. **Blocchi** (`/config/local/saluteora/database/content/blocks/`)
   - File nominati: `navigation.json`, `actions.json`
   - Riutilizzabili tra sezioni
   - Supporto multilingua

3. **Pagine** (`/config/local/saluteora/database/content/pages/`)
   - Contenuti specifici delle pagine
   - Struttura personalizzata
   - Supporto multilingua

### Esempio di Struttura JSON
```json
{
    "id": 1,
    "type": "header",
    "attributes": {
        "class": "bg-white",
        "id": "main-header"
    },
    "blocks": {
        "it": [
            {
                "type": "navigation",
                "data": {
                    "items": [
                        {
                            "title": "Home",
                            "url": "/",
                            "attributes": {
                                "class": "nav-link"
                            }
                        },
                        {
                            "title": "Servizi",
                            "url": "/servizi",
                            "attributes": {
                                "class": "nav-link"
                            }
                        }
                    ]
                }
            }
        ],
        "en": [
            {
                "type": "navigation",
                "data": {
                    "items": [
                        {
                            "title": "Home",
                            "url": "/",
                            "attributes": {
                                "class": "nav-link"
                            }
                        },
                        {
                            "title": "Services",
                            "url": "/services",
                            "attributes": {
                                "class": "nav-link"
                            }
                        }
                    ]
                }
            }
        ]
    }
}
```

### Best Practices

1. **Modifica dei Contenuti**
   - Modificare i file JSON invece del codice
   - Mantenere la struttura coerente
   - Aggiornare tutte le traduzioni
   - Versionare i contenuti

2. **Struttura dei Dati**
   - Usare ID numerici per le sezioni
   - Organizzare i blocchi per lingua
   - Mantenere la coerenza tra sezioni
   - Documentare le modifiche

3. **Performance**
   - Cache dei contenuti
   - Lazy loading dei blocchi
   - Ottimizzazione delle query
   - Minificazione dei JSON

4. **Manutenzione**
   - Testare le traduzioni
   - Verificare la coerenza
   - Aggiornare la documentazione
   - Monitorare le performance

## Convenzioni di Naming

### Cartelle
- Usare sempre minuscole
- Usare trattini per spazi: `my-folder`
- Esempi corretti:
  - `database` non `Database`
  - `resources` non `Resources`
  - `config` non `Config`

### File
- Usare minuscole per i nomi
- Usare underscore per spazi: `my_file.php`
- Esempi corretti:
  - `header.blade.php` non `Header.blade.php`
  - `theme_service.php` non `ThemeService.php`

### Namespace
- Usare PascalCase per i namespace
- Usare PascalCase per le classi
- Esempi corretti:
  - `Theme\One\Providers\ThemeServiceProvider`
  - `Theme\One\Components\Header`

### File JSON
- Usare numeri per le sezioni: `1.json`, `2.json`
- Usare nomi descrittivi per i blocchi
- Mantenere la struttura coerente

## Best Practices

1. **Struttura**
   - Mantenere la coerenza nelle maiuscole/minuscole
   - Seguire le convenzioni di naming
   - Verificare i percorsi prima di ogni modifica

2. **Documentazione**
   - Usare sempre minuscole nei percorsi
   - Mantenere la coerenza con la struttura
   - Aggiornare la documentazione quando si modifica la struttura

3. **Sviluppo**
   - Verificare i percorsi prima di ogni commit
   - Mantenere la coerenza tra ambienti
   - Testare su sistemi case-sensitive

## Blocchi Disponibili

Il tema One include i seguenti blocchi:

### Hero
Un blocco hero per le pagine principali con titolo, sottotitolo, immagine e call-to-action.

### Feature Sections
Sezioni di caratteristiche con icone, titoli e descrizioni.

### Team
Sezione per visualizzare i membri del team con foto, nomi, ruoli e biografie.

### Stats
Statistiche con numeri e etichette.

### CTA
Call-to-action con titolo, descrizione e pulsante.

## Personalizzazione

### Modificare le Viste
Le viste possono essere modificate nella directory `resources/views`.

### Modificare gli Assets
Gli assets CSS e JavaScript possono essere modificati nella directory `assets`.

### Configurazione
La configurazione del tema può essere modificata nel file `config/theme.php`.

## Integrazione con Laravel Folio

Il tema One utilizza Laravel Folio per la gestione delle rotte del frontend. Le pagine sono definite nella directory `resources/views/pages` e seguono la convenzione di naming di Folio.

Esempio:
- `resources/views/pages/about.blade.php` -> `/about`
- `resources/views/pages/blog/[slug].blade.php` -> `/blog/{slug}`

## Integrazione con il Modulo CMS

Il tema One si integra con il modulo CMS per la gestione dei contenuti. I contenuti sono definiti in file JSON nella directory `config/local/saluteora/database/content/pages`.

## Supporto

Per supporto tecnico, contattare il team il progetto.

# Tema One

## Struttura
- [Componenti](./components.md) - Componenti UI riutilizzabili
- [Stili](./styles.md) - Gestione stili e variabili CSS
- [Layout](./layouts.md) - Layout e strutture di pagina

## Best Practices
1. **Componenti**
   - Mantenere contrasto adeguato
   - Usare colori della palette
   - Testare la visibilità

2. **Stili**
   - Definire variabili CSS
   - Usare classi Tailwind
   - Mantenere coerenza

3. **Layout**
   - Seguire la struttura
   - Testare responsive
   - Documentare modifiche

## Collegamenti
- [Modulo UI](../../Modules/UI/docs/README.md)
- [Modulo Cms](../../Modules/Cms/docs/README.md)

## Struttura del Tema

### Componenti
- **Sezioni**
  - `header.blade.php`: Header principale del sito
  - `footer.blade.php`: Footer principale con supporto per contenuti dinamici
- **Filament**
  - `resources/views/filament/`: Componenti e widget Filament personalizzati
  - Tutti i componenti seguono le convenzioni di stile di Filament

### Stili
- **CSS**
  - Utilizzo dei preset Filament per Tailwind
  - Sistema di colori basato su variabili CSS
  - Classi di utilità prefissate con `fi-`
  - Supporto per tema chiaro/scuro

### Best Practices
1. **Componenti**
   - Usare i componenti Filament quando possibile
   - Mantenere la coerenza con gli stili Filament
   - Seguire le convenzioni di naming di Filament

2. **Stili**
   - Usare le classi `fi-` per gli elementi UI
   - Mantenere la palette colori coerente
   - Testare in modalità chiara e scura

3. **Form e Widget**
   - Utilizzare i form builder di Filament
   - Mantenere la struttura dei widget coerente
   - Seguire le linee guida di accessibilità

### Routing
- **Auth**
  - `/it/auth/register` → `pages/auth/register.blade.php`
  - `/it/auth/login` → `pages/auth/login.blade.php`

### Best Practices
1. **Sezioni**
   - Usare i componenti di sezione per header e footer
   - Non duplicare logica di presentazione nei widget
   - Gestire i contenuti dinamici tramite props

2. **Widgets**
   - Concentrarsi sulla logica di business
   - Delegare la presentazione ai componenti
   - Mantenere la separazione delle responsabilità

## Note Importanti
- **Lo script `copy` è irrinunciabile**: copia gli asset compilati nella directory pubblica (`../../../public_html/themes/One`).

## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
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
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

---

## Politica, Filosofia, Religione, Etica, Zen

- **Politica**: Il progetto promuove la collaborazione, la trasparenza e l'inclusività, evitando ogni forma di discriminazione o pregiudizio.
- **Filosofia**: Si ispira ai principi del minimalismo, della chiarezza e della ricerca continua del miglioramento.
- **Religione**: Il progetto è laico e rispetta tutte le fedi, promuovendo la libertà di pensiero e la convivenza.
- **Etica**: Ogni contributo deve essere guidato da onestà, rispetto, responsabilità e attenzione all'impatto sociale e ambientale.
- **Zen**: Si valorizza la semplicità, la concentrazione sul presente, l'armonia tra le parti e la serenità nel processo di sviluppo.

