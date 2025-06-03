# Componenti UI

## Introduzione

Questo documento descrive in dettaglio i componenti UI disponibili nel tema "One". Ogni componente è progettato seguendo i principi di minimalismo, funzionalità e accessibilità.

## Componenti Base

### Button

#### Varianti
```html
<!-- Primary -->
<button class="button" data-variant="primary">
  <span class="button__text">Primary</span>
</button>

<!-- Secondary -->
<button class="button" data-variant="secondary">
  <span class="button__text">Secondary</span>
</button>

<!-- Outline -->
<button class="button" data-variant="outline">
  <span class="button__text">Outline</span>
</button>

<!-- Text -->
<button class="button" data-variant="text">
  <span class="button__text">Text</span>
</button>
```

#### Stati
```html
<!-- Disabled -->
<button class="button" disabled>
  <span class="button__text">Disabled</span>
</button>

<!-- Loading -->
<button class="button" data-loading="true">
  <span class="button__text">Loading</span>
  <span class="button__loader"></span>
</button>
```

#### Dimensioni
```html
<!-- Small -->
<button class="button" data-size="sm">
  <span class="button__text">Small</span>
</button>

<!-- Medium -->
<button class="button" data-size="md">
  <span class="button__text">Medium</span>
</button>

<!-- Large -->
<button class="button" data-size="lg">
  <span class="button__text">Large</span>
</button>
```

### Card

#### Base
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

#### Varianti
```html
<!-- Elevated -->
<div class="card" data-variant="elevated">
  <!-- Contenuto -->
</div>

<!-- Outlined -->
<div class="card" data-variant="outlined">
  <!-- Contenuto -->
</div>

<!-- Interactive -->
<div class="card" data-variant="interactive">
  <!-- Contenuto -->
</div>
```

### Form Elements

#### Input
```html
<div class="form-group">
  <label class="form-label" for="input">Etichetta</label>
  <input 
    class="form-input" 
    id="input" 
    type="text" 
    placeholder="Placeholder"
  >
  <div class="form-help">Testo di aiuto</div>
</div>
```

#### Select
```html
<div class="form-group">
  <label class="form-label" for="select">Seleziona</label>
  <select class="form-select" id="select">
    <option value="">Seleziona un'opzione</option>
    <option value="1">Opzione 1</option>
    <option value="2">Opzione 2</option>
  </select>
</div>
```

#### Checkbox
```html
<div class="form-group">
  <label class="checkbox">
    <input type="checkbox" class="checkbox__input">
    <span class="checkbox__label">Accetta i termini</span>
  </label>
</div>
```

### Navigation

#### Navbar
```html
<nav class="navbar">
  <div class="navbar__brand">
    <a href="/" class="navbar__logo">Logo</a>
  </div>
  <div class="navbar__menu">
    <a href="#" class="navbar__link">Link 1</a>
    <a href="#" class="navbar__link">Link 2</a>
    <a href="#" class="navbar__link">Link 3</a>
  </div>
</nav>
```

#### Breadcrumb
```html
<nav class="breadcrumb">
  <a href="#" class="breadcrumb__item">Home</a>
  <span class="breadcrumb__separator">/</span>
  <a href="#" class="breadcrumb__item">Sezione</a>
  <span class="breadcrumb__separator">/</span>
  <span class="breadcrumb__item">Pagina</span>
</nav>
```

## Componenti Avanzati

### Modal
```html
<div class="modal" data-modal="example">
  <div class="modal__overlay"></div>
  <div class="modal__content">
    <div class="modal__header">
      <h3 class="modal__title">Titolo</h3>
      <button class="modal__close">&times;</button>
    </div>
    <div class="modal__body">
      <p>Contenuto</p>
    </div>
    <div class="modal__footer">
      <button class="button">Chiudi</button>
    </div>
  </div>
</div>
```

### Accordion
```html
<div class="accordion">
  <div class="accordion__item">
    <button class="accordion__header">
      <span class="accordion__title">Titolo 1</span>
      <span class="accordion__icon">+</span>
    </button>
    <div class="accordion__content">
      <p>Contenuto 1</p>
    </div>
  </div>
  <!-- Altri items -->
</div>
```

### Tabs
```html
<div class="tabs">
  <div class="tabs__header">
    <button class="tabs__button" data-tab="1">Tab 1</button>
    <button class="tabs__button" data-tab="2">Tab 2</button>
    <button class="tabs__button" data-tab="3">Tab 3</button>
  </div>
  <div class="tabs__content">
    <div class="tabs__panel" data-tab="1">
      <p>Contenuto 1</p>
    </div>
    <div class="tabs__panel" data-tab="2">
      <p>Contenuto 2</p>
    </div>
    <div class="tabs__panel" data-tab="3">
      <p>Contenuto 3</p>
    </div>
  </div>
</div>
```

## Best Practices

### Accessibilità
- Utilizzare ARIA attributes
- Implementare keyboard navigation
- Fornire alternative testuali
- Mantenere contrasto adeguato

### Performance
- Ottimizzare animazioni
- Implementare lazy loading
- Minimizzare DOM
- Utilizzare CSS efficiente

### Responsive
- Mobile-first approach
- Breakpoints chiari
- Layout fluidi
- Touch-friendly

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

- [Sistema di Design](../design_system.md)
- [Roadmap](../roadmap.md)
- [Guida allo Stile](../style_guide.md)
- [Best Practices](../best_practices.md) 
