# Regola Critica: Estensione XotBase - MAI VIOLARE

## Regola Fondamentale

**CRITICO**: NON estendere MAI direttamente le classi Filament. Utilizzare SEMPRE le classi XotBase con il prefisso appropriato.

## Pattern di Estensione

### Regola Generale
Se prima estendevi una classe Filament, ora estendi la corrispondente classe XotBase:

```
\Filament\Widgets\ChartWidget → \Modules\Xot\Filament\Widgets\XotBaseChartWidget
\Filament\Widgets\Widget → \Modules\Xot\Filament\Widgets\XotBaseWidget
\Filament\Pages\Page → \Modules\Xot\Filament\Pages\XotBasePage
\Filament\Resources\Resource → \Modules\Xot\Filament\Resources\XotBaseResource
```

### Esempi Specifici

#### ChartWidget
```php
// ❌ ERRORE FATALE - MAI USARE
use Filament\Widgets\ChartWidget;
class WidgetName extends ChartWidget

// ✅ CORRETTO - SEMPRE USARE
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
class WidgetName extends XotBaseChartWidget
```

#### Widget Generico
```php
// ❌ ERRORE FATALE - MAI USARE
use Filament\Widgets\Widget;
class WidgetName extends Widget

// ✅ CORRETTO - SEMPRE USARE
use Modules\Xot\Filament\Widgets\XotBaseWidget;
class WidgetName extends XotBaseWidget
```

#### StatsOverviewWidget
```php
// ❌ ERRORE FATALE - MAI USARE
use Filament\Widgets\StatsOverviewWidget;
class WidgetName extends StatsOverviewWidget

// ✅ CORRETTO - SEMPRE USARE
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;
class WidgetName extends XotBaseStatsOverviewWidget
```

#### Page
```php
// ❌ ERRORE FATALE - MAI USARE
use Filament\Pages\Page;
class PageName extends Page

// ✅ CORRETTO - SEMPRE USARE
use Modules\Xot\Filament\Pages\XotBasePage;
class PageName extends XotBasePage
```

#### Resource
```php
// ❌ ERRORE FATALE - MAI USARE
use Filament\Resources\Resource;
class ResourceName extends Resource

// ✅ CORRETTO - SEMPRE USARE
use Modules\Xot\Filament\Resources\XotBaseResource;
class ResourceName extends XotBaseResource
```

## Checklist Obbigatoria

### Prima di Ogni Commit
- [ ] **CRITICO**: NON importare mai classi Filament direttamente
- [ ] **CRITICO**: Importare sempre classi XotBase
- [ ] **CRITICO**: Estendere sempre classi XotBase
- [ ] **CRITICO**: Preservare il nome della classe originale + prefisso XotBase
- [ ] **CRITICO**: Verificare che l'import sia corretto

### Verifica Import
```php
// ❌ ERRORE - Import diretto Filament
use Filament\Widgets\ChartWidget;
use Filament\Pages\Page;
use Filament\Resources\Resource;

// ✅ CORRETTO - Import XotBase
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Resources\XotBaseResource;
```

## Motivazione Architettonica

### Separazione delle Responsabilità
- **Filament**: Framework originale, non modificabile
- **XotBase**: Classi base personalizzate del progetto
- **Moduli**: Implementazioni specifiche che estendono XotBase

### Vantaggi dell'Approccio XotBase
1. **Consistenza**: Tutte le classi seguono lo stesso pattern
2. **Manutenibilità**: Modifiche centralizzate nelle classi base
3. **Estensibilità**: Funzionalità aggiuntive nelle classi XotBase
4. **Tracciabilità**: Chiara separazione tra framework e personalizzazioni

## Errori Comuni da Evitare

### 1. Import Diretto Filament
```php
// ❌ ERRORE
use Filament\Widgets\ChartWidget;
```

### 2. Estensione Diretta Filament
```php
// ❌ ERRORE
class WidgetName extends ChartWidget
```

### 3. Confusione Nomi
```php
// ❌ ERRORE - Nome sbagliato
use Modules\Xot\Filament\Widgets\XotBaseWidget;  // Per ChartWidget
```

## Template Corretto

### ChartWidget Template
```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Illuminate\Support\Facades\Cache;

class ExampleChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = null;
    protected static ?int $sort = 1;
    protected static bool $isLazy = true;
    protected static ?string $pollingInterval = '5m';

    public function getHeading(): ?string
    {
        return __('salutemo::widgets.example_chart.title');
    }

    protected function getData(): array
    {
        // Implementazione dati
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        // Configurazione grafico
    }

    protected function getHeight(): ?string
    {
        return '300px';
    }

    public static function canView(): bool
    {
        return true;
    }
}
```

## Regole di Memoria

### MAI DIMENTICARE
1. **NON estendere mai classi Filament direttamente**
2. **Sempre estendere classi XotBase**
3. **Preservare il nome della classe originale + prefisso XotBase**
4. **Importare sempre le classi XotBase**
5. **Verificare sempre prima del commit**

### VERIFICA SEMPRE
- Import corretto (XotBase, non Filament)
- Estensione corretta (XotBase, non Filament)
- Nome classe corretto (XotBase + nome originale)
- Namespace corretto

## Collegamenti Correlati
- [Widget Documentation](./widgets.md)
- [Error Prevention](./widget-error-prevention.md)
- [Dashboard Widgets](./dashboard-widgets-completed.md) 