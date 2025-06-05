# Guida allo Stile

## Introduzione

Questa guida allo stile definisce le regole visive e di design per il tema "One". È basata sui principi di minimalismo, coerenza e accessibilità.

## Colori

### Palette Primaria
```css
:root {
  --color-primary: #007bff;
  --color-primary-light: #4da3ff;
  --color-primary-dark: #0056b3;
  
  --color-secondary: #6c757d;
  --color-secondary-light: #8e9ba4;
  --color-secondary-dark: #495057;
  
  --color-accent: #ffc107;
  --color-accent-light: #ffd54f;
  --color-accent-dark: #ffa000;
}
```

### Palette Neutra
```css
:root {
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
}
```

### Stati e Feedback
```css
:root {
  --color-success: #28a745;
  --color-success-light: #5cb85c;
  --color-success-dark: #218838;
  
  --color-warning: #ffc107;
  --color-warning-light: #ffd54f;
  --color-warning-dark: #ffa000;
  
  --color-danger: #dc3545;
  --color-danger-light: #e57373;
  --color-danger-dark: #c62828;
  
  --color-info: #17a2b8;
  --color-info-light: #4fc3f7;
  --color-info-dark: #0288d1;
}
```

## Tipografia

### Font Family
```css
:root {
  --font-primary: 'Helvetica Neue', Arial, sans-serif;
  --font-secondary: 'Georgia', 'Times New Roman', serif;
  --font-mono: 'Courier New', monospace;
}
```

### Scale Tipografica
```css
:root {
  --text-xs: 0.75rem;    /* 12px */
  --text-sm: 0.875rem;   /* 14px */
  --text-base: 1rem;     /* 16px */
  --text-lg: 1.125rem;   /* 18px */
  --text-xl: 1.25rem;    /* 20px */
  --text-2xl: 1.5rem;    /* 24px */
  --text-3xl: 1.875rem;  /* 30px */
  --text-4xl: 2.25rem;   /* 36px */
  --text-5xl: 3rem;      /* 48px */
}
```

### Pesanti Font
```css
:root {
  --font-light: 300;
  --font-normal: 400;
  --font-medium: 500;
  --font-semibold: 600;
  --font-bold: 700;
}
```

### Line Height
```css
:root {
  --leading-none: 1;
  --leading-tight: 1.25;
  --leading-snug: 1.375;
  --leading-normal: 1.5;
  --leading-relaxed: 1.625;
  --leading-loose: 2;
}
```

## Spaziatura

### Scale
```css
:root {
  --space-0: 0;
  --space-1: 0.25rem;    /* 4px */
  --space-2: 0.5rem;     /* 8px */
  --space-3: 0.75rem;    /* 12px */
  --space-4: 1rem;       /* 16px */
  --space-5: 1.25rem;    /* 20px */
  --space-6: 1.5rem;     /* 24px */
  --space-8: 2rem;       /* 32px */
  --space-10: 2.5rem;    /* 40px */
  --space-12: 3rem;      /* 48px */
  --space-16: 4rem;      /* 64px */
  --space-20: 5rem;      /* 80px */
  --space-24: 6rem;      /* 96px */
  --space-32: 8rem;      /* 128px */
}
```

## Bordi

### Raggio
```css
:root {
  --radius-none: 0;
  --radius-sm: 0.125rem;  /* 2px */
  --radius: 0.25rem;      /* 4px */
  --radius-md: 0.375rem;  /* 6px */
  --radius-lg: 0.5rem;    /* 8px */
  --radius-xl: 0.75rem;   /* 12px */
  --radius-2xl: 1rem;     /* 16px */
  --radius-3xl: 1.5rem;   /* 24px */
  --radius-full: 9999px;
}
```

### Spessore
```css
:root {
  --border-none: 0;
  --border: 1px;
  --border-2: 2px;
  --border-4: 4px;
  --border-8: 8px;
}
```

## Ombre

### Elevazione
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

## Animazioni

### Durata
```css
:root {
  --duration-75: 75ms;
  --duration-100: 100ms;
  --duration-150: 150ms;
  --duration-200: 200ms;
  --duration-300: 300ms;
  --duration-500: 500ms;
  --duration-700: 700ms;
  --duration-1000: 1000ms;
}
```

### Timing
```css
:root {
  --ease-linear: linear;
  --ease-in: cubic-bezier(0.4, 0, 1, 1);
  --ease-out: cubic-bezier(0, 0, 0.2, 1);
  --ease-in-out: cubic-bezier(0.4, 0, 0.2, 1);
}
```

## Breakpoints

### Responsive
```css
:root {
  --breakpoint-sm: 640px;
  --breakpoint-md: 768px;
  --breakpoint-lg: 1024px;
  --breakpoint-xl: 1280px;
  --breakpoint-2xl: 1536px;
}
```

## Best Practices

### Accessibilità
- Contrasto minimo 4.5:1 per testo normale
- Contrasto minimo 3:1 per testo grande
- Focus states visibili
- Alternative testuali per immagini
- Struttura semantica HTML

### Performance
- Ottimizzare immagini
- Minimizzare CSS/JS
- Utilizzare font system
- Implementare lazy loading
- Caching appropriato

### Responsive
- Mobile-first approach
- Breakpoints chiari
- Layout fluidi
- Immagini responsive
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
- [Componenti](../components.md)
- [Roadmap](../roadmap.md)
- [Best Practices](../best_practices.md) 
