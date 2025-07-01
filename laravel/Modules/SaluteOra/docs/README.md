# Documentazione SaluteOra

Documentazione completa del modulo SaluteOra per la gestione di studi dentistici e appuntamenti medici.

## 📚 Indice Generale

### 🏗️ Architettura e Pattern
- [**Lessons Learned**](lessons-learned.md) - Lezioni apprese e best practices fondamentali ⭐
- [**Widget Development**](patterns/widget-development.md) - Pattern sviluppo widget Filament ⭐
- [**Event System**](patterns/event-system.md) - Sistema eventi Livewire
- [**LangServiceProvider Labels**](langserviceprovider-labels.md) - Gestione automatica traduzioni

### 🛠️ Componenti e Widget
- [**StudioFilterWidget**](studio-filter-widget.md) - Widget filtro studio completo
- [**FindDoctorAndAppointmentWidget**](find-doctor-appointment-widget.md) - Widget prenotazione appuntamenti

### 📊 Stati e Workflow
- [**Appointment States**](appointment-states.md) - Stati degli appuntamenti e transizioni
- [**User States**](user-states.md) - Stati degli utenti
- [**BaseTransition Pattern**](patterns/base-transition.md) - Pattern transizioni automatiche

### 🔧 Implementazione Tecnica
- [**Model Context Protocol**](model-context-protocol.md) - Gestione contesto modelli
- [**Filament Wizard Best Practices**](filament-wizard-best-practices.md) - Best practices wizard
- [**Translation Guidelines**](translation-guidelines.md) - Linee guida traduzioni

### 🗄️ Database e Modelli
- [**Schema Database**](schema-database.md) - Struttura database completa
- [**Relazioni STI**](relazioni-sti.md) - Single Table Inheritance per User

## 🚀 Quick Start

### Per Sviluppatori Nuovi al Progetto
1. **Inizia qui**: [Lessons Learned](lessons-learned.md) - Contiene tutto quello che DEVI sapere
2. **Pattern Widget**: [Widget Development](patterns/widget-development.md) - Come creare widget correttamente
3. **Eventi**: [Event System](patterns/event-system.md) - Comunicazione tra componenti
4. **Traduzioni**: [LangServiceProvider Labels](langserviceprovider-labels.md) - Mai più label hardcoded

### Per Creare un Nuovo Widget
1. Seguire [Widget Development](patterns/widget-development.md)
2. Consultare [StudioFilterWidget](studio-filter-widget.md) come esempio
3. Implementare [Event System](patterns/event-system.md) per comunicazione
4. Aggiungere traduzioni seguendo [LangServiceProvider](langserviceprovider-labels.md)

### Per Gestire Stati e Transizioni
1. Leggere [Appointment States](appointment-states.md) per comprendere il workflow
2. Implementare transizioni usando il pattern [BaseTransition](patterns/base-transition.md)
3. Seguire le convenzioni negli [User States](user-states.md)

## 📋 Documenti Aggiornati Recentemente

### ⭐ Gennaio 2025 - Major Updates
- **NEW**: [Lessons Learned](lessons-learned.md) - Raccoglie tutta l'esperienza del progetto
- **NEW**: [Widget Development Patterns](patterns/widget-development.md) - Pattern completi per widget
- **NEW**: [Event System](patterns/event-system.md) - Sistema eventi documentato
- **UPDATED**: [Appointment States](appointment-states.md) - Corretti stati e transizioni
- **UPDATED**: [LangServiceProvider](langserviceprovider-labels.md) - Pattern StudioFilterWidget
- **UPDATED**: [StudioFilterWidget](studio-filter-widget.md) - Documentazione completa

## 🎯 Best Practices Essenziali

### ✅ Da Fare SEMPRE
- Estendere `XotBaseWidget` (mai `Widget` direttamente)
- Implementare `getFormSchema()` e `canView()` in ogni widget
- Usare sistema eventi per comunicazione tra componenti
- Affidarsi a LangServiceProvider per traduzioni (mai `->label()`)
- Verificare sempre permessi utente e multi-tenancy
- Gestire stati vuoti nelle viste Blade
- Documentare ogni nuovo pattern o componente

### ❌ Da Evitare ASSOLUTAMENTE
- Label hardcoded (`->label()`, `->placeholder()`, `->helperText()`)
- Bypass controlli di sicurezza
- Widget che estendono direttamente `Widget`
- Stati semanticamente sbagliati per il dominio
- Eventi senza dati o naming scorretto
- Query N+1 (sempre eager loading)
- Viste senza gestione stato vuoto

## 🔗 Collegamenti Esterni

### Documentazione Correlata
- [Modules/Xot - Base Framework](../../Xot/docs/)
- [Root Documentation](../../../docs/)
- [Laravel Filament](https://filamentphp.com/docs)
- [Livewire Events](https://laravel-livewire.com/docs/events)

### Risorse Sviluppo
- [PHPStan Level 9+](https://phpstan.org/)
- [Laravel Coding Standards](https://laravel.com/docs/contributions#coding-style)
- [Filament Best Practices](https://filamentphp.com/docs/support/upgrade-guide)

## 📈 Metriche Progetto

### Componenti Implementati
- ✅ **StudioFilterWidget** - Widget filtro studio completo
- ✅ **FindDoctorAndAppointmentWidget** - Widget prenotazione
- ✅ **Appointment States** - 9 stati + transizioni
- ✅ **User States** - STI con Doctor/Patient/Admin
- ✅ **Event System** - Comunicazione reattiva
- ✅ **Translation System** - Zero-config multilingua

### Pattern Consolidati
- ✅ **XotBaseWidget Pattern** - Template per tutti i widget
- ✅ **BaseTransition Pattern** - Transizioni automatiche
- ✅ **LangServiceProvider Pattern** - Traduzioni seamless
- ✅ **Event Communication Pattern** - Architettura disaccoppiata
- ✅ **Multi-Tenancy Pattern** - Sicurezza studio-based
- ✅ **Responsive UI Pattern** - Design coerente

## 💡 Contribuire alla Documentazione

### Per Aggiungere Nuova Documentazione
1. Creare il file nella cartella appropriata (`patterns/`, `components/`, etc.)
2. Seguire il template esistente per coerenza
3. Aggiornare questo README.md con il nuovo documento
4. Creare collegamenti bidirezionali con docs correlate
5. Aggiungere esempi pratici e anti-pattern

### Template Documento Standard
```markdown
# Titolo Documento

## Panoramica
Breve descrizione dello scopo

## Pattern/Implementazione
Codice e esempi

## Best Practices
Cosa fare e cosa evitare

## Troubleshooting
Problemi comuni e soluzioni

## Collegamenti
Link a documentazione correlata

*Ultimo aggiornamento: [Data]*
```

---

*Ultima revisione: Gennaio 2025*  
*Versione documentazione: 2.0*  
*Maintainer: Team SaluteOra*

**Per supporto o domande**: Consultare prima [Lessons Learned](lessons-learned.md), poi aprire issue nel repository.