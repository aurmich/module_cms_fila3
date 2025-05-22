# Componenti UI

## Componenti SVG

### Bandiere (Flags)

I componenti SVG per le bandiere sono registrati automaticamente e possono essere utilizzati con il prefisso `ui-flags`. 

#### Utilizzo
```blade
{{-- Bandiera italiana --}}
<x-ui-flags.it class="w-6 h-4" />

{{-- Bandiera inglese --}}
<x-ui-flags.gb class="w-6 h-4" />
```

#### Caratteristiche
- Registrazione automatica dei componenti
- Supporto per tutte le bandiere del mondo
- Dimensioni ottimizzate
- Colori ufficiali
- ViewBox corretto per il mantenimento delle proporzioni

#### Best Practices
1. **Dimensioni**
   - Utilizzare classi Tailwind per le dimensioni
   - Mantenere le proporzioni originali (3:2)
   - Esempio: `class="w-6 h-4"`

2. **Accessibilità**
   - Aggiungere attributi `aria-label` quando necessario
   - Fornire testo alternativo per screen reader
   - Esempio:
     ```blade
     <x-ui-flags.it class="w-6 h-4" aria-label="Bandiera italiana" />
     ```

3. **Performance**
   - Gli SVG sono ottimizzati
   - Non richiedono richieste HTTP aggiuntive
   - Caching automatico

4. **Personalizzazione**
   - Possibilità di modificare i colori via CSS
   - Supporto per classi Tailwind
   - Esempio:
     ```blade
     <x-ui-flags.it class="w-6 h-4 text-primary-600" />
     ```

## Collegamenti Correlati
- [Documentazione SVG](./SVG.md)
- [Best Practices UI](./UI_BEST_PRACTICES.md)
- [Guida Componenti](./COMPONENTS_GUIDE.md) 
