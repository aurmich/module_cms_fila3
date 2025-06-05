# Design Tokens

## Introduzione

Questo documento descrive il sistema di design tokens del tema "One", che definisce i valori fondamentali per la coerenza visiva.

## Sistema di Tokens

### Colori
```css
:root {
  /* Primari */
  --color-primary: #007bff;
  --color-primary-light: #4da3ff;
  --color-primary-dark: #0056b3;
  
  /* Secondari */
  --color-secondary: #6c757d;
  --color-secondary-light: #8e9ba4;
  --color-secondary-dark: #495057;
  
  /* Accenti */
  --color-accent: #ffc107;
  --color-accent-light: #ffd54f;
  --color-accent-dark: #ffa000;
  
  /* Neutri */
  --color-white: #ffffff;
  --color-light: #f8f9fa;
  --color-gray-100: #f8f9fa;
  --color-gray-200: #e9ecef;
  --color-gray-300: #dee2e6;
  --color-gray-400: #ced4da;
  --color-gray-500: #adb5bd;
  --color-gray-600: #6c757d;
  --color-gray-700: #495057;
  --color-gray-800: #343a40;
  --color-gray-900: #212529;
  --color-black: #000000;
  
  /* Stati */
  --color-success: #28a745;
  --color-warning: #ffc107;
  --color-danger: #dc3545;
  --color-info: #17a2b8;
}
```

### Tipografia
```css
:root {
  /* Font Family */
  --font-primary: 'Helvetica Neue', Arial, sans-serif;
  --font-secondary: 'Georgia', 'Times New Roman', serif;
  --font-mono: 'Courier New', monospace;
  
  /* Font Size */
  --text-xs: 0.75rem;
  --text-sm: 0.875rem;
  --text-base: 1rem;
  --text-lg: 1.125rem;
  --text-xl: 1.25rem;
  --text-2xl: 1.5rem;
  --text-3xl: 1.875rem;
  --text-4xl: 2.25rem;
  --text-5xl: 3rem;
  
  /* Font Weight */
  --font-light: 300;
  --font-normal: 400;
  --font-medium: 500;
  --font-semibold: 600;
  --font-bold: 700;
  
  /* Line Height */
  --leading-none: 1;
  --leading-tight: 1.25;
  --leading-snug: 1.375;
  --leading-normal: 1.5;
  --leading-relaxed: 1.625;
  --leading-loose: 2;
}
```

### Spaziatura
```css
:root {
  --space-0: 0;
  --space-1: 0.25rem;
  --space-2: 0.5rem;
  --space-3: 0.75rem;
  --space-4: 1rem;
  --space-5: 1.25rem;
  --space-6: 1.5rem;
  --space-8: 2rem;
  --space-10: 2.5rem;
  --space-12: 3rem;
  --space-16: 4rem;
  --space-20: 5rem;
  --space-24: 6rem;
  --space-32: 8rem;
}
```

### Bordi
```css
:root {
  /* Raggio */
  --radius-none: 0;
  --radius-sm: 0.125rem;
  --radius: 0.25rem;
  --radius-md: 0.375rem;
  --radius-lg: 0.5rem;
  --radius-xl: 0.75rem;
  --radius-2xl: 1rem;
  --radius-3xl: 1.5rem;
  --radius-full: 9999px;
  
  /* Spessore */
  --border-none: 0;
  --border: 1px;
  --border-2: 2px;
  --border-4: 4px;
  --border-8: 8px;
}
```

### Ombre
```css
:root {
  --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
  --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
  --shadow-inner: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
}
```

### Breakpoints
```css
:root {
  --breakpoint-sm: 640px;
  --breakpoint-md: 768px;
  --breakpoint-lg: 1024px;
  --breakpoint-xl: 1280px;
  --breakpoint-2xl: 1536px;
}
```

### Z-Index
```css
:root {
  --z-0: 0;
  --z-10: 10;
  --z-20: 20;
  --z-30: 30;
  --z-40: 40;
  --z-50: 50;
  --z-auto: auto;
}
```

## Utilizzo

### Componenti
```css
.button {
  background-color: var(--color-primary);
  color: var(--color-white);
  padding: var(--space-2) var(--space-4);
  border-radius: var(--radius);
  font-size: var(--text-base);
  font-weight: var(--font-medium);
  box-shadow: var(--shadow);
}

.button:hover {
  background-color: var(--color-primary-dark);
  box-shadow: var(--shadow-md);
}
```

### Layout
```css
.container {
  max-width: var(--breakpoint-lg);
  margin: 0 auto;
  padding: var(--space-4);
}

.grid {
  display: grid;
  gap: var(--space-4);
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
}
```

## Best Practices

### Organizzazione
- Raggruppare tokens correlati
- Utilizzare nomi descrittivi
- Mantenere coerenza
- Documentare valori
- Versionare cambiamenti

### Manutenzione
- Aggiornare documentazione
- Testare cambiamenti
- Verificare accessibilità
- Ottimizzare performance
- Gestire fallback

## Metriche di Successo

### Coerenza
- Uniformità visiva
- Scalabilità
- Manutenibilità
- Documentazione
- Adozione

### Performance
- Tempo di caricamento
- Dimensione CSS
- Utilizzo memoria
- Compatibilità
- Fallback

## Collegamenti

- [Sistema di Design](../design_system.md)
- [Componenti](../components.md)
- [Guida allo Stile](../style_guide.md)
- [Best Practices](../best_practices.md) 
