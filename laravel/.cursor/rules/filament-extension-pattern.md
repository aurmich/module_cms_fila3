# Pattern di Estensione per Componenti Filament

## Regola Fondamentale

**NON estendere MAI direttamente le classi Filament, ma utilizzare sempre le classi base corrispondenti con il prefisso "XotBase" dal modulo Xot.**

## Mappatura delle Classi

| Classe Filament | Classe Base da Utilizzare |
|-----------------|---------------------------|
| `\Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` |
| `\Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `\Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `\Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `\Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `\Filament\Resources\Pages\ViewRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord` |
| `\Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |

## Esempi

### CORRETTO ✅

```php
use Modules\Xot\Filament\Pages\XotBasePage;

class SendSmsPage extends XotBasePage
{
    // Implementazione...
}
```

### ERRATO ❌

```php
use Filament\Pages\Page;

class SendSmsPage extends Page // NON fare questo!
{
    // Implementazione...
}
```

## Motivazione

1. **Personalizzazione Centralizzata**: Le classi XotBase forniscono funzionalità specifiche per SaluteOra
2. **Aggiornamenti Semplificati**: Quando Filament viene aggiornato, è possibile adattare solo le classi XotBase
3. **Funzionalità Aggiuntive**: Le classi XotBase includono metodi e proprietà aggiuntivi
4. **Gestione delle Dipendenze**: Le classi XotBase gestiscono dipendenze specifiche del progetto
5. **Consistenza del Codice**: Garantisce che tutti i componenti seguano lo stesso pattern

## Verifica

Prima di ogni commit, verificare che:
1. Nessuna classe estenda direttamente una classe Filament
2. Tutte le classi Filament estendano la corrispondente classe XotBase
