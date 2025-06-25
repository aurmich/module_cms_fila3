# DoctorAvailabilitiesWidget - Analisi e Progettazione

## ⚠️ Stato Attuale: WIDGET MANCANTE

Il widget `DoctorAvailabilitiesWidget` è **referenziato** in `/config/local/saluteora/database/content/pages/doctor-home.json` ma **non esiste fisicamente**. Deve essere creato seguendo i pattern eccellenti scoperti nel modulo.

## 🎯 Scopo del Widget

Permettere ai dottori di visualizzare e gestire le proprie **disponibilità orarie** per il tenant (studio) corrente, utilizzando l'approccio DRY con il modello `Appointment`.

## 🧠 Ispirazione dai Pattern Esistenti

### Pattern BaseTransition (DRY + KISS)
Il modulo SaluteOra implementa pattern eccellenti che il widget dovrebbe seguire:
- **Auto-discovery**: Nomi che si auto-spiegano 
- **Minimal boilerplate**: Codice essenziale
- **Centralizzazione**: Una fonte di verità per tutto

### Pattern Appointment-Based (DRY Policy)
Dalla documentazione: **TUTTO** usa il modello `Appointment`:
```php
// ✅ Slot disponibili = Appointment con type=availability
Appointment::where('doctor_id', $doctorId)
    ->where('type', AppointmentTypeEnum::AVAILABILITY) 
    ->where('status', AppointmentStatusEnum::AVAILABLE)
    ->get();
```

**❌ MAI** creare tabelle custom per disponibilità!

## 📋 Analisi dei Problemi Attuali

### 1. Widget Mancante
- **Problema**: Widget referenziato ma non esiste
- **Impatto**: Homepage dottore rotta
- **Soluzione**: Implementazione completa

### 2. Violazione Pattern Module
Dalla struttura esistente:
```
/laravel/Modules/SaluteOra/app/Filament/Widgets/
├── StudioOverviewWidget.php        ❌ Estende Widget (sbagliato!)
├── DoctorCalendarWidget.php        ✅ Pattern eccellente!
├── AdminCalendarWidget.php         ✅ Molto ben fatto
└── [MANCANTE] DoctorAvailabilitiesWidget.php
```

### 3. Pattern Inconsistente 
- `StudioOverviewWidget`: Estende `Widget` (❌ sbagliato secondo regole Laraxot)
- `DoctorCalendarWidget`: Implementazione eccellente con trait e multi-tenancy

## 🎯 Progettazione Ideale

### Caratteristiche Obbligatorie

1. **Estende XotBaseWidget** (non Widget!)
2. **Multi-Tenant**: Utilizza `Filament::getTenant()` 
3. **UserType Control**: Solo `UserTypeEnum::DOCTOR`
4. **Appointment-Based**: Usa solo modello Appointment
5. **Tipizzazione Rigorosa**: PHPDoc completi, strict types
6. **Traduzioni**: Zero stringhe hardcoded

### Funzionalità Target

1. **Visualizzazione Disponibilità**
   - Mostra slot di disponibilità settimanali
   - Vista calendario o lista
   - Filtri per periodo

2. **Gestione Quick**
   - Toggle rapido disponibilità
   - Modifica orari inline
   - Aggiunta/rimozione slot

3. **Integrazione Studio**
   - Context-aware per studio corrente
   - Controlli accesso appropriati

## 🏗️ Implementazione Proposta

### Struttura Base
```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Filament\Facades\Filament;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Models\Appointment;

/**
 * Widget per gestione disponibilità dottore.
 * 
 * Permette ai dottori di visualizzare e gestire le proprie disponibilità
 * per il tenant (studio) corrente utilizzando il modello Appointment.
 * 
 * Pattern utilizzati:
 * - DRY: Riutilizzo modello Appointment 
 * - KISS: Interface semplice e intuitiva
 * - Multi-tenant: Context-aware per studio
 */
class DoctorAvailabilitiesWidget extends XotBaseWidget
{
    protected static string $view = 'saluteora::filament.widgets.doctor-availabilities';
    protected static ?int $sort = 2;
    
    /**
     * Verifica se l'utente può visualizzare il widget.
     */
    public static function canView(): bool
    {
        if (!auth()->check() || auth()->user()?->type !== UserTypeEnum::DOCTOR->value) {
            return false;
        }
        return Filament::getTenant() !== null;
    }
    
    /**
     * Dati per la view.
     */
    protected function getViewData(): array
    {
        return [
            'availabilities' => $this->getCurrentAvailabilities(),
            'weeklyStats' => $this->getWeeklyStats(),
            'quickActions' => $this->getQuickActions(),
        ];
    }
    
    /**
     * Recupera disponibilità correnti del dottore.
     */
    private function getCurrentAvailabilities(): Collection
    {
        return Appointment::where('doctor_id', auth()->id())
            ->where('studio_id', Filament::getTenant()->id)
            ->where('type', AppointmentTypeEnum::AVAILABILITY)
            ->where('status', AppointmentStatusEnum::AVAILABLE)
            ->whereDate('start_time', '>=', now())
            ->orderBy('start_time')
            ->take(20)
            ->get();
    }
}
```

### Azioni Widget
```php
/**
 * Azioni rapide per il widget.
 */
private function getQuickActions(): array
{
    return [
        'add_availability' => [
            'label' => __('saluteora::doctor_availabilities.actions.add.label'),
            'icon' => 'heroicon-o-plus',
            'action' => 'openAvailabilityModal',
        ],
        'manage_schedule' => [
            'label' => __('saluteora::doctor_availabilities.actions.manage.label'), 
            'icon' => 'heroicon-o-calendar',
            'url' => route('filament.pages.doctor-availability'),
        ],
    ];
}
```

## 🎨 Design UX/UI

### Layout Proposto
```
┌─────────────────────────────────────────┐
│ 🕐 Le Tue Disponibilità                │
├─────────────────────────────────────────┤
│ Questa Settimana:  18 slot disponibili │
│ Prossimi 7 giorni: 12 appuntamenti     │
├─────────────────────────────────────────┤
│ Lun 16/12  ●●●○○  (3/5 slot occupati) │
│ Mar 17/12  ●●○○○  (2/5 slot occupati) │  
│ Mer 18/12  ●●●●○  (4/5 slot occupati) │
├─────────────────────────────────────────┤
│ [+ Aggiungi]  [⚙️ Gestisci Orari]     │
└─────────────────────────────────────────┘
```

### Componenti UI
- **Progress Indicators**: Visual per occupazione slot
- **Quick Stats**: Numeri importanti in evidenza  
- **Action Buttons**: CTA principali in fondo
- **Status Colors**: Verde=libero, Blu=occupato, Rosso=urgente

## 🔄 Integrazioni Necessarie

### 1. Con DoctorCalendarWidget
- **Sync dati**: Modifiche in uno si riflettono nell'altro
- **Navigazione**: Link tra widget
- **Consistent UX**: Stesso design language

### 2. Con DoctorAvailabilityPage  
- **Deep linking**: Widget → Pagina gestione
- **Shared logic**: Stessa business logic
- **Validation**: Stesse regole

### 3. Con PatientBookingFlow
- **Real-time**: Aggiornamenti in tempo reale
- **Notifications**: Avvisi nuove prenotazioni

## ⚡ Performance Considerations

### Caching Strategy
```php
/**
 * Cache delle disponibilità con invalidazione intelligente.
 */
private function getCurrentAvailabilities(): Collection
{
    $cacheKey = "doctor_availabilities_{auth()->id()}_{Filament::getTenant()->id}";
    
    return cache()->remember($cacheKey, 300, function() {
        return Appointment::where(/* query */)->get();
    });
}
```

### Optimization Points
- **Lazy loading**: Carica solo dati visibili
- **Smart refresh**: Update solo se necessario  
- **Minimal queries**: Query ottimizzate
- **Cache invalidation**: Su modifiche rilevanti

## 🛡️ Security & Access Control

### Controlli Implementati
```php
public static function canView(): bool
{
    // 1. User autenticato
    if (!auth()->check()) return false;
    
    // 2. Tipo dottore
    if (auth()->user()?->type !== UserTypeEnum::DOCTOR->value) return false;
    
    // 3. Tenant attivo
    if (!Filament::getTenant()) return false;
    
    // 4. Dottore appartiene al tenant
    return auth()->user()->studios()->where('id', Filament::getTenant()->id)->exists();
}
```

## 📋 TODO Implementation

### Fase 1: Base Widget
- [ ] Creare classe DoctorAvailabilitiesWidget
- [ ] Implementare canView() con security
- [ ] Creare view template base
- [ ] Setup traduzioni

### Fase 2: Core Features  
- [ ] Fetch disponibilità via Appointment
- [ ] Implementare stats settimanali
- [ ] Aggiungere quick actions
- [ ] Testing base

### Fase 3: UX/UI
- [ ] Design responsive 
- [ ] Animazioni smooth
- [ ] Loading states
- [ ] Error handling

### Fase 4: Integrations
- [ ] Link con DoctorCalendarWidget
- [ ] Deep link con DoctorAvailabilityPage  
- [ ] Real-time updates
- [ ] Notifications

### Fase 5: Polish
- [ ] Performance optimization
- [ ] Advanced caching
- [ ] Analytics tracking
- [ ] Documentation completa

## 🧪 Testing Strategy

### Unit Tests
- [ ] canView() logic
- [ ] getCurrentAvailabilities() 
- [ ] getWeeklyStats()
- [ ] Cache behavior

### Integration Tests  
- [ ] Multi-tenant isolation
- [ ] Widget rendering
- [ ] User interactions
- [ ] Error scenarios

### E2E Tests
- [ ] Doctor workflow completo
- [ ] Cross-widget consistency
- [ ] Performance benchmarks

## 🎯 Success Metrics

### Performance KPIs
- **Load time** < 200ms
- **First paint** < 100ms  
- **Cache hit ratio** > 90%
- **Error rate** < 0.1%

### UX KPIs
- **User engagement** con widget
- **Task completion** rate
- **Time to action** from widget
- **User satisfaction** scores

## 🔗 Collegamenti

- [Doctor Availability Management](../doctor-availability-management.md)
- [DoctorCalendarWidget Implementation](../../../app/Filament/Widgets/DoctorCalendarWidget.php)
- [Appointment Model](../../../app/Models/Appointment.php)
- [Multi-Tenancy Documentation](../../Tenant/docs/README.md)
- [BaseTransition Pattern](../models/base-transition-pattern.md)
- [Widget Best Practices](../widgets/find-doctor-appointment-widget.md)

---

**Status**: 📋 Analysis Complete - Ready for Implementation  
**Priority**: 🔥 High (Homepage dottore rotta)  
**Effort**: 🏗️ Medium (2-3 giorni con testing)  
**Risk**: 🟢 Low (pattern consolidati disponibili)

*Ultimo aggiornamento: Gennaio 2025* 