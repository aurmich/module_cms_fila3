# Favicon Tema One - SaluteOra

## Panoramica

Il favicon per il tema One è stato progettato ispirandosi al logo principale di SaluteOra, mantenendo coerenza visiva e professionalità nel design.

## Design e Stile

### Elementi Principali
- **Iniziali "SO"**: Acronimo di "Salute Orale"
- **Cerchio di sfondo**: Blu navy (#001F3F) per professionalità
- **Testo bianco**: #FFFFFF per massimo contrasto e leggibilità
- **Stile minimalista**: Design pulito e riconoscibile anche in dimensioni ridotte

### Ispirazione
Il design si basa sul logo principale di SaluteOra:
- Stesso schema colori (blu navy + bianco)
- Stesso font family (Segoe UI, Arial, sans-serif)
- Stesso approccio professionale e medico

## File Creati

### 1. `favicon.svg`
- **Formato**: SVG vettoriale
- **ViewBox**: 32x32 pixel
- **Vantaggi**: Scalabile, leggero, supporto moderno
- **Utilizzo**: Browser moderni con supporto SVG

### 2. `favicon.ico`
- **Formato**: ICO binario
- **Risoluzioni**: 16x16, 32x32, 48x48 pixel
- **Vantaggi**: Compatibilità universale
- **Utilizzo**: Browser legacy e fallback

### 3. `favicon-example.html`
- **Scopo**: Esempio di implementazione
- **Contenuto**: HTML completo con meta tags
- **Utilizzo**: Riferimento per sviluppatori

## Implementazione

### HTML Head
```html
<!-- Favicon per tema One -->
<link rel="icon" type="image/x-icon" href="favicon.ico">
<link rel="icon" type="image/svg+xml" href="favicon.svg">

<!-- Meta tags per tema -->
<meta name="theme-color" content="#001F3F">
<meta name="description" content="Tema One per sistema SaluteOra">
```

### Struttura Directory
```
themes/One/
├── public/
│   ├── favicon.ico          # Favicon binario
│   ├── favicon.svg          # Favicon vettoriale
│   └── favicon-example.html # Esempio implementazione
├── manifest.json            # Configurazione tema
└── favicon-documentation.md # Questa documentazione
```

## Specifiche Tecniche

### SVG
- **ViewBox**: 0 0 32 32
- **Elementi**: Circle + Text
- **Font**: Segoe UI, Arial, sans-serif
- **Font-size**: 14px
- **Font-weight**: 700 (bold)

### ICO
- **Formato**: Multi-risoluzione
- **Risoluzioni**: 16x16, 32x32, 48x48
- **Profondità colore**: 32-bit con alpha
- **Compressione**: RLE per dimensioni ottimali

## Compatibilità

### Browser Supportati
- ✅ Chrome 4+
- ✅ Firefox 3+
- ✅ Safari 4+
- ✅ Edge 12+
- ✅ Internet Explorer 9+

### Dispositivi
- ✅ Desktop
- ✅ Tablet
- ✅ Mobile
- ✅ Retina/High-DPI

## Personalizzazione

### Modifica Colori
Per modificare i colori del favicon, editare `favicon.svg`:
```svg
<!-- Cambia il colore del cerchio -->
<circle cx="16" cy="16" r="15" fill="#NUOVO_COLORE" />

<!-- Cambia il colore del testo -->
<text fill="#NUOVO_COLORE">SO</text>
```

### Modifica Testo
Per cambiare le iniziali:
```svg
<text x="16" y="20" text-anchor="middle" font-family="'Segoe UI', Arial, sans-serif" font-size="14" font-weight="700" fill="#FFFFFF" dominant-baseline="middle">NUOVE_INIZIALI</text>
```

## Best Practices

### 1. **Fallback**
Utilizzare sempre entrambi i formati per massima compatibilità:
```html
<link rel="icon" type="image/x-icon" href="favicon.ico">
<link rel="icon" type="image/svg+xml" href="favicon.svg">
```

### 2. **Meta Tags**
Includere meta tags appropriati per il tema:
```html
<meta name="theme-color" content="#001F3F">
<meta name="msapplication-TileColor" content="#001F3F">
```

### 3. **Accessibilità**
Mantenere ARIA labels e title per screen reader:
```svg
<svg role="img" aria-label="Favicon SaluteOra">
  <title>SaluteOra</title>
</svg>
```

## Manutenzione

### Aggiornamenti
- Mantenere coerenza con logo principale
- Verificare compatibilità browser
- Testare su diversi dispositivi
- Aggiornare documentazione

### Versioning
- Documentare modifiche al design
- Mantenere backup delle versioni precedenti
- Testare su ambiente di staging

## Collegamenti

- [Logo Principale](../../assets/saluteora/images/logo-v2.png)
- [Logo SVG](../../assets/saluteora/images/logo.svg)
- [Documentazione Tema](../README.md)
- [Manifest Tema](manifest.json)

---

**Creato**: Dicembre 2024
**Versione**: 1.0
**Responsabile**: Team Design SaluteOra
**Ultimo Aggiornamento**: Dicembre 2024
