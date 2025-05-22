# Stili del Tema One

## Variabili CSS
```css
:root {
  --primary-color: #3B82F6;
  --secondary-color: #6B7280;
  --background-color: #FFFFFF;
  --text-color: #1F2937;
  --button-bg: var(--primary-color);
  --button-text: #FFFFFF;
  --button-hover: #2563EB;
}
```

## Best Practices
1. **Colori**
   - Usare sempre le variabili CSS
   - Mantenere contrasto WCAG 2.1
   - Testare la visibilità

2. **Componenti**
   - Definire stili base
   - Usare classi Tailwind
   - Mantenere coerenza

3. **Responsive**
   - Testare su tutti i dispositivi
   - Usare breakpoints
   - Mantenere leggibilità

## Esempi
```css
.button {
  background-color: var(--button-bg);
  color: var(--button-text);
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  transition: background-color 0.2s;
}

.button:hover {
  background-color: var(--button-hover);
}
```

## Collegamenti
- [Documentazione Tailwind](https://tailwindcss.com/docs)
- [Guida WCAG 2.1](https://www.w3.org/WAI/WCAG21/quickref/) 