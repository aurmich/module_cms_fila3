# Implementazione delle Tabelle Filament

## Metodo `getTableColumns()`

Tutte le classi che estendono `XotBaseListRecords` devono implementare il metodo `getTableColumns()` che restituisce un array associativo con chiavi stringa. Questo metodo è utilizzato dal trait `HasXotTable` per costruire la tabella dell'interfaccia di amministrazione.

### Requisiti

1. Il metodo deve essere implementato in ogni classe di tipo `ListRecords`
2. Deve restituire un array associativo con chiavi stringa (non numeriche)
3. Le colonne devono essere derivate dal modello o dalle migrazioni corrispondenti

### Esempio Corretto

```php
/**
 * Get the table columns.
 *
 * @return array<string, Tables\Columns\Column>
 */
public function getTableColumns(): array
{
    return [
        'id' => Tables\Columns\TextColumn::make('id')
            ->sortable(),
            
        'name' => Tables\Columns\TextColumn::make('name')
            ->searchable()
            ->sortable(),
            
        // Altre colonne...
    ];
}
```

### Errori Comuni

1. **Metodo mancante:** Causa errore `Method Modules\...\ListRecords::getTableColumns does not exist`
2. **Chiavi numeriche:** Le chiavi dell'array devono essere stringhe, non numeri
3. **Namespace non importato:** Assicurarsi di importare il namespace `Filament\Tables`

## Connessione con TableLayoutEnum

Il metodo `getTableColumns()` viene utilizzato dal modulo UI attraverso la classe `TableLayoutEnum` che richiede specificamente un array con chiavi stringa. La visualizzazione può cambiare tra griglia e tabella standard in base alle impostazioni dell'amministratore.

## Linee Guida per le Colonne

1. Includere colonne essenziali (id, nome, ecc.)
2. Rendere ricercabili le colonne testuali importanti
3. Rendere ordinabili le colonne che potrebbero necessitare di ordinamento
4. Utilizzare i tipi di colonna appropriati (TextColumn, IconColumn, ecc.)
5. Applicare la formattazione appropriata per date, booleani e altri tipi di dati

## Collegamenti ad Altri Documenti

- [Guida generale alle risorse Filament](/var/www/html/_bases/base_saluteora/laravel/docs/filament/risorse.md)
- [Moduli SaluteOra](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/README.md)
