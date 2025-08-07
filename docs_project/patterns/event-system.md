# Sistema di Eventi - SaluteOra

## Panoramica

Il modulo SaluteOra implementa un sistema di eventi Livewire per la comunicazione tra widget e componenti, permettendo un'architettura disaccoppiata e reattiva.

## Pattern Implementati

### Naming Convention Eventi

#### Pattern Standard
- `{entità}-changed`: Quando cambia l'entità principale
- `{entità}-selected`: Per selezione da componenti esterni  
- `{entità}-filter-applied`: Per applicazione filtri
- `{entità}-updated`: Per aggiornamenti generici

#### Esempi Reali
```php
// Eventi studio
'studio-changed'       // StudioFilterWidget cambio studio
'studio-selected'      // Selezione studio da form esterni
'studio-filter-applied' // Filtro studio applicato

// Eventi appuntamenti
'appointment-created'   // Nuovo appuntamento
'appointment-updated'   // Modifica appuntamento
'appointment-cancelled' // Annullamento
```

### Dispatching Eventi

#### Pattern Base
```php
// Nel widget/componente che genera l'evento
$this->dispatch('studio-changed', [
    'studioId' => $studioId,
    'studio' => $this->currentStudio->toArray(),
    'timestamp' => now()->toISOString(),
]);
```

#### Dati Standard Eventi
Ogni evento dovrebbe includere:
- **ID dell'entità**: `studioId`, `appointmentId`, etc.
- **Dati dell'entità**: oggetto serializzato
- **Metadata**: timestamp, user_id, etc.
- **Context**: informazioni aggiuntive se necessarie

### Listening Eventi

#### Attributo On
```php
use Livewire\Attributes\On;

class MyWidget extends XotBaseWidget
{
    #[On('studio-changed')]
    public function onStudioChanged(array $data): void
    {
        if (isset($data['studioId'])) {
            $this->selectedStudioId = $data['studioId'];
            $this->refresh();
        }
    }
    
    #[On('studio-selected')]
    public function onStudioSelected(array $data): void
    {
        // Gestione selezione esterna
        $this->changeStudio($data['studioId']);
    }
}
```

#### Listener Multipli
```php
#[On('studio-changed')]
#[On('studio-selected')]
#[On('studio-filter-applied')]
public function onStudioEvent(array $data): void
{
    // Gestione unificata eventi studio
    $this->handleStudioChange($data);
}
```

## Implementazione StudioFilterWidget

### Eventi Dispatched

#### studio-changed
```php
public function changeStudio(int $studioId): void
{
    // ... validazioni e logica ...
    
    // Dispatch evento con dati completi
    $this->dispatch('studio-changed', [
        'studioId' => $studioId,
        'studio' => $this->currentStudio->toArray(),
        'previousStudioId' => $this->currentStudioId,
        'userId' => Auth::id(),
        'timestamp' => now()->toISOString(),
    ]);
    
    // Aggiorna tenant per coerenza
    if (Filament::getTenant()?->id !== $studioId) {
        session(['tenant_id' => $studioId]);
    }
}
```

### Eventi Listened

#### studio-selected
```php
#[On('studio-selected')]
public function onStudioSelected(array $data): void
{
    if (isset($data['studioId'])) {
        // Cambia studio senza loop infinito
        $this->changeStudio($data['studioId']);
    }
}
```

## Gestione Form e Widget

### FindDoctorAndAppointmentWidget
```php
// Nel widget di prenotazione
#[On('studio-changed')]
public function onStudioChanged(array $data): void
{
    // Reset campi dipendenti quando cambia studio
    $this->reset(['doctor_id', 'appointment_date', 'appointment_time']);
    
    // Aggiorna opzioni disponibili
    $this->loadAvailableDoctors($data['studioId']);
}

// Dispatch quando seleziona studio nel form
public function updateStudioSelection($studioId): void
{
    $this->dispatch('studio-selected', [
        'studioId' => $studioId,
        'source' => 'appointment-form',
    ]);
}
```

### Dashboard Widgets
```php
// Widget statistiche
#[On('studio-changed')]
public function onStudioChanged(array $data): void
{
    $this->selectedStudioId = $data['studioId'];
    $this->loadStatistics();
}

// Widget calendario
#[On('studio-changed')]
public function onStudioChanged(array $data): void
{
    $this->studioId = $data['studioId'];
    $this->loadAppointments();
}
```

## Pattern Avanzati

### Event Bubbling
```php
// Widget figlio dispatcha a genitore
$this->dispatch('child-event', $data)->to('parent-component');

// Dispatch globale
$this->dispatch('global-event', $data)->self();
```

### Conditional Listening
```php
#[On('studio-changed')]
public function onStudioChanged(array $data): void
{
    // Processa solo se il widget è attivo
    if (!$this->isActive) {
        return;
    }
    
    // Processa solo se studio diverso dall'attuale
    if ($data['studioId'] === $this->currentStudioId) {
        return;
    }
    
    $this->handleStudioChange($data);
}
```

### Debouncing Eventi
```php
public function changeStudio(int $studioId): void
{
    // Evita dispatching multipli rapidi
    if ($this->lastEventTime && now()->diffInMilliseconds($this->lastEventTime) < 100) {
        return;
    }
    
    $this->lastEventTime = now();
    
    // ... logica cambio studio ...
    
    $this->dispatch('studio-changed', $data);
}
```

## Debugging Eventi

### Logging
```php
public function changeStudio(int $studioId): void
{
    Log::info('StudioFilterWidget: Changing studio', [
        'from_studio_id' => $this->currentStudioId,
        'to_studio_id' => $studioId,
        'user_id' => Auth::id(),
        'component' => static::class,
    ]);
    
    // ... logica ...
    
    $this->dispatch('studio-changed', $data);
    
    Log::info('StudioFilterWidget: Event dispatched', [
        'event' => 'studio-changed',
        'data' => $data,
    ]);
}
```

### Browser Console
```php
// In vista Blade per debug
<script>
document.addEventListener('livewire:event-dispatched', (event) => {
    if (event.detail.event === 'studio-changed') {
        console.log('Studio changed event:', event.detail.data);
    }
});
</script>
```

### Livewire Devtools
- Usare browser extension per monitoring eventi real-time
- Verificare payload eventi nel network tab
- Tracciare lifecycle componenti

## Best Practices

### Performance
1. **Dati Minimali**: Inviare solo dati necessari negli eventi
2. **Debouncing**: Evitare eventi troppo frequenti
3. **Conditional Processing**: Non processare eventi inutili
4. **Lazy Loading**: Caricare dati pesanti solo quando necessario

### Architettura
1. **Single Responsibility**: Un evento una responsabilità
2. **Naming Consistency**: Seguire convention stabilite
3. **Data Structure**: Struttura dati eventi consistente
4. **Error Handling**: Gestire errori nei listener

### UX
1. **Immediate Feedback**: UI reattiva agli eventi
2. **Loading States**: Indicatori durante elaborazione
3. **Error Messages**: Feedback chiaro in caso di errori
4. **Rollback**: Possibilità di annullare azioni

## Troubleshooting

### Eventi Non Ricevuti
```php
// Verificare registrazione listener
dd(static::class, method_exists($this, 'onStudioChanged'));

// Verificare nome evento
Log::info('Listening for events:', ['events' => $this->getEventsBeingListenedFor()]);
```

### Dati Mancanti
```php
#[On('studio-changed')]
public function onStudioChanged(array $data): void
{
    // Validare struttura dati
    if (!isset($data['studioId'])) {
        Log::warning('Missing studioId in studio-changed event', $data);
        return;
    }
    
    // Continuare elaborazione
}
```

### Loop Infiniti
```php
public function changeStudio(int $studioId): void
{
    // Evitare auto-trigger
    if ($studioId === $this->currentStudioId) {
        return;
    }
    
    // Flag per evitare re-trigger
    if ($this->isChangingStudio) {
        return;
    }
    
    $this->isChangingStudio = true;
    
    try {
        // Logica cambio studio
        $this->dispatch('studio-changed', $data);
    } finally {
        $this->isChangingStudio = false;
    }
}
```

## Testing

### Unit Tests
```php
public function test_dispatches_studio_changed_event(): void
{
    Event::fake();
    
    $widget = Livewire::test(StudioFilterWidget::class);
    $widget->call('changeStudio', 1);
    
    Event::assertDispatched('studio-changed');
}
```

### Feature Tests
```php
public function test_studio_filter_updates_other_widgets(): void
{
    $studio1 = Studio::factory()->create();
    $studio2 = Studio::factory()->create();
    
    $filterWidget = Livewire::test(StudioFilterWidget::class);
    $statsWidget = Livewire::test(StudioStatsWidget::class);
    
    // Cambia studio nel filter
    $filterWidget->call('changeStudio', $studio2->id);
    
    // Verifica aggiornamento stats widget
    $statsWidget->assertSet('selectedStudioId', $studio2->id);
}
```

## Collegamenti

### Documentazione Correlata
- [Widget Development](widget-development.md)
- [StudioFilterWidget](../studio-filter-widget.md)
- [LangServiceProvider](../langserviceprovider-labels.md)

### File Correlati
- `StudioFilterWidget.php`
- `FindDoctorAndAppointmentWidget.php`
- Tutti i widget che implementano eventi

*Ultimo aggiornamento: Gennaio 2025*
*Basato su: StudioFilterWidget event system*
