# Filament Custom Field: OpeningHours

## Introduzione

La gestione degli orari di apertura è una necessità comune per studi, negozi, strutture sanitarie e qualsiasi entità che abbia una presenza fisica. Un campo custom Filament per gli orari di apertura deve offrire la massima flessibilità, usabilità e compatibilità con le best practice di backend e frontend.

Questa documentazione illustra come progettare, implementare e integrare un campo custom Filament per la gestione degli orari di apertura, ispirato alla libreria [spatie/opening-hours](https://github.com/spatie/opening-hours) e alle migliori soluzioni UI/UX.

---

## Motivazione e Obiettivi

- **Esperienza utente moderna**: input rapido, intuitivo, con azioni di massa e feedback immediato.
- **Flessibilità**: supporto per orari multipli per giorno, giorni chiusi, eccezioni (festività, aperture straordinarie).
- **Compatibilità**: dati serializzati in formato compatibile con [spatie/opening-hours](https://github.com/spatie/opening-hours).
- **Validazione**: nessuna sovrapposizione, orari coerenti, gestione edge case.
- **Accessibilità**: navigazione tastiera, label chiare, errori accessibili.
- **Estendibilità**: possibilità di aggiungere nuove feature (es. preview, drag&drop, import/export, preset).

---

## Struttura dati

Il campo deve serializzare i dati in formato JSON/array compatibile con spatie/opening-hours:

```json
{
  "monday": [
    {"open": "09:00", "close": "12:30"},
    {"open": "15:00", "close": "19:00"}
  ],
  "tuesday": [
    {"open": "09:00", "close": "12:30"},
    {"open": "15:00", "close": "19:00"}
  ],
  "sunday": [],
  "exceptions": {
    "2024-12-25": [],
    "2024-08-15": [
      {"open": "10:00", "close": "13:00"}
    ]
  }
}
```

- **Chiave giorno**: array di intervalli (può essere vuoto = chiuso)
- **Eccezioni**: chiave `exceptions` con date specifiche e relativi intervalli

---

## UX/UI: Specifiche e Mockup

### Tabella settimanale
- Righe: giorni della settimana (lun-dom)
- Colonne: intervalli orari (apertura/chiusura), azioni
- Checkbox "chiuso" per ogni giorno
- Pulsante "+" per aggiungere intervalli nello stesso giorno
- Azioni rapide: "Copia orari da...", "Applica a tutti", "Resetta"
- Sezione collapsible per eccezioni (festività, aperture straordinarie)
- Validazione live: errori evidenziati subito (es. orari sovrapposti, orari non validi)
- Preview: riepilogo leggibile degli orari inseriti

### Accessibilità
- Tutti i campi devono avere label e aria-label
- Navigazione tastiera completa
- Errori e feedback accessibili screen reader

### Responsive
- Layout mobile: stack verticale, azioni rapide sempre visibili
- Layout desktop: tabella completa, drag&drop opzionale

---

## API del Custom Field (Filament)

```php
use Modules\SaluteOra\Filament\Fields\OpeningHoursField;

OpeningHoursField::make('opening_hours')
    ->label('Orari di apertura')
    ->helperText('Imposta gli orari di apertura settimanali. Puoi aggiungere più intervalli per giorno.')
    ->required()
    ->columnSpanFull()
    ->exceptionsEnabled(true) // opzionale
    ->copyToAllDaysEnabled(true)
    ->previewEnabled(true)
    ->rules(['json', 'opening_hours_valid']); // custom rule per validazione spatie/opening-hours
```

### Opzioni avanzate
- `exceptionsEnabled(bool $enabled = true)`: abilita la gestione delle eccezioni
- `copyToAllDaysEnabled(bool $enabled = true)`: abilita azione rapida "copia su tutti"
- `previewEnabled(bool $enabled = true)`: mostra un riepilogo leggibile
- `preset(array $preset)`: imposta orari predefiniti (es. orario ufficio)

---

## Validazione

- **Validazione lato frontend**: nessuna sovrapposizione, orari coerenti, orari validi (es. open < close)
- **Validazione lato backend**: custom rule `opening_hours_valid` che usa la libreria spatie/opening-hours per validare la struttura e la coerenza
- **Messaggi di errore**: chiari, localizzati, con suggerimenti di correzione

---

## Integrazione backend

- **Salvataggio**: il campo salva i dati in formato JSON compatibile
- **Utilizzo**: istanzia `OpeningHours::from($model->opening_hours)` per tutte le operazioni (es. `isOpenAt`, `forDay`, ecc.)
- **Esempio**:

```php
use Spatie\OpeningHours\OpeningHours;

$oh = OpeningHours::from($studio->opening_hours);
if ($oh->isOpenAt('monday 10:00')) {
    // ...
}
```

---

## Esempio di utilizzo in una risorsa Filament

```php
use Modules\SaluteOra\Filament\Fields\OpeningHoursField;

public static function getFormSchema(): array
{
    return [
        // ... altri campi ...
        'opening_hours' => OpeningHoursField::make('opening_hours')
            ->label('Orari di apertura')
            ->required()
            ->columnSpanFull(),
    ];
}
```

---

## Estendibilità e personalizzazione

- **Preset**: orari predefiniti (es. orario ufficio, orario continuato)
- **Import/Export**: possibilità di importare/esportare orari in JSON
- **Drag&Drop**: riordinamento intervalli (opzionale)
- **Colori/Temi**: personalizzazione UI per accessibilità
- **Supporto multi-lingua**: tutte le label e i messaggi devono essere localizzati

---

## Test e QA

- **Test di validazione**: orari multipli, giorni chiusi, eccezioni, errori di input
- **Test di serializzazione**: compatibilità con spatie/opening-hours
- **Test di accessibilità**: navigazione tastiera, screen reader
- **Test di integrazione**: salvataggio, modifica, visualizzazione in Filament

---

## Roadmap e TODO

- [ ] Prototipare il componente in `Modules/SaluteOra/Filament/Fields/OpeningHoursField.php`
- [ ] Scrivere i test di validazione e serializzazione
- [ ] Aggiornare la documentazione con screenshot e esempi reali
- [ ] Integrare la validazione con spatie/opening-hours
- [ ] Aggiornare le risorse Filament che usano `opening_hours`
- [ ] Raccogliere feedback dagli utenti e iterare sulla UX

---

## Collegamenti e risorse

- [spatie/opening-hours (GitHub)](https://github.com/spatie/opening-hours)
- [Articolo Freek.dev](https://freek.dev/595-managing-opening-hours-with-php)
- [Filament Custom Fields Docs](https://filamentphp.com/docs/3.x/forms/custom-fields)
- [Esempio UI moderna su Figma](https://www.figma.com/community/file/1169630032468786462)
- [Filament Discord](https://filamentphp.com/community/discord)

---

**Questa documentazione va mantenuta aggiornata e linkata da tutte le risorse che usano orari di apertura.** 
