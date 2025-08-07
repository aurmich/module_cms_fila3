# Analisi del Widget FindDoctorAndAppointmentWidget - Step 2 Implementation

## Stato Attuale del Widget

### 🔍 **Struttura Esistente**

Il widget `FindDoctorAndAppointmentWidget` ha una struttura a 5 step:

1. **search_step** ✅ - IMPLEMENTATO
   - Selezione Regione (live)
   - Selezione Provincia (dipendente da regione, live)  
   - Selezione CAP (dipendente da provincia/regione, live)

2. **studio_step** ❌ - DA IMPLEMENTARE 
   - *Attualmente vuoto*
   - Deve mostrare gli studi dentistici nella zona selezionata

3. **date_step** ✅ - IMPLEMENTATO
   - Selezione data appuntamento
   - Date disabilitate (domeniche e date specifiche)

4. **time_step** ✅ - IMPLEMENTATO  
   - Selezione orario appuntamento
   - Slot orari fissi

5. **confirm_step** ✅ - IMPLEMENTATO
   - Riepilogo prenotazione
   - Note opzionali

### 📊 **Dati di Form Attuali**

```php
public ?array $data = [
    'region' => null,        // Codice regione
    'province' => null,      // Codice provincia  
    'city' => null,         // Non utilizzato ancora
    'cap' => null,          // CAP selezionato
    'specialization' => null, // Non utilizzato
    'appointment_date' => null,
    'test_field' => null,
    'appointment_type' => null,
    'appointment_time' => null,
    'notes' => null,
];
```

## 🎯 **Requisiti del Secondo Step**

Dall'analisi dei file `/docs/images/10.*` il secondo step deve:

### Funzionalità Core
- **Titolo**: "Gli Studi Odontoiatrici più vicini a te"
- **Visualizzazione Lista**: Elenco studi filtrati per area geografica del primo step
- **Dati per Studio**:
  - Nome studio (es. "Studio Odontoiatrico 1")
  - Indirizzo completo (Via, numero civico, CAP, città)
  - Pulsante "Prenota" per selezione

### Funzionalità Avanzate (da `10.blade.php`)
- **Filtri Aggiuntivi**: Distanza, rating, specializzazioni, disponibilità oggi
- **Informazioni Estese**: Rating stelle, numero recensioni, specializzazioni
- **Distanza**: Calcolo e visualizzazione distanza dalla posizione utente
- **Empty State**: Gestione caso nessuno studio trovato
- **Paginazione**: Per gestire molti risultati

## 🏗️ **Architettura dei Dati**

### Modello Studio
**Caratteristiche principali**:
- Extends `BaseTenant` (multi-tenancy)
- Usa trait `HasAddress` (gestione indirizzi geografici)
- **Database**: `salute_ora` connection
- **Relazioni**: 
  - `doctors()` - belongsToManyX con Doctor
  - `appointments()` - hasMany Appointment
  - `addresses` (da HasAddress trait)

### Campi Studio Rilevanti
```php
protected $fillable = [
    'name',              // Nome studio
    'phone',            // Telefono
    'email',            // Email  
    'website',          // Sito web
    'description',      // Descrizione
    'opening_hours',    // Orari (JSON)
    'services',         // Servizi (JSON array)
    'active',           // Attivo/Disattivo
];
```

### Relazione con Dati Geografici
- **HasAddress Trait**: Collegamento con modulo Geo
- **Query Possibili**: 
  - `inRegion(string $region)`
  - `inProvince(string $province)` 
  - `inPostalCode(string $postalCode)`
  - `inCity(string $city)`

## 🛠️ **Componenti Riutilizzabili da Creare nel Modulo UI**

### 1. LocationSelector Component

**Path**: `laravel/Modules/UI/app/Filament/Forms/Components/LocationSelector.php`

**Funzionalità**:
- Selezione gerarchica Regione → Provincia → CAP
- Live updates tra i campi
- Integrazione con modulo Geo
- Validazione cascata

```php
// Esempio utilizzo
LocationSelector::make()
    ->regionField('region')
    ->provinceField('province') 
    ->capField('cap')
    ->required()
```

### 2. StudioCard Component  

**Path**: `laravel/Modules/UI/resources/views/components/ui/studio-card.blade.php`

**Funzionalità**:
- Display informazioni studio
- Layout responsive (mobile/desktop)
- Integrazione rating e recensioni
- Azioni personalizzabili (Prenota, Dettagli)

```blade
<x-ui::studio-card 
    :studio="$studio"
    :show-distance="true"
    :show-rating="true"
    :actions="['book', 'details']"
/>
```

### 3. StudioList Component

**Path**: `laravel/Modules/UI/resources/views/components/ui/studio-list.blade.php`

**Funzionalità**:
- Lista studi con paginazione
- Filtri avanzati
- Empty states
- Loading states

```blade
<x-ui::studio-list 
    :studios="$studios"
    :filters="$filters"
    :show-filters="true"
/>
```

### 4. StudioFilters Component

**Path**: `laravel/Modules/UI/app/Filament/Forms/Components/StudioFilters.php`

**Funzionalità**:
- Filtro distanza (slider)
- Filtro rating (select)
- Filtro specializzazioni (multiple select)
- Filtri boolean (disponibile oggi, parcheggio)

## 📝 **Roadmap Implementazione**

### Fase 1: Componenti UI Riutilizzabili
1. **LocationSelector** - Componente Filament per selezione geografica
2. **StudioCard** - Blade component per singolo studio
3. **StudioList** - Blade component per lista studi  
4. **StudioFilters** - Componente Filament per filtri avanzati

### Fase 2: Business Logic 
1. **StudioQuery Service** - Logica query studi per area geografica
2. **DistanceCalculator** - Calcolo distanze tra coordinate
3. **StudioRating** - Sistema valutazione studi
4. **StudioAvailability** - Controllo disponibilità slot

### Fase 3: Widget Integration
1. **getStudioStepSchema()** - Implementazione schema secondo step
2. **Form State Management** - Gestione dati tra gli step
3. **Navigation Logic** - Validazione passaggio tra step
4. **Selection Handling** - Gestione selezione studio

### Fase 4: UX Enhancements
1. **Loading States** - Stati di caricamento tra step
2. **Error Handling** - Gestione errori e retry
3. **Responsive Design** - Ottimizzazione mobile/desktop
4. **Accessibility** - ARIA labels e keyboard navigation

## 🔗 **Integrazioni Richieste**

### Modulo Geo
- **Comune Model**: Per dati regione/provincia/cap
- **Address Model**: Per indirizzi studi
- **HasAddress Trait**: Per query geografiche

### Modulo User  
- **Doctor Model**: Per relazione studi-dottori
- **Cross-database Relations**: gestione relazioni tra database

### Modulo SaluteOra
- **Studio Model**: Modello principale
- **Appointment Model**: Per verifica disponibilità  
- **StudioUser Pivot**: Per relazioni studio-utenti

## 📊 **Query Performance Considerations**

### Ottimizzazioni Necessarie
1. **Indici Database**: 
   - `studios(active)` - già presente
   - `addresses(postal_code, city, province, region)` - da verificare
   - `studio_doctor(studio_id, doctor_id)` - per relazioni

2. **Eager Loading**:
   - `->with(['addresses', 'doctors', 'media'])`
   - Evitare N+1 queries

3. **Caching Strategy**:
   - Cache risultati ricerca per area geografica (5-10 min)
   - Cache dati geografici regioni/province (1 giorno)  
   - Cache rating studi (30 min)

4. **Pagination**:
   - Limitare risultati a 10-15 studi per pagina
   - Lazy loading per performance

## 🧪 **Testing Strategy**

### Unit Tests
- `LocationSelector` - Test selezione gerarchica
- `StudioQuery` - Test filtri geografici
- `DistanceCalculator` - Test calcoli distanza

### Integration Tests  
- `FindDoctorWidget` - Test flusso completo widget
- `StudioStep` - Test secondo step specifico
- `CrossDatabase` - Test relazioni cross-database

### E2E Tests
- User Journey completo da ricerca a prenotazione
- Test responsive su diversi dispositivi
- Test accessibility con screen readers

## 📚 **Documentazione da Aggiornare**

### Modulo UI
- `docs/components.md` - Nuovi componenti UI
- `docs/filament-components.md` - Componenti Filament form
- `docs/best-practices.md` - Pattern di utilizzo

### Modulo SaluteOra  
- `docs/widgets/` - Documentazione widget completa
- `docs/models/studio.md` - Documentazione modello Studio
- `docs/geographic-integration.md` - Integrazione modulo Geo

### Root Docs
- `docs/ui-components.md` - Componenti riutilizzabili globali
- `docs/geo-integration.md` - Integrazione geografica cross-module

## ⚠️ **Potenziali Problematiche**

### Cross-Database Relations
- Studio (salute_ora) ↔ Doctor (user) 
- **Soluzione**: Verificare configurazione `belongsToManyX`

### Performance Geographic Queries
- Query su grandi dataset geografici
- **Soluzione**: Indici appropriati + caching

### State Management tra Step
- Mantenimento stato form tra navigazione step
- **Soluzione**: Livewire state management + validation

### Responsive Design Complexity
- Layout diversi mobile/desktop per lista studi
- **Soluzione**: Component blade con slot condizionali

## 🚀 **Next Steps**

1. **Iniziare con LocationSelector** - Componente più riutilizzabile
2. **Test integrazione Geo** - Verificare query geografiche
3. **Prototipo StudioCard** - Component visual di base
4. **Implementazione getStudioStepSchema()** - Integrazione widget

---

**Creato**: 26 Giugno 2025  
**Autore**: AI Assistant  
**Stato**: Analysis Complete - Ready for Implementation  
**Priority**: P1 - Core Functionality 