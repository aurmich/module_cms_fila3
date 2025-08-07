# Analisi FindDoctorAndAppointmentWidget - Studio Step Implementation

## 🎯 **Obiettivo**
Implementare il secondo step del wizard `FindDoctorAndAppointmentWidget` per visualizzare gli studi odontoiatrici filtrati in base a regione, provincia e CAP selezionati nel primo step.

## 📋 **Contesto Attuale**

### Widget Esistente
- **File**: `Modules/SaluteOra/app/Filament/Widgets/Patient/FindDoctorAndAppointmentWidget.php`
- **Struttura**: 5-step wizard (search → studio → date → time → confirm)
- **Problema**: `getStudioStepSchema()` è attualmente vuoto

### Step 1 (Funzionante)
```php
protected function getSeachStepSchema(): array
{
    return [
        'region' => Select::make('region')...    // ✅ Regioni da Comune
        'province' => Select::make('province')... // ✅ Province filtrate per regione
        'cap' => Select::make('cap')...          // ✅ CAP filtrati per provincia
    ];
}
```

### Step 2 (Da Implementare)
```php
protected function getStudioStepSchema(): array
{
    return []; // ❌ VUOTO - DA IMPLEMENTARE
}
```

## 🎨 **Design Target** (da docs/images/10.*)

### Specifiche Visual Design
- **Layout**: Lista verticale di card responsive
- **Card Structure**:
  - Nome studio (heading blu #0055a4)
  - Indirizzo completo (testo grigio)
  - Pulsante "Prenota" (blu con hover effects)
- **Animazioni**: Slide-in progressivo, hover con shadow
- **Mobile-first**: Stack verticale, bottoni touch-friendly

### HTML Reference Pattern
```html
<div class="bg-white rounded-lg p-6 shadow-md card-hover">
    <div class="flex flex-wrap justify-between items-center">
        <div class="mb-2 sm:mb-0">
            <h2 class="text-blue-800 text-2xl font-bold">Studio Odontoiatrico 1</h2>
            <p class="text-gray-500">Via Malapelli 9B, 00042 Roma</p>
        </div>
        <a href="#" class="bg-blue-800 text-white px-6 py-3 rounded-md">Prenota</a>
    </div>
</div>
```

## 🏗️ **Architettura Dati Disponibile**

### Studio Model
```php
class Studio extends BaseModel
{
    use HasAddress; // ✅ Trait per geolocalizzazione
    
    // Proprietà principali
    'name', 'phone', 'email', 'description', 'active'
    
    // Relazioni
    public function address(): MorphOne // ✅ Indirizzo principale
    public function doctors(): BelongsToMany // ✅ Dottori associati
}
```

### Address Model Integration
```php
class Address
{
    'postal_code',                     // ✅ CAP per filtro
    'administrative_area_level_3',     // ✅ Provincia 
    'administrative_area_level_2',     // ✅ Regione
    'locality',                       // ✅ Città
    'route', 'street_number',         // ✅ Via e numero
    'formatted_address'               // ✅ Indirizzo completo
}
```

### Query Pattern Necessaria
```php
Studio::whereHas('address', function($q) use ($cap, $province, $region) {
    $q->where('postal_code', $cap)
      ->where('administrative_area_level_3', $province)  
      ->where('administrative_area_level_2', $region);
})
->where('active', true)
->with(['address', 'doctors'])
->get();
```

## 🔧 **Approccio Implementativo CORRETTO**

### ✅ **Card/Pulsanti → TextInput Nascosto**
**Design conforme alle specifiche originali `/docs/images/10.*`**

```php
protected function getStudioStepSchema(): array
{
    return [
        Fieldset::make(__('saluteora::widgets.find_doctor_and_appointment.studio_list.title'))
            ->schema([
                // Campo nascosto che conterrà l'ID dello studio selezionato
                Form\TextInput::make('selected_studio')
                    ->label(__('saluteora::widgets.find_doctor_and_appointment.fields.selected_studio.label'))
                    ->placeholder(__('saluteora::widgets.find_doctor_and_appointment.fields.selected_studio.placeholder'))
                    ->helperText(__('saluteora::widgets.find_doctor_and_appointment.fields.selected_studio.helper_text'))
                    ->readonly()
                    ->required()
                    ->hidden(), // Campo nascosto
                
                // View con le card degli studi come pulsanti cliccabili
                Form\View::make('saluteora::filament.widgets.studio-cards-selector')
                    ->viewData(fn (Get $get) => [
                        'studios' => $this->getStudiosForLocationFull($get),
                        'selectedStudioId' => $get('selected_studio'),
                        'widget' => $this
                    ])
                    ->columnSpanFull(),
            ])
    ];
}
```

### ❌ **Errore Architetturale Iniziale**
**Select Component - NON conforme alle specifiche**

```php
// ❌ IMPLEMENTAZIONE ERRATA (corretta successivamente)
Select::make('selected_studio')
    ->options(fn (Get $get) => $this->getStudiosForLocation($get))
    ->searchable()
    ->required()
```

**Problema**: Le specifiche in `/docs/images/10.*` richiedevano chiaramente:
> **Lista risultati**: Tre schede bianche con i dettagli degli studi odontoiatrici:
> - Nome dello studio 
> - Indirizzo completo
> - **Pulsante "Prenota"** per ciascuno studio

### 🎨 **Implementazione Card View**
**Vista Blade con card responsive e pulsanti cliccabili**

```blade
{{-- saluteora::filament.widgets.studio-cards-selector --}}
<div x-data="{ selectedStudioId: @js($selectedStudioId) }">
    @foreach($studios as $studio)
        <div class="bg-white rounded-lg border-2 p-6 cursor-pointer"
             x-on:click="selectStudio({{ $studio->id }}, '{{ addslashes($studio->name) }}')">
            
            <h2 class="text-xl font-bold text-blue-800">{{ $studio->name }}</h2>
            <p class="text-gray-600">{{ $studio->address?->formatted_address }}</p>
            
            <div class="bg-blue-800 text-white px-6 py-3 rounded-md">
                Seleziona
            </div>
        </div>
    @endforeach
</div>
```

### 🚀 **Integrazione JavaScript**
**Alpine.js per gestione stato e notifiche**

```javascript
// Popola campo nascosto e mostra feedback
selectStudio(studioId, studioName) {
    this.selectedStudioId = studioId;
    $wire.set('data.selected_studio', studioId);
    
    $dispatch('notify', {
        type: 'success',
        title: 'Studio selezionato',
        body: 'Hai selezionato ' + studioName
    });
}
```

## 📚 **Sistema Traduzioni**

### Chiavi Necessarie da Aggiungere
```php
// lang/it/widgets.php
'find_doctor_and_appointment' => [
    'steps' => [
        'studio' => [
            'label' => 'Selezione Studio',
            'description' => 'Scegli lo studio più vicino a te'
        ]
    ],
    'studio_list' => [
        'title' => 'Gli Studi Odontoiatrici più vicini a te',
        'empty_state' => 'Nessuno studio trovato nella zona selezionata',
        'loading' => 'Caricamento studi...',
        'book_button' => 'Prenota',
        'distance' => 'Distanza',
        'phone' => 'Telefono',
        'specializations' => 'Specializzazioni'
    ]
]
```

## 🚀 **Piano Implementazione**

### Fase 1: Quick Fix (Filament Nativo)
1. ✅ **Select Component**: Implementazione base con Select
2. ✅ **Query Logic**: Filtro studios per location
3. ✅ **Traduzioni**: Aggiornamento chiavi widgets.php
4. ✅ **Testing**: Verificare funzionamento wizard

### Fase 2: UI Component Avanzato  
1. 🔄 **StudioCardSelector**: Componente riutilizzabile in UI
2. 🔄 **Blade Template**: Vista card responsive con design
3. 🔄 **JavaScript**: Interazioni hover e animazioni
4. 🔄 **Documentation**: Guida component UI

### Fase 3: Enhancement & Polish
1. 🔄 **Performance**: Caching queries, lazy loading
2. 🔄 **UX**: Loading states, error handling  
3. 🔄 **Accessibility**: Screen reader, keyboard nav
4. 🔄 **Mobile**: Ottimizzazioni touch e responsive

## 📖 **Riferimenti Documentazione**

### Modulo SaluteOra
- [Widget Analysis](./find_doctor_widget_error_analysis.md)
- [Geo Integration](../geo-integration.md)
- [Studio Models](../models/studio-address-relationship.md)

### Modulo UI  
- [Components Guide](../../UI/docs/components.md)
- [Form Components](../../UI/docs/form-components.md)
- [Filament Usage](../../UI/docs/filament_components_usage.md)

### Design Reference
- [Design Specification](../../../docs/images/10.md)
- [HTML Template](../../../docs/images/10.html)
- [Blade Integration](../../../docs/images/10.blade.php)

---

**Status**: 📋 Analysis Complete - Ready for Implementation  
**Priority**: 🔥 P1 - Core User Journey  
**Estimated Effort**: 2-3 days for complete implementation  
**Last Updated**: January 2025 