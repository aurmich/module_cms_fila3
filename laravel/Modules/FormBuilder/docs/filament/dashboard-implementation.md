# Dashboard Implementation Rules

## Principi Fondamentali

Nel framework Laraxot, tutte le Dashboard dei moduli **DEVONO** estendere `Modules\Xot\Filament\Pages\XotBaseDashboard`. **MAI** estendere direttamente `Filament\Pages\Dashboard`.

## Filosofia e Motivazione

- **Filosofia**: "Una sola base per tutte le dashboard"
- **Politica**: "Non avrai altra dashboard all'infuori di XotBase"
- **Religione**: "La centralizzazione dei filtri porta alla serenità del codice"
- **Zen**: "Semplicità nella dashboard, potenza nei widget"

## Struttura Corretta

### ✅ Pattern Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBaseDashboard;
use Modules\FormBuilder\Filament\Widgets;

/**
 * Dashboard principale del modulo FormBuilder.
 *
 * Estende XotBaseDashboard per garantire:
 * - Filtri standardizzati e persistenti
 * - Gestione widget centralizzata
 * - Coerenza UI/UX tra moduli
 * - Pattern di navigazione uniforme
 */
class Dashboard extends XotBaseDashboard
{
    // ✅ NIENTE proprietà di navigazione - le Dashboard sono pagine speciali

    /**
     * Schema dei filtri specifici per il modulo.
     *
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public function getFiltersFormSchema(): array
    {
        return [
            // Filtri specifici del modulo FormBuilder
        ];
    }

    /**
     * Widget da visualizzare nell'header della dashboard.
     *
     * @return array<class-string>
     */
    public function getHeaderWidgets(): array
    {
        return [
            // Widget header specifici
        ];
    }

    /**
     * Widget da visualizzare nel footer della dashboard.
     *
     * @return array<class-string>
     */
    public function getFooterWidgets(): array
    {
        return [
            // Widget footer specifici
        ];
    }

    /**
     * Widget da visualizzare nella dashboard (metodo richiesto da Filament).
     *
     * @return array<class-string>
     */
    public function getWidgets(): array
    {
        return [
            // Widget principali della dashboard
        ];
    }
}
```

### ❌ Anti-Pattern (da evitare)

```php
<?php

// ❌ MAI estendere direttamente Dashboard di Filament
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // Questo approccio è VIETATO nel framework Laraxot
}

// ❌ MAI estendere XotBasePage per le Dashboard
use Modules\Xot\Filament\Pages\XotBasePage;

class Dashboard extends XotBasePage
{
    // Le Dashboard hanno logiche specifiche diverse dalle pagine generiche
}

// ❌ MAI dichiarare proprietà di navigazione nelle Dashboard
class Dashboard extends XotBaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home'; // ERRORE!
    protected static ?string $navigationGroup = 'FormBuilder'; // ERRORE!
    protected static ?int $navigationSort = 1; // ERRORE!
    
    // Le Dashboard sono pagine speciali, non elementi di navigazione
}
```

## ⚠️ REGOLA CRITICA: NO Proprietà di Navigazione

**Le Dashboard NON devono MAI dichiarare proprietà di navigazione**:

- `$navigationIcon` ❌
- `$navigationGroup` ❌ 
- `$navigationSort` ❌
- `$navigationLabel` ❌

**Motivazione**: Le Dashboard sono pagine speciali in Filament che rappresentano la pagina principale del pannello, non elementi di navigazione. Queste proprietà sono riservate alle pagine normali che appaiono nel menu di navigazione.

**Filosofia**: "La Dashboard è la casa, non un elemento del menu"
**Politica**: "Non avrai proprietà di navigazione nella Dashboard"
**Religione**: "La Dashboard è sacra e non ha bisogno di navigazione"
**Zen**: "Semplicità nella Dashboard, navigazione altrove"

## Funzionalità Ereditate da XotBaseDashboard

### Gestione Filtri Automatica

- **Persistenza Filtri**: I filtri vengono automaticamente salvati nella sessione
- **Form Centralizzato**: Struttura form standardizzata con sezioni
- **Trait HasFiltersForm**: Gestione automatica dei filtri

### Metodi Disponibili

#### `getFiltersFormSchema(): array`

Definisce i filtri specifici del modulo:

```php
public function getFiltersFormSchema(): array
{
    return [
        DatePicker::make('startDate')
            ->label('Data Inizio')
            ->maxDate(fn (Get $get) => $get('endDate') ?: now()),
            
        DatePicker::make('endDate')
            ->label('Data Fine')
            ->minDate(fn (Get $get) => $get('startDate') ?: now())
            ->maxDate(now()),
            
        Select::make('status')
            ->label('Stato')
            ->options([
                'all' => 'Tutti',
                'active' => 'Attivi',
                'inactive' => 'Inattivi',
            ])
            ->default('all'),
    ];
}
```

#### Widget Methods

- `getHeaderWidgets()`: Widget visualizzati nell'header
- `getFooterWidgets()`: Widget visualizzati nel footer  
- `getWidgets()`: Widget principali (metodo richiesto da Filament)

## Implementazione Specifica FormBuilder

### Widget Consigliati

```php
public function getHeaderWidgets(): array
{
    return [
        Widgets\FormStatsOverviewWidget::class,
        Widgets\QuickActionsWidget::class,
    ];
}

public function getFooterWidgets(): array
{
    return [
        Widgets\FormSubmissionsChartWidget::class,
        Widgets\FormFieldsDistributionWidget::class,
        Widgets\PopularTemplatesWidget::class,
        Widgets\RecentActivityWidget::class,
    ];
}

public function getWidgets(): array
{
    return [
        Widgets\FormManagementWidget::class,
        Widgets\SubmissionOverviewWidget::class,
    ];
}
```

### Filtri Specifici FormBuilder

```php
public function getFiltersFormSchema(): array
{
    return [
        DatePicker::make('startDate')
            ->label('Data Inizio')
            ->maxDate(fn (Get $get) => $get('endDate') ?: now()),
            
        DatePicker::make('endDate')
            ->label('Data Fine')
            ->minDate(fn (Get $get) => $get('startDate') ?: now())
            ->maxDate(now()),
            
        Select::make('formStatus')
            ->label('Stato Form')
            ->options([
                'all' => 'Tutti gli stati',
                'active' => 'Attivi',
                'inactive' => 'Inattivi',
                'draft' => 'Bozza',
                'archived' => 'Archiviati',
            ])
            ->default('all'),
            
        Select::make('formCategory')
            ->label('Categoria Form')
            ->options([
                'all' => 'Tutte le categorie',
                'medical' => 'Medico',
                'survey' => 'Sondaggio',
                'contact' => 'Contatto',
                'registration' => 'Registrazione',
            ])
            ->default('all'),
    ];
}
```

## Proprietà Standard

### Navigazione

```php
protected static ?string $navigationIcon = 'heroicon-o-home';
protected static ?string $navigationGroup = 'FormBuilder';
protected static ?int $navigationSort = 1;
```

### View Personalizzata (Opzionale)

```php
protected static string $view = 'formbuilder::filament.pages.dashboard';
```

## Best Practices

### 1. Organizzazione Widget

- **Header**: Widget di statistiche rapide e azioni veloci
- **Body**: Widget principali di gestione e overview
- **Footer**: Widget di analisi e grafici dettagliati

### 2. Filtri Efficaci

- Utilizzare filtri che influenzano realmente i widget
- Mantenere filtri semplici e intuitivi
- Fornire valori predefiniti sensati

### 3. Performance

- Limitare il numero di widget per evitare sovraccarico
- Utilizzare lazy loading per widget pesanti
- Implementare caching dove appropriato

### 4. Accessibilità

- Utilizzare icone standard di Heroicons
- Fornire label descrittive per tutti i filtri
- Mantenere un layout responsive

## Errori Comuni e Soluzioni

### Errore: "Class not found XotBaseDashboard"

**Causa**: Import non corretto della classe base

**Soluzione**:
```php
use Modules\Xot\Filament\Pages\XotBaseDashboard;
```

### Errore: "Method getFiltersFormSchema not found"

**Causa**: Metodo non implementato nella classe figlia

**Soluzione**:
```php
public function getFiltersFormSchema(): array
{
    return []; // Anche se vuoto, deve essere implementato
}
```

### Errore: Widget non visualizzati

**Causa**: Metodi widget non implementati o widget non esistenti

**Soluzione**:
- Verificare che i widget esistano nel namespace corretto
- Implementare tutti i metodi widget richiesti
- Controllare i permessi di accesso ai widget

## Vantaggi dell'Approccio Centralizzato

### 1. Coerenza UI/UX

- Layout standardizzato tra tutti i moduli
- Comportamento filtri uniforme
- Pattern di navigazione consolidati

### 2. Manutenibilità

- Modifiche alla logica dashboard in un solo punto
- Aggiornamenti automatici per tutti i moduli
- Refactoring sicuro e controllato

### 3. Funzionalità Avanzate

- Persistenza filtri automatica
- Gestione stato dashboard
- Integrazione con sistema di permessi

### 4. Estensibilità

- Override semplice per logiche custom
- Aggiunta filtri specifici per modulo
- Personalizzazione widget per esigenze specifiche

## Documentazione Correlata

- [XotBaseDashboard Source](/var/www/html/_bases/base_saluteora/laravel/Modules/Xot/app/Filament/Pages/XotBaseDashboard.php)
- [Esempio SaluteMo](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteMo/app/Filament/Pages/Dashboard.php)
- [Widget Implementation](../widgets/implementation-guide.md)
- [Filament Dashboard Documentation](https://filamentphp.com/docs/3.x/panels/dashboard)

## Note Importanti

- **Filtri Persistenti**: I filtri vengono salvati automaticamente nella sessione
- **Trait HasFiltersForm**: Già incluso in XotBaseDashboard
- **Metodi Obbligatori**: `getFiltersFormSchema()` deve essere sempre implementato
- **Widget Responsivi**: Considerare sempre la visualizzazione mobile

*Ultimo aggiornamento: Luglio 2025*
