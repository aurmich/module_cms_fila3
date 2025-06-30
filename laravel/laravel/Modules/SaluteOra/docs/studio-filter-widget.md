# StudioFilterWidget

Widget per dottori che permette di visualizzare e cambiare lo studio corrente.

## Funzionalità
- Visualizzazione informazioni studio corrente
- Cambio studio tramite dropdown 
- Eventi per notificare il cambio studio
- Compatibile con LangServiceProvider

## Utilizzo
```php
// In una pagina Filament
protected function getHeaderWidgets(): array
{
    return [
        StudioFilterWidget::class,
    ];
}
```

## Eventi
- `studio-changed`: Dispatched quando cambia studio
- `studio-selected`: Listener per selezione esterna

*Creato: Mon Jun 30 21:52:52 CEST 2025*
