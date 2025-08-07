# Componenti Tab in Filament

## Errore Comune: Metodo description()
Il metodo `description()` non esiste nei componenti Tab di Filament. Questo è un errore comune quando si confondono i componenti Section (che hanno il metodo description) con i componenti Tab.

### ❌ Errato
```php
Forms\Components\Tabs\Tab::make('tab_name')
    ->description('Descrizione tab') // Questo metodo non esiste!
    ->schema([...]);
```

### ✅ Corretto
```php
Forms\Components\Tabs\Tab::make('tab_name')
    ->label('Label del Tab')
    ->icon('heroicon-o-user')
    ->schema([...]);
```

## Metodi Disponibili per Tab

### Metodi Base
- `make(string $name)`: Crea una nuova istanza del tab
- `label(string $label)`: Imposta la label del tab
- `icon(string $icon)`: Imposta l'icona del tab
- `badge(string|int $badge)`: Aggiunge un badge al tab
- `schema(array $schema)`: Definisce lo schema del contenuto

### Esempi di Uso Corretto
```php
use Filament\Forms\Components\Tabs;

Tabs::make('Gruppo Tab')
    ->tabs([
        Tabs\Tab::make('informazioni')
            ->label('Informazioni')
            ->icon('heroicon-o-information-circle')
            ->badge('Nuovo')
            ->schema([
                // Schema del tab
            ]),
    ]);
```

## Best Practices

1. **Struttura Chiara**
   - Usare nomi descrittivi per i tab
   - Aggiungere icone per migliorare l'UX
   - Organizzare logicamente i campi

2. **Validazione**
   - Gestire la validazione per ogni tab
   - Mostrare errori appropriatamente
   - Mantenere feedback utente

3. **Traduzione**
   - Usare file di traduzione per le label
   - Mantenere coerenza linguistica
   - Evitare testo hardcoded

## Collegamenti Bidirezionali
- [README](README.md)
- [Filament Resources](filament-resources.md)
- [Form Components](filament-form-components.md)

## Vedi Anche
- [Filament Forms Documentation](https://filamentphp.com/docs/forms)
- [Tabs Component](https://filamentphp.com/docs/forms/layout#tabs)
- [Best Practices](../../Xot/docs/filament-best-practices.md) 