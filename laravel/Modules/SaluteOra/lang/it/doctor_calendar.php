<?php

return array (
  'title' => 
  array (
    'label' => 'Calendario Medico',
    'description' => 'Gestione degli appuntamenti del medico',
    'help' => 'Visualizza e gestisce gli appuntamenti del calendario medico',
  ),
  'navigation' => 
  array (
    'label' => 'Calendario',
    'group' => 'Gestione Medica',
    'icon' => 'heroicon-o-calendar-days',
    'sort' => 20,
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Nuovo Appuntamento',
      'tooltip' => 'Crea un nuovo appuntamento',
      'modal_heading' => 'Nuovo Appuntamento',
      'modal_description' => 'Inserisci i dettagli per il nuovo appuntamento',
      'success' => 'Appuntamento creato con successo',
      'error' => 'Errore durante la creazione dell\'appuntamento',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Appuntamento',
      'tooltip' => 'Modifica i dettagli dell\'appuntamento',
      'modal_heading' => 'Modifica Appuntamento',
      'modal_description' => 'Aggiorna i dettagli dell\'appuntamento selezionato',
      'success' => 'Appuntamento aggiornato con successo',
      'error' => 'Errore durante l\'aggiornamento dell\'appuntamento',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Appuntamento',
      'tooltip' => 'Elimina l\'appuntamento',
      'confirmation' => 'Sei sicuro di voler eliminare questo appuntamento? Questa azione non può essere annullata.',
      'success' => 'Appuntamento eliminato con successo',
      'error' => 'Errore durante l\'eliminazione dell\'appuntamento',
    ),
    'reschedule' => 
    array (
      'label' => 'Riprogramma',
      'tooltip' => 'Riprogramma l\'appuntamento',
      'modal_heading' => 'Riprogramma Appuntamento',
      'modal_description' => 'Seleziona una nuova data e ora per l\'appuntamento',
      'success' => 'Appuntamento riprogrammato con successo',
      'error' => 'Errore durante la riprogrammazione dell\'appuntamento',
    ),
    'cancel' => 
    array (
      'label' => 'Annulla',
      'tooltip' => 'Annulla l\'appuntamento',
      'confirmation' => 'Sei sicuro di voler annullare questo appuntamento?',
      'success' => 'Appuntamento annullato con successo',
      'error' => 'Errore durante l\'annullamento dell\'appuntamento',
    ),
    'confirm' => 
    array (
      'label' => 'Conferma',
      'tooltip' => 'Conferma l\'appuntamento',
      'success' => 'Appuntamento confermato con successo',
      'error' => 'Errore durante la conferma dell\'appuntamento',
    ),
    'complete' => 
    array (
      'label' => 'Completa',
      'tooltip' => 'Segna come completato',
      'confirmation' => 'Sei sicuro di voler segnare questo appuntamento come completato?',
      'success' => 'Appuntamento completato con successo',
      'error' => 'Errore durante il completamento dell\'appuntamento',
    ),
    'change_studio' => 
    array (
      'label' => 'Cambia Studio',
      'tooltip' => 'Cambia studio per l\'appuntamento',
      'modal_heading' => 'Cambia Studio',
      'modal_description' => 'Seleziona un nuovo studio per questo appuntamento',
      'success' => 'Studio cambiato con successo',
      'error' => 'Errore durante il cambio studio',
    ),
  ),
  'fields' => 
  array (
    'starts_at' => 
    array (
      'label' => 'Inizio',
      'placeholder' => 'Seleziona data e ora di inizio',
      'help' => 'Data e ora di inizio dell\'appuntamento',
      'helper_text' => '',
      'description' => 'starts_at',
    ),
    'ends_at' => 
    array (
      'label' => 'Fine',
      'placeholder' => 'Seleziona data e ora di fine',
      'help' => 'Data e ora di fine dell\'appuntamento',
      'helper_text' => '',
      'description' => 'ends_at',
    ),
    'name' => 
    array (
      'label' => 'Titolo',
      'placeholder' => 'Inserisci il titolo dell\'appuntamento',
      'help' => 'Titolo o descrizione breve dell\'appuntamento',
      'helper_text' => '',
    ),
    'notes' => 
    array (
      'label' => 'Note',
      'placeholder' => 'Inserisci note aggiuntive',
      'help' => 'Note e osservazioni per l\'appuntamento',
      'helper_text' => '',
      'description' => 'notes',
    ),
    'state' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Seleziona lo stato',
      'help' => 'Stato attuale dell\'appuntamento',
      'helper_text' => '',
      'options' => 
      array (
        'scheduled' => 'Programmato',
        'confirmed' => 'Confermato',
        'in_progress' => 'In corso',
        'completed' => 'Completato',
        'cancelled' => 'Annullato',
        'no_show' => 'Assente',
        'rescheduled' => 'Riprogrammato',
      ),
      'description' => 'state',
    ),
    'priority' => 
    array (
      'label' => 'Priorità',
      'placeholder' => 'Seleziona la priorità',
      'help' => 'Livello di priorità dell\'appuntamento',
      'helper_text' => '',
      'options' => 
      array (
        'low' => 'Bassa',
        'normal' => 'Normale',
        'high' => 'Alta',
        'urgent' => 'Urgente',
      ),
    ),
    'type' => 
    array (
      'label' => 'Tipo Visita',
      'placeholder' => 'Seleziona il tipo di visita',
      'help' => 'Tipologia di appuntamento medico',
      'helper_text' => '',
      'options' => 
      array (
        'consultation' => 'Consulenza',
        'follow_up' => 'Controllo',
        'treatment' => 'Trattamento',
        'surgery' => 'Intervento',
        'emergency' => 'Emergenza',
      ),
    ),
    'duration' => 
    array (
      'label' => 'Durata',
      'placeholder' => 'Durata in minuti',
      'help' => 'Durata prevista dell\'appuntamento in minuti',
      'helper_text' => '',
    ),
    'room' => 
    array (
      'label' => 'Stanza',
      'placeholder' => 'Seleziona la stanza',
      'help' => 'Stanza o ambulatorio dove si svolge l\'appuntamento',
      'helper_text' => '',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Nome del paziente',
      'help' => 'Nome di battesimo del paziente',
      'helper_text' => '',
      'description' => 'first_name',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Cognome del paziente',
      'help' => 'Cognome del paziente',
      'helper_text' => '',
      'description' => 'last_name',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => '+39 123 456 7890',
      'help' => 'Numero di telefono del paziente',
      'helper_text' => '',
      'description' => 'phone',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'paziente@email.com',
      'help' => 'Indirizzo email del paziente',
      'helper_text' => '',
      'description' => 'email',
    ),
    'fiscal_code' => 
    array (
      'label' => 'Codice Fiscale',
      'placeholder' => 'RSSMRA80A01H501Z',
      'help' => 'Codice fiscale del paziente',
      'helper_text' => '',
      'description' => 'fiscal_code',
    ),
    'birth_date' => 
    array (
      'label' => 'Data di Nascita',
      'placeholder' => 'Seleziona la data di nascita',
      'help' => 'Data di nascita del paziente',
      'helper_text' => '',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Via Roma, 123',
      'help' => 'Indirizzo di residenza del paziente',
      'helper_text' => '',
    ),
    'insurance' => 
    array (
      'label' => 'Assicurazione',
      'placeholder' => 'Seleziona l\'assicurazione',
      'help' => 'Compagnia assicurativa del paziente',
      'helper_text' => '',
    ),
    'doctor_id' => 
    array (
      'label' => 'Medico',
      'placeholder' => 'Seleziona il medico',
      'help' => 'Medico responsabile dell\'appuntamento',
      'helper_text' => '',
    ),
    'studio_id' => 
    array (
      'label' => 'Studio',
      'placeholder' => 'Seleziona lo studio',
      'help' => 'Studio medico dove si svolge l\'appuntamento',
      'helper_text' => '',
    ),
    'author_id' => 
    array (
      'label' => 'Creato da',
      'placeholder' => 'Utente che ha creato l\'appuntamento',
      'help' => 'Operatore che ha registrato l\'appuntamento',
      'helper_text' => '',
    ),
  ),
  'patient' => 
  array (
    'first_name' => 
    array (
      'label' => 'Nome Paziente',
      'placeholder' => 'Nome del paziente',
      'help' => 'Nome di battesimo del paziente',
      'helper_text' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome Paziente',
      'placeholder' => 'Cognome del paziente',
      'help' => 'Cognome del paziente',
      'helper_text' => '',
    ),
    'full_name' => 
    array (
      'label' => 'Nome Completo',
      'placeholder' => 'Nome e cognome del paziente',
      'help' => 'Nome completo del paziente',
      'helper_text' => '',
    ),
    'contact_info' => 
    array (
      'label' => 'Contatti',
      'description' => 'Informazioni di contatto del paziente',
    ),
    'medical_info' => 
    array (
      'label' => 'Info Mediche',
      'description' => 'Informazioni mediche del paziente',
    ),
  ),
  'calendar' => 
  array (
    'views' => 
    array (
      'month' => 'Vista Mensile',
      'week' => 'Vista Settimanale',
      'day' => 'Vista Giornaliera',
      'list' => 'Vista Elenco',
    ),
    'navigation' => 
    array (
      'today' => 'Oggi',
      'previous' => 'Precedente',
      'next' => 'Successivo',
    ),
    'time_slots' => 
    array (
      'morning' => 'Mattina (08:00-12:00)',
      'afternoon' => 'Pomeriggio (14:00-18:00)',
      'evening' => 'Sera (18:00-20:00)',
    ),
  ),
  'filters' => 
  array (
    'status' => 
    array (
      'label' => 'Per Stato',
      'placeholder' => 'Filtra per stato',
      'help' => 'Filtra gli appuntamenti per stato',
      'helper_text' => '',
    ),
    'date_range' => 
    array (
      'label' => 'Periodo',
      'placeholder' => 'Seleziona periodo',
      'help' => 'Filtra per intervallo di date',
      'helper_text' => '',
    ),
    'doctor' => 
    array (
      'label' => 'Per Medico',
      'placeholder' => 'Seleziona medico',
      'help' => 'Filtra per medico specifico',
      'helper_text' => '',
    ),
    'studio' => 
    array (
      'label' => 'Per Studio',
      'placeholder' => 'Seleziona studio',
      'help' => 'Filtra per studio specifico',
      'helper_text' => '',
    ),
    'type' => 
    array (
      'label' => 'Per Tipo',
      'placeholder' => 'Seleziona tipo visita',
      'help' => 'Filtra per tipologia di appuntamento',
      'helper_text' => '',
    ),
  ),
  'messages' => 
  array (
    'appointment_created' => 'Appuntamento creato con successo',
    'appointment_updated' => 'Appuntamento aggiornato con successo',
    'appointment_deleted' => 'Appuntamento eliminato con successo',
    'appointment_confirmed' => 'Appuntamento confermato',
    'appointment_cancelled' => 'Appuntamento annullato',
    'appointment_completed' => 'Appuntamento completato',
    'patient_notified' => 'Paziente notificato via email/SMS',
    'time_slot_unavailable' => 'Orario non disponibile',
    'overlapping_appointment' => 'Conflitto con altro appuntamento',
    'past_date_warning' => 'Attenzione: stai programmando un appuntamento nel passato',
    'outside_hours_warning' => 'Attenzione: appuntamento fuori dagli orari di lavoro',
  ),
  'notifications' => 
  array (
    'reminder_sent' => 'Promemoria inviato al paziente',
    'confirmation_sent' => 'Conferma inviata al paziente',
    'cancellation_sent' => 'Notifica di annullamento inviata',
    'schedule_changed' => 'Modifica programmazione notificata',
  ),
  'sections' => 
  array (
    'appointment_details' => 
    array (
      'label' => 'Dettagli Appuntamento',
      'description' => 'Informazioni principali dell\'appuntamento',
    ),
    'patient_info' => 
    array (
      'label' => 'Informazioni Paziente',
      'description' => 'Dati anagrafici e di contatto del paziente',
    ),
    'medical_notes' => 
    array (
      'label' => 'Note Mediche',
      'description' => 'Osservazioni e note cliniche',
    ),
    'scheduling' => 
    array (
      'label' => 'Programmazione',
      'description' => 'Gestione di data, ora e durata',
    ),
  ),
  'validation' => 
  array (
    'required' => 'Il campo :attribute è obbligatorio',
    'date' => 'Il campo :attribute deve essere una data valida',
    'after' => 'Il campo :attribute deve essere successivo a :date',
    'before' => 'Il campo :attribute deve essere precedente a :date',
    'email' => 'Il campo :attribute deve essere un indirizzo email valido',
    'phone' => 'Il campo :attribute deve essere un numero di telefono valido',
    'fiscal_code' => 'Il codice fiscale deve essere valido',
    'time_slot_available' => 'L\'orario selezionato non è disponibile',
    'minimum_duration' => 'La durata minima dell\'appuntamento è di :min minuti',
    'maximum_duration' => 'La durata massima dell\'appuntamento è di :max minuti',
  ),
  'empty_state' => 
  array (
    'heading' => 'Nessun appuntamento programmato',
    'description' => 'Non ci sono appuntamenti per il periodo selezionato',
    'action' => 'Programma il primo appuntamento',
  ),
  'statistics' => 
  array (
    'total_appointments' => 'Appuntamenti Totali',
    'confirmed_appointments' => 'Appuntamenti Confermati',
    'cancelled_appointments' => 'Appuntamenti Annullati',
    'completed_appointments' => 'Appuntamenti Completati',
    'no_show_rate' => 'Tasso di Assenza',
    'average_duration' => 'Durata Media',
  ),
);
