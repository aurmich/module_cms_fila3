# Struttura Filament in SaluteMo

## Convenzioni Fondamentali

### Struttura delle Directory
Le classi Filament devono essere organizzate nel seguente modo:
```
Modules/SaluteMo/
  app/
    Filament/
      Pages/       # Pagine Filament personalizzate
      Resources/   # Risorse per la gestione dei modelli
      Widgets/     # Widget personalizzati
```

### Namespace Corretto
Tutte le classi Filament devono utilizzare il namespace:
```php
namespace Modules\SaluteMo\Filament;
```

### Regola di Estensione Fondamentale
**IMPORTANTE**: Mai estendere direttamente le classi Filament. Utilizzare sempre le classi base XotBase corrispondenti.

## Mappatura delle Classi Base

| Classe Filament | Classe XotBase da Estendere |
|-----------------|----------------------------|
| `\Filament\Resources\Resource` | `\Modules\Xot\Filament\Resources\XotBaseResource` |
| `\Filament\Resources\Pages\Page` | `\Modules\Xot\Filament\Resources\Pages\XotBasePage` |
| `\Filament\Resources\Pages\ListRecords` | `\Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `\Filament\Resources\Pages\CreateRecord` | `\Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `\Filament\Resources\Pages\EditRecord` | `\Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `\Filament\Pages\Page` | `\Modules\Xot\Filament\Pages\XotBasePage` |
| `\Filament\Widgets\Widget` | `\Modules\Xot\Filament\Widgets\XotBaseWidget` |

## Esempi di Implementazione Corretta

### Resource
```php
namespace Modules\SaluteMo\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
// ...

class ExampleResource extends XotBaseResource
{
    // ...
}
```

### ListRecords Page
```php
namespace Modules\SaluteMo\Filament\Resources\ExampleResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
// ...

class ListExamples extends XotBaseListRecords
{
    // ...
}
```

## Errori Comuni da Evitare

### Estensione Diretta delle Classi Filament
❌ **ERRATO**:
```php
use Filament\Resources\Resource;

class ExampleResource extends Resource
```

✅ **CORRETTO**:
```php
use Modules\Xot\Filament\Resources\XotBaseResource;

class ExampleResource extends XotBaseResource
```

### Uso del Metodo `->label()`
❌ **ERRATO**:
```php
TextInput::make('title')->label('Titolo')
```

✅ **CORRETTO**:
Utilizzare il sistema di traduzione integrato:
```php
TextInput::make('title') // La traduzione viene gestita automaticamente dal LangServiceProvider
```

### Definizione di `navigationIcon` in XotBaseResource
❌ **ERRATO**:
```php
class ExampleResource extends XotBaseResource
{
    protected static ?string $navigationIcon = 'heroicon-o-document';
    // ...
}
```

✅ **CORRETTO**:
Non definire `$navigationIcon` se la classe estende `XotBaseResource`.

### Metodi da Rimuovere se Non Necessari
- Rimuovere `getRelations()` se restituisce un array vuoto
- Rimuovere `getPages()` se contiene solo route standard
- Rimuovere `Actions()` in XotBaseListRecords se restituisce solo `createAction`

## Struttura dei Metodi di Form e Tabella

### getFormSchema()
```php
public static function getFormSchema(): array
{
    return [
        'title' => Forms\Components\TextInput::make('title'),
        'content' => Forms\Components\RichEditor::make('content'),
        // Notare le chiavi 'title' e 'content' come stringhe
    ];
}
```

### getTableColumns()
```php
public function getTableColumns(): array
{
    return [
        'id' => Tables\Columns\TextColumn::make('id'),
        'title' => Tables\Columns\TextColumn::make('title'),
        // Notare le chiavi 'id' e 'title' come stringhe
    ];
}
```

## Collegamenti Correlati
- [Problemi Strutturali](../issues/structural-problems.md)
- [Convenzioni dei Namespace](../structure/namespace-conventions.md)
- [Widget di Filament](./widgets.md)
