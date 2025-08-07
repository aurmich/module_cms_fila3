# Errore: Uso di `prefixIcon` su FileUpload di Filament

## Problema
Nel codice è stato utilizzato il metodo `prefixIcon` su `Filament\Forms\Components\FileUpload`:

```php
FileUpload::make('certification')->prefixIcon('heroicon-o-document-text')
```

Tuttavia, il metodo `prefixIcon` **non esiste** per il componente FileUpload. È disponibile solo su alcuni componenti come TextInput, Textarea, Password, ma **non** su FileUpload.

## Motivo dell'errore
- Generalizzazione errata delle API tra componenti Filament.
- Mancata consultazione della documentazione ufficiale Filament prima di applicare metodi comuni ad altri componenti.

## Best Practice
- Prima di usare un metodo su un componente Filament, verificare sempre nella documentazione ufficiale se quel metodo è supportato.
- Usare solo le API realmente disponibili per ogni componente.
- Se si vuole aggiungere un'icona a FileUpload, bisogna customizzare lo slot o la view, non usare `prefixIcon`.

## Regola aggiornata
**Mai usare `prefixIcon` su FileUpload.**
Se serve un'icona, usare solo i metodi previsti dalla documentazione Filament.

---

**Questa regola è ora parte delle convenzioni interne di sviluppo dei moduli.**

---

## Collegamenti
- [Errore UI corrispondente in Modules/UI/docs](../../UI/docs/filament-error-fileupload-prefixicon.md)

**Nota:** Questa regola è trasversale e si applica a tutti i moduli che usano Filament.

## Collegamenti tra versioni di filament-error-fileupload-prefixicon.md
* [filament-error-fileupload-prefixicon.md](../../UI/docs/filament-error-fileupload-prefixicon.md)

