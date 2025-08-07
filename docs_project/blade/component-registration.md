# Registrazione componenti Blade nel modulo Reporting

> **NOTA IMPORTANTE**: Questo documento è un riferimento specifico per il modulo Reporting.
> La documentazione completa si trova nel [modulo UI](../../../UI/docs/blade/component-registration.md).

## Componenti Blade disponibili

### ReportingChartAssets

Componente che carica gli asset necessari per i grafici (Chart.js, plugin e stili).

**Struttura**:
- Classe: `Modules\Reporting\View\Components\ReportingChartAssets`
- Vista: `Modules\Reporting\resources\views\components\chart-assets.blade.php`

**Utilizzo**:
```blade
<x-reporting-chart-assets />
```

**Assets caricati**:
- Chart.js
- Plugin per i colori personalizzati
- Plugin per le etichette dei dati
- Script e stili personalizzati

## Registrazione automatica tramite XotBaseServiceProvider

Il modulo Reporting utilizza `XotBaseServiceProvider` che registra automaticamente tutti i componenti Blade nella directory `Modules/Reporting/View/Components`.

### Errori comuni da evitare

1. ❌ **NON registrare manualmente** i componenti nel `ReportingServiceProvider`
2. ❌ **NON tentare di rinominare** le classi dei componenti per adattarle al tag (es. non rinominare `ReportingChartAssets` in `ChartAssets`)
3. ❌ **NON modificare** il percorso standard delle viste dei componenti

## Riferimenti

- [Documentazione generale sui componenti Blade](../../../UI/docs/blade/component-registration.md)
- [XotBaseServiceProvider](../../../Xot/app/Providers/XotBaseServiceProvider.php)
