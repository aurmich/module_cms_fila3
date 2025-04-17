# Processo di Build e Pubblicazione del Tema

## Panoramica

Il modulo CMS utilizza un tema principale definito nella cartella `laravel/Themes/One`. Questo documento spiega il processo di compilazione e pubblicazione degli asset del tema, con particolare attenzione ai comandi `npm run build` e `npm run copy` che sono essenziali per lo sviluppo frontend.

## Indice

1. [Struttura del Tema](#struttura-del-tema)
2. [Processo di Build](#processo-di-build)
3. [Pubblicazione degli Asset](#pubblicazione-degli-asset)
4. [Flusso di Lavoro Consigliato](#flusso-di-lavoro-consigliato)
5. [Troubleshooting](#troubleshooting)

## Struttura del Tema

Il tema "One" è organizzato con la seguente struttura:

```
laravel/Themes/One/
├── resources/           # Risorse sorgente
│   ├── css/             # File CSS e Tailwind
│   ├── js/              # File JavaScript
│   ├── views/           # Viste Blade
│   └── dist/            # Output della build (generato)
├── vite.config.js       # Configurazione Vite
├── tailwind.config.js   # Configurazione Tailwind
└── package.json         # Dipendenze e script NPM
```

Il processo di build trasforma i file sorgente in `resources/css` e `resources/js` in asset ottimizzati che vengono salvati in `resources/dist`.

## Processo di Build

### 1. Compilazione con Vite

Il tema utilizza [Vite](https://vitejs.dev/) come bundler per compilare i file CSS e JavaScript. La configurazione è definita in `vite.config.js`:

```javascript
// Estratto da vite.config.js
export default defineConfig({
    build: {
        outDir: __dirname + '/resources/dist',
        emptyOutDir: false,
        manifest: 'manifest.json'
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        })
    ]
});
```

Quando si esegue `npm run build`, Vite:

1. Legge i file sorgente in `resources/css/app.css` e `resources/js/app.js`
2. Processa i file CSS attraverso PostCSS e Tailwind
3. Compila i file JavaScript, inclusi i moduli importati
4. Ottimizza e minimizza i file per la produzione
5. Genera i file di output nella cartella `resources/dist`
6. Crea un file `manifest.json` con il mapping dei file originali ai file compilati

### 2. Tailwind CSS

Il tema utilizza Tailwind CSS per lo styling. La configurazione è definita in `tailwind.config.js` e include:

- I percorsi dei file da analizzare per le classi Tailwind
- Estensioni del tema (colori, font, ecc.)
- Plugin aggiuntivi (forms, typography)

Durante il processo di build, Tailwind genera il CSS finale includendo solo le classi effettivamente utilizzate nei file (purging).

## Pubblicazione degli Asset

### Comando `npm run copy`

Dopo aver compilato gli asset, è necessario pubblicarli nella cartella pubblica del server web. Questo viene fatto con il comando `npm run copy`, che:

1. Copia tutti i file generati in `resources/dist` 
2. Li posiziona nella cartella pubblica `public_html/themes/One`

Il comando è definito in `package.json`:

```json
{
    "scripts": {
        "copy": "cp -r ./resources/dist/* ../../../public_html/themes/One"
    }
}
```

Questo passaggio è cruciale perché sposta gli asset compilati in una posizione accessibile dal web. Senza questo passaggio, le modifiche non sarebbero visibili agli utenti.

## Flusso di Lavoro Consigliato

### Sviluppo

1. Naviga nella cartella del tema:
   ```bash
   cd /var/www/html/saluteora/laravel/Themes/One
   ```

2. Esegui la build in modalità watch durante lo sviluppo:
   ```bash
   npm run dev
   # oppure
   npm run watch
   ```

3. Al termine delle modifiche, compila per la produzione:
   ```bash
   npm run build
   ```

4. Pubblica gli asset:
   ```bash
   npm run copy
   ```

### Produzione

In ambiente di produzione, è consigliato utilizzare:

```bash
cd /var/www/html/saluteora/laravel/Themes/One
npm ci           # Installa le dipendenze esatte
npm run build    # Compila per la produzione
npm run copy     # Pubblica gli asset
```

### Automatizzazione

È possibile automatizzare il processo creando uno script bash:

```bash
#!/bin/bash
cd /var/www/html/saluteora/laravel/Themes/One
npm run build
npm run copy
echo "Theme assets built and published successfully!"
```

## Motivazione dell'Architettura

Questa architettura offre diversi vantaggi:

1. **Separazione delle preoccupazioni**: I file sorgente sono separati dai file compilati
2. **Controllo versione ottimizzato**: Solo i file sorgente vengono tracciati in Git, non i file compilati
3. **Prestazioni ottimizzate**: Gli asset vengono minimizzati e ottimizzati per la produzione
4. **Sviluppo modulare**: Il tema può essere sviluppato indipendentemente dall'applicazione principale
5. **Isolamento dell'ambiente**: I moduli non interferiscono tra loro durante il processo di build

### Perché due step separati?

La separazione tra `build` e `copy` è intenzionale e offre diversi vantaggi:

1. **Test in isolamento**: È possibile verificare che il build funzioni correttamente prima di pubblicare
2. **Rollback semplificato**: In caso di problemi, è più facile tornare a una versione precedente
3. **Flessibilità di deployment**: Lo stesso build può essere pubblicato in ambienti diversi
4. **Prestazioni di build**: Separare la compilazione dalla copia migliora le prestazioni del processo

## Troubleshooting

### Problema: Le modifiche CSS non sono visibili

1. Verifica che il build sia stato eseguito: `npm run build`
2. Verifica che gli asset siano stati copiati: `npm run copy`
3. Controlla che il browser non stia utilizzando la cache: premi Ctrl+F5

### Problema: Errori di compilazione

Se incontri errori durante la compilazione:

1. Controlla i log di errore di NPM
2. Verifica che tutte le dipendenze siano installate: `npm install`
3. Assicurati che i file sorgente referenziati in `vite.config.js` esistano

### Problema: Asset non trovati

Se il browser non riesce a trovare gli asset:

1. Verifica che `npm run copy` sia stato eseguito correttamente
2. Controlla i percorsi nel file `manifest.json`
3. Assicurati che i file esistano in `public_html/themes/One`

## Conclusione

Il processo di build e pubblicazione del tema è un aspetto fondamentale dello sviluppo frontend nel modulo CMS. Seguendo il flusso di lavoro consigliato e comprendendo l'architettura sottostante, gli sviluppatori possono mantenere un processo di sviluppo efficiente e organizzato. 
