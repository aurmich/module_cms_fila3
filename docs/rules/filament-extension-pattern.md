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

## Esempi di Implementazione

### Esempio Errato
```php
// ❌ SCORRETTO
namespace Modules\Notify\Filament\Pages;

use Filament\Pages\Page;

class TestSmtpPage extends Page
{
    // Implementazione...
}
```

### Esempio Corretto
```php
// ✅ CORRETTO
namespace Modules\Notify\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class TestSmtpPage extends XotBasePage
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

## Errori Comuni da Evitare

1. Non importare classi Filament originali se si estendono le classi XotBase
2. Non definire proprietà di navigazione (`$navigationIcon`, `$navigationGroup`, ecc.) se la classe estende `XotBaseResource`
3. Non implementare metodi standard che sono già forniti dalle classi base

## Documentazione Correlata

- [Architettura Filament in SaluteOra](../filament/architecture.md)
- [XotBase Classes Analysis](../../laravel/Modules/Xot/docs/XOT_BASE_CLASSES_ANALYSIS.md)
- [Filament Form Schema Conventions](../rules/filament-form-schema.md)
