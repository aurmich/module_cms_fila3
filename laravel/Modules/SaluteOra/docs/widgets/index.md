# Widget Filament - Modulo SaluteOra

## Panoramica Widget

Il modulo SaluteOra implementa diversi widget Filament specializzati per la gestione di appuntamenti, disponibilità e funzionalità specifiche del settore odontoiatrico.

## Widget Implementati

### Widget FullCalendar

#### 1. DoctorAvailabilitiesWidget
- **File**: [DoctorAvailabilitiesWidget.php](../../app/Filament/Widgets/DoctorAvailabilitiesWidget.php)
- **Documentazione**: [doctor-availabilities-widget.md](./doctor-availabilities-widget.md)
- **Scopo**: Overview studi del dottore con gestione orari inline
- **Utenti**: Solo dottori
- **Caratteristiche**:
  - Lista di tutti gli studi del dottore
  - Form inline OpeningHoursField per ogni studio
  - Editing diretto degli orari di disponibilità
  - Studio principale evidenziato
  - Auto-save con notifiche real-time

#### 2. DoctorCalendarWidget
- **File**: [DoctorCalendarWidget.php](../../app/Filament/Widgets/DoctorCalendarWidget.php)
- **Scopo**: Gestione appuntamenti per dottori
- **Utenti**: Dottori e amministratori studio
- **Caratteristiche**:
  - CRUD completo appuntamenti
  - Drag & drop per spostare appuntamenti
  - Resize per modificare durata
  - Integrazione con pazienti e studi

#### 3. PatientCalendarWidget
- **File**: [PatientCalendarWidget.php](../../app/Filament/Widgets/PatientCalendarWidget.php)
- **Scopo**: Visualizzazione appuntamenti per pazienti
- **Utenti**: Solo pazienti
- **Caratteristiche**:
  - Vista sola lettura degli appuntamenti
  - Filtri per stato appuntamento
  - Integrazione con profilo paziente

#### 4. AdminCalendarWidget
- **File**: [AdminCalendarWidget.php](../../app/Filament/Widgets/AdminCalendarWidget.php)
- **Scopo**: Vista completa per amministratori
- **Utenti**: Amministratori studio e sistema
- **Caratteristiche**:
  - Vista globale tutti i dottori
  - Filtri avanzati per studio
  - Statistiche aggregate

### Widget Form e Wizard

#### 5. FindDoctorAndAppointmentWidget
- **File**: [FindDoctorAndAppointmentWidget.php](../../app/Filament/Widgets/Patient/FindDoctorAndAppointmentWidget.php)
- **Documentazione**: [find-doctor-appointment-widget.md](./find-doctor-appointment-widget.md)
- **Scopo**: Widget per ricerca dottori e prenotazione appuntamenti
- **Utenti**: Pazienti e visitatori
- **Caratteristiche**:
  - Ricerca geografica (Regione > Provincia > Città)
  - Filtri per specializzazione
  - Wizard multi-step per prenotazione
  - Integrazione con disponibilità dottori

#### 6. PatientRegistrationWizard
- **File**: [PatientRegistrationWizard.php](../../app/Filament/Widgets/PatientRegistrationWizard.php)
- **Scopo**: Registrazione guidata pazienti
- **Utenti**: Nuovi utenti pazienti
- **Caratteristiche**:
  - Processo guidato multi-step
  - Validazione dati anagrafici
  - Upload documenti identificativi
  - Gestione consensi privacy

### Widget Overview e Statistiche

#### 7. StudioOverviewWidget
- **File**: [StudioOverviewWidget.php](../../app/Filament/Widgets/StudioOverviewWidget.php)
- **Scopo**: Panoramica statistiche studio
- **Utenti**: Amministratori e dottori
- **Caratteristiche**:
  - Statistiche giornaliere/settimanali
  - Metriche appuntamenti
  - Indicatori performance

## Architettura Comune

### Trait Condivisi

#### HasFullCalendarConfig
- **File**: [HasFullCalendarConfig.php](../../app/Traits/HasFullCalendarConfig.php)
- **Scopo**: Configurazioni comuni per tutti i widget FullCalendar
- **Fornisce**:
  - Configurazione base calendario (locale, timezone, orari business)
  - Metodi caching standardizzati
  - Formattazione eventi e colori
  - Controlli accesso e sicurezza
  - Gestione multi-tenancy

### Base Classes

#### XotBaseWidget
- Esteso da tutti i widget del progetto
- Fornisce funzionalità base Laraxot
- Gestione automatica traduzioni
- Pattern di caching standardizzato

### Multi-Tenancy

Tutti i widget implementano:
- **Isolamento Dati**: Ogni studio vede solo i propri dati
- **Context Awareness**: Utilizzo di `Filament::getTenant()` per studio corrente
- **Controlli Accesso**: Verifica appartenenza utente a studio/tenant
- **Sicurezza**: Validazione permessi cross-database

## Configurazioni Global

### FullCalendar Config
- **File**: `config/fullcalendar.php`
- **Sezioni**:
  - Localizzazione (italiano, timezone Europe/Rome)
  - Orari business (Lun-Sab 08:00-19:00)
  - Colori per tipi appuntamento e stati
  - Performance e caching
  - Configurazioni responsive

### Widget Specifici Config
```php
'widgets' => [
    'patient' => [
        'editable' => false,
        'selectable' => false,
        'initialView' => 'timeGridWeek',
    ],
    'doctor' => [
        'editable' => true,
        'selectable' => true,
        'initialView' => 'timeGridWeek',
    ],
    'admin' => [
        'editable' => true,
        'selectable' => true,
        'initialView' => 'dayGridMonth',
    ],
],
```

## Best Practices Widget

### 1. Sicurezza
- ✅ Sempre implementare `canView()` con controlli tipo utente
- ✅ Validare tenancy per operazioni CRUD
- ✅ Filtrare dati per utente corrente quando appropriato
- ✅ Utilizzare policy per controlli granulari

### 2. Performance
- ✅ Implementare caching con TTL appropriato
- ✅ Limitare query con paginazione/limits
- ✅ Utilizzare eager loading per relazioni
- ✅ Invalidare cache su modifiche dati

### 3. UX
- ✅ Fornire feedback immediato per azioni utente
- ✅ Gestire stati di caricamento e errore
- ✅ Implementare tooltip informativi
- ✅ Utilizzare colori semantici coerenti

### 4. Manutenibilità
- ✅ Estendere da classi base appropriate
- ✅ Utilizzare trait per codice comune
- ✅ Documentare configurazioni personalizzate
- ✅ Implementare test per logica business

## File di Supporto

### Traduzioni
- `lang/it/widgets.php` - Traduzioni widget
- `lang/it/calendar.php` - Traduzioni calendario
- `lang/it/appointments.php` - Traduzioni appuntamenti

### Migrations
- `database/migrations/*_create_studio_user_table.php` - Tabella pivot disponibilità
- `database/migrations/*_create_appointments_table.php` - Tabella appuntamenti

### Testing
- `tests/Feature/Widgets/` - Test funzionali widget
- `tests/Unit/Widgets/` - Test unitari logica widget

---

*Ultimo aggiornamento: Gennaio 2025*  
*Widgets implementati: 7*  
*Framework: Filament v3.0+, FullCalendar v6.0+* 