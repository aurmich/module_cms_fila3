# Componenti UI

## Componenti Form Avanzati

### StudioCardSelector

Componente Filament Form per la selezione di studi medici attraverso interfaccia card visuale.

#### Utilizzo Base
```php
use Modules\UI\Forms\Components\StudioCardSelector;

StudioCardSelector::make('selected_studio')
    ->studios(fn (Get $get) => $this->getStudiosForLocation($get))
    ->required();
```

#### Caratteristiche
- **Layout Responsive**: Card stack verticali su mobile, orizzontali su desktop
- **Accessibilità**: Supporto completo keyboard navigation e screen reader
- **Personalizzazione**: Varianti compact/default/detailed
- **Interattività**: Selezione radio con feedback visivo
- **Alpine.js**: Interazioni fluide senza page reload

#### Varianti Layout
```php
// Layout compatto
StudioCardSelector::make('studio')->compact();

// Layout dettagliato con info extra
StudioCardSelector::make('studio')
    ->detailed()
    ->showDistance()
    ->showSpecializations()
    ->showPhone();
```

#### Features Opzionali
- `showDistance()`: Badge distanza con icona mappa
- `showSpecializations()`: Tag specializzazioni mediche  
- `showPhone()`: Numero telefono con icona

[**📖 Documentazione Completa**](./studio-card-selector-implementation.md)

## Componenti Form Filament

### LocationSelector

Componente per la selezione gerarchica di dati geografici (Regione → Provincia → CAP).

#### Utilizzo
```php
use Modules\UI\Filament\Forms\Components\LocationSelector;

LocationSelector::make()
    ->regionField('region')
    ->provinceField('province')
    ->capField('cap')
    ->required()
    ->searchable()
```

#### Caratteristiche
- Selezione gerarchica con dipendenze automatiche
- Integrazione con modulo Geo
- Live updates tra i campi
- Validazione cascata
- Gestione errori con logging

## Componenti Blade UI

### StudioSelector

Componente semplificato per la selezione di uno studio odontoiatrico tramite pulsanti radio-style.

#### Utilizzo
```blade
<x-ui::ui.studio-selector 
    :studios="$studios"
    :selected-studio="$selectedStudioId"
    target-field="selected_studio"
/>
```

#### Caratteristiche
- Pulsanti radio-style per selezione singola
- Visual feedback per stato selezionato
- Informazioni compatte (nome, indirizzo, contatti)
- Empty states integrati
- Integrazione Livewire automatica
- Layout responsive

### StudioCard (Completa)

Componente avanzato per la visualizzazione dettagliata di uno studio (per liste, dashboard, dettagli).

#### Utilizzo
```blade
<x-ui::ui.studio-card 
    :studio="$studio"
    :show-distance="true"
    :show-rating="true"
    :show-services="true"
    :actions="['book', 'details', 'contact']"
/>
```

#### Caratteristiche
- Layout responsive completo
- Rating con stelle
- Informazioni di contatto estese
- Servizi offerti
- Azioni personalizzabili
- Orari di apertura

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
