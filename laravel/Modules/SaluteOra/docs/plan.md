# Piano di Refactoring: Migrazione da start_time/end_time a starts_at/ends_at per Appointment

## Obiettivo
Correggere sistematicamente tutti i riferimenti errati a `start_time`/`end_time` nei file del progetto, sostituendoli con `starts_at`/`ends_at` in coerenza con il modello e il database.

## Passi operativi

1. **Audit e mappatura file**
   - [x] Creazione file di audit con elenco file coinvolti (`appointment_start_end_migration.md`)

2. **Definizione pattern di refactoring**
   - [x] Sostituire tutte le istanze di `start_time` con `starts_at` e `end_time` con `ends_at` nei form, query, blade, notifiche, ecc.
   - [x] Aggiornare eventuali accessor/mutator, relazioni, e PHPDoc
   - [x] Aggiornare test e factories se necessario

3. **Correzione file per file**
   - [x] app/Filament/Resources/AppointmentResource/Pages/ListAppointments.php
   - [x] app/Filament/Resources/AppointmentResource.php
   - [x] app/Actions/Calendar/FetchCalendarEventsAction.php
   - [x] app/Filament/Widgets/StudioOverviewWidget.php
   - [x] app/Filament/Widgets/PatientCalendarWidget.php
   - [x] app/Filament/Widgets/AdminCalendarWidget.php
   - [x] app/States/Appointment/Transitions/BaseTransition.php
   - [x] app/Models/Studio.php
   - [x] resources/views/filament/pages/doctor-availability-manager.blade.php
   - [x] resources/views/emails/appointments/*.blade.php (Notify)
   - [x] app/Models/Appointment.php (PHPDoc, fillable, casts, metodi)

4. **Testing e validazione**
   - [ ] Eseguire test manuali e automatici su tutte le funzionalità coinvolte
   - [ ] Validare la coerenza dei dati e l’assenza di regressioni

5. **Aggiornamento documentazione**
   - [x] Aggiornare esempi e doc tecniche dove necessario
   - [x] Annotare ogni step completato in questo file

---

## Tracking avanzamento

- [x] Audit completato
- [x] Refactoring pattern definito
- [x] Tutti i file corretti
- [ ] Test e validazione completati
- [x] Documentazione aggiornata

---

*Ultimo aggiornamento: giugno 2025*