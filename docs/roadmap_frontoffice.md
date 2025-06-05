# AVVISO IMPORTANTE
Questa è la roadmap di riferimento UNICA per il frontoffice. Tutte le attività, priorità e avanzamenti devono essere tracciati qui e nei file collegati. Aggiorna SEMPRE questa roadmap PRIMA di ogni sviluppo o modifica.

# Roadmap Frontoffice SaluteOra

## Introduzione

Questo documento descrive la roadmap di sviluppo dettagliata per il frontoffice di SaluteOra, il portale dedicato alla promozione della salute orale per le gestanti in condizioni di vulnerabilità socio-economica, basato sulla [Presentazione del portale Salute Orale](./12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md).

La roadmap è organizzata in aree funzionali, ognuna contenente task specifici con relative sotto-attività e percentuali di completamento. Per ogni task complesso sono disponibili documenti dettagliati nella directory `roadmap_frontoffice/` con spiegazioni passo-passo per l'implementazione.

## Stato Avanzamento Maggio 2025

| Macro-area                                 | Stato (%) | Responsabile     | File Dettaglio                                 | Note principali                                 |
|--------------------------------------------|-----------|------------------|-----------------------------------------------|-------------------------------------------------|
| Architettura Base                          | 95%       | Team Backend     | 02-architettura-base.md                       | Ottimizzazione API e lazy loading in corso       |
| Setup Ambiente                             | 100%      | Team DevOps      | 01-setup-ambiente.md                          | Completato                                      |
| Componenti UI                              | 85%       | Team Frontend    | 03-ui-ux-base.md                              | Focus su mobile e caricamento veloce             |
| Modelli e Architettura Dati                | 90%       | Team Backend     | 10-modelli-ereditarieta.md                    | Documentazione aggiornata                       |
| Registrazione/Autenticazione               | 80%       | Team Frontoffice | 04-registrazione-autenticazione.md            | Da completare validazione odontoiatra e 2FA      |
| Ricerca Dentista                           | 75%       | Team Frontoffice | 07-prenotazione-visite.md                     | Mappa interattiva in sviluppo                    |
| Prenotazione Visite                        | 70%       | Team Frontoffice | 07-prenotazione-visite.md                     | Da completare gestione rifiuti e notifiche       |
| Area Personale Paziente                    | 65%       | Team Frontoffice | paziente-registrazione.md                     | Focus su documentazione clinica                  |
| Registrazione Odontoiatra                  | 80%       | Team Frontoffice | 08-registrazione-odontoiatra.md               | Flusso multi-step e UX in completamento          |
| Gestione Appuntamenti Odontoiatra          | 75%       | Team Frontoffice | dentista-appuntamenti.md                      | Referti e storico appuntamenti                   |
| Sistema di Rimborsi                        | 65%       | Team Amministr.  | 26-sistema-rimborsi.md                        | Tracking e notifiche pagamento                   |
| Back Office                                | 85%       | Team Backoffice  | 09-backoffice.md                              | Dashboard integrata e segnalazioni               |
| Ottimizzazioni/Miglioramenti               | 70%       | Team Fullstack   |                                              | Performance API, caching, mobile                 |
| Sistema Notifiche                          | 70%       | Team Frontoffice | 28-sistema-notifiche.md                       | SMS e push in sviluppo                           |
| Prenotazione Paziente da URL /it/patient/book | 0%        | Team Frontoffice | 30-patient-book.md                            | Analisi e progettazione in corso                 |
| Funzionalità Future                        | -         | Team Prodotto    |                                              | Telemedicina, mobile app, API partner            |

## Prossimi Passi Operativi (Priorità Maggio-Giugno 2025)

1. **Completare la registrazione odontoiatra** (validazione documenti, flusso multi-step, UX) - **Priorità Alta**
2. **Implementare lazy loading** per componenti e immagini in homepage e UI - **Priorità Alta**
3. **Completare la mappa interattiva e le schede dettaglio dentisti** - **Priorità Alta**
4. **Migliorare la gestione notifiche** (SMS, in-app, push) - **Priorità Media**
5. **Ottimizzare area personale paziente** (documentazione clinica, mobile) - **Priorità Media**
6. **Completare referti e storico appuntamenti odontoiatra** - **Priorità Media**
7. **Completare tracking rimborsi e notifiche pagamento** - **Priorità Media**
8. **Ottimizzare performance API e caching** - **Priorità Bassa**
9. **Avviare MVP mobile app** (focus su prenotazione e notifiche) - **Priorità Bassa**
10. **Avviare API partner esterni** (autenticazione, rate limiting) - **Priorità Bassa**

## Checklist Finale (aggiornata)
- [ ] Aggiornamento documentazione neutra e bidirezionale
- [ ] Nessun riferimento a brand/progetto nei moduli
- [ ] Nessuna duplicazione trait nei modelli
- [ ] Error handling solo con ValidationException::withMessages
- **User Moderation Integration**: Integrate moderation functionalities into the existing `User` model, removing the separate `UserModeration` model.
- [ ] STI e trait secondo best practice
- [ ] Test e validazione su tutte le nuove feature
- [ ] Collegamenti bidirezionali aggiornati
- [ ] Analisi, documentazione e test flusso /it/patient/book
- Verificare sempre che la pagina sia orchestrata da una blade tematica in Themes/One/resources/views/pages/ e che includa solo widget modulari con un solo root element. Vietato l'uso di Livewire/Patient/Book.php o blade legacy fuori dai moduli/temi.

## Best Practice e Regole (2025-05)
- Neutralità documentazione (mai riferimenti a brand/progetto nei moduli)
- Ereditarietà trait: mai duplicare trait già presenti nei modelli base
- Error handling: solo ValidationException::withMessages
- STI: tutti i campi su tabella base, logica comune su User, specializzazione su Doctor/Patient
- Documentazione e checklist PRIMA di ogni sviluppo

## Collegamenti Operativi
- [Dettaglio UI/UX Base](./roadmap_frontoffice/03-ui-ux-base.md)
- [Homepage/Landing](./roadmap_frontoffice/05-homepage-landing.md)
- [Registrazione/Autenticazione](./roadmap_frontoffice/04-registrazione-autenticazione.md)
- [Prenotazione Visite](./roadmap_frontoffice/07-prenotazione-visite.md)
- [Modelli/Ereditarietà](./roadmap_frontoffice/10-modelli-ereditarieta.md)
- [Registrazione Odontoiatra](./roadmap_frontoffice/08-registrazione-odontoiatra.md)
- [Backoffice](./roadmap_frontoffice/09-backoffice.md)

---

*Ultimo aggiornamento: 16 Maggio 2025*

## Prossimi step operativi

1. Scegli una delle attività in sviluppo (🚧) con percentuale < 80% come priorità.
2. Leggi il file dettagliato collegato (es. roadmap_frontoffice/07-prenotazione-visite.md).
3. Segui la checklist e le best practice indicate.
4. Aggiorna la documentazione locale se necessario.
5. Procedi con l'implementazione seguendo la guida dettagliata.
6. Aggiorna la percentuale di completamento in questa roadmap.

> Questa roadmap e i file collegati sono la fonte di verità per il frontoffice. Ogni modifica deve essere documentata qui PRIMA di essere implementata.

# Best Practice e Regole Aggiornate (2025-05)

## Neutralità della documentazione
- Tutta la documentazione nelle cartelle docs dei moduli deve essere **neutra** e **riutilizzabile**: mai inserire riferimenti a progetti, brand o contesti specifici.
- Se serve un riferimento specifico, va messo solo nella documentazione root del progetto.

## Ereditarietà dei trait
- **Mai duplicare trait già presenti nei modelli base**. Esempio: se `HasFactory` è già in `BaseUser`, non aggiungerlo in `User` o `Doctor`.
- Motivazione: evitare ridondanza, warning, confusione e problemi di override.
- Vedi: [Patient/Models/Doctor.md](../laravel/Modules/Patient/docs/Models/Doctor.md)

## Gestione ValidationException custom
- Usare sempre `ValidationException::withMessages()` per errori custom.
- Anti-pattern: non usare mai `validator([], [])->errors()->add(...)`.
- Vedi: [Patient/docs/errors/validation.md](../laravel/Modules/Patient/docs/errors/validation.md)

## File PHP chiave coinvolti
- [Doctor.php](../laravel/Modules/Patient/app/Models/Doctor.php)
- [User.php](../laravel/Modules/Patient/app/Models/User.php)
- [BaseUser.php](../laravel/Modules/User/app/Models/BaseUser.php)
- [RegisterAction.php](../laravel/Modules/Patient/app/Actions/Doctor/RegisterAction.php)
- [RegistrationWidget.php](../laravel/Modules/User/app/Filament/Widgets/RegistrationWidget.php)
- [DoctorResource.php](../laravel/Modules/Patient/app/Filament/Resources/DoctorResource.php)

## Collegamenti documentazione
- [Patient/Models/Doctor.md](../laravel/Modules/Patient/docs/Models/Doctor.md)
- [Patient/docs/errors/validation.md](../laravel/Modules/Patient/docs/errors/validation.md)
- [Patient/docs/README.md](../laravel/Modules/Patient/docs/README.md)
- [Xot/docs/README.md](../laravel/Modules/Xot/docs/README.md)

## Errori Comuni e Soluzioni (Best Practice)

- Gestione ValidationException custom:
  Vedi [docs/standards/error-handling.md](./standards/error-handling.md)
  Esempio:
  ```php
  throw \Illuminate\Validation\ValidationException::withMessages([
      'email' => ['Messaggio di errore personalizzato.'],
  ]);
  ```
- Fallback enum/status:
  Vedi [docs/standards/models.md](./standards/models.md)
  Esempio:
  ```php
  private function getDoctorRegistrationStatus(): string { /* ... */ }
  ```
- Ereditarietà STI e trait:
  Vedi [docs/standards/models.md](./standards/models.md)
- Non duplicare trait già presenti nella gerarchia (es. HasFactory).

### File PHP chiave coinvolti
- Modules/Patient/app/Actions/Doctor/RegisterAction.php
- Modules/Patient/app/Models/User.php
- Modules/Patient/app/Models/Doctor.php
- Modules/Patient/app/Models/DoctorRegistrationWorkflow.php
- Modules/Patient/app/Datas/DoctorData.php
- Modules/Notify/Models/MailTemplate.php
- Modules/Notify/Emails/SpatieEmail.php

### Collegamenti utili
- [Gestione errori](./standards/error-handling.md)
- [Validazione](./standards/validation.md)
- [Migrazioni](./standards/migrations.md)
- [Modelli e architettura](./standards/models.md)
- [Architettura generale](./standards/architecture.md)

## Checklist
- [ ] Nessun riferimento a nomi di progetto
- [ ] Error handling idiomatico
- [ ] Fallback enum/status
- [ ] Ereditarietà STI e trait corretta
- [ ] Override dei casts tramite metodo
- [ ] Collegamenti bidirezionali aggiornati
- [ ] Test e validazione

---

# Roadmap Frontoffice

## Overview
This document outlines the current roadmap for the frontoffice development of the SaluteOra project. It focuses on the immediate priorities and tasks to be completed for the frontoffice functionalities within the Patient module and related areas.

## Current Priorities

1. **User Model Updates**:
   - **Remove UserModeration Model**: Integrate moderation functionalities into the existing `User` model for simplicity and data cohesion. Add fields like `last_action_by`, `last_action_at`, and `last_reason` to track the latest moderation action.
   - **Update Documentation**: Ensure all related documentation reflects the removal of the `UserModeration` model and updates to the `User` model.

2. **Frontoffice Development**:
   - **Patient Registration Workflow**: Implement and refine the patient registration process, ensuring it aligns with the wizard structure and validation rules outlined in related documentation.
   - **Doctor Registration Workflow**: Continue development of the doctor registration process, focusing on form validation, state management, and integration with backend services.
   - **UI/UX Enhancements**: Improve the user interface for frontoffice pages, ensuring responsive design and accessibility compliance.

3. **Filament Resource Management**:
   - **Compliance with XotBaseResource Guidelines**: Review and update all Filament resources to adhere to project conventions, avoiding forbidden properties and ensuring proper namespace usage.
   - **Translation and Localization**: Implement the translation system for Filament resources, following the guidelines in `TRANSLATIONS.md`.

## Upcoming Tasks

1. **Testing and Validation**:
   - Conduct thorough testing of frontoffice functionalities, including user registration flows and moderation actions now integrated into the `User` model.
   - Validate UI components for consistency across different devices and browsers.

2. **Performance Optimization**:
   - Optimize database queries related to user management and moderation actions.
   - Implement caching strategies for frontoffice pages to improve load times.

3. **Security Enhancements**:
   - Ensure GDPR compliance for user data handling in the frontoffice.
   - Implement secure session management and authentication for frontoffice users.

## Related Documentation

- [PATIENT_MANAGEMENT.md](/var/www/html/saluteora/laravel/Modules/Patient/docs/PATIENT_MANAGEMENT.md)
- [DOCTOR_REGISTRATION_PROCESS.md](/var/www/html/saluteora/laravel/Modules/Patient/docs/DOCTOR_REGISTRATION_PROCESS.md)
- [USER_MODERATION_MODEL_ANALYSIS.md](/var/www/html/saluteora/laravel/Modules/Patient/docs/USER_MODERATION_MODEL_ANALYSIS.md)
- [FILAMENT_RESOURCES_IMPLEMENTATION.md](/var/www/html/saluteora/laravel/Modules/Patient/docs/FILAMENT_RESOURCES_IMPLEMENTATION.md)
- [TRANSLATIONS.md](/var/www/html/saluteora/laravel/Modules/Patient/docs/TRANSLATIONS.md)

**Last Updated**: 2025-05-16

## Sezione dedicata: Prenotazione Paziente da URL /it/patient/book

### Descrizione
Permette al paziente di accedere direttamente al flusso di prenotazione tramite la URL `/it/patient/book`, con percorso semplificato, validazione documenti, selezione servizio/data/orario e conferma in un unico step. Ottimizzato per mobile.

### Stato attuale
- **Analisi**: in corso
- **Progettazione**: da avviare
- **Implementazione**: non iniziata

### User Story
Come paziente voglio poter prenotare una visita accedendo direttamente a /it/patient/book, scegliendo servizio, data e orario, caricando eventuali documenti richiesti e ricevendo conferma immediata, così da velocizzare il processo senza passaggi intermedi.

#### Acceptance Criteria
- Accesso diretto a /it/patient/book senza login obbligatorio (se già autenticato)
- Form unico con selezione servizio, data, orario, upload documenti
- Validazione dati e documenti in tempo reale
- Conferma e notifica immediata (email/SMS/push)
- Visualizzazione stato prenotazione nell'area personale

### Collegamenti
- [Dettaglio tecnico e flusso completo](./roadmap_frontoffice/30-patient-book.md)
- [Prenotazione Visite](./roadmap_frontoffice/07-prenotazione-visite.md)
- [UI/UX Base](./roadmap_frontoffice/03-ui-ux-base.md)
- [Sistema Notifiche](./roadmap_frontoffice/28-sistema-notifiche.md)
- [Backoffice](./roadmap_frontoffice/09-backoffice.md)
- [Torna alla tabella di sintesi](#stato-avanzamento-maggio-2025)

## Checklist Finale (aggiornata)
- [ ] Aggiornamento documentazione neutra e bidirezionale
- [ ] Nessun riferimento a brand/progetto nei moduli
- [ ] Nessuna duplicazione trait nei modelli
- [ ] Error handling solo con ValidationException::withMessages
- [ ] STI e trait secondo best practice
- [ ] Test e validazione su tutte le nuove feature
- [ ] Collegamenti bidirezionali aggiornati
- [ ] Analisi, documentazione e test flusso /it/patient/book
