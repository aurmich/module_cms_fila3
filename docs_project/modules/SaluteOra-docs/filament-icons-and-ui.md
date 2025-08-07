# Icone e UI Components in SaluteOra

## Principi di Design

Nel progetto SaluteOra, seguiamo rigorosi principi di design per garantire coerenza visiva e ottima esperienza utente:

1. **Consistenza stilistica**: Tutte le icone seguono lo stile Heroicons outline
2. **Reattività**: Le icone includono animazioni hover per migliorare il feedback utente
3. **Supporto dark mode**: Ogni componente visivo è ottimizzato sia per tema chiaro che scuro
4. **Accessibilità**: Contrasto adeguato e semantica corretta per screen reader

## Icone SVG Personalizzate

### Struttura delle Icone

Tutte le icone SVG personalizzate sono archiviate in:
```
/Modules/SaluteOra/resources/svg/
```

### Convenzioni di Denominazione

- Le icone seguono la convenzione `entity-name.svg`
- Ogni icona ha una classe CSS corrispondente `entity-name-icon`

### Implementazione Tecnica

Ogni icona SVG include:

1. **Namespace SVG standard**:
   ```xml
   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
   ```

2. **Stili incorporati** per l'animazione e il supporto dark mode:
   ```css
   <style>
     .icon-class {
       transition: all 0.3s ease;
     }
     .icon-class:hover {
       stroke: #colorcode;
       transform: scale(1.05);
     }
     @media (prefers-color-scheme: dark) {
       .icon-class:hover {
         stroke: #lighter-colorcode;
       }
     }
   </style>
   ```

3. **Percorsi SVG semantici** che rappresentano chiaramente l'entità

### Icone Disponibili

#### Doctor (Medico)
- **File**: `doctor.svg`
- **Rappresentazione**: Figura con simbolo medico
- **Colore hover**: Blu (#3b82f6, #60a5fa in dark mode)

#### Studio (Clinica)
- **File**: `studio.svg`
- **Rappresentazione**: Edificio medico con elementi distintivi
- **Colore hover**: Azzurro (#0ea5e9, #38bdf8 in dark mode)

#### Admin (Segretaria)
- **File**: `admin.svg`
- **Rappresentazione**: Figura con elementi amministrativi
- **Colore hover**: Viola (#d946ef, #e879f9 in dark mode)

## Utilizzo nelle Risorse Filament

Per utilizzare queste icone nelle risorse Filament:

```php
// In XotBaseResource o classe derivata
protected static ?string $navigationIcon = 'saluteora::doctor';

// Dove 'saluteora::' è il namespace dell'icona e 'doctor' è il nome del file senza estensione
```

## Considerazioni Filosofiche sul Design

La scelta di icone specifiche per ciascun ruolo riflette una profonda comprensione dell'esperienza utente:

- L'**icona del medico** include elementi che simboleggiano cura e competenza medica
- L'**icona dello studio** rappresenta lo spazio fisico organizzato per l'attività sanitaria
- L'**icona della segretaria** combina elementi umani e amministrativi, riflettendo il ruolo di supporto e organizzazione

Questa attenzione ai dettagli semantici non è solo estetica, ma risponde a una necessità di chiarezza cognitiva nell'interfaccia utente, facilitando la comprensione intuitiva dei ruoli all'interno del sistema.
