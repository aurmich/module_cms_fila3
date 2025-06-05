# Tema One – Tema Frontend Moderno e Riusabile

## Introduzione

Tema One è un tema frontend moderno e altamente personalizzabile basato su:
- Laravel 10+
- Filament 3.3+ (per l'admin panel)
- Volt (per la gestione delle viste)
- Folio (per il routing)
- Laraxot (per l'estensibilità)

Può essere utilizzato sia come tema generico per progetti multipli, sia come tema predefinito per istanze specifiche come il progetto.

## 🎯 Caratteristiche Principali

- Design moderno e responsive
- Integrazione completa con Filament Admin
- Sistema di blocchi modulari
- Supporto multilingua
- Ottimizzato per SEO
- Performance ottimizzata
- Facile personalizzazione

> Consulta la documentazione dettagliata nella [cartella docs](docs/) del modulo e nella cartella docs principale del progetto per best practices, installazione, roadmap e altro.

## 📊 Roadmap

Per la roadmap completa e lo stato di sviluppo, consulta [docs/roadmap.md](docs/roadmap.md)

## 🛠️ Requisiti

- PHP 8.1+
- Laravel 10+
- Filament 3.3+
- Node.js 16+
- NPM 8+

## 🚀 Installazione

1. Aggiungi il tema al tuo `composer.json` (adatta il nome del pacchetto se usato in progetti diversi):

```json
{
    "require": {
        "saluteora/theme-one": "^1.0"
    }
}
```

2. Esegui l'installazione:

```bash
composer update
```

3. Pubblica gli asset del tema:

```bash
php artisan vendor:publish --tag=theme-one-assets
php artisan vendor:publish --tag=theme-one-views
php artisan vendor:publish --tag=theme-one-config
```

3. **IMPORTANTE:** Con Filament 3.x è OBBLIGATORIO usare solo le seguenti dipendenze (come da [Filament Docs](https://filamentphp.com/docs/3.x/notifications/installation#installing-tailwind-css)):
  ```sh
  npm install tailwindcss@3 @tailwindcss/forms @tailwindcss/typography postcss postcss-nesting autoprefixer --save-dev
  npm run build
  ```

4. Installa le dipendenze NPM:

```bash
npm install
```

5. Compila gli asset:

```bash
npm run build
```

## ⚙️ Configurazione

### Tailwind CSS

Il tema utilizza Tailwind CSS per lo styling. Assicurati che i seguenti file siano configurati correttamente:
1. `postcss.config.js`:

```js
module.exports = {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
}
```

2. `tailwind.config.js`:

```js
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './vendor/saluteora/theme-one/resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
```

3. `vite.config.js`:

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
```

## 📁 Struttura del Tema

```
laravel/Themes/One/
├── app/
│   └── Providers/
│       └── ThemeServiceProvider.php
├── config/
│   └── theme.php
├── resources/
│   ├── views/
│   │   ├── components/
│   │   │   ├── ui/          # Componenti UI di base
│   │   │   ├── layouts/     # Layout principali
│   │   │   └── blocks/      # Blocchi di contenuto
│   │   └── pages/
│   │       ├── pages/
│   │       │   └── [slug].blade.php
│   │       └── it/
│   │           └── pages/
│   └── assets/
├── routes/
│   └── web.php
└── docs/
    ├── roadmap.md
    ├── blocks.md
    ├── folio.md
    └── installation.md
```

## 🧩 Componenti Disponibili

### UI Components
- `application-logo` - Logo dell'applicazione
- `dropdown` - Menu a tendina
- `dropdown-link` - Link per menu a tendina
- `input-error` - Messaggi di errore per input
- `input-label` - Etichette per input
- `nav-link` - Link di navigazione
- `primary-button` - Pulsante primario
- `responsive-nav-link` - Link di navigazione responsive
- `text-input` - Input di testo

### Layout Components
- `guest-layout` - Layout per utenti non autenticati
- `app-layout` - Layout principale dell'applicazione

### Block Components
- `hero` - Sezione hero con titolo e CTA
- `feature-sections` - Sezioni di caratteristiche
- `team` - Sezione team
- `stats` - Statistiche
- `cta` - Call to Action
- `paragraph` - Paragrafo di testo

## 🔧 Personalizzazione

### Viste
Le viste possono essere personalizzate copiandole dalla directory `resources/views` del tema nella directory `resources/views` della tua applicazione.

### Asset
Gli asset possono essere personalizzati modificando i file nella directory `resources/assets` del tema.

### Configurazione
La configurazione del tema può essere personalizzata modificando il file `config/theme.php`.

## 🔄 Integrazioni

### Filament
Il tema si integra perfettamente con Filament per la gestione dell'admin panel.

### Volt
Utilizza Volt per la gestione delle viste e dei componenti.

### Folio
Implementa Folio per il routing delle pagine frontend.

### Laraxot
Sfrutta Laraxot per l'estensibilità e la modularità.

## 📚 Documentazione

Per la documentazione completa, consulta:
- [Roadmap](docs/roadmap.md)
- [Blocchi](docs/blocks.md)
- [Folio](docs/folio.md)
- [Installazione](docs/installation.md)

## 🤝 Contribuire

1. Fork del repository
2. Crea un branch per la tua feature (`git checkout -b feature/AmazingFeature`)
3. Commit delle modifiche (`git commit -m 'Add some AmazingFeature'`)
4. Push del branch (`git push origin feature/AmazingFeature`)
5. Apri una Pull Request

## 📝 Licenza

Questo tema è open-source sotto la licenza MIT. Vedi il file `LICENSE` per maggiori dettagli.

## Integrazione con Laravel Folio

Il tema utilizza Laravel Folio per la gestione delle rotte frontend. Vedi la documentazione in `docs/folio.md` per maggiori dettagli.

## Integrazione con il CMS

Il tema si integra con il modulo CMS per la gestione dei contenuti. I blocchi di contenuto sono gestiti attraverso il modello `Page` del modulo CMS.

## Compatibilità

Assicurati che i nomi dei parametri nel database corrispondano a quelli attesi dai componenti. In particolare:

- Il blocco `feature_sections` utilizza il parametro `sections` invece di `features`
- Il blocco `stats` utilizza il parametro `number` invece di `value` per i valori delle statistiche

## Supporto

Per assistenza tecnica, contattare:
- Email: support@saluteora.com
- Documentazione: https://docs.saluteora.com
