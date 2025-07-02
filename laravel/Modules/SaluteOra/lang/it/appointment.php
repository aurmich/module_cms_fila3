<?php

return array (
  'name' => 'Appuntamenti',
  'navigation' => 
  array (
    'label' => 'Calendario Appuntamenti',
    'group' => 'Agenda',
    'icon' => 'heroicon-o-calendar-days',
    'color' => 'sky',
    'sort' => 1,
    'tooltip' => 'Visualizza e gestisci tutti gli appuntamenti e le visite',
  ),
  'model' => 
  array (
    'label' => 'Appuntamento',
    'plural' => 'Appuntamenti',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Appuntamenti',
    ),
    'create' => 
    array (
      'title' => 'Nuovo Appuntamento',
    ),
    'edit' => 
    array (
      'title' => 'Modifica Appuntamento',
    ),
    'availability' => 
    array (
      'title' => 'Gestione Disponibilità',
      'heading' => 'Calendario Disponibilità',
      'subheading' => 'Gestisci le tue disponibilità e approva gli appuntamenti',
      'description' => 'Crea slot di disponibilità per permettere ai pazienti di prenotare appuntamenti e gestisci gli appuntamenti esistenti.',
    ),
  ),
  'fields' => 
  array (
    'title' => 
    array (
      'label' => 'Titolo',
      'placeholder' => 'Inserisci un titolo per l\'appuntamento',
      'help' => 'Breve descrizione dell\'appuntamento',
      'description' => 'Un titolo chiaro aiuta a identificare rapidamente l\'appuntamento',
    ),
    'patient_id' => 
    array (
      'label' => 'Paziente',
      'placeholder' => 'Seleziona il paziente',
      'help' => 'Paziente per cui è fissato l\'appuntamento',
      'description' => 'La persona che riceverà la prestazione medica',
      'helper_text' => 'patient_id',
    ),
    'doctor_id' => 
    array (
      'label' => 'Medico',
      'placeholder' => 'Seleziona il medico',
      'help' => 'Medico che terrà l\'appuntamento',
      'description' => 'Seleziona il professionista per l\'appuntamento',
      'helper_text' => 'doctor_id',
    ),
    'studio_id' => 
    array (
      'label' => 'Studio',
      'placeholder' => 'Seleziona lo studio',
      'help' => 'Studio dove si terrà l\'appuntamento',
      'description' => 'Sede dell\'appuntamento',
    ),
    'start_time' => 
    array (
      'label' => 'Ora di inizio',
      'placeholder' => 'Seleziona l\'ora di inizio',
      'help' => 'Quando inizia l\'appuntamento',
      'description' => 'Orario di inizio programmato',
      'helper_text' => 'start_time',
    ),
    'end_time' => 
    array (
      'label' => 'Ora di fine',
      'placeholder' => 'Seleziona l\'ora di fine',
      'help' => 'Quando termina l\'appuntamento',
      'description' => 'Orario di fine previsto',
      'helper_text' => 'end_time',
    ),
    'treatment_id' => 
    array (
      'label' => 'Trattamento',
      'placeholder' => 'Seleziona un trattamento',
      'help' => 'Il tipo di trattamento previsto',
      'description' => 'Procedura medica che verrà eseguita',
      'helper_text' => 'treatment_id',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Seleziona lo stato',
      'help' => 'Stato attuale dell\'appuntamento',
      'description' => 'Indica se l\'appuntamento è confermato, in attesa, annullato, etc.',
      'options' => 
      array (
        'scheduled' => 'Programmato',
        'confirmed' => 'Confermato',
        'completed' => 'Completato',
        'cancelled' => 'Annullato',
        'no_show' => 'Non presentato',
      ),
      'helper_text' => 'status',
    ),
    'notes' => 
    array (
      'label' => 'Note',
      'placeholder' => 'Inserisci eventuali note',
      'help' => 'Informazioni aggiuntive',
      'description' => 'Note importanti relative all\'appuntamento',
      'helper_text' => '',
    ),
    'reason' => 
    array (
      'label' => 'Motivo',
      'placeholder' => 'Inserisci il motivo dell\'appuntamento',
      'help' => 'Motivo principale della visita',
      'description' => 'Descrizione sintetica della ragione dell\'appuntamento',
    ),
    'patient' => 
    array (
      'name' => 
      array (
        'label' => 'patient.name',
      ),
    ),
    'doctor' => 
    array (
      'name' => 
      array (
        'label' => 'doctor.name',
      ),
    ),
    'studio' => 
    array (
      'name' => 
      array (
        'label' => 'studio.name',
      ),
    ),
    'type' => 
    array (
      'label' => 'type',
    ),
    'emergency' => 
    array (
      'label' => 'emergency',
    ),
    'created_at' => 
    array (
      'label' => 'created_at',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
    'dentist_id' => 
    array (
      'label' => 'dentist_id',
      'placeholder' => 'dentist_id',
      'helper_text' => 'dentist_id',
      'description' => 'dentist_id',
    ),
    'eligibility_confirmed' => 
    array (
      'label' => 'eligibility_confirmed',
      'placeholder' => 'eligibility_confirmed',
      'helper_text' => 'eligibility_confirmed',
      'description' => 'eligibility_confirmed',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Nuovo appuntamento',
      'tooltip' => 'Crea un nuovo appuntamento',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'tooltip' => 'Modifica i dettagli dell\'appuntamento',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Rimuovi questo appuntamento',
      'confirmation' => 'Sei sicuro di voler eliminare questo appuntamento?',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'tooltip' => 'Visualizza i dettagli dell\'appuntamento',
    ),
    'confirm' => 
    array (
      'label' => 'Conferma',
      'tooltip' => 'Conferma questo appuntamento',
    ),
    'cancel' => 
    array (
      'label' => 'Annulla',
      'tooltip' => 'Annulla questo appuntamento',
    ),
    'reschedule' => 
    array (
      'label' => 'Riprogramma',
      'tooltip' => 'Cambia data e ora dell\'appuntamento',
    ),
    'mark_completed' => 
    array (
      'label' => 'Completa',
      'tooltip' => 'Segna come completato',
    ),
    'mark_no_show' => 
    array (
      'label' => 'Non presentato',
      'tooltip' => 'Segna come non presentato',
    ),
    'legend' => 
    array (
      'label' => 'Legenda',
      'modal_heading' => 'Legenda del Calendario',
    ),
  ),
  'filters' => 
  array (
    'today' => 
    array (
      'label' => 'Oggi',
    ),
    'upcoming' => 
    array (
      'label' => 'Prossimi',
    ),
    'past' => 
    array (
      'label' => 'Passati',
    ),
    'by_status' => 
    array (
      'label' => 'Per stato',
    ),
    'by_doctor' => 
    array (
      'label' => 'Per medico',
    ),
    'by_date_range' => 
    array (
      'label' => 'Per intervallo di date',
    ),
  ),
  'calendar' => 
  array (
    'title' => 'Calendario Appuntamenti',
    'today' => 'Oggi',
    'month' => 'Mese',
    'week' => 'Settimana',
    'day' => 'Giorno',
    'list' => 'Lista',
    'next' => 'Prossimo',
    'previous' => 'Precedente',
    'day_view' => 'Giornaliero',
    'week_view' => 'Settimanale',
    'month_view' => 'Mensile',
  ),
  'availability' => 
  array (
    'title' => 'Disponibilità',
    'add' => 'Aggiungi disponibilità',
    'edit' => 'Modifica disponibilità',
    'delete' => 'Elimina disponibilità',
  ),
  'legend' => 
  array (
    'description' => 'Legenda dei colori e delle icone utilizzate nel calendario.',
    'types' => 'Tipi di Evento',
    'icons' => 'Significato Icone',
    'availability' => 'Disponibilità',
    'pending' => 'Appuntamento in attesa',
    'confirmed' => 'Appuntamento confermato',
    'completed' => 'Appuntamento completato',
    'cancelled' => 'Appuntamento annullato',
    'availability_icon' => 'Slot di disponibilità',
    'pending_icon' => 'Appuntamento in attesa di conferma',
    'confirmed_icon' => 'Appuntamento confermato',
    'completed_icon' => 'Appuntamento completato',
    'cancelled_icon' => 'Appuntamento annullato',
    'instructions' => 'Istruzioni',
    'instruction_add' => 'Clicca su uno slot vuoto o sul pulsante \'+\' per aggiungere una nuova disponibilità.',
    'instruction_edit' => 'Clicca su un evento esistente per modificarlo o cambiarne lo stato.',
    'instruction_delete' => 'Nelle opzioni di modifica, clicca \'Elimina\' per rimuovere una disponibilità o un appuntamento non confermato.',
    'instruction_approve' => 'Per approvare un appuntamento, cambia lo stato da \'In attesa\' a \'Confermato\'.',
  ),
  'notifications' => 
  array (
    'reminder' => 
    array (
      'title' => 'Promemoria Appuntamento',
      'body' => 'Hai un appuntamento con :doctor tra :time ore',
    ),
    'confirmation' => 
    array (
      'title' => 'Appuntamento Confermato',
      'body' => 'Il tuo appuntamento con :doctor per il :date è stato confermato',
    ),
    'cancellation' => 
    array (
      'title' => 'Appuntamento Annullato',
      'body' => 'Il tuo appuntamento con :doctor per il :date è stato annullato',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Appuntamento creato con successo',
    'updated' => 'Appuntamento aggiornato con successo',
    'deleted' => 'Appuntamento eliminato con successo',
    'confirmed' => 'Appuntamento confermato con successo',
    'cancelled' => 'Appuntamento annullato con successo',
    'completed' => 'Appuntamento completato con successo',
    'rescheduled' => 'Appuntamento riprogrammato con successo',
    'conflict' => 'È già presente un altro appuntamento in questo orario',
    'unavailable_slot' => 'Questo orario non è disponibile per il medico selezionato',
    'past_date' => 'Non è possibile fissare un appuntamento nel passato',
    'unavailable' => 'Il medico non è disponibile in questo orario',
    'availability_created' => 'Disponibilità creata con successo',
    'availability_updated' => 'Disponibilità aggiornata con successo',
    'availability_deleted' => 'Disponibilità eliminata con successo',
    'appointment_updated' => 'Appuntamento aggiornato con successo',
  ),
);
