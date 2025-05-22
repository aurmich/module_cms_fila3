# Utility Classes

## Introduzione

Questo documento descrive il sistema di utility classes del tema "One", che fornisce classi atomiche per la costruzione rapida di interfacce.

## Sistema di Utility

### Spaziatura
```css
/* Margin */
.m-0 { margin: 0; }
.m-1 { margin: 0.25rem; }
.m-2 { margin: 0.5rem; }
.m-4 { margin: 1rem; }

/* Margin Top */
.mt-0 { margin-top: 0; }
.mt-1 { margin-top: 0.25rem; }
.mt-2 { margin-top: 0.5rem; }
.mt-4 { margin-top: 1rem; }

/* Margin Right */
.mr-0 { margin-right: 0; }
.mr-1 { margin-right: 0.25rem; }
.mr-2 { margin-right: 0.5rem; }
.mr-4 { margin-right: 1rem; }

/* Margin Bottom */
.mb-0 { margin-bottom: 0; }
.mb-1 { margin-bottom: 0.25rem; }
.mb-2 { margin-bottom: 0.5rem; }
.mb-4 { margin-bottom: 1rem; }

/* Margin Left */
.ml-0 { margin-left: 0; }
.ml-1 { margin-left: 0.25rem; }
.ml-2 { margin-left: 0.5rem; }
.ml-4 { margin-left: 1rem; }

/* Padding */
.p-0 { padding: 0; }
.p-1 { padding: 0.25rem; }
.p-2 { padding: 0.5rem; }
.p-4 { padding: 1rem; }

/* Padding Top */
.pt-0 { padding-top: 0; }
.pt-1 { padding-top: 0.25rem; }
.pt-2 { padding-top: 0.5rem; }
.pt-4 { padding-top: 1rem; }

/* Padding Right */
.pr-0 { padding-right: 0; }
.pr-1 { padding-right: 0.25rem; }
.pr-2 { padding-right: 0.5rem; }
.pr-4 { padding-right: 1rem; }

/* Padding Bottom */
.pb-0 { padding-bottom: 0; }
.pb-1 { padding-bottom: 0.25rem; }
.pb-2 { padding-bottom: 0.5rem; }
.pb-4 { padding-bottom: 1rem; }

/* Padding Left */
.pl-0 { padding-left: 0; }
.pl-1 { padding-left: 0.25rem; }
.pl-2 { padding-left: 0.5rem; }
.pl-4 { padding-left: 1rem; }
```

### Display
```css
/* Display */
.d-none { display: none; }
.d-block { display: block; }
.d-inline { display: inline; }
.d-inline-block { display: inline-block; }
.d-flex { display: flex; }
.d-grid { display: grid; }

/* Flex Direction */
.flex-row { flex-direction: row; }
.flex-row-reverse { flex-direction: row-reverse; }
.flex-col { flex-direction: column; }
.flex-col-reverse { flex-direction: column-reverse; }

/* Flex Wrap */
.flex-wrap { flex-wrap: wrap; }
.flex-nowrap { flex-wrap: nowrap; }
.flex-wrap-reverse { flex-wrap: wrap-reverse; }

/* Justify Content */
.justify-start { justify-content: flex-start; }
.justify-end { justify-content: flex-end; }
.justify-center { justify-content: center; }
.justify-between { justify-content: space-between; }
.justify-around { justify-content: space-around; }

/* Align Items */
.items-start { align-items: flex-start; }
.items-end { align-items: flex-end; }
.items-center { align-items: center; }
.items-baseline { align-items: baseline; }
.items-stretch { align-items: stretch; }
```

### Posizionamento
```css
/* Position */
.position-static { position: static; }
.position-relative { position: relative; }
.position-absolute { position: absolute; }
.position-fixed { position: fixed; }
.position-sticky { position: sticky; }

/* Top, Right, Bottom, Left */
.top-0 { top: 0; }
.right-0 { right: 0; }
.bottom-0 { bottom: 0; }
.left-0 { left: 0; }

/* Z-Index */
.z-0 { z-index: 0; }
.z-10 { z-index: 10; }
.z-20 { z-index: 20; }
.z-30 { z-index: 30; }
.z-40 { z-index: 40; }
.z-50 { z-index: 50; }
```

### Tipografia
```css
/* Font Size */
.text-xs { font-size: 0.75rem; }
.text-sm { font-size: 0.875rem; }
.text-base { font-size: 1rem; }
.text-lg { font-size: 1.125rem; }
.text-xl { font-size: 1.25rem; }

/* Font Weight */
.font-light { font-weight: 300; }
.font-normal { font-weight: 400; }
.font-medium { font-weight: 500; }
.font-semibold { font-weight: 600; }
.font-bold { font-weight: 700; }

/* Text Align */
.text-left { text-align: left; }
.text-center { text-align: center; }
.text-right { text-align: right; }
.text-justify { text-align: justify; }

/* Text Color */
.text-primary { color: var(--color-primary); }
.text-secondary { color: var(--color-secondary); }
.text-success { color: var(--color-success); }
.text-danger { color: var(--color-danger); }
.text-warning { color: var(--color-warning); }
.text-info { color: var(--color-info); }
```

### Background
```css
/* Background Color */
.bg-primary { background-color: var(--color-primary); }
.bg-secondary { background-color: var(--color-secondary); }
.bg-success { background-color: var(--color-success); }
.bg-danger { background-color: var(--color-danger); }
.bg-warning { background-color: var(--color-warning); }
.bg-info { background-color: var(--color-info); }

/* Background Size */
.bg-cover { background-size: cover; }
.bg-contain { background-size: contain; }

/* Background Position */
.bg-center { background-position: center; }
.bg-top { background-position: top; }
.bg-right { background-position: right; }
.bg-bottom { background-position: bottom; }
.bg-left { background-position: left; }
```

### Bordi
```css
/* Border Width */
.border-0 { border-width: 0; }
.border { border-width: 1px; }
.border-2 { border-width: 2px; }
.border-4 { border-width: 4px; }

/* Border Color */
.border-primary { border-color: var(--color-primary); }
.border-secondary { border-color: var(--color-secondary); }
.border-success { border-color: var(--color-success); }
.border-danger { border-color: var(--color-danger); }
.border-warning { border-color: var(--color-warning); }
.border-info { border-color: var(--color-info); }

/* Border Radius */
.rounded-none { border-radius: 0; }
.rounded-sm { border-radius: 0.125rem; }
.rounded { border-radius: 0.25rem; }
.rounded-md { border-radius: 0.375rem; }
.rounded-lg { border-radius: 0.5rem; }
.rounded-full { border-radius: 9999px; }
```

### Ombre
```css
/* Box Shadow */
.shadow-none { box-shadow: none; }
.shadow-sm { box-shadow: var(--shadow-sm); }
.shadow { box-shadow: var(--shadow); }
.shadow-md { box-shadow: var(--shadow-md); }
.shadow-lg { box-shadow: var(--shadow-lg); }
.shadow-xl { box-shadow: var(--shadow-xl); }
```

## Utilizzo

### Esempi
```html
<!-- Card -->
<div class="bg-white rounded-lg shadow p-4">
  <h3 class="text-lg font-semibold mb-2">Titolo</h3>
  <p class="text-gray-600">Contenuto</p>
</div>

<!-- Button -->
<button class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-dark">
  Clicca qui
</button>

<!-- Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
  <div class="bg-gray-100 p-4">Item 1</div>
  <div class="bg-gray-100 p-4">Item 2</div>
  <div class="bg-gray-100 p-4">Item 3</div>
</div>
```

## Best Practices

### Organizzazione
- Raggruppare utility correlate
- Utilizzare nomi consistenti
- Mantenere ordine alfabetico
- Documentare classi
- Versionare cambiamenti

### Performance
- Minimizzare CSS
- Utilizzare shorthand
- Ottimizzare selettori
- Gestire media queries
- Implementare purge

## Metriche di Successo

### Qualità
- Coerenza
- Manutenibilità
- Documentazione
- Adozione
- Performance

### Usabilità
- Intuitività
- Efficienza
- Flessibilità
- Scalabilità
- Accessibilità

## Collegamenti

- [Sistema di Design](../design_system.md)
- [Componenti](../components.md)
- [Guida allo Stile](../style_guide.md)
- [Best Practices](../best_practices.md) 
