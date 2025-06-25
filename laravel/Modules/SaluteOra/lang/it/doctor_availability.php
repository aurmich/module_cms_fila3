<?php

return array (
  'navigation' => 
  array (
    'label' => 'Disponibilità Medici',
    'group' => 'Agenda',
    'icon' => 'heroicon-o-calendar',
    'sort' => 6,
  ),
  'model' => 
  array (
    'label' => 'Disponibilità Medico',
    'plural' => 'Disponibilità Medici',
  ),
  'sections' => 
  array (
    'general_settings' => 'Impostazioni Generali',
    'weekly_availability' => 'Disponibilità Settimanale',
    'exceptions' => 'Eccezioni e Giorni Speciali',
    'pending_appointments' => 'Appuntamenti in Attesa di Approvazione',
    'pending_appointments_description' => 'Qui puoi vedere e gestire tutti gli appuntamenti in attesa della tua approvazione.',
    'calendar' => 'Calendario Disponibilità',
    'calendar_description' => 'Visualizza i tuoi appuntamenti e le tue disponibilità in un\'unica vista.',
  ),
  'fields' => 
  array (
    'is_accepting_appointments' => 
    array (
      'label' => 'Accetto nuovi appuntamenti',
      'help' => 'Abilita/disabilita la possibilità per i pazienti di prenotare nuovi appuntamenti con te.',
    ),
    'default_duration' => 
    array (
      'label' => 'Durata predefinita degli appuntamenti',
      'help' => 'La durata predefinita degli appuntamenti in minuti.',
    ),
    'notice_hours' => 
    array (
      'label' => 'Preavviso minimo',
      'help' => 'Il preavviso minimo richiesto per prenotare un appuntamento (in ore).',
    ),
    'day' => 
    array (
      'label' => 'Giorno della settimana',
    ),
    'start_time' => 
    array (
      'label' => 'Ora di inizio',
    ),
    'end_time' => 
    array (
      'label' => 'Ora di fine',
    ),
    'is_available' => 
    array (
      'label' => 'Disponibile',
      'help' => 'Indica se sei disponibile in questo intervallo orario.',
    ),
    'date' => 
    array (
      'label' => 'Data',
    ),
    'exception_available' => 
    array (
      'help' => 'Attiva per aggiungere disponibilità extra in un giorno specifico. Disattiva per bloccare un periodo in cui normalmente saresti disponibile.',
    ),
  ),

  'calendar' => 
  array (
    'month' => 'Mese',
    'week' => 'Settimana',
    'day' => 'Giorno',
  ),
  'legend' => 
  array (
    'pending' => 'In Attesa',
    'confirmed' => 'Confermato',
    'completed' => 'Completato',
    'cancelled' => 'Cancellato',
    'no_show' => 'Non Presentato',
    'availability' => 'Guida Orari',
  ),
  'table' => 
  array (
    'patient' => 'Paziente',
    'date' => 'Data',
    'time' => 'Orario',
    'reason' => 'Motivo',
    'actions' => 'Azioni',
  ),
  'empty_states' => 
  array (
    'no_pending_appointments' => 'Nessun appuntamento in attesa',
    'no_pending_appointments_description' => 'Non ci sono appuntamenti in attesa di approvazione.',
  ),
  'available' => 'Disponibile',
  'widget' => 
  array (
    'title' => 'I Miei Studi',
    'description' => 'Gestisci le tue disponibilità in tutti gli studi in cui lavori.',
    'no_studios' => 'Nessuno studio associato',
    'no_studios_description' => 'Non sei ancora associato a nessuno studio. Contatta l\'amministratore per essere aggiunto.',
    'unknown_studio' => 'Studio sconosciuto',
    'primary_studio' => 'Studio Principale',
    'address' => 'Indirizzo',
    'phone' => 'Telefono',
    'schedule' => 'Orari di Disponibilità',
    'no_schedule' => 'Nessun orario impostato',
    'morning' => 'Mattina',
    'afternoon' => 'Pomeriggio',
    'closed' => 'Chiuso',
    'edit_schedule' => 'Modifica Orari',
    'set_primary' => 'Imposta come Principale',
  ),
  'actions' => 
  array (
    'save' => 
    array (
      'label' => 'save',
    ),
    'add_exception' => 'Aggiungi Eccezione',
    'approve' => 'Approva',
    'reject' => 'Rifiuta',
    'toggle_appointments' => 'Appuntamenti',
    'toggle_availability' => 'Disponibilità',
    'edit_schedule' => 'Modifica Orari',
    'set_primary' => 'Imposta come Principale',
  ),
  'modals' => 
  array (
    'set_primary_description' => 'Sei sicuro di voler impostare questo studio come principale? Tutti gli altri studi verranno automaticamente rimossi come primari.',
  ),
  'notifications' => 
  array (
    'saved' => 
    array (
      'title' => 'Disponibilità salvate',
      'body' => 'Le tue disponibilità sono state aggiornate con successo.',
    ),
    'not_doctor' => 
    array (
      'title' => 'Utente non autorizzato',
      'body' => 'Solo i profili medico possono gestire le disponibilità.',
    ),
    'error' => 
    array (
      'title' => 'Errore durante il salvataggio',
      'body' => 'Si è verificato un errore durante il salvataggio delle disponibilità.',
      'invalid_studio' => 'Studio non valido o non trovato.',
    ),
    'not_found' => 
    array (
      'title' => 'Appuntamento non trovato',
      'body' => 'L\'appuntamento selezionato non esiste o non è associato al tuo profilo.',
    ),
    'appointment_approved' => 
    array (
      'title' => 'Appuntamento approvato',
      'body' => 'L\'appuntamento è stato confermato con successo.',
    ),
    'appointment_rejected' => 
    array (
      'title' => 'Appuntamento rifiutato',
      'body' => 'L\'appuntamento è stato rifiutato con successo.',
    ),
    'primary_set' => 
    array (
      'title' => 'Studio principale impostato',
      'body' => 'Lo studio è stato impostato come principale con successo.',
    ),
  ),
);
