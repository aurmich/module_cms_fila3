# TableLayoutEnum - Documentazione Completa

## Panoramica

Il `TableLayoutEnum` è un componente fondamentale del modulo UI che gestisce i layout delle tabelle in Filament. Fornisce un sistema standardizzato per alternare tra visualizzazioni lista e griglia, con supporto completo per traduzioni, icone e colori.

## Scopo e Funzionalità

### Obiettivo Principale
- **Gestione Layout**: Fornisce un enum tipizzato per gestire i layout delle tabelle
- **Interfaccia Filament**: Implementa le interfacce `HasColor`, `HasIcon`, `HasLabel` per integrazione nativa
- **Responsive Design**: Supporta configurazioni responsive per diversi dispositivi
- **Type Safety**: Garantisce type safety completo con PHP 8.1+ enum

### Funzionalità Core

#### 1. Layout Types
```php
enum TableLayoutEnum: string
{
    case LIST = 'list';  // Layout tradizionale a tabella
    case GRID = 'grid';  // Layout a griglia con carte
}
```

#### 2. Metodi Principali
- `getLabel()`: Restituisce etichette tradotte
- `getColor()`: Restituisce colori per UI components
- `getIcon()`: Restituisce icone Heroicon
- `toggle()`: Alterna tra layout
- `getTableContentGrid()`: Configurazione responsive
- `getTableColumns()`: Selezione colonne per layout

#### 3. Configurazione Responsive
```php
public function getTableContentGrid(): ?array
{
    return $this->isGridLayout()
        ? [
            'sm' => 1,   // 1 colonna su mobile
            'md' => 2,   // 2 colonne su tablet
            'lg' => 3,   // 3 colonne su desktop
            'xl' => 4,   // 4 colonne su large
            '2xl' => 5,  // 5 colonne su extra large
        ]
        : null;
}
```

## Integrazione con Filament

### Trait HasXotTable
Il trait `HasXotTable` integra automaticamente il TableLayoutEnum:

```php
trait HasXotTable
{
    public TableLayoutEnum $layoutView = TableLayoutEnum::LIST;
    
    public function table(Table $table): Table
    {
        return $table
            ->columns($this->layoutView->getTableColumns(
                $this->getTableColumns(),      // Colonne per lista
                $this->getGridTableColumns()   // Colonne per griglia
            ))
            ->contentGrid($this->layoutView->getTableContentGrid());
    }
}
```

### Action Toggle
L'action `TableLayoutToggleTableAction` permette di alternare i layout:

```php
public function getTableHeaderActions(): array
{
    return [
        'layout' => TableLayoutToggleTableAction::make('layout')
            ->icon($this->layoutView->getIcon())
            ->color($this->layoutView->getColor())
            ->label($this->layoutView->getLabel()),
    ];
}
```

## Utilizzo Pratico

### 1. In ListRecords Pages
```php
use Modules\UI\Enums\TableLayoutEnum;

class ListUsers extends ListRecords
{
    public TableLayoutEnum $layoutView = TableLayoutEnum::LIST;
    
    public function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('email'),
            Tables\Columns\TextColumn::make('created_at'),
        ];
    }
    
    public function getGridTableColumns(): array
    {
        return [
            Tables\Columns\Layout\Stack::make([
                Tables\Columns\TextColumn::make('name')->weight('bold'),
                Tables\Columns\TextColumn::make('email'),
            ]),
        ];
    }
}
```

### 2. Gestione Layout Personalizzata
```php
class CustomListPage extends ListRecords
{
    protected TableLayoutEnum $layoutView = TableLayoutEnum::LIST;
    
    public function mount(): void
    {
        // Recupera layout salvato o usa default
        $this->layoutView = $this->getCurrentLayout();
    }
    
    public function toggleLayout(): void
    {
        $this->layoutView = $this->layoutView->toggle();
        $this->saveLayout($this->layoutView);
    }
    
    protected function getCurrentLayout(): TableLayoutEnum
    {
        $saved = session('table_layout_' . $this->getTableIdentifier());
        return $saved ? TableLayoutEnum::from($saved) : TableLayoutEnum::LIST;
    }
    
    protected function saveLayout(TableLayoutEnum $layout): void
    {
        session(['table_layout_' . $this->getTableIdentifier() => $layout->value]);
    }
}
```

## Traduzioni

### File di Traduzione
```php
// Modules/UI/lang/it/table-layout.php
return [
    'list' => [
        'label' => 'Lista',
        'description' => 'Visualizzazione tradizionale in formato tabella',
        'tooltip' => 'Mostra i dati in righe di tabella',
    ],
    'grid' => [
        'label' => 'Griglia',
        'description' => 'Visualizzazione a griglia responsive',
        'tooltip' => 'Mostra i dati in formato griglia con carte',
    ],
    'toggle' => [
        'label' => 'Cambia Layout',
        'tooltip' => 'Alterna tra visualizzazione lista e griglia',
    ],
];
```

### Utilizzo nelle Traduzioni
```php
public function getLabel(): string
{
    return match ($this) {
        self::LIST => __('ui::table-layout.list.label'),
        self::GRID => __('ui::table-layout.grid.label'),
    };
}
```

## Best Practices

### 1. Type Safety
- Utilizzare sempre il tipo `TableLayoutEnum` invece di stringhe
- Evitare confronti diretti con stringhe
- Utilizzare i metodi `isListLayout()` e `isGridLayout()`

### 2. Performance
- Cache del layout per utente
- Lazy loading delle colonne
- Ottimizzazione query per layout diversi

### 3. UX/UI
- Icone intuitive per ogni layout
- Colori coerenti con il design system
- Tooltip informativi
- Transizioni fluide

### 4. Responsive Design
- Configurazioni appropriate per ogni breakpoint
- Fallback per dispositivi non supportati
- Test su diversi dispositivi

## Architettura e Design Patterns

### 1. Enum Pattern
Il TableLayoutEnum segue il pattern Enum di PHP 8.1+:
- **Type Safety**: Valori tipizzati e immutabili
- **Interfacce**: Implementa interfacce Filament per integrazione nativa
- **Metodi**: Metodi di utilità per operazioni comuni

### 2. Strategy Pattern
Il layout viene gestito tramite il pattern Strategy:
- **Context**: La pagina ListRecords
- **Strategy**: TableLayoutEnum (LIST o GRID)
- **Concrete Strategies**: Implementazioni specifiche per ogni layout

### 3. Observer Pattern
Il trait HasXotTable osserva i cambiamenti di layout:
- **Subject**: TableLayoutEnum
- **Observer**: HasXotTable trait
- **Notification**: Aggiornamento automatico della tabella

## Estensibilità

### 1. Nuovi Layout Types
Per aggiungere nuovi layout:

```php
enum TableLayoutEnum: string
{
    case LIST = 'list';
    case GRID = 'grid';
    case COMPACT = 'compact';  // Nuovo layout
    
    public function getLabel(): string
    {
        return match ($this) {
            self::LIST => __('ui::table-layout.list.label'),
            self::GRID => __('ui::table-layout.grid.label'),
            self::COMPACT => __('ui::table-layout.compact.label'),
        };
    }
}
```

### 2. Layout Personalizzati
Per layout specifici del modulo:

```php
// Nel modulo specifico
enum CustomTableLayoutEnum: string
{
    case CARD = 'card';
    case TIMELINE = 'timeline';
    
    public function getTableContentGrid(): ?array
    {
        return match ($this) {
            self::CARD => ['sm' => 1, 'md' => 2, 'lg' => 3],
            self::TIMELINE => null,
        };
    }
}
```

## Testing

### 1. Unit Tests
```php
class TableLayoutEnumTest extends TestCase
{
    public function test_enum_values(): void
    {
        $this->assertEquals('list', TableLayoutEnum::LIST->value);
        $this->assertEquals('grid', TableLayoutEnum::GRID->value);
    }
    
    public function test_toggle_functionality(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;
        
        $this->assertEquals($grid, $list->toggle());
        $this->assertEquals($list, $grid->toggle());
    }
    
    public function test_layout_checks(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;
        
        $this->assertTrue($list->isListLayout());
        $this->assertFalse($list->isGridLayout());
        $this->assertTrue($grid->isGridLayout());
        $this->assertFalse($grid->isListLayout());
    }
}
```

### 2. Integration Tests
```php
class TableLayoutIntegrationTest extends TestCase
{
    public function test_layout_integration_with_filament(): void
    {
        $page = new TestListPage();
        $page->layoutView = TableLayoutEnum::GRID;
        
        $table = $page->table(Table::make());
        
        // Verifica che la configurazione sia corretta
        $this->assertNotNull($table->getContentGrid());
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

#### Layout non cambia
```php
// Verifica che il trait sia utilizzato
use Modules\Xot\Filament\Traits\HasXotTable;

class ListPage extends ListRecords
{
    use HasXotTable;
    
    public TableLayoutEnum $layoutView = TableLayoutEnum::LIST;
}
```

#### Colonne non si aggiornano
```php
// Verifica che getTableColumns() e getGridTableColumns() siano implementati
public function getTableColumns(): array
{
    return [/* colonne per lista */];
}

public function getGridTableColumns(): array
{
    return [/* colonne per griglia */];
}
```

#### Traduzioni mancanti
```php
// Verifica che il file di traduzione esista
// Modules/UI/lang/it/table-layout.php
return [
    'list' => ['label' => 'Lista'],
    'grid' => ['label' => 'Griglia'],
];
```

### 2. Debug
```php
// Debug del layout corrente
dd($this->layoutView->value);
dd($this->layoutView->getLabel());
dd($this->layoutView->getTableContentGrid());
```

## Collegamenti Correlati

- [Table Components](./table-components.md)
- [HasXotTable Trait](../../Xot/docs/has-xot-table.md)
- [Filament Integration](./filament-components.md)
- [Translation Standards](../../Lang/docs/translation-standards.md)
- [UI Best Practices](./best-practices.md)

## Changelog

### v1.0.0 (2024-01-15)
- Implementazione iniziale del TableLayoutEnum
- Supporto per layout LIST e GRID
- Integrazione con trait HasXotTable
- Sistema di traduzioni completo

### v1.1.0 (2024-02-20)
- Aggiunto supporto per configurazioni responsive
- Migliorata type safety con PHP 8.1+ enum
- Ottimizzazioni performance
- Documentazione completa

### v1.2.0 (2024-03-10)
- Aggiunto metodo `getTableColumns()` con parametri espliciti
- Rimosso utilizzo di `debug_backtrace()` per migliori performance
- Migliorata compatibilità con PHPStan livello 10
- Aggiunto supporto per layout personalizzati

## Contributi

Per contribuire al TableLayoutEnum:

1. Seguire le convenzioni di codice PSR-12
2. Aggiungere test per nuove funzionalità
3. Aggiornare la documentazione
4. Verificare compatibilità con PHPStan livello 10
5. Testare su diversi dispositivi e browser

---

**Ultimo aggiornamento**: Marzo 2025
**Versione**: 1.2.0
**Compatibilità**: PHP 8.1+, Filament 3.x, Laravel 10.x 