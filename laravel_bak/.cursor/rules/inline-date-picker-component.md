# InlineDatePicker Component Rules

## Filosofia del Componente

Il componente `InlineDatePicker` rappresenta una **manifestazione fenomenologica** del tempo nell'interfaccia utente, applicando principi di:

- **Zen Design**: Minimalismo che elimina friction cognitivo
- **Fisica Quantistica**: Date in stato di potenzialità fino alla selezione
- **Termodinamica**: Minimizzazione entropia informativa
- **Governance Democratica**: Controllo trasparente delle date disponibili
- **Navigazione Temporale**: Controllo quantistico del flusso temporale (NUOVO v2.0)

## Regole Fondamentali

### ✅ Pattern Corretti

```php
use Modules\UI\Filament\Forms\Components\InlineDatePicker;

// Utilizzo standard con date selettive
InlineDatePicker::make('appointment_date')
    ->enabledDates(['2025-06-05', '2025-06-21'])
    ->highlightColor('bg-indigo-600 text-white')
    ->compactMode()
    ->required();

// Con closure dinamica per business logic
InlineDatePicker::make('date')
    ->enabledDates(fn () => $this->getAvailableDates())
    ->live()
    ->afterStateUpdated(fn ($state) => $this->handleDateSelection($state));
```

### ❌ Anti-pattern da Evitare

```php
// MAI usare DatePicker standard per date limitate
DatePicker::make('date')->minDate(now())->maxDate(now()->addDays(30));

// MAI hardcodare date statiche
->enabledDates(['2025-01-01', '2025-01-02'])

// MAI omettere enabledDates se ci sono restrizioni
InlineDatePicker::make('date') // Tutte le date selezionabili!
```

## API Methods - Governance di Utilizzo

### enabledDates() - OBBLIGATORIO
Definisce le date selezionabili seguendo il principio di **scarsità controllata**.

```php
// Array statico (solo per prototyping)
->enabledDates(['2025-06-05', '2025-06-21'])

// Closure dinamica (pattern raccomandato)
->enabledDates(fn () => AvailabilityService::getAvailableDates())

// Con caching per performance
->enabledDates(function () {
    return cache()->remember('dates_'.$this->id, 300, fn () => 
        $this->calculateAvailableDates()
    );
})
```

### highlightColor() - Design System
Semiologia cromatica standardizzata:

```php
->highlightColor('bg-indigo-600 text-white')   // Default/Neutral
->highlightColor('bg-green-600 text-white')    // Success/Available  
->highlightColor('bg-orange-600 text-white')   // Warning/Limited
->highlightColor('bg-red-600 text-white')      // Error/Unavailable
```

### compactMode() - Responsive Design
```php
->compactMode()           // Per sidebar, modal, mobile
->compactMode(false)      // Per main content areas
```

### showNavigation() - Controllo Democratico Temporale (NUOVO v2.0)
```php
->showNavigation(true)    // Default: navigazione completa abilitata
->showNavigation(false)   // Solo visualizzazione, nessun controllo temporale
```

## Navigazione Temporale Avanzata - NUOVO v2.0 🚀

### Principi Quantistici della Navigazione
La navigazione implementa **fisica quantistica applicata al design UI**:

- **Cronologia**: Sequenza ordinata degli eventi temporali
- **Sincronicità**: Coordinazione dell'esperienza temporale  
- **Persistenza**: Mantenimento dello stato durante la navigazione
- **Democraticità**: Controllo utente completo sul flusso temporale

### Pattern JavaScript Alpine.js
```javascript
x-data="{
    currentMonth: @js($currentViewMonth->format('Y-m')),
    
    // Navigazione con easing quantistico
    navigateToMonth(direction) {
        const currentDate = new Date(this.currentMonth + '-01');
        
        if (direction === 'prev') {
            currentDate.setMonth(currentDate.getMonth() - 1);
        } else if (direction === 'next') {
            currentDate.setMonth(currentDate.getMonth() + 1);
        }
        
        const newMonth = currentDate.getFullYear() + '-' + 
            String(currentDate.getMonth() + 1).padStart(2, '0');
        
        this.currentMonth = newMonth;
        $wire.call('setCurrentViewMonth', newMonth);
    }
}"
```

### Metodi PHP per Controllo Temporale
```php
// Metodo Livewire per bridge JavaScript→PHP
public function setCurrentViewMonth(string $monthString): void

// Helper di navigazione diretta
$picker->previousMonth();               // Mese precedente
$picker->nextMonth();                   // Mese successivo  
$picker->setDisplayDate($carbon);       // Mese specifico

// Controllo stato navigazione
$current = $picker->getCurrentViewMonth();  // Carbon instance
$hasPrev = $picker->hasPreviousMonth();     // bool
$hasNext = $picker->hasNextMonth();         // bool
```

### Iconografia Quantistica UI
```html
<!-- Controlli di navigazione standard -->
<button @click="navigateToMonth('prev')" aria-label="Mese precedente">
    <!-- Chevron Left: simbolo movimento temporale verso passato -->
    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
    </svg>
</button>
```

## Integrazione con Wizard

Pattern orchestrale per composizione armonica:

```php
protected function getDateSelectionStep(): Wizard\Step
{
    return Wizard\Step::make('date_selection')
        ->icon('heroicon-o-calendar')
        ->schema([
            InlineDatePicker::make('appointment_date')
                ->enabledDates(fn () => $this->getAvailableDates())
                ->live()
                ->afterStateUpdated(function ($state) {
                    $this->loadTimeSlots($state);
                    $this->updatePricing($state);
                    $this->validateBusinessRules($state);
                }),
        ]);
}
```

## Performance e Sicurezza

### Caching Strategy
```php
->enabledDates(function () {
    return cache()->remember('doctor_'.$this->doctorId.'_dates', 300, 
        fn () => AvailabilityService::getDoctorAvailableDates($this->doctorId)
    );
})
```

### Validazione Server-Side OBBLIGATORIA
```php
->rules([
    function ($value, Closure $fail) {
        if (!AvailabilityService::isDateActuallyAvailable($value)) {
            $fail('Data non più disponibile');
        }
    }
])
```

## Testing Requirements

### Unit Testing Pattern
```php
/** @test */
public function it_only_allows_enabled_dates_selection(): void
{
    $component = InlineDatePicker::make('test')
        ->enabledDates(['2025-06-05']);
    
    $this->assertTrue($component->isDateEnabled('2025-06-05'));
    $this->assertFalse($component->isDateEnabled('2025-06-06'));
}
```

### Integration Testing Pattern  
```php
/** @test */
public function it_integrates_with_wizard_correctly(): void
{
    Livewire::test(AppointmentWizard::class)
        ->set('appointment_date', '2025-06-05')
        ->assertHasNoFormErrors()
        ->assertSet('appointment_date', '2025-06-05');
}
```

## Documentazione Obbligatoria

### File da Mantenere
1. `Modules/UI/docs/components/inline-date-picker.md` - Documentazione completa
2. `Modules/UI/docs/components.md` - Overview integrata  
3. `Modules/{Module}/docs/inline-date-picker-usage.md` - Utilizzo specifico

### Collegamenti Bidirezionali
- Documentazione UI ↔ Root docs
- Documentazione modulo ↔ UI docs
- Regole .cursor/.windsurf ↔ Documentazione markdown

## Accessibilità - Design Universale

### Screen Reader Support
Aria-labels automatici per ogni data con descrizioni semantiche.

### Keyboard Navigation
- Tab/Shift+Tab per navigazione tra date
- Enter/Space per selezione
- Arrow keys per navigazione calendario (roadmap)

## Compliance Standards

### PHPStan Level 9+
- Tipizzazione rigorosa completa
- Generics per collection
- Null safety assoluta

### Laraxot Framework Conventions
- Namespace: `Modules\UI\Filament\Forms\Components`
- View: `ui::filament.forms.components.inline-date-picker`
- Translations: `ui::components.inline_date_picker.*`

## Roadmap Evolutiva

### Feature Pianificate
1. **Multi-Date Selection** - Range di date
2. **Time Integration** - Selezione data+ora unificata
3. **Recurring Patterns** - Pattern ricorrenti
4. **AI Suggestions** - Suggerimenti intelligenti ML

### Ecosystem Integration
1. **Google Calendar Sync** - Integrazione calendari esterni
2. **Weather API** - Info meteo per eventi outdoor  
3. **Holiday API** - Festività automatiche
4. **Timezone Support** - Gestione fusi orari

## Backlink e Collegamenti

- [UI Components Documentation](../../Modules/UI/docs/components.md)
- [Form Components Guide](../../Modules/UI/docs/form-components.md)
- [SaluteOra Usage Example](../../Modules/SaluteOra/docs/inline-date-picker-usage.md)
- [Windsurf Rules](../.windsurf/rules/inline-date-picker-component.mdc)

---

*Ultimo aggiornamento: Dicembre 2024*  
*Versione: 2.0.0 con Navigazione Temporale Quantistica*  
*Principi: Fenomenologia, Zen, Fisica Quantistica, Governance Democratica, Cronologia* 