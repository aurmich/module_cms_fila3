# Componente Calendar

## Descrizione
Il componente `pub_theme::components.blocks.calendar` fornisce un'interfaccia frontend per i widget FullCalendar del modulo SaluteOra.

## Struttura
Il componente deve essere posizionato in:
```
Modules/Cms/Resources/views/components/blocks/calendar.blade.php
```

## Utilizzo
```php
<x-pub_theme::components.blocks.calendar 
    :config="$config"
    :events="$events" 
/>
```

## Parametri
- `config`: Configurazione del calendario (array)
- `events`: Eventi da visualizzare (array)

## Integrazione con SaluteOra
Il componente si integra con i widget FullCalendar del modulo SaluteOra seguendo le specifiche definite in `fullcalendar-saluteora.mdc`.

## Note
- Non estendere direttamente classi Filament
- Utilizzare i file di traduzione del modulo
- Seguire le convenzioni di naming in lowercase
- Mantenere la documentazione aggiornata

## Collegamenti
- [Documentazione Frontend](/docs/frontend/calendar-component.md)
- [Regole FullCalendar](/Modules/SaluteOra/docs/fullcalendar_implementation_guide.md)

## File Correlati

- `resources/views/livewire/components/calendar.blade.php`: Template del componente
- `lang/it/calendar.php`: File di traduzione
- `app/Filament/Widgets/*CalendarWidget.php`: Widget Filament 
