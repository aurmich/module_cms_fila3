# Piano di Correzione: utilizzo starts_at/ends_at per Appointment (giugno 2024)

## Obiettivo
Uniformare l'utilizzo dei campi temporali degli appuntamenti su `starts_at`/`ends_at` in tutto il progetto, eliminando ogni riferimento a `start_time`/`end_time`.

## Step operativi
1. Analisi e lista di tutti i file coinvolti (vedi appointment_resource_corrections.md)
2. Aggiornamento del modello Appointment e delle sue relazioni
3. Refactoring di tutte le risorse Filament che usano i campi errati
4. Refactoring di tutte le azioni, widget, view e test che usano i campi errati
5. Aggiornamento della documentazione tecnica e degli esempi
6. Test di regressione su tutto il flusso appuntamenti

## File da correggere
- Modules/SaluteOra/app/Models/Appointment.php
- Modules/SaluteOra/app/Filament/Resources/AppointmentResource.php
- Modules/SaluteOra/app/Actions/Calendar/FetchCalendarEventsAction.php
- Modules/SaluteOra/app/Filament/Widgets/AdminCalendarWidget.php
- Modules/SaluteOra/docs/appointment-system.md
- Modules/SaluteOra/docs/fullcalendar_widgets.md
- Themes/One/resources/views/appointment/card.blade.php
- Themes/One/resources/views/appointment/item.blade.php
- Modules/SaluteMo/app/Filament/Resources/AppointmentResource.php
- Modules/Notify/app/Actions/SendAppointmentNotificationAction.php.old

## Stato avanzamento
- [ ] Analisi completata
- [ ] Modello Appointment aggiornato
- [ ] Risorse Filament aggiornate
- [ ] Azioni e widget aggiornati
- [ ] View aggiornate
- [ ] Documentazione aggiornata
- [ ] Test di regressione completati

## Note
Aggiornerò questo file man mano che correggo ogni file/step. 