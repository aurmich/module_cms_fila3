# Audit utilizzo errato di start_time/end_time per Appointment

## Problema
Molti file del progetto usano ancora i campi `start_time` e `end_time` per il modello Appointment, mentre la convenzione corretta e la struttura attuale del modello/database richiedono l'uso di `starts_at` e `ends_at`.

### Perché è un errore?
- **Incoerenza** tra modello, database e form: genera bug, comportamenti imprevedibili e difficoltà di manutenzione.
- **DRY/KISS**: la fonte di verità deve essere unica e coerente.
- **Refactoring difficile**: ogni duplicazione o naming incoerente rende rischioso ogni cambio futuro.

## File coinvolti (da correggere)

- app/Filament/Resources/AppointmentResource/Pages/ListAppointments.php
  - Usa: `TextColumn::make('start_time')`, `TextColumn::make('end_time')`
- app/Filament/Resources/AppointmentResource.php
  - Usa: `DateTimePicker::make('start_time')`, `DateTimePicker::make('end_time')`
- app/Actions/Calendar/FetchCalendarEventsAction.php
  - Usa: `->whereBetween('start_time', ...)`, `$appointment->start_time`, `$appointment->end_time`
- app/Filament/Widgets/StudioOverviewWidget.php
  - Usa: `whereMonth('start_time', ...)`, `whereYear('start_time', ...)`
- app/Filament/Widgets/PatientCalendarWidget.php
  - Usa: `->whereBetween('start_time', ...)`, `$appointment->start_time`, `$appointment->end_time`
- app/Filament/Widgets/AdminCalendarWidget.php
  - Usa: `->whereBetween('start_time', ...)`, `$appointment->start_time`, `$appointment->end_time`, `DateTimePicker::make('start_time')`, `DateTimePicker::make('end_time')`, ecc.
- app/States/Appointment/Transitions/BaseTransition.php
  - Usa: `$this->appointment->start_time->format(...)`
- app/Models/Studio.php
  - Usa: `whereMonth('start_time', ...)`, `whereYear('start_time', ...)`
- resources/views/filament/pages/doctor-availability-manager.blade.php
  - Usa: `$appointment->start_time->format(...)`, `$appointment->end_time->format(...)`
- resources/views/emails/appointments/*.blade.php (Notify)
  - Usa: `$appointment->start_time->format(...)`, `$appointment->end_time->format(...)`

## Prossimi passi
- Vedi il file `plan.md` per il piano di refactoring dettagliato.

---

## Rimozione campo 'date', 'start_datetime', 'end_datetime' per Appointment (giugno 2025)

### Motivazione
- Il modello Appointment usa solo 'starts_at' e 'ends_at' come riferimento temporale.
- Qualsiasi altro campo temporale (date, start_datetime, end_datetime) è fonte di confusione, bug e incoerenza.
- La presenza di questi campi in vecchie migrazioni o codice legacy va eliminata.

### File coinvolti
- database/migrations/2024_03_31_000010_create_appointments_table.php.old
- (eventuali altri file legacy, factories, test, blade)

### Azione
- Eliminati tutti i riferimenti a 'date', 'start_datetime', 'end_datetime'.
- Aggiornata la docstring e aggiunto commento di correzione nella migrazione legacy.

---

## File legacy (.php.old) da correggere (giugno 2025)

Questi file, anche se marcati come .old, possono essere fonte di confusione o errori futuri se usati come base per nuovi sviluppi. Vanno quindi allineati alle convenzioni attuali (solo starts_at/ends_at come riferimento temporale):

- app/Actions/CreateAppointmentAction.php.old
- app/Actions/FinalizeAppointmentWorkflowAction.php.old
- app/Actions/Patient/Calendar/FetchEventsAction.php.old
- app/Filament/Components/AppointmentWorkflowSummary.php.old
- app/Filament/Widgets/DoctorAvailabilityCalendarWidget.php.old
- app/Models/DoctorAvailability.php.old

**Azione:**
- Correggere tutti i riferimenti a date, start_time, end_time → starts_at, ends_at
- Lasciare commento di deprecazione se il file è solo di esempio

---

*Ultimo aggiornamento: giugno 2025* 