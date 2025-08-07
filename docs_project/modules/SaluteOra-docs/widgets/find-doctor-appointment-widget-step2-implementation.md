# Implementazione Step 2 - Studio Selection Widget

## Stato Implementazione

### ✅ **Componenti UI Creati**

#### 1. LocationSelector Component (Modulo UI)
**Path**: `laravel/Modules/UI/app/Filament/Forms/Components/LocationSelector.php`

```php
use Modules\UI\Filament\Forms\Components\LocationSelector;

// Utilizzo nel widget
LocationSelector::make()
    ->regionField('region')
    ->provinceField('province')
    ->capField('cap')
    ->required()
    ->searchable()
```

**Caratteristiche**:
- ✅ Selezione gerarchica Regione → Provincia → CAP
- ✅ Live updates automatici
- ✅ Integrazione modulo Geo
- ✅ Validazione cascata
- ✅ Error handling e logging
- ✅ Traduzioni in italiano

#### 2. StudioCard Component (Modulo UI)
**Path**: `laravel/Modules/UI/resources/views/components/ui/studio-card.blade.php`

```blade
<x-ui::ui.studio-card 
    :studio="$studio"
    :show-distance="true"
    :show-rating="true"
    :show-services="true"
    :actions="['book', 'details']"
    :selectable="true"
    wire-click="selectStudio({{ $studio->id }})"
/>
```

**Caratteristiche**:
- ✅ Layout responsive
- ✅ Informazioni complete studio
- ✅ Rating con stelle
- ✅ Distanza e servizi
- ✅ Azioni personalizzabili
- ✅ Stati di selezione
- ✅ Integrazione Livewire

### 📋 **Prossimo Step: Implementazione Widget**

## Step 1: Aggiornamento getSearchStepSchema

**File**: `laravel/Modules/SaluteOra/app/Filament/Widgets/Patient/FindDoctorAndAppointmentWidget.php`

```php
/**
 * Schema per il primo step - Selezione geografica
 */
protected function getSearchStepSchema(): array
{
    return [
        Fieldset::make('location_search')
            ->label(__('saluteora::widgets.find_doctor.steps.search.title'))
            ->schema([
                // Sostituire i Select esistenti con LocationSelector
                LocationSelector::make()
                    ->regionField('region')
                    ->provinceField('province')
                    ->capField('cap')
                    ->required()
                    ->searchable()
                    ->labels([
                        'region' => __('saluteora::widgets.find_doctor.fields.region.label'),
                        'province' => __('saluteora::widgets.find_doctor.fields.province.label'),
                        'cap' => __('saluteora::widgets.find_doctor.fields.cap.label'),
                    ])
                    ->placeholders([
                        'region' => __('saluteora::widgets.find_doctor.fields.region.placeholder'),
                        'province' => __('saluteora::widgets.find_doctor.fields.province.placeholder'),
                        'cap' => __('saluteora::widgets.find_doctor.fields.cap.placeholder'),
                    ])
            ])
    ];
}
```

## Step 2: Implementazione getStudioStepSchema (Approccio Semplificato)

```php
/**
 * Schema per il secondo step - Selezione studio (semplice con pulsanti + TextInput)
 */
protected function getStudioStepSchema(): array
{
    return [
        // Titolo step
        View::make('saluteora::filament.widgets.studio-step-header')
            ->viewData([
                'studiosCount' => $this->getStudiosCount(),
                'geographicArea' => $this->getGeographicAreaName(),
            ])
            ->visible(fn (): bool => $this->hasValidGeographicSelection()),

        // Pulsanti selezione studio
        View::make('saluteora::filament.widgets.studio-selector')
            ->viewData([
                'studios' => $this->getStudiosForSelectedArea(),
                'selectedStudio' => $this->data['selected_studio'] ?? null,
            ])
            ->visible(fn (): bool => $this->hasValidGeographicSelection()),

        // TextInput per mostrare studio selezionato
        TextInput::make('selected_studio_name')
            ->label(__('saluteora::widgets.find_doctor.fields.selected_studio.label'))
            ->placeholder(__('saluteora::widgets.find_doctor.fields.selected_studio.placeholder'))
            ->readonly()
            ->visible(fn (): bool => !empty($this->data['selected_studio']))
            ->suffixIcon('heroicon-o-check-circle')
            ->suffixIconColor('success'),

        // Hidden field per memorizzare ID studio
        Hidden::make('selected_studio'),
    ];
}
```

## Step 3: Metodi di Support Widget

```php
/**
 * Verifica se la selezione geografica è valida
 */
protected function hasValidGeographicSelection(): bool
{
    return !empty($this->data['region']) && 
           !empty($this->data['province']) && 
           !empty($this->data['cap']);
}

/**
 * Ottiene gli studi per l'area selezionata
 */
protected function getStudiosForSelectedArea(): Collection
{
    if (!$this->hasValidGeographicSelection()) {
        return collect();
    }

    return Studio::query()
        ->active()
        ->with(['addresses', 'media'])
        ->whereHas('addresses', function ($query) {
            $query->where('region_code', $this->data['region'])
                  ->where('province_code', $this->data['province'])
                  ->where('postal_code', $this->data['cap']);
        })
        ->limit(10) // Limita risultati per performance
        ->get();
}

/**
 * Ottiene il conteggio degli studi
 */
protected function getStudiosCount(): int
{
    return $this->getStudiosForSelectedArea()->count();
}

/**
 * Ottiene il nome dell'area geografica selezionata
 */
protected function getGeographicAreaName(): string
{
    if (!$this->hasValidGeographicSelection()) {
        return '';
    }

    // Utilizza il LocationSelector per ottenere i dati completi
    $locationData = $this->getLocationData();
    
    return sprintf('%s, %s (%s)', 
        $locationData['province']['name'] ?? '',
        $locationData['region']['name'] ?? '',
        $this->data['cap']
    );
}

/**
 * Azione Livewire per selezione studio (popola TextInput)
 */
public function selectStudio(int $studioId): void
{
    $studio = Studio::find($studioId);
    
    if (!$studio || !$studio->active) {
        $this->addError('selected_studio', 'Studio non disponibile');
        return;
    }

    // Aggiorna i dati del form
    $this->data['selected_studio'] = $studioId;
    $this->data['selected_studio_name'] = $studio->name;
    
    // Notifica il cambio di stato
    $this->dispatch('studio-selected', studioId: $studioId, studioName: $studio->name);
}
```

## Step 4: View Blade per Studio Step

### Header Studio Step
**File**: `laravel/Modules/SaluteOra/resources/views/filament/widgets/studio-step-header.blade.php`

```blade
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-2">
        {{ __('saluteora::widgets.find_doctor.steps.studio.title') }}
    </h2>
    
    <p class="text-sm text-gray-600 mb-4">
        {{ __('saluteora::widgets.find_doctor.steps.studio.description', [
            'area' => $geographicArea,
            'count' => $studiosCount
        ]) }}
    </p>

    @if($studiosCount === 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center">
                <x-filament::icon
                    name="heroicon-o-exclamation-triangle"
                    class="w-5 h-5 text-yellow-600 mr-2"
                />
                <div>
                    <h3 class="text-sm font-medium text-yellow-800">
                        {{ __('saluteora::widgets.find_doctor.steps.studio.no_studios_title') }}
                    </h3>
                    <p class="text-sm text-yellow-700 mt-1">
                        {{ __('saluteora::widgets.find_doctor.steps.studio.no_studios_message') }}
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
```

### Studio Selector (Semplificato)
**File**: `laravel/Modules/SaluteOra/resources/views/filament/widgets/studio-selector.blade.php`

```blade
<div class="space-y-4">
    {{-- Utilizziamo il componente UI semplificato --}}
    <x-ui::ui.studio-selector 
        :studios="$studios"
        :selected-studio="$selectedStudio"
        target-field="selected_studio"
    />
</div>
```

Il componente `studio-selector` (già creato nel modulo UI) gestisce:
- Pulsanti radio-style per ogni studio
- Visual feedback per selezione
- Informazioni compatte (nome, indirizzo, telefono)
- Empty states
- Integrazione con `wire:click="selectStudio()"`

## Step 5: Traduzioni

**File**: `laravel/Modules/SaluteOra/lang/it/widgets.php`

```php
return [
    'find_doctor' => [
        'steps' => [
            'search' => [
                'title' => 'Dove vuoi prenotare?',
                'description' => 'Seleziona la zona di interesse',
            ],
            'studio' => [
                'title' => 'Gli Studi Odontoiatrici più vicini a te',
                'description' => 'Abbiamo trovato :count studi disponibili in :area',
                'no_studios_title' => 'Nessuno studio trovato',
                'no_studios_message' => 'Non abbiamo trovato studi disponibili nell\'area selezionata. Prova a selezionare un\'area diversa.',
                'empty_title' => 'Seleziona un\'area',
                'empty_message' => 'Completa il primo step per vedere gli studi disponibili.',
            ],
        ],
        'fields' => [
            'region' => [
                'label' => 'Regione',
                'placeholder' => 'Seleziona una regione',
            ],
            'province' => [
                'label' => 'Provincia', 
                'placeholder' => 'Seleziona una provincia',
            ],
            'cap' => [
                'label' => 'CAP',
                'placeholder' => 'Seleziona un CAP',
            ],
            'selected_studio' => [
                'label' => 'Studio selezionato',
                'placeholder' => 'Nessuno studio selezionato',
            ],
        ],
    ],
];
```

## Step 6: Testing e Validazione

### Test Funzionale
```php
class FindDoctorWidgetStep2Test extends TestCase
{
    /** @test */
    public function step2_shows_studios_for_selected_area()
    {
        // Arrange
        $studio = Studio::factory()->create();
        $address = $studio->addresses()->create([
            'region_code' => '12',
            'province_code' => 'RM',
            'postal_code' => '00042',
        ]);
        
        $widget = Livewire::test(FindDoctorAndAppointmentWidget::class)
            ->set('data.region', '12')
            ->set('data.province', 'RM')
            ->set('data.cap', '00042');
            
        // Act & Assert
        $widget->assertSee($studio->name)
               ->assertSee('Prenota');
    }
    
    /** @test */
    public function selecting_studio_proceeds_to_next_step()
    {
        $studio = Studio::factory()->create();
        
        $widget = Livewire::test(FindDoctorAndAppointmentWidget::class)
            ->set('data.region', '12')
            ->set('data.province', 'RM')
            ->set('data.cap', '00042')
            ->call('selectStudio', $studio->id);
            
        $widget->assertSet('data.selected_studio', $studio->id);
    }
}
```

## Step 7: Performance e Ottimizzazioni

### Caching Query Studi
```php
protected function getStudiosForSelectedArea(): Collection
{
    $cacheKey = "studios_area_{$this->data['region']}_{$this->data['province']}_{$this->data['cap']}";
    
    return cache()->remember($cacheKey, 300, function () {
        return Studio::query()
            ->active()
            ->with(['addresses', 'media'])
            ->whereHas('addresses', function ($query) {
                $query->where('region_code', $this->data['region'])
                      ->where('province_code', $this->data['province'])
                      ->where('postal_code', $this->data['cap']);
            })
            ->limit(10)
            ->get();
    });
}
```

### Lazy Loading per Performance
```php
protected function getStudioStepSchema(): array
{
    return [
        Fieldset::make('studio_selection')
            ->lazy() // Carica solo quando necessario
            ->schema([
                // ... schema
            ])
    ];
}
```

## Roadmap Completamento

### ✅ **Fase 1 - COMPLETATA**
- [x] Analisi requisiti
- [x] Componenti UI riutilizzabili (LocationSelector, StudioSelector)
- [x] Documentazione architetturale
- [x] Approccio semplificato pulsanti + TextInput

### 🚧 **Fase 2 - READY FOR IMPLEMENTATION**
- [ ] Aggiornamento widget esistente con LocationSelector
- [ ] Implementazione getStudioStepSchema() semplificato
- [ ] View Blade studio-selector (già creata)
- [ ] Traduzioni complete
- [ ] Azione selectStudio() che popola TextInput

### 📋 **Fase 3 - PIANIFICATA**
- [ ] Test funzionali semplificati
- [ ] Ottimizzazioni performance con caching
- [ ] Validazione UX con pulsanti radio-style
- [ ] Documentazione finale approccio semplificato

---

**Creato**: 26 Giugno 2025  
**Aggiornato**: 26 Giugno 2025 - Semplificato con approccio pulsanti + TextInput  
**Stato**: Implementation Guide Ready (Approccio Semplificato)  
**Prossimo**: Widget Update con LocationSelector + StudioSelector  
**Approccio**: ✅ Pulsanti radio-style + TextInput readonly (semplice e diretto) 