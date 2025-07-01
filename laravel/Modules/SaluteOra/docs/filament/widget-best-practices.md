# Widget Filament - Best Practices SaluteOra

## Lezioni Apprese dall'Implementazione

Questa documentazione raccoglie le **lezioni critiche** apprese durante l'implementazione di widget complessi nel modulo SaluteOra, in particolare dal `StudioFilterWidget` e `DoctorAvailabilitiesWidget`.

## Pattern Architetturale Obbligatorio

### 1. Estensione XotBaseWidget
```php
// ✅ SEMPRE estendere XotBaseWidget
class MyWidget extends XotBaseWidget implements HasActions
{
    use InteractsWithActions;
    
    protected static string $view = 'saluteora::filament.widgets.my-widget';
}

// ❌ MAI estendere direttamente Widget
class MyWidget extends Widget  // ERRORE
```

**Motivazione**: XotBaseWidget fornisce funzionalità centralizzate, pattern consistenti e integrazione con il framework Laraxot.

### 2. Metodi Obbligatori per Compatibilità
```php
/**
 * Schema del form per questo widget.
 * Obbligatorio anche se vuoto per compatibilità con XotBaseWidget.
 *
 * @return array<int|string, \Filament\Forms\Components\Component>
 */
public function getFormSchema(): array
{
    // Restituire array vuoto se il widget non ha form
    return [];
}
```

### 3. Controllo Accesso Statico
```php
/**
 * SEMPRE usare static per canView()
 */
public static function canView(): bool  // ✅ CORRETTO
{
    $user = Auth::user();
    
    return $user instanceof User && 
           $user->type === UserTypeEnum::DOCTOR &&
           $user instanceof Doctor;
}

// ❌ ERRATO
public function canView(): bool  // Non statico
```

## Pattern di Sicurezza Multi-Livello

### Controlli Progressivi
```php
public static function canView(): bool
{
    // 1. Verifica autenticazione base
    $user = Auth::user();
    if (!$user instanceof User) {
        return false;
    }
    
    // 2. Verifica tipo utente tramite enum
    if ($user->type !== UserTypeEnum::DOCTOR) {
        return false;
    }
    
    // 3. Verifica istanza specifica (STI)
    if (!$user instanceof Doctor) {
        return false;
    }
    
    // 4. Verifica business logic specifica
    return $user->studios()->exists();
}
```

### Pattern di Tenancy Awareness
```php
/**
 * Integrazione con Filament Tenancy
 */
private function getCurrentContext(): ?Studio
{
    // Usa il tenant corrente se disponibile
    $tenantId = Filament::getTenant()?->id;
    
    if ($tenantId) {
        return $this->getDoctor()
            ->studios()
            ->where('studios.id', $tenantId)
            ->first();
    }
    
    // Fallback: studio principale del dottore
    return $this->getDoctor()
        ->studios()
        ->wherePivot('is_primary', true)
        ->first();
}
```

## Gestione Eventi e Comunicazione

### Pattern Event-Driven
```php
public function changeContext(string $newId): void
{
    try {
        // 1. Validazione e cambio stato
        $this->validateAndUpdateContext($newId);
        
        // 2. Dispatch eventi per altri componenti
        $this->dispatch('context-changed', [
            'contextId' => $newId,
            'contextType' => 'studio',
            'timestamp' => now()->toISOString(),
        ]);
        
        // 3. Notifica utente
        Notification::make()
            ->title(__('saluteora::widgets.context_changed'))
            ->success()
            ->send();
            
        // 4. Logging per audit
        Log::info('Widget context changed', [
            'widget' => static::class,
            'user_id' => auth()->id(),
            'new_context' => $newId,
        ]);
        
    } catch (\Exception $e) {
        $this->handleContextChangeError($e);
    }
}
```

### Listener Pattern
```php
protected array $listeners = [
    'studio-changed' => 'onStudioChanged',
    'context-refresh' => 'refreshData',
];

public function onStudioChanged(array $data): void
{
    $this->currentStudioId = $data['studioId'] ?? null;
    $this->refreshData();
}
```

## Gestione Relazioni e Performance

### Eager Loading Pattern
```php
protected function getRelatedData(): Collection
{
    return $this->getDoctor()
        ->studios()
        ->with(['address', 'doctors']) // Eager loading
        ->withPivot(['schedule', 'is_primary', 'created_at']) // Dati pivot
        ->where('active', true) // Filtri appropriati
        ->orderBy('studio_user.is_primary', 'desc') // Studio principale primo
        ->orderBy('name') // Ordinamento secondario
        ->get();
}
```

### Caching Strategy
```php
protected function getCachedData(string $key, callable $callback, int $ttl = 300)
{
    $cacheKey = sprintf('widget.%s.%s.%s', 
        static::class, 
        auth()->id(), 
        $key
    );
    
    return Cache::remember($cacheKey, $ttl, $callback);
}
```

## Traduzioni Strutturate

### Gerarchia Standardizzata
```php
// laravel/Modules/SaluteOra/lang/it/widgets.php
'widget_name' => [
    'title' => 'Titolo Widget',
    'description' => 'Descrizione funzionalità',
    
    'sections' => [
        'main_info' => 'Informazioni Principali',
        'actions' => 'Azioni Disponibili',
    ],
    
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'help_text' => 'Testo di aiuto',
            'placeholder' => 'Placeholder',
        ],
    ],
    
    'actions' => [
        'action_name' => [
            'label' => 'Etichetta Azione',
            'tooltip' => 'Tooltip descrittivo',
            'confirmation' => 'Messaggio di conferma',
        ],
    ],
    
    'messages' => [
        'success' => 'Operazione completata',
        'error' => 'Errore durante operazione',
        'loading' => 'Caricamento in corso...',
    ],
    
    'empty_states' => [
        'no_data' => 'Nessun dato disponibile',
        'no_permission' => 'Accesso non autorizzato',
    ],
];
```

## Pattern Vista Blade

### Wrapper Standard
```blade
<x-filament::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('saluteora::widgets.widget_name.title') }}
        </x-slot>
        
        <x-slot name="description">
            {{ __('saluteora::widgets.widget_name.description') }}
        </x-slot>
        
        <x-slot name="headerActions">
            {{ $this->myAction }}
        </x-slot>
        
        {{-- Contenuto principale --}}
        <div class="space-y-4">
            {{-- Struttura del widget --}}
        </div>
    </x-filament::section>
</x-filament::widget>
```

### Pattern Responsive
```blade
{{-- Grid responsive con fallback mobile --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    {{-- Colonna principale --}}
    <div class="lg:col-span-2">
        {{-- Contenuto principale --}}
    </div>
    
    {{-- Sidebar azioni --}}
    <div class="lg:col-span-1">
        {{-- Azioni e informazioni secondarie --}}
    </div>
</div>

{{-- Stack mobile-first --}}
<div class="space-y-4">
    {{-- Elementi impilati verticalmente su mobile --}}
</div>
```

## Error Handling e Resilienza

### Pattern Graceful Degradation
```php
protected function getViewData(): array
{
    try {
        $data = $this->fetchPrimaryData();
        
        return [
            'status' => 'success',
            'data' => $data,
            'hasData' => !empty($data),
        ];
        
    } catch (DatabaseException $e) {
        Log::error('Widget database error', [
            'widget' => static::class,
            'error' => $e->getMessage(),
        ]);
        
        return [
            'status' => 'error',
            'data' => [],
            'hasData' => false,
            'errorMessage' => __('saluteora::widgets.common.database_error'),
        ];
        
    } catch (\Exception $e) {
        Log::error('Widget unexpected error', [
            'widget' => static::class,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        return [
            'status' => 'error',
            'data' => [],
            'hasData' => false,
            'errorMessage' => __('saluteora::widgets.common.unexpected_error'),
        ];
    }
}
```

### Validation Pattern
```php
private function validateBusinessRules(): bool
{
    $user = $this->getDoctor();
    
    // Validazioni multiple con early return
    if (!$user->studios()->exists()) {
        $this->addError('studios', __('saluteora::widgets.errors.no_studios'));
        return false;
    }
    
    if (!$user->is_active) {
        $this->addError('status', __('saluteora::widgets.errors.inactive_user'));
        return false;
    }
    
    return true;
}
```

## Testing Pattern

### Unit Testing
```php
class MyWidgetTest extends TestCase
{
    /** @test */
    public function widget_is_visible_only_to_authorized_users()
    {
        // Test controllo accesso
        $doctor = Doctor::factory()->create();
        $this->actingAs($doctor);
        
        $this->assertTrue(MyWidget::canView());
    }
    
    /** @test */
    public function widget_handles_context_changes_correctly()
    {
        // Test gestione eventi
        $widget = Livewire::test(MyWidget::class);
        $widget->call('changeContext', 'studio-123');
        
        $widget->assertEmitted('context-changed');
    }
}
```

### Integration Testing
```php
/** @test */
public function widget_integrates_with_filament_tenancy()
{
    $studio = Studio::factory()->create();
    $doctor = Doctor::factory()->create();
    $doctor->studios()->attach($studio, ['is_primary' => true]);
    
    Filament::setTenant($studio);
    $this->actingAs($doctor);
    
    $widget = Livewire::test(MyWidget::class);
    $widget->assertSee($studio->name);
}
```

## Performance Best Practices

### 1. Lazy Loading
```php
public function mount(): void
{
    // Inizializzazione minima
    $this->initializeBasicState();
    
    // Dati pesanti caricati on-demand
    $this->defer(['loadHeavyData']);
}

public function loadHeavyData(): void
{
    $this->heavyData = $this->fetchComplexData();
}
```

### 2. Database Optimization
```php
// ✅ Ottimizzato
public function getStudiosWithStats(): Collection
{
    return $this->getDoctor()
        ->studios()
        ->withCount(['appointments', 'activePatients'])
        ->with(['address:id,studio_id,full_address'])
        ->selectRaw('studios.*, studio_user.is_primary')
        ->get();
}

// ❌ Non ottimizzato (N+1 queries)
public function getStudiosWithStats(): Collection
{
    return $this->getDoctor()->studios->map(function ($studio) {
        return [
            'studio' => $studio,
            'appointments_count' => $studio->appointments()->count(), // N+1!
            'patients_count' => $studio->patients()->count(), // N+1!
        ];
    });
}
```

## Anti-Pattern da Evitare

### ❌ Widget Monolitici
```php
// ERRATO: Widget che fa troppo
class MegaWidget extends XotBaseWidget
{
    // Gestisce studi, appuntamenti, pazienti, fatturazione, statistiche...
    // 500+ righe di codice
}
```

### ❌ Logic Business nelle Viste
```blade
{{-- ERRATO: Calcoli nella vista --}}
@php
    $totalRevenue = $appointments->sum(function($apt) {
        return $apt->price * $apt->tax_rate;
    });
@endphp
```

### ❌ Stati Mutable Condivisi
```php
// ERRATO: Stato condiviso tra istanze
class BadWidget extends XotBaseWidget
{
    public static $sharedState = []; // Problematico!
}
```

### ❌ Hardcoded Business Rules
```php
// ERRATO: Regole hardcoded
if ($user->type === 'doctor' && $user->specialty === 'cardiologist') {
    // Logica specifica hardcoded
}

// CORRETTO: Usare enum e configuration
if ($user->type === UserTypeEnum::DOCTOR && $user->hasSpecialty(SpecialtyEnum::CARDIOLOGY)) {
    // Logica configurabile
}
```

## Checklist Widget Production-Ready

### Implementazione
- [ ] Estende XotBaseWidget
- [ ] Implementa getFormSchema() (anche se vuoto)
- [ ] canView() è statico con controlli multi-livello
- [ ] Gestione errori robusta con try-catch
- [ ] Eager loading per relazioni
- [ ] Caching per dati costosi

### Sicurezza
- [ ] Controlli di autorizzazione completi
- [ ] Validazione input utente
- [ ] Logging per audit trail
- [ ] Gestione session e tenancy

### UX/UI
- [ ] Traduzioni complete e strutturate
- [ ] Design responsive mobile-first
- [ ] Stati di caricamento e errore
- [ ] Feedback utente chiaro e tempestivo

### Performance
- [ ] Query ottimizzate (no N+1)
- [ ] Lazy loading per dati pesanti
- [ ] Caching appropriato
- [ ] Paginazione per grandi dataset

### Testing
- [ ] Test unità per business logic
- [ ] Test integrazione con Filament
- [ ] Test sicurezza e autorizzazioni
- [ ] Test performance con dati grandi

### Documentazione
- [ ] Documentazione tecnica completa
- [ ] Esempi di utilizzo
- [ ] API documentation
- [ ] Collegamenti bidirezionali

## Collegamenti Correlati

- [StudioFilterWidget Implementation](../widgets/studio-filter-widget.md)
- [DoctorAvailabilitiesWidget Analysis](../widgets/doctor-availabilities-widget-analysis.md)
- [Multi-Studio Management](../models/multi-studio-management.md)
- [Filament Tenancy Integration](../filament/tenancy-integration.md)
- [Translation Guidelines](../translations/widget-translations.md)

*Ultimo aggiornamento: Gennaio 2025*
*Versione: 2.0 - Post StudioFilterWidget Implementation*
*Priorità: P0 - Fondamentale per qualità codebase* 