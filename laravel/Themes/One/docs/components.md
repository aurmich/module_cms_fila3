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

## Logo

Il componente `x-ui.logo` è un SVG che rappresenta il logo dell'applicazione. 

### Utilizzo Base
```blade
<x-ui.logo />
```

### Dimensioni
- Dimensione predefinita: altezza 64px (h-16) con larghezza automatica
- Le dimensioni possono essere sovrascritte passando classi Tailwind:
```blade
<x-ui.logo class="h-8 w-auto" />
```

### Colori
- Il colore può essere controllato attraverso la classe `text-{color}` grazie all'uso di `currentColor` nell'SVG
- Supporta il tema chiaro/scuro attraverso le classi `dark:`

### Best Practices
- Mantenere le proporzioni usando `w-auto`
- Per header e navbar, usare dimensioni tra h-8 e h-16
- Per hero sections e splash screens, considerare dimensioni maggiori
