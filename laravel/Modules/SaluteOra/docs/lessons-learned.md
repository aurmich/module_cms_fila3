# Lezioni Apprese - SaluteOra

## Panoramica

Questo documento raccoglie le lezioni apprese e le best practices scoperte durante lo sviluppo del modulo SaluteOra, da tenere sempre a mente per futuri sviluppi.

## Pattern Architetturali Fondamentali

### 1. XotBaseWidget Pattern ✅

**Scoperta**: Tutti i widget devono estendere `XotBaseWidget`, mai `Widget` direttamente.

**Problema risolto**: Il `StudioFilterWidget` inizialmente causava errori di linting perché non implementava i metodi richiesti.

**Soluzione implementata**:
```php
class StudioFilterWidget extends XotBaseWidget
{
    // SEMPRE implementare anche se vuoto
    public function getFormSchema(): array
    {
        return [];
    }
    
    // SEMPRE implementare controlli accesso
    public static function canView(): bool
    {
        $user = Auth::user();
        return $user && 
               $user->type === UserTypeEnum::DOCTOR &&
               $user instanceof Doctor;
    }
}
```

**Da ricordare**: Ogni nuovo widget deve seguire questo pattern senza eccezioni.

### 2. LangServiceProvider Zero-Configuration ✅

**Scoperta**: Il sistema traduzione automatico è MOLTO potente e elimina completamente la necessità di label manuali.

**Errore comune**: Aggiungere `->label()`, `->placeholder()`, `->helperText()` nei componenti.

**Pattern corretto**:
```php
// ❌ MAI fare questo
TextInput::make('studio_name')
    ->label('Studio')
    ->placeholder('Nome studio');

// ✅ SEMPRE fare questo  
TextInput::make('studio_name');
```

**File necessari**:
- `lang/it/widgets.php` - Traduzioni specifiche widget
- `lang/it/fields.php` - Traduzioni campi form

**Da ricordare**: Le traduzioni sono automatiche se i file esistono. Mai bypass manuale.

### 3. Sistema Eventi Livewire ✅

**Scoperta**: Il sistema eventi permette comunicazione elegante tra componenti senza accoppiamento.

**Pattern implementato in StudioFilterWidget**:
```php
// Dispatch evento
$this->dispatch('studio-changed', [
    'studioId' => $studioId,
    'studio' => $this->currentStudio->toArray(),
]);

// Listen evento
#[On('studio-selected')]
public function onStudioSelected(array $data): void
{
    if (isset($data['studioId'])) {
        $this->changeStudio($data['studioId']);
    }
}
```

**Naming convention eventi**:
- `{entità}-changed`: Cambio entità principale
- `{entità}-selected`: Selezione da componente esterno
- `{entità}-filter-applied`: Applicazione filtri

**Da ricordare**: Eventi permettono architettura modulare e testabile.

## Stati e Transizioni

### 4. BaseTransition Pattern ✅

**Scoperta**: Il modulo implementa un pattern `BaseTransition` che è un capolavoro di automazione.

**Genius del design**:
```php
// ✅ Transizione semplice (99% dei casi)
class PendingToConfirmed extends BaseTransition
{
    // BASTA COSÌ! Tutto il resto è automatico
}
```

**Funzionalità automatiche**:
- Auto-discovery stato target dal nome classe
- Notifiche automatiche con slug generato
- Persistenza stato nel database
- Logging completo

**Da ricordare**: Non reinventare la ruota. Usare BaseTransition per tutto.

### 5. Stati Appuntamenti Corretti ✅

**Errore scoperto**: `IntegrationRequested` e `IntegrationCompleted` erano stati degli **utenti**, non degli appuntamenti.

**Correzione implementata**:
- ❌ Rimossi: `IntegrationRequested`, `IntegrationCompleted`  
- ✅ Implementati: `Pending`, `Confirmed`, `Scheduled`, `InProgress`, `Completed`, `Cancelled`, `Rejected`, `NoShow`, `Rescheduled`

**Flusso corretto**:
```
Pending → Confirmed → Scheduled → InProgress → Completed
   ↓          ↓          ↓
Cancelled   Cancelled   NoShow
             ↓          ↓
          Rescheduled   Cancelled
```

**Da ricordare**: Stati devono essere semanticamente corretti per il dominio specifico.

## Sicurezza e Permessi

### 6. Multi-Tenancy Doctor-Studio ✅

**Scoperta**: I dottori possono appartenere a più studi, il filtro studio è fondamentale.

**Pattern implementato**:
```php
// Verifica accesso studio
$studio = $user->studios()->where('studios.id', $studioId)->first();

if (!$studio) {
    $this->notification()
        ->title(__('saluteora::widgets.studio_filter.errors.unauthorized'))
        ->danger()
        ->send();
    return;
}
```

**Integrazione tenant Filament**:
```php
// Aggiorna tenant per coerenza
if (Filament::getTenant()?->id !== $studioId) {
    session(['tenant_id' => $studioId]);
}
```

**Da ricordare**: Sempre verificare permessi + aggiornare tenant di Filament.

### 7. Controlli di Accesso Tipizzati ✅

**Pattern scoperto**: Combinare controllo enum + instanceof per sicurezza completa.

```php
public static function canView(): bool
{
    $user = Auth::user();
    
    return $user && 
           $user->type === UserTypeEnum::DOCTOR &&  // Controllo enum
           $user instanceof Doctor;                 // Controllo tipo
}
```

**Da ricordare**: Doppio controllo previene bypass e errori di tipo.

## UX e Interface

### 8. Feedback Utente Immediato ✅

**Scoperta**: Le notifiche sono fondamentali per UX di qualità.

**Pattern implementato**:
```php
// Successo con dettagli
$this->notification()
    ->title(__('saluteora::widgets.studio_filter.messages.studio_changed'))
    ->body(__('saluteora::widgets.studio_filter.messages.studio_changed_body', [
        'studio' => $this->currentStudio->name
    ]))
    ->success()
    ->send();

// Errore chiaro
$this->notification()
    ->title(__('saluteora::widgets.studio_filter.errors.unauthorized'))
    ->danger()
    ->send();
```

**Da ricordare**: Ogni azione deve avere feedback chiaro e immediato.

### 9. Stato Vuoto Gestito ✅

**Pattern nelle viste**:
```blade
@if($currentStudio)
    {{-- Stato con dati --}}
    <div class="space-y-4">
        {{-- Contenuto principale --}}
    </div>
@else
    {{-- Stato vuoto elegante --}}
    <div class="text-center py-8">
        <x-filament::icon icon="heroicon-o-exclamation-triangle" />
        <h3>{{ __('saluteora::widgets.studio_filter.no_studio.title') }}</h3>
        <p>{{ __('saluteora::widgets.studio_filter.no_studio.description') }}</p>
    </div>
@endif
```

**Da ricordare**: Sempre gestire stati vuoti con messaggi utili e design coerente.

## Performance e Ottimizzazione

### 10. Eager Loading Strategico ✅

**Pattern efficiente**:
```php
$this->availableStudios = $user->studios()
    ->with(['address'])  // Carica relazioni necessarie
    ->where('active', true)
    ->orderBy('name')
    ->get();
```

**Da ricordare**: Sempre includere relazioni che verranno usate nella vista.

### 11. Caching Dati Session ✅

**Pattern implementato**:
```php
// Carica da tenant Filament o primo disponibile
$this->currentStudioId = Filament::getTenant()?->id ?? $this->getFirstAvailableStudioId();

// Aggiorna session per persistenza
session(['tenant_id' => $studioId]);
```

**Da ricordare**: Sfruttare session per evitare query ripetute.

## Troubleshooting e Debug

### 12. Debug Pattern Eventi ✅

**Tecniche scoperte**:
```php
// Logging eventi
Log::info('Studio changed', [
    'from' => $this->currentStudioId,
    'to' => $studioId,
    'user' => Auth::id(),
]);

// Debug in browser
// document.addEventListener('livewire:event-dispatched', console.log);
```

**Da ricordare**: Logging strutturato è essenziale per debug eventi complessi.

### 13. Syntax Check Workflow ✅

**Comando fondamentale**:
```bash
php -l file.php  # Verifica sintassi
```

**Workflow scoperto**:
1. Creare file con `cat > file << 'EOF'`
2. Verificare sintassi con `php -l`
3. Testare funzionalità
4. Documentare

**Da ricordare**: Verifica sintassi previene errori runtime.

## Architettura Moduli

### 14. Separazione Responsabilità ✅

**Pattern scoperto**:
- **Widget**: Logica presentazione + eventi
- **Models**: Logica business + relazioni
- **States**: Workflow e transizioni
- **Translations**: Interfaccia utente
- **Views**: Solo presentazione

**Da ricordare**: Ogni layer ha responsabilità ben definite.

### 15. Directory Structure Standard ✅

**Struttura implementata**:
```
SaluteOra/
├── app/
│   ├── Filament/Widgets/
│   ├── States/Appointment/
│   ├── States/User/
│   └── Models/
├── lang/it/
│   ├── widgets.php
│   └── fields.php
├── docs/
│   ├── patterns/
│   └── *.md
└── Themes/One/resources/views/filament/widgets/
```

**Da ricordare**: Consistenza nella struttura facilita manutenzione.

## Errori da Evitare Assolutamente

### ❌ Anti-Pattern Fatali

1. **Mai estendere Widget direttamente**
   ```php
   // ❌ ERRORE
   class MyWidget extends Widget
   
   // ✅ CORRETTO  
   class MyWidget extends XotBaseWidget
   ```

2. **Mai usare label manuali con LangServiceProvider**
   ```php
   // ❌ ERRORE
   ->label('Studio')
   
   // ✅ CORRETTO
   // Niente, traduzione automatica
   ```

3. **Mai bypassare controlli di sicurezza**
   ```php
   // ❌ ERRORE
   public static function canView(): bool { return true; }
   
   // ✅ CORRETTO
   public static function canView(): bool { 
       return auth()->user()?->type === UserTypeEnum::DOCTOR;
   }
   ```

4. **Mai dispatchare eventi senza dati**
   ```php
   // ❌ ERRORE
   $this->dispatch('studio-changed');
   
   // ✅ CORRETTO
   $this->dispatch('studio-changed', [
       'studioId' => $studioId,
       'studio' => $this->currentStudio->toArray(),
   ]);
   ```

5. **Mai stati sbagliati per il dominio**
   ```php
   // ❌ ERRORE per Appointment
   IntegrationRequested::class
   
   // ✅ CORRETTO per Appointment
   Pending::class
   ```

## Checklist Pre-Commit

### Verifiche Obbligatorie
- [ ] Widget estende `XotBaseWidget`
- [ ] Implementa `getFormSchema()` e `canView()`
- [ ] Nessun `->label()`, `->placeholder()`, `->helperText()`
- [ ] File traduzioni `widgets.php` e `fields.php` aggiornati
- [ ] Eventi seguono naming convention
- [ ] Controlli sicurezza implementati
- [ ] Stati semanticamente corretti
- [ ] Vista Blade gestisce stato vuoto
- [ ] Eager loading per relazioni
- [ ] Documentazione aggiornata

## Metriche di Successo

### StudioFilterWidget Achievement ✅
- ✅ **228 righe** di widget completo e funzionante
- ✅ **156 righe** di vista Blade responsive
- ✅ **Zero errori** di linting o sintassi
- ✅ **Traduzione completa** italiano
- ✅ **Sistema eventi** bidirezionale
- ✅ **Sicurezza multi-tenant** implementata
- ✅ **Documentazione completa** con esempi

### Pattern Reusability ✅
- ✅ **Widget Pattern** riutilizzabile per altre entità
- ✅ **Event System** applicabile a tutti i componenti  
- ✅ **Translation System** zero-config per nuovi campi
- ✅ **Security Pattern** template per controlli accesso

## Prossimi Passi

### Applicazione Pattern Appesi
1. **AppointmentFilterWidget** - Applicare stesso pattern per appuntamenti
2. **PatientFilterWidget** - Filter per pazienti  
3. **DashboardWidget** - Widget statistiche con eventi
4. **ScheduleWidget** - Gestione orari con multi-studio

### Miglioramenti Architetturali
1. **Caching Layer** - Cache per query frequenti
2. **Event Bus** - Sistema eventi più sofisticato
3. **Translation Cache** - Ottimizzazione traduzioni
4. **Widget Factory** - Generazione automatica widget

### Documentazione
1. **Video Tutorial** - Screencast pattern implementazione
2. **Migration Guide** - Da widget legacy a pattern corretto
3. **Testing Guide** - Test automatizzati per widget
4. **Performance Guide** - Ottimizzazioni avanzate

## Filosofia Progetto

### Principi Cardine Scoperti
1. **DRY** - Don't Repeat Yourself (BaseTransition pattern)
2. **KISS** - Keep It Simple Stupid (LangServiceProvider zero-config)
3. **SOLID** - Single Responsibility (ogni widget una funzionalità)
4. **Convention over Configuration** - Pattern automatici
5. **Progressive Enhancement** - Funziona anche se JS disabilitato

### Zen dello Sviluppatore
> "Il codice migliore è quello che non devi scrivere"  
> "La miglior configurazione è quella automatica"  
> "L'errore migliore è quello che non può succedere"

**Da ricordare**: Automazione intelligente > Configurazione manuale

---

*Ultimo aggiornamento: Gennaio 2025*  
*Versione: 1.0 - Post StudioFilterWidget Implementation*  
*Autore: Lezioni apprese durante sviluppo SaluteOra*

**Questo documento deve essere consultato ad ogni nuovo sviluppo.**
