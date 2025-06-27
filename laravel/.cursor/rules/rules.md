# Regole per i Componenti Blade UI

## Posizionamento dei Componenti

### Regola Fondamentale
Tutti i componenti Blade UI condivisi (es. ui.logo) devono essere **SEMPRE** posizionati in `Modules/UI/resources/views/components/ui/` e **MAI** nella root `resources/views/components/`.

### ✅ CORRETTO
```
Modules/
└── UI/
    └── resources/
        └── views/
            └── components/
                └── ui/
                    ├── logo.blade.php
                    ├── button.blade.php
                    └── card.blade.php
```

### ❌ ERRATO
```
resources/
└── views/
    └── components/
        ├── ui/
        │   ├── logo.blade.php
        │   └── button.blade.php
        └── card.blade.php
```

## Componenti Form Filament

### InlineDatePicker
Componente specializzato per la selezione di date con calendario inline sempre visibile e controllo granulare delle date selezionabili. Ideale per appuntamenti, prenotazioni e scenari con date limitate.

**Utilizzo:**
```php
use Modules\UI\Filament\Forms\Components\InlineDatePicker;

InlineDatePicker::make('appointment_date')
    ->enabledDates(['2025-06-05', '2025-06-21'])
    ->highlightColor('bg-indigo-600 text-white')
    ->compactMode()
    ->required();
```

**Documentazione completa:** [inline-date-picker-component.md](./inline-date-picker-component.md)

## Motivazione 