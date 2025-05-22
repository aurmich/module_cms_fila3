# Processo di Build del Tema One

## Prerequisiti

- Node.js (v18+)
- npm (v9+)
- Laravel Vite Plugin
- Tailwind CSS
- Alpine.js e i suoi plugin

## Struttura dei File

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

## Installazione delle Dipendenze

```bash
npm install
```

Questo installerà tutte le dipendenze necessarie, incluse:

- Tailwind CSS e i suoi plugin
- Alpine.js e i suoi plugin (@alpinejs/focus, @alpinejs/collapse, @alpinejs/persist)
- PostCSS e i suoi plugin
- Vite e Laravel Vite Plugin

## Script di Build

Il `package.json` contiene tre script principali:

1. `dev`: Avvia il server di sviluppo Vite
2. `build`: Compila gli asset per la produzione
3. `copy`: Copia gli asset compilati nella directory pubblica del progetto

Lo script `copy` è fondamentale perché:

- Copia gli asset compilati da `./public*` a `../../../public_html/themes/One`
- Mantiene sincronizzati gli asset tra il tema e la directory pubblica
- Permette al frontend di accedere agli asset compilati
- È necessario per il corretto funzionamento del tema in produzione

## Configurazione di Tailwind CSS

Il file `tailwind.config.js` è configurato per utilizzare il preset di Filament e include una palette di colori personalizzata:

```javascript
import preset from '../../vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
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
                    950: '#082f49',
                }
            }
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
```

## Configurazione di Vite

Il file `vite.config.js` è configurato per utilizzare il plugin Laravel e gestire correttamente i percorsi:

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            buildDirectory: 'build/theme-one'
        }),
    ],
    build: {
        outDir: './public',
        emptyOutDir: false,
        manifest: 'manifest.json',
        rollupOptions: {
            external: [
                'jquery'
            ]
        }
    },
    resolve: {
        alias: {
            '@': '/resources/js'
        }
    }
});
```

## Processo di Build Completo

1. Pulire la cache di npm:
```bash
npm cache clean --force
```

2. Rimuovere node_modules:
```bash
rm -rf node_modules
```

3. Installare le dipendenze:
```bash
npm install
```

4. Eseguire il build:
```bash
npm run build
```

5. Copiare gli asset nella directory pubblica:
```bash
npm run copy
```

## Best Practices

1. Eseguire sempre `npm install` dopo aver modificato il `package.json`
2. Pulire la cache di Laravel dopo il build:
```bash
php artisan cache:clear
php artisan view:clear
```
3. In sviluppo, utilizzare `npm run dev` per il build in tempo reale
4. In produzione, utilizzare `npm run build` seguito da `npm run copy`
5. Verificare sempre che gli asset siano stati copiati correttamente nella directory pubblica

## Troubleshooting

### Errori di Tailwind

Se Tailwind non viene compilato correttamente:
1. Verificare che il file `postcss.config.js` sia configurato correttamente
2. Assicurarsi che tutti i plugin di Tailwind siano installati
3. Controllare che i percorsi nel `tailwind.config.js` siano corretti

### Errori di Compilazione

Se il build fallisce:
1. Verificare che tutte le dipendenze siano installate
2. Controllare che i percorsi nel `vite.config.js` siano corretti
3. Assicurarsi che non ci siano errori di sintassi nei file JS/CSS

### Errori di Caricamento Asset

Se gli asset non vengono caricati correttamente:
1. Verificare che il `buildDirectory` nel `vite.config.js` sia corretto
2. Controllare che i file di manifest siano generati correttamente
3. Assicurarsi che i percorsi nelle view Blade siano corretti
4. Verificare che lo script `copy` sia stato eseguito correttamente
5. Controllare i permessi della directory `public_html/themes/One`

### Errori di ESM

Se ci sono errori relativi ai moduli ES:
1. Verificare che `"type": "module"` sia presente nel `package.json`
2. Controllare che tutti i file di configurazione utilizzino la sintassi ESM
3. Assicurarsi che le importazioni nei file JS utilizzino la sintassi corretta

### Errori di Alpine.js

Se Alpine.js non funziona correttamente:
1. Verificare che tutte le dipendenze di Alpine.js siano installate
2. Controllare che i plugin siano importati correttamente nel file JS principale
3. Assicurarsi che Alpine.js sia inizializzato prima dell'uso dei suoi plugin 