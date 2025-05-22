# Errore: Uso del metodo `description` su `Filament\Forms\Components\Tabs\Tab`

## Problema
Nel codice del modulo Patient è stato utilizzato il metodo `description` su un oggetto `Filament\Forms\Components\Tabs\Tab`:

```php
Tabs\Tab::make('contacts')
    ->label(trans("$prefix.tabs.contacts.label"))
    ->description(trans("$prefix.tabs.contacts.description"))
```

Tuttavia, il metodo `description` **non esiste** nella classe `Filament\Forms\Components\Tabs\Tab` (né nelle versioni attuali di Filament). Questo causa un errore fatale in fase di esecuzione.

## Motivo dell'Errore
- Confusione tra API di diversi componenti Filament: alcuni componenti (es. Card, Section) supportano `description`, ma Tab **no**.
- Mancanza di verifica nella documentazione ufficiale delle API Filament.

## Best Practice
- Prima di usare metodi su componenti Filament, consultare sempre la documentazione ufficiale e/o l'autocompletamento IDE.
- Evitare di copiare pattern tra componenti diversi senza verifica.

## Correzione
Rimuovere ogni chiamata a `->description()` su Tab. Se serve una descrizione, inserirla come testo all'interno dello schema della Tab (es. usando `Placeholder`, `HtmlString`, `View`, ecc.).

---

**Questa regola è ora parte delle convenzioni interne di sviluppo dei moduli.**
