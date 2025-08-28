# Tema One - SaluteOra

## Panoramica

Il Tema One è il tema principale del sistema SaluteOra, caratterizzato da un design professionale e medico che riflette la natura del sistema sanitario.

## Caratteristiche

### Design
- **Stile**: Professionale e medico
- **Colori**: Blu navy (#001F3F) e bianco (#FFFFFF)
- **Tipografia**: Font moderni e leggibili
- **Layout**: Responsive e accessibile

### Favicon Personalizzato
Il tema include un favicon personalizzato ispirato al logo principale di SaluteOra:
- **Design**: Iniziali "SO" in cerchio blu navy
- **Formati**: SVG e ICO per massima compatibilità
- **Stile**: Coerente con l'identità visiva del sistema

## Struttura del Tema

```
themes/One/
├── assets/                    # Asset compilati
├── images/                    # Immagini del tema
├── public/                    # File pubblici
│   ├── favicon.ico           # Favicon binario
│   ├── favicon.svg           # Favicon vettoriale
│   ├── favicon-example.html  # Esempio implementazione
│   └── assets/               # CSS e JS compilati
├── manifest.json             # Configurazione Vite
├── theme-config.json         # Configurazione tema
├── favicon-documentation.md  # Documentazione favicon
└── README.md                 # Questo file
```

## Installazione

### 1. Copia del Tema
```bash
cp -r themes/One /path/to/your/project/themes/
```

### 2. Configurazione Favicon
Aggiungi al tuo HTML:
```html
<link rel="icon" type="image/x-icon" href="themes/One/public/favicon.ico">
<link rel="icon" type="image/svg+xml" href="themes/One/public/favicon.svg">
```

### 3. Meta Tags
```html
<meta name="theme-color" content="#001F3F">
<meta name="description" content="Tema One per sistema SaluteOra">
```

## Personalizzazione

### Colori
I colori principali del tema sono definiti in `theme-config.json`:
- **Primary**: #001F3F (Blu navy)
- **Secondary**: #FFFFFF (Bianco)
- **Accent**: #3B82F6 (Blu accent)

### Favicon
Per personalizzare il favicon:
1. Modifica `public/favicon.svg`
2. Regenera `public/favicon.ico`
3. Aggiorna `theme-config.json`

## Sviluppo

### Build Assets
```bash
cd themes/One
npm install
npm run build
```

### Watch Mode
```bash
npm run dev
```

### Test
```bash
npm run test
```

## Compatibilità

### Browser
- Chrome 4+
- Firefox 3+
- Safari 4+
- Edge 12+
- Internet Explorer 9+

### Dispositivi
- Desktop
- Tablet
- Mobile
- Retina/High-DPI

## Documentazione

- [Documentazione Favicon](favicon-documentation.md)
- [Configurazione Tema](theme-config.json)
- [Manifest](manifest.json)

## Supporto

Per supporto tecnico o domande sul tema:
- Consulta la documentazione
- Controlla i file di esempio
- Verifica la configurazione

## Licenza

Questo tema è parte del sistema SaluteOra e segue le stesse licenze del progetto principale.

---

**Versione**: 1.0.0
**Ultimo Aggiornamento**: Dicembre 2024
**Responsabile**: Team Design SaluteOra
