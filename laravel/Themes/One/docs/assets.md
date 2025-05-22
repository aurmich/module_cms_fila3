# Gestione Assets

## Introduzione

Questo documento descrive le linee guida per la gestione degli assets (icone, immagini, font) nel tema "One".

## Icone

### Sistema di Icone

#### SVG Sprite
```html
<!-- Utilizzo -->
<svg class="icon">
  <use xlink:href="/assets/icons/sprite.svg#icon-name"></use>
</svg>
```

#### Icone Inline
```html
<!-- Utilizzo -->
<button class="button">
  <svg class="icon" width="24" height="24" viewBox="0 0 24 24">
    <path d="M12 2L1 21h22L12 2zm0 3.99L19.53 19H4.47L12 5.99z"/>
  </svg>
  <span>Testo</span>
</button>
```

### Best Practices
- Utilizzare SVG per scalabilità
- Ottimizzare path SVG
- Implementare fallback
- Gestire colori con currentColor
- Fornire alternative testuali

## Immagini

### Formati Supportati
- WebP (preferito)
- JPEG
- PNG
- SVG

### Ottimizzazione
```html
<!-- Picture Element -->
<picture>
  <source srcset="image.webp" type="image/webp">
  <source srcset="image.jpg" type="image/jpeg">
  <img src="image.jpg" alt="Descrizione">
</picture>

<!-- Lazy Loading -->
<img 
  src="placeholder.jpg"
  data-src="image.jpg"
  class="lazy"
  alt="Descrizione"
>

<!-- Responsive -->
<img 
  src="image.jpg"
  srcset="image-320w.jpg 320w,
          image-480w.jpg 480w,
          image-800w.jpg 800w"
  sizes="(max-width: 320px) 280px,
         (max-width: 480px) 440px,
         800px"
  alt="Descrizione"
>
```

### Best Practices
- Ottimizzare dimensioni
- Implementare lazy loading
- Fornire alternative
- Gestire errori
- Utilizzare placeholder

## Font

### Font System
```css
:root {
  --font-system: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, 
                 Helvetica, Arial, sans-serif, "Apple Color Emoji", 
                 "Segoe UI Emoji", "Segoe UI Symbol";
}
```

### Font Personalizzati
```css
@font-face {
  font-family: 'Custom Font';
  src: url('/assets/fonts/custom.woff2') format('woff2'),
       url('/assets/fonts/custom.woff') format('woff');
  font-weight: normal;
  font-style: normal;
  font-display: swap;
}
```

### Best Practices
- Utilizzare font system
- Implementare font-display
- Ottimizzare formati
- Gestire fallback
- Preload font critici

## Struttura Directory

```
assets/
├── icons/
│   ├── sprite.svg
│   └── individual/
├── images/
│   ├── content/
│   ├── backgrounds/
│   └── logos/
├── fonts/
│   ├── custom.woff2
│   └── custom.woff
└── styles/
    └── variables.css
```

## Ottimizzazione

### Build Process
- Minificare SVG
- Ottimizzare immagini
- Convertire formati
- Generare sprite
- Gestire cache

### Performance
- Implementare preload
- Gestire priorità
- Ottimizzare dimensioni
- Utilizzare CDN
- Implementare caching

## Metriche di Successo

### Performance
- Tempo di caricamento
- Dimensione assets
- Utilizzo cache
- Lazy loading
- Priorità risorse

### Qualità
- Qualità immagini
- Scalabilità icone
- Leggibilità font
- Coerenza visiva
- Accessibilità

## Collegamenti

- [Sistema di Design](../design_system.md)
- [Componenti](../components.md)
- [Guida allo Stile](../style_guide.md)
- [Best Practices](../best_practices.md) 
