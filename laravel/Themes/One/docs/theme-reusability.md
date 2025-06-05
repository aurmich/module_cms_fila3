# Riutilizzabilità del Tema One

## Pacchetto NPM

Il tema One è pubblicato come pacchetto npm:
```json
{
    "name": "laraxot/theme_one_fila3",
    "description": "Tema riutilizzabile per progetti Laravel con Filament 3"
}
```

## Caratteristiche di Riutilizzabilità

1. **Indipendenza dal Progetto**
   - Il tema è completamente indipendente da il progetto
   - Può essere utilizzato in qualsiasi progetto Laravel + Filament 3
   - Non contiene logica specifica di business

2. **Gestione Assets**
   - Lo script `copy` deve essere adattato al progetto specifico
   - Il percorso `public_html/themes/One` è solo un esempio
   - Ogni progetto può definire il proprio percorso di destinazione

3. **Configurazione**
   - Il tema è configurabile tramite file di configurazione
   - Le variabili di stile sono personalizzabili
   - I componenti sono modulari e riutilizzabili

## Installazione in Altri Progetti

1. **Installazione NPM**
```bash
npm install laraxot/theme_one_fila3
```

2. **Configurazione package.json**
```json
{
    "scripts": {
        "copy": "cp -r ./public* PATH_TO_YOUR_PUBLIC_THEME_DIRECTORY"
    }
}
```

3. **Struttura Consigliata**
```
your-project/
├── public/
│   └── themes/
│       └── one/
└── resources/
    └── themes/
        └── one/
```

## Best Practices per la Riutilizzabilità

1. **Configurazione**
   - Mantenere le configurazioni specifiche del progetto separate
   - Utilizzare variabili d'ambiente quando necessario
   - Documentare tutte le opzioni di configurazione

2. **Assets**
   - Adattare lo script `copy` al proprio progetto
   - Mantenere una struttura coerente degli assets
   - Documentare eventuali dipendenze specifiche

3. **Personalizzazione**
   - Utilizzare il sistema di override dei componenti
   - Mantenere le personalizzazioni in un tema child
   - Non modificare direttamente i file del tema

## Collegamenti

- [Documentazione NPM](https://www.npmjs.com/package/laraxot/theme_one_fila3)
- [Processo di Build](build-process.md)
- [Gestione Assets](theme-assets.md)
- [Struttura del Tema](theme-structure.md)
- [Documentazione CMS](../../Modules/Cms/docs/themes/reusability.md)
- [Root Documentation](../../../docs/themes/reusability.md) 
## Collegamenti tra versioni di theme-reusability.md
* [theme-reusability.md](laravel/Modules/Cms/docs/best-practices/theme-reusability.md)
* [theme-reusability.md](laravel/Themes/One/docs/best_practices/theme-reusability.md)
* [theme-reusability.md](laravel/Themes/One/docs/theme-reusability.md)

