# AppointmentOverviewWidget - Design e Implementazione

## Panoramica

Il `AppointmentOverviewWidget` è un widget Filament personalizzato che mostra statistiche degli appuntamenti organizzate per stato. A differenza del `StatsOverviewWidget` di Filament, questo widget è progettato per essere più compatto, elegante e occupare meno spazio verticale.

**⚠️ IMPORTANTE**: Questo widget mostra **TUTTI** gli appuntamenti del sistema, non filtrati per utente specifico. È progettato per dashboard amministrative e panoramiche generali.

## Obiettivi del Design

### 1. **Compattezza**
- Occupazione minima di spazio verticale
- Layout orizzontale efficiente
- 9 elementi per riga su desktop (responsive)

### 2. **Eleganza**
- Design pulito e moderno
- Icone e colori distintivi per ogni stato
- Animazioni sottili per migliorare l'UX

### 3. **Funzionalità**
- Conteggio in tempo reale per ogni stato
- Aggiornamento automatico dei dati
- Interazione minima (solo visualizzazione)
- **Statistiche globali** (non filtrate per utente)

## Architettura Tecnica

### Estensione Base
```php
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class AppointmentOverviewWidget extends XotBaseWidget
{
    // Implementazione specifica
}
```

### Caratteristiche XotBaseWidget
- ✅ **InteractsWithForms**: Gestione form integrata
- ✅ **InteractsWithPageFilters**: Supporto filtri di pagina
- ✅ **InteractsWithActions**: Gestione azioni
- ✅ **TransTrait**: Sistema traduzioni automatico

## Struttura Dati

### Stati degli Appuntamenti
Il widget mostra tutti gli stati disponibili dal sistema `AppointmentState`:

```php
protected function getAppointmentStates(): array
{
    $states = [];
    $stateMapping = AppointmentState::getStateMapping()->toArray();
    
    foreach ($stateMapping as $name => $stateClass) {
        $appointment = new Appointment();
        $state = new $stateClass($appointment);
        
        $states[] = [
            'name' => $name,
            'label' => $state->label(),
            'icon' => $state->icon(),
            'color' => $state->bgColor(),
            'count' => $this->getCountForState($name),
            'description' => $state->modalDescription(),
        ];
    }
    
    return $states;
}
```

### Conteggio per Stato - STATISTICHE GLOBALI
```php
/**
 * Ottiene il conteggio degli appuntamenti per uno stato specifico.
 * IMPORTANTE: Mostra TUTTI gli appuntamenti, non filtrati per utente.
 */
protected function getCountForState(string $stateName): int
{
    // ✅ CORRETTO - Statistiche globali per dashboard amministrativa
    return Appointment::where('state', $stateName)->count();
    
    // ❌ ERRATO - Non filtrare per utente specifico
    // ->when(auth()->user()->hasRole('doctor'), function ($query) {
    //     return $query->where('doctor_id', auth()->id());
    // })
}
```

### Principio Fondamentale
- **Dashboard Amministrativa**: Mostra statistiche complete del sistema
- **Non Filtro Utente**: Tutti gli appuntamenti sono visibili
- **Panoramica Globale**: Per gestione e monitoraggio generale

## Layout Responsive

### Grid System
```blade
{{-- 4 colonne su mobile, 6 su tablet, 9 su desktop --}}
<div class="grid grid-cols-4 gap-3 md:grid-cols-6 lg:grid-cols-9">
    @foreach($states as $state)
        <div class="bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-200 dark:border-gray-700">
            {{-- Contenuto stato --}}
        </div>
    @endforeach
</div>
```

### Breakpoints
- **Mobile**: 4 colonne (320px+)
- **Tablet**: 6 colonne (768px+)
- **Desktop**: 9 colonne (1024px+)

## Componenti UI

### Card Stato
Ogni stato è rappresentato da una card compatta con:

```blade
<div class="text-center">
    {{-- Icona con background colorato --}}
    <div class="inline-flex items-center justify-center w-8 h-8 rounded-full mb-1" 
         style="background-color: {{ $state['color'] }}20;">
        <x-heroicon-o-{{ $state['icon'] }} 
             class="w-4 h-4" 
             style="color: {{ $state['color'] }};" />
    </div>
    
    {{-- Conteggio --}}
    <div class="text-sm font-bold text-gray-900 dark:text-white">
        {{ number_format($state['count']) }}
    </div>
    
    {{-- Label --}}
    <div class="text-xs text-gray-600 dark:text-gray-400 mt-0.5 leading-tight">
        {{ $state['label'] }}
    </div>
</div>
```

## Performance e Caching

### Strategia di Caching
```php
protected function getCachedStats(): array
{
    $cacheKey = 'appointment-overview-stats-global'; // Cache globale, non per utente
    
    return Cache::remember($cacheKey, now()->addMinutes(5), function () {
        return $this->calculateStats();
    });
}
```

### Invalidation Cache
```php
protected function invalidateCache(): void
{
    $cacheKey = 'appointment-overview-stats-global';
    Cache::forget($cacheKey);
}
```

## Traduzioni

### Struttura File Traduzione
```php
// Modules/SaluteMo/lang/it/widgets.php
return [
    'appointment_overview' => [
        'title' => 'Panoramica Appuntamenti',
        'description' => 'Statistiche globali degli appuntamenti per stato',
        'no_data' => 'Nessun appuntamento trovato',
        'loading' => 'Caricamento statistiche...',
    ],
];
```

### Utilizzo Traduzioni
```php
// Nel widget
public function getTitle(): string
{
    return __('salutemo::widgets.appointment_overview.title');
}
```

## Metodi Obbligatori

### getFormSchema()
```php
/**
 * Schema del form per il widget.
 * Questo widget non ha form, restituisce array vuoto.
 *
 * @return array<int|string, \Filament\Forms\Components\Component>
 */
public function getFormSchema(): array
{
    return []; // Widget solo visualizzazione
}
```

### getViewData()
```php
/**
 * Dati da passare alla vista.
 *
 * @return array<string, mixed>
 */
protected function getViewData(): array
{
    return [
        'states' => $this->getAppointmentStates(),
        'totalAppointments' => $this->getTotalAppointments(),
        'lastUpdated' => now()->format('H:i'),
    ];
}
```

## Vista Blade

### Template Completo
```blade
{{-- resources/views/filament/widgets/appointment-overview.blade.php --}}
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-4">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ __('salutemo::widgets.appointment_overview.title') }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('salutemo::widgets.appointment_overview.description') }}
                    </p>
                </div>
                <div class="text-xs text-gray-500">
                    Aggiornato: {{ $lastUpdated }}
                </div>
            </div>

            {{-- Stati Grid --}}
            <div class="grid grid-cols-4 gap-3 md:grid-cols-6 lg:grid-cols-9">
                @foreach($states as $state)
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                        <div class="text-center">
                            {{-- Icona --}}
                            <div class="inline-flex items-center justify-center w-8 h-8 rounded-full mb-1" 
                                 style="background-color: {{ $state['color'] }}20;">
                                <x-heroicon-o-{{ $state['icon'] }} 
                                     class="w-4 h-4" 
                                     style="color: {{ $state['color'] }};" />
                            </div>
                            
                            {{-- Conteggio --}}
                            <div class="text-sm font-bold text-gray-900 dark:text-white">
                                {{ number_format($state['count']) }}
                            </div>
                            
                            {{-- Label --}}
                            <div class="text-xs text-gray-600 dark:text-gray-400 mt-0.5 leading-tight">
                                {{ $state['label'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Footer --}}
            <div class="text-center text-sm text-gray-500">
                Totale: {{ number_format($totalAppointments) }} appuntamenti
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
```

## Configurazione Widget

### Proprietà Widget
```php
class AppointmentOverviewWidget extends XotBaseWidget
{
    protected static ?string $pollingInterval = '30s'; // Aggiornamento automatico
    protected int | string | array $columnSpan = 'full'; // Larghezza completa
    protected static ?int $sort = 1; // Ordinamento nel dashboard
    
    public string $title = '';
    public string $icon = 'heroicon-o-calendar-days';
}
```

### Registrazione Widget
```php
// Nel ServiceProvider del modulo
protected function registerWidgets(): void
{
    Filament::registerWidgets([
        AppointmentOverviewWidget::class,
    ]);
}
```

## Testing

### Test Structure
```php
class AppointmentOverviewWidgetTest extends TestCase
{
    /** @test */
    public function it_renders_all_appointment_states(): void
    {
        // Test che tutti gli stati vengano renderizzati
    }
    
    /** @test */
    public function it_shows_correct_counts_for_each_state(): void
    {
        // Test che i conteggi siano corretti
    }
    
    /** @test */
    public function it_shows_global_statistics_not_filtered_by_user(): void
    {
        // Test che mostri statistiche globali, non filtrate per utente
    }
}
```

## Vantaggi vs StatsOverviewWidget

### ✅ Vantaggi del Nuovo Design
1. **Spazio Ottimizzato**: Occupa meno spazio verticale
2. **Layout Responsive**: 9 elementi per riga su desktop
3. **Design Personalizzato**: Controllo completo su stile e layout
4. **Performance**: Caching ottimizzato per grandi dataset
5. **Flessibilità**: Facile personalizzazione e estensione
6. **Statistiche Globali**: Mostra tutti gli appuntamenti del sistema

### ❌ Limitazioni StatsOverviewWidget
1. **Layout Rigido**: Massimo 4 colonne per riga
2. **Spazio Verticale**: Occupa più spazio del necessario
3. **Personalizzazione Limitata**: Difficile modificare stile e layout
4. **Performance**: Nessun caching integrato

## Collegamenti Bidirezionali

### Documentazione Correlata
- [XotBaseWidget](../../Xot/docs/filament/widgets/xot-base-widget.md)
- [Widget Rules Consolidated](./widget-rules-consolidated.md)
- [Appointment States](../../SaluteOra/docs/appointment-states.md)
- [Filament Widgets Philosophy](../../../docs/filosofia_filament_widgets.md)

### Implementazione
- [AppointmentOverviewWidget](../app/Filament/Resources/AppointmentResource/Widgets/AppointmentOverviewWidget.php)
- [Vista Widget](../resources/views/filament/widgets/appointment-overview.blade.php)
- [Traduzioni Widget](../lang/it/widgets.php)

---

*Ultimo aggiornamento: Gennaio 2025*
*Versione: 1.1*
*Compatibilità: Laravel 12.x, Filament 3.x, XotBaseWidget* 