# Prevenzione Errori Widget Filament

## Regole Critiche - MAI VIOLARE

### 1. Access Level - getHeading()
**CRITICO**: Il metodo `getHeading()` deve essere `public`:

```php
// ✅ CORRETTO - SEMPRE USARE
public function getHeading(): ?string
{
    return __('salutemo::widgets.widget_name.title');
}

// ❌ ERRORE FATALE - MAI USARE
protected function getHeading(): ?string
{
    return __('salutemo::widgets.widget_name.title');
}
```

### 2. Type Hints - Proprietà Statiche
**CRITICO**: I type hints devono essere esatti:

```php
// ✅ CORRETTO
protected static ?string $heading = null;
protected static ?int $sort = 1;
protected static bool $isLazy = true;  // bool, non ?bool
protected static ?string $pollingInterval = '5m';

// ❌ ERRORE FATALE
protected static ?bool $isLazy = true;  // ?bool causa errore
protected static int $sort = 1;         // int causa errore
```

### 3. Estensione Corretta - REGOLA CRITICA
**CRITICO**: NON estendere MAI direttamente le classi Filament. Utilizzare SEMPRE le classi XotBase:

```php
// ✅ CORRETTO - SEMPRE USARE
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class WidgetName extends XotBaseChartWidget
{
    // Implementazione...
}

// ❌ ERRORE FATALE - MAI USARE
use Filament\Widgets\ChartWidget;

class WidgetName extends ChartWidget  // ERRORE: estensione diretta Filament
{
    // Implementazione...
}
```

**REGOLA FONDAMENTALE**: 
- Se prima estendevi `\Filament\Widgets\ChartWidget`
- Ora estendi `\Modules\Xot\Filament\Widgets\XotBaseChartWidget`
- Preserva sempre la struttura e il nome della classe originale
- Aggiungi sempre il prefisso `XotBase`

## Checklist Obbigatoria

### Prima di Ogni Commit
- [ ] `getHeading()` è `public`
- [ ] `$isLazy` è `bool` (non `?bool`)
- [ ] `$sort` è `?int` (non `int`)
- [ ] `$heading` è `?string` (non `string`)
- [ ] `$pollingInterval` è `?string` (non `string`)
- [ ] **CRITICO**: Estensione è `XotBaseChartWidget` (NON `ChartWidget`)
- [ ] Namespace è `Modules\SaluteMo\Filament\Widgets`
- [ ] **CRITICO**: Import `Modules\Xot\Filament\Widgets\XotBaseChartWidget` presente
- [ ] **CRITICO**: NON importare mai direttamente classi Filament

### Verifica Type Hints
```php
// Proprietà corrette per ChartWidget
protected static ?string $heading = null;      // nullable string
protected static ?int $sort = 1;               // nullable int
protected static bool $isLazy = true;          // non-nullable bool
protected static ?string $pollingInterval = '5m'; // nullable string
```

## Errori Comuni e Soluzioni

### Errore: "Access level to ... getHeading() must be public"
**Causa**: Metodo `getHeading()` è `protected`
**Soluzione**: Cambiare in `public`

### Errore: "Type of ... $isLazy must be bool"
**Causa**: Proprietà `$isLazy` è `?bool`
**Soluzione**: Cambiare in `bool`

### Errore: "Type of ... $sort must be ?int"
**Causa**: Proprietà `$sort` è `int`
**Soluzione**: Cambiare in `?int`

## Template Widget Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Illuminate\Support\Facades\Cache;

class ExampleChartWidget extends XotBaseChartWidget
{
    // CRITICO: Type hints esatti
    protected static ?string $heading = null;
    protected static ?int $sort = 1;
    protected static bool $isLazy = true;  // bool, non ?bool
    protected static ?string $pollingInterval = '5m';

    // CRITICO: public, non protected
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
1. **getHeading() = public** - Sempre, senza eccezioni
2. **$isLazy = bool** - Mai nullable
3. **XotBaseChartWidget** - Estensione XotBase per grafici (NON ChartWidget diretto)
4. **Type hints esatti** - Controllare sempre prima del commit
5. **NON estendere mai classi Filament direttamente** - Regola CRITICA

### VERIFICA SEMPRE
- Access level dei metodi
- Type hints delle proprietà
- Import e namespace
- **CRITICO**: Estensione XotBase (NON Filament diretto)
- **CRITICO**: Import XotBase (NON Filament diretto)

## Collegamenti Correlati
- [Widget Documentation](./widgets.md)
- [Dashboard Widgets](./dashboard-widgets-completed.md)
- [Filament Documentation](https://filamentphp.com/docs/2.x/admin/widgets) 