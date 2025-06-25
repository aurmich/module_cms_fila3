# DoctorAvailabilitiesWidget - Analisi Completa e Implementazione

## Analisi Post-Studio (Gennaio 2025)

### 🎯 Scopo Corretto del Widget

**ERRORE INIZIALE**: Avevo frainteso il ruolo del widget pensando fosse un calendario.

**SCOPO REALE**: Il `DoctorAvailabilitiesWidget` deve:
1. **Mostrare tutti gli studi** in cui lavora il dottore autenticato
2. **Per ogni studio** visualizzare la colonna `schedule` della tabella pivot `studio_user`
3. **Rendering readable** degli orari impostati tramite `OpeningHoursField`

### 🔍 Analisi Architettura Esistente

#### DoctorAvailabilityPage (Singolo Studio)
- **Funzione**: Gestisce gli orari per UN studio specifico (current tenant)
- **Componente**: Usa `OpeningHoursField` per editing degli orari
- **Scope**: Multi-tenancy (lavora su studio corrente)
- **Pattern**: Form → salvataggio → notifica

#### DoctorAvailabilitiesWidget (Multi-Studio Overview)
- **Funzione**: Visualizza TUTTI gli studi del dottore
- **Componente**: Dovrà usare `OpeningHoursField` per ogni studio
- **Scope**: Global overview con editing inline
- **Pattern**: Widget → form per studio → salvataggio AJAX

### 🏗️ Architettura Implementata

#### Modello Pivot: StudioUser
```php
class StudioUser extends BasePivot
{
    protected $fillable = ['user_id', 'studio_id', 'schedule', 'is_primary'];
    
    protected function casts(): array {
        return [
            'schedule' => 'array',      // ← Struttura OpeningHoursField
            'is_primary' => 'boolean',
        ];
    }
}
```

#### Struttura Schedule
```php
// Format richiesto da OpeningHoursField
[
    'monday' => [
        'morning_from' => '08:00',
        'morning_to' => '12:30', 
        'afternoon_from' => '15:00',
        'afternoon_to' => '19:00'
    ],
    'tuesday' => [...],
    // ... altri giorni
]
```

## 📝 Ragionamento per Studio Item Vista

### Problema da Risolvere
La vista principale ora usa `@each('saluteora::filament.widgets.doctor-availabilities.studio.item', $doctor->studios, 'studio')` ma la vista item non esiste ancora.

### Requisiti per Studio Item Vista
1. **Display Info Studio**: Nome, badge principale, status configurazione
2. **Form Inline**: OpeningHoursField integrato per editing diretto
3. **Salvataggio AJAX**: Non refresh pagina, update del solo widget
4. **Feedback Visivo**: Notifiche successo/errore, stato caricamento
5. **Mobile Responsive**: Layout adattivo per dispositivi touch

### Analisi Tecnica OpeningHoursField

#### Punti di Forza
- ✅ **Layout 3 Colonne**: Giorno | Mattina | Pomeriggio
- ✅ **TimePicker Separati**: `morning_from/to`, `afternoon_from/to`
- ✅ **Zebra Striping**: Alternanza colori per leggibilità
- ✅ **Validazione Automatica**: Controllo `from < to`
- ✅ **Mobile-First**: TimePicker nativi per touch
- ✅ **Nullable Support**: Campi vuoti = "chiuso"

#### Integrazione nel Widget
**SFIDA**: OpeningHoursField è progettato per Form Filament standard, ma dobbiamo integrarlo in un widget con multiple istanze (una per studio).

**SOLUZIONI VALUTATE**:

1. **🔴 Form Modal**: Una per studio → Troppo click, UX frammentata
2. **🔴 Form Esterno**: Redirect a pagina → Perde contesto overview  
3. **🟡 Form Collapsible**: Click espande → Buono ma ancora 2 step
4. **🟢 Form Inline**: Sempre visibile → UX ottimale, editing diretto

**DECISIONE**: **Form Inline** per ogni studio con OpeningHoursField embedded.

### Architettura Proposta: Studio Item Vista

#### 1. Vista Studio Item Struttura
```blade
{{-- saluteora::filament.widgets.doctor-availabilities.studio.item --}}
<div class="studio-card border rounded-lg {{ $studio->pivot->is_primary ? 'border-blue-500' : 'border-gray-200' }}">
    
    {{-- Header Studio --}}
    <div class="studio-header p-4 border-b">
        <h3>{{ $studio->name }}</h3>
        {{-- Badge principale, status configurazione --}}
    </div>
    
    {{-- Form Schedule Inline --}}
    <div class="studio-schedule-form p-4">
        {{-- OpeningHoursField embedded --}}
    </div>
    
</div>
```

#### 2. Challenge: Multiple Form Instance
**PROBLEMA**: Ogni studio deve avere un form separato con OpeningHoursField indipendente.

**STRATEGIE**:
- **Wire Model Unique**: `wire:model="schedules.{{ $studio->id }}.monday.morning_from"`
- **Form State Isolation**: Ogni studio mantiene stato separato
- **Livewire Actions**: Submit separato per ogni studio

#### 3. Salvataggio e Performance
**PATTERN**: Salvataggio automatico o button-based per studio
- **Auto Save**: Su blur dei campi (rischio: troppe calls)
- **Save Button**: Per studio (migliore controllo utente)
- **Batch Save**: Tutti in una volta (potenziale data loss)

**SCELTA**: **Save Button per studio** = migliore balance UX/performance.

### UX Flow Proposto

#### User Journey
1. **Landing**: Widget mostra tutti studi con schedule attuali
2. **Visual Scan**: Studio principale in cima, badge status per tutti
3. **Quick Edit**: Modifica orari direttamente senza click extra
4. **Save Studio**: Button salva solo quello studio specifico
5. **Feedback**: Toast notification + visual update
6. **Continue**: Passa al prossimo studio se necessario

#### Vantaggi UX
- **Overview Completo**: Vede tutto in un colpo d'occhio
- **Context Switching**: Nessun passaggio modal/pagina
- **Selective Edit**: Modifica solo quello che serve
- **Visual Hierarchy**: Studio principale evidente
- **Progress Tracking**: Badge mostrano cosa è configurato

### Implementazione Tecnica

#### Sfide Livewire
1. **Multiple Forms**: Gestire più OpeningHoursField simultaneamente
2. **State Management**: Mantenere stato separato per ogni studio
3. **Validation**: Validazione indipendente per ogni form
4. **Performance**: Non refreshare tutto per un singolo salvataggio

#### Soluzioni Tecniche
```php
// Nel Widget
public array $schedules = []; // Stato per ogni studio

public function mount() {
    foreach($this->doctor->studios as $studio) {
        $this->schedules[$studio->id] = $studio->pivot->schedule ?? [];
    }
}

public function saveStudioSchedule($studioId) {
    // Salva solo lo studio specifico
    $studioUser = StudioUser::where([
        'user_id' => $this->doctor->id,
        'studio_id' => $studioId
    ])->first();
    
    $studioUser->update(['schedule' => $this->schedules[$studioId]]);
    
    // Notifica + mini refresh
}
```

### Mobile Considerations

#### Responsive Layout
- **Desktop**: 3-colonne fianco a fianco per studio
- **Tablet**: 2-colonne con scroll orizzontale
- **Mobile**: 1-colonna con stack verticale

#### Touch Optimizations
- **TimePicker Nativi**: iOS/Android picker wheel
- **Button Sizing**: Minimum 44px per touch target
- **Scroll Areas**: Smooth scrolling per overview

### Performance Optimization

#### Loading Strategy
- **Eager Load**: Pivot data con `withPivot(['schedule', 'is_primary'])`
- **Lazy Components**: OpeningHoursField render solo quando visible
- **Debounced Save**: Previene save troppo frequenti

#### Caching Strategy
- **Widget Level**: Cache overview data per 5min
- **Studio Level**: Cache schedule data per 1min
- **User Level**: Cache doctor studios per 10min

## 📋 Piano Implementazione Studio Item Vista

### Step 1: Analisi Finale Structure
1. ✅ **DONE**: Analizzato OpeningHoursField structure e capabilities
2. ✅ **DONE**: Analizzato StudioUser pivot e schedule format
3. ✅ **DONE**: Ragionato architettura e UX flow
4. 🔄 **CURRENT**: Implementazione vista blade studio.item

### Step 2: Implementation Plan
1. **Creare Vista Blade**: `studio.item.blade.php` con layout responsive
2. **Embed OpeningHoursField**: Form inline per ogni studio
3. **Livewire Integration**: State management e save actions
4. **Mobile Testing**: Verificare UX su dispositivi touch
5. **Performance Test**: Verificare con multi-studio scenarios

### Step 3: Final Integration
1. **Widget Update**: Agggiornare methods per supportare multiple forms
2. **Translation Updates**: Label e messages per nuovo flow
3. **Documentation**: Aggiornare analisi con risultati implementazione

---

**NEXT ACTION**: Implementare vista `saluteora::filament.widgets.doctor-availabilities.studio.item` con OpeningHoursField embedded e gestione state per multiple forms.

*Analisi completata: Gennaio 2025* 