# Convenzioni per la Dashboard Filament nel modulo SaluteMo

## Nomenclatura delle Classi Base Filament

### Regola Fondamentale
Quando si estendono classi di Filament, è essenziale utilizzare nomi di alias che evitino confusione e seguano lo schema di nomenclatura del progetto.

### Importazione Corretta delle Classi Base
```php
// ✅ CORRETTO
use Filament\Pages\Dashboard as FilamentDashboard;

// ❌ ERRATO
use Filament\Pages\Dashboard as BaseDashboard;
```

### Motivazione Filosofica e Architettonica
L'utilizzo di `FilamentDashboard` come alias segue un principio di chiarezza semantica che riflette l'origine effettiva della classe. Questo approccio:

1. **Tracciabilità**: Rende immediatamente evidente la provenienza della classe (pacchetto Filament)
2. **Coerenza**: Si allinea con lo schema di nomenclatura dove "Base" è riservato alle classi del modulo Xot
3. **Distinzione chiara**: Evita confusione con le classi di base personalizzate del progetto (XotBase*)
4. **Intento esplicito**: Comunica chiaramente che stiamo utilizzando una classe dal framework Filament

## Implementazione Corretta della Dashboard

### Struttura del File
```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Pages;

use Filament\Pages\Dashboard as FilamentDashboard;

class Dashboard extends FilamentDashboard
{
    // Personalizzazioni specifiche per SaluteMo
}
```

### Posizione e Namespace
- **File**: `/Modules/SaluteMo/app/Filament/Pages/Dashboard.php`
- **Namespace**: `Modules\SaluteMo\Filament\Pages`

### Widget Raccomandati
La Dashboard di SaluteMo dovrebbe includere widget pertinenti alle funzionalità mobile, come:

```php
protected function getHeaderWidgets(): array
{
    return [
        \Modules\SaluteMo\Filament\Widgets\MobileUserStatsWidget::class,
        \Modules\SaluteMo\Filament\Widgets\MobileActivityWidget::class,
    ];
}

protected function getFooterWidgets(): array
{
    return [
        \Modules\SaluteMo\Filament\Widgets\MobileUsageChartWidget::class,
    ];
}
```

## Approccio Zen all'Estensione delle Classi

La scelta del nome dell'alias per le classi estese rappresenta più di una semplice convenzione tecnica—è una manifestazione dell'approccio filosofico del progetto alla chiarezza e all'intento.

### Principi Fondamentali
1. **Trasparenza**: Il nome deve rivelare l'origine e lo scopo
2. **Specificità**: Deve essere specifico e non ambiguo
3. **Coerenza**: Deve seguire un pattern riconoscibile in tutto il progetto
4. **Intenzione**: Deve comunicare l'intento del designer

### Riflessione Pratica
Utilizzare `FilamentDashboard` invece di `BaseDashboard` è una scelta deliberata che riflette un approccio zen alla programmazione: la soluzione più semplice e diretta è spesso la migliore. Il nome comunica esattamente ciò che rappresenta la classe, senza introdurre ambiguità.

## Evoluzione Storica di questa Convenzione

La convenzione di utilizzo di `FilamentDashboard` è emersa dall'evoluzione dell'architettura del progetto, che inizialmente poteva utilizzare approcci diversi. La maturazione dell'architettura ha portato alla chiara separazione tra:

- **XotBase***: Classi base personalizzate dal modulo Xot
- **Filament***: Classi originali dal framework Filament
- **[Nome classe]**: Implementazioni specifiche del modulo

Questo approccio tripartitico garantisce che il flusso di ereditarietà sia sempre chiaro e tracciabile nel codice.

## Collegamenti Correlati
- [Struttura Filament](./structure.md)
- [Convenzioni di Nomenclatura](../structure/namespace-conventions.md)
- [Problemi di Implementazione Filament](../issues/filament-implementation/missing-dashboard.md)
