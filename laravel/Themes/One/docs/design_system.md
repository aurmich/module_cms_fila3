# Sistema di Design

## Introduzione

Il sistema di design del tema "One" è costruito su principi di minimalismo, funzionalità e coerenza. Questo documento descrive i componenti fondamentali, le regole e le best practices che guidano lo sviluppo del tema.

## Fondamenti

### Filosofia
- [Minimalismo Zen](../roadmap/philosophy/minimalism.md)
- [Wabi-Sabi](../roadmap/philosophy/wabi_sabi.md)
- [Less is More](../roadmap/philosophy/less_is_more.md)
- [Design Sistemico](../roadmap/philosophy/systemic_design.md)

### Ispirazioni
- [Architettura](../roadmap/inspiration/architecture.md)
- [Arte](../roadmap/inspiration/art.md)
- [Natura](../roadmap/inspiration/nature.md)

## Componenti Base

### Layout
```css
:root {
  --spacing-unit: 1rem;
  --grid-gap: var(--spacing-unit);
  --container-padding: calc(var(--spacing-unit) * 2);
  --border-radius: 4px;
}

.container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: var(--container-padding);
}

.grid {
  display: grid;
  gap: var(--grid-gap);
  grid-template-columns: repeat(12, 1fr);
}
```

### Tipografia
```css
:root {
  --font-primary: 'Helvetica Neue', sans-serif;
  --font-secondary: 'Georgia', serif;
  
  --text-xs: 0.75rem;
  --text-sm: 0.875rem;
  --text-base: 1rem;
  --text-lg: 1.125rem;
  --text-xl: 1.25rem;
  --text-2xl: 1.5rem;
  
  --line-height-tight: 1.25;
  --line-height-normal: 1.5;
  --line-height-relaxed: 1.75;
}

.heading {
  font-family: var(--font-primary);
  font-weight: 700;
  line-height: var(--line-height-tight);
}

.body {
  font-family: var(--font-secondary);
  line-height: var(--line-height-normal);
}
```

### Colori
```css
:root {
  /* Colori Primari */
  --color-primary: #007bff;
  --color-secondary: #6c757d;
  --color-accent: #ffc107;
  
  /* Colori Neutri */
  --color-white: #ffffff;
  --color-light: #f8f9fa;
  --color-gray: #6c757d;
  --color-dark: #343a40;
  --color-black: #000000;
  
  /* Colori di Stato */
  --color-success: #28a745;
  --color-warning: #ffc107;
  --color-danger: #dc3545;
  --color-info: #17a2b8;
}
```

### Componenti UI

#### Button
```html
<button class="button" data-variant="primary">
  <span class="button__text">Testo</span>
</button>
```

```css
.button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.5rem 1rem;
  border-radius: var(--border-radius);
  font-weight: 500;
  transition: all 0.3s ease;
}

.button[data-variant="primary"] {
  background-color: var(--color-primary);
  color: var(--color-white);
}

.button[data-variant="secondary"] {
  background-color: var(--color-secondary);
  color: var(--color-white);
}
```

#### Card
```html
<div class="card">
  <div class="card__header">
    <h3 class="card__title">Titolo</h3>
  </div>
  <div class="card__body">
    <p class="card__content">Contenuto</p>
  </div>
  <div class="card__footer">
    <button class="button">Azione</button>
  </div>
</div>
```

```css
.card {
  background: var(--color-white);
  border-radius: var(--border-radius);
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  padding: var(--spacing-unit);
}

.card__header {
  margin-bottom: var(--spacing-unit);
}

.card__body {
  margin-bottom: var(--spacing-unit);
}

.card__footer {
  margin-top: var(--spacing-unit);
}
```

## Best Practices

### Accessibilità
- Utilizzare contrasto adeguato
- Implementare focus states
- Fornire alternative testuali
- Supportare navigazione da tastiera

### Performance
- Ottimizzare risorse
- Implementare lazy loading
- Minimizzare CSS/JS
- Utilizzare caching

### Responsive Design
- Mobile-first approach
- Breakpoints chiari
- Layout fluidi
- Immagini responsive

## Metriche di Successo

### Qualità
- Coerenza visiva
- Performance ottimale
- Accessibilità completa
- Manutenibilità

### Usabilità
- Intuitività
- Efficienza
- Soddisfazione utente
- Tasso di conversione

## Collegamenti

- [Roadmap](../roadmap.md)
- [Componenti](../components.md)
- [Guida allo Stile](../style_guide.md)
- [Best Practices](../best_practices.md) 
