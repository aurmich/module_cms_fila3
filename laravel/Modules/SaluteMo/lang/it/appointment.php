<?php

return array (
  'model' => 
  array (
    'label' => 'Appuntamento',
    'plural' => 'Appuntamenti',
    'description' => 'Gestione completa degli appuntamenti medici',
    'icon' => 'heroicon-o-calendar',
  ),
  'navigation' => 
  array (
    'label' => 'Appuntamenti',
    'group' => 'Gestione Appuntamenti',
    'icon' => 'heroicon-o-calendar',
    'color' => 'blue',
    'sort' => 1,
    'tooltip' => 'Gestisci tutti gli appuntamenti medici del sistema',
    'helper_text' => '',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Elenco Appuntamenti',
      'subtitle' => 'Gestione completa degli appuntamenti medici',
      'description' => 'Visualizza e gestisci tutti gli appuntamenti del sistema',
    ),
    'create' => 
    array (
      'title' => 'Nuovo Appuntamento',
      'subtitle' => 'Crea un nuovo appuntamento medico',
      'description' => 'Inserisci i dettagli per creare un nuovo appuntamento',
    ),
    'edit' => 
    array (
      'title' => 'Modifica Appuntamento',
      'subtitle' => 'Modifica i dettagli dell\'appuntamento',
      'description' => 'Aggiorna le informazioni dell\'appuntamento selezionato',
    ),
    'view' => 
    array (
      'title' => 'Dettagli Appuntamento',
      'subtitle' => 'Visualizza i dettagli completi dell\'appuntamento',
      'description' => 'Informazioni dettagliate sull\'appuntamento selezionato',
    ),
  ),
  'fields' => 
  array (
    'patient_section' => 
    array (
      'label' => 'Informazioni Paziente',
      'description' => 'Dati del paziente e del medico',
      'tooltip' => 'Seleziona il paziente, il medico e lo studio per l\'appuntamento',
      'helper_text' => '',
    ),
    'schedule_section' => 
    array (
      'label' => 'Programmazione',
      'description' => 'Data, ora e stato dell\'appuntamento',
      'tooltip' => 'Imposta la data, l\'ora e lo stato dell\'appuntamento',
      'helper_text' => '',
    ),
    'details_section' => 
    array (
      'label' => 'Dettagli Aggiuntivi',
      'description' => 'Note e flag speciali',
      'tooltip' => 'Aggiungi note e imposta flag speciali per l\'appuntamento',
      'helper_text' => '',
    ),
    'patient_id' => 
    array (
      'label' => 'Paziente',
      'placeholder' => 'Seleziona il paziente',
      'help' => 'Scegli il paziente per questo appuntamento',
      'tooltip' => 'Il paziente che ha prenotato l\'appuntamento',
      'helper_text' => '',
    ),
    'doctor_id' => 
    array (
      'label' => 'Medico',
      'placeholder' => 'Seleziona il medico',
      'help' => 'Scegli il medico che effettuerà la visita',
      'tooltip' => 'Il medico responsabile dell\'appuntamento',
      'helper_text' => '',
    ),
    'studio_id' => 
    array (
      'label' => 'Studio',
      'placeholder' => 'Seleziona lo studio',
      'help' => 'Scegli lo studio dove si terrà l\'appuntamento',
      'tooltip' => 'Lo studio medico dove si terrà l\'appuntamento',
      'helper_text' => '',
    ),
    'start_time' => 
    array (
      'label' => 'Data e Ora Inizio',
      'placeholder' => 'Seleziona data e ora di inizio',
      'help' => 'Data e ora di inizio dell\'appuntamento',
      'tooltip' => 'Quando inizia l\'appuntamento',
      'helper_text' => '',
    ),
    'end_time' => 
    array (
      'label' => 'Data e Ora Fine',
      'placeholder' => 'Seleziona data e ora di fine',
      'help' => 'Data e ora di fine dell\'appuntamento',
      'tooltip' => 'Quando termina l\'appuntamento',
      'helper_text' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Seleziona lo stato',
      'help' => 'Stato attuale dell\'appuntamento',
      'tooltip' => 'Lo stato corrente dell\'appuntamento',
      'helper_text' => '',
    ),
    'notes' => 
    array (
      'label' => 'Note',
      'placeholder' => 'Inserisci note aggiuntive...',
      'help' => 'Note o commenti aggiuntivi sull\'appuntamento',
      'tooltip' => 'Informazioni aggiuntive sull\'appuntamento',
      'helper_text' => '',
    ),
    'is_emergency' => 
    array (
      'label' => 'Emergenza',
      'help' => 'Indica se si tratta di un appuntamento di emergenza',
      'tooltip' => 'Flag per appuntamenti di emergenza',
      'helper_text' => '',
    ),
    'is_reminder_sent' => 
    array (
      'label' => 'Promemoria Inviato',
      'help' => 'Indica se è stato inviato un promemoria al paziente',
      'tooltip' => 'Stato dell\'invio del promemoria',
      'helper_text' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'help' => 'Data e ora di creazione dell\'appuntamento',
      'tooltip' => 'Quando è stato creato l\'appuntamento',
      'helper_text' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
    ),
    'delete' => 
    array (
      'label' => 'delete',
    ),
    'edit' => 
    array (
      'label' => 'edit',
    ),
    'view' => 
    array (
      'label' => 'view',
    ),
    'state' => 
    array (
      'label' => 'state',
    ),
    'invoice' => 
    array (
      'label' => 'invoice',
    ),
    'ends_at' => 
    array (
      'label' => 'ends_at',
    ),
    'starts_at' => 
    array (
      'label' => 'starts_at',
    ),
    'title' => 
    array (
      'label' => 'title',
    ),
    'patient' => 
    array (
      'full_name' => 
      array (
        'label' => 'patient.full_name',
      ),
    ),
    'value' => 
    array (
      'description' => 'value',
    ),
  ),
  'statuses' => 
  array (
    'scheduled' => 'Programmato',
    'confirmed' => 'Confermato',
    'completed' => 'Completato',
    'cancelled' => 'Annullato',
    'no_show' => 'Non Presentato',
  ),
  'filters' => 
  array (
    'date_range' => 
    array (
      'label' => 'Intervallo Date',
      'start_date' => 'Data Inizio',
      'end_date' => 'Data Fine',
      'tooltip' => 'Filtra appuntamenti per intervallo di date',
      'helper_text' => '',
    ),
  ),
  'actions' => 
  array (
    'view' => 
    array (
      'label' => 'Visualizza',
      'tooltip' => 'Visualizza i dettagli dell\'appuntamento',
      'helper_text' => '',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'tooltip' => 'Modifica l\'appuntamento',
      'helper_text' => '',
    ),
    'confirm' => 
    array (
      'label' => 'Conferma',
      'modal_heading' => 'Conferma Appuntamento',
      'modal_description' => 'Sei sicuro di voler confermare questo appuntamento?',
      'tooltip' => 'Conferma l\'appuntamento programmato',
      'helper_text' => '',
    ),
    'cancel' => 
    array (
      'label' => 'Annulla',
      'modal_heading' => 'Annulla Appuntamento',
      'modal_description' => 'Sei sicuro di voler annullare questo appuntamento?',
      'tooltip' => 'Annulla l\'appuntamento',
      'helper_text' => '',
    ),
    'bulk_confirm' => 
    array (
      'label' => 'Conferma Selezionati',
      'modal_heading' => 'Conferma Appuntamenti Selezionati',
      'modal_description' => 'Sei sicuro di voler confermare gli appuntamenti selezionati?',
      'tooltip' => 'Conferma tutti gli appuntamenti selezionati',
      'helper_text' => '',
    ),
    'bulk_cancel' => 
    array (
      'label' => 'Annulla Selezionati',
      'modal_heading' => 'Annulla Appuntamenti Selezionati',
      'modal_description' => 'Sei sicuro di voler annullare gli appuntamenti selezionati?',
      'tooltip' => 'Annulla tutti gli appuntamenti selezionati',
      'helper_text' => '',
    ),
    'bulk_delete' => 
    array (
      'label' => 'Elimina Selezionati',
      'tooltip' => 'Elimina tutti gli appuntamenti selezionati',
      'helper_text' => '',
    ),
    'create' => 
    array (
      'label' => 'create',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Appuntamento creato con successo',
    'updated' => 'Appuntamento aggiornato con successo',
    'deleted' => 'Appuntamento eliminato con successo',
    'confirmed' => 'Appuntamento confermato con successo',
    'cancelled' => 'Appuntamento annullato con successo',
    'bulk_confirmed' => 'Appuntamenti confermati con successo',
    'bulk_cancelled' => 'Appuntamenti annullati con successo',
    'bulk_deleted' => 'Appuntamenti eliminati con successo',
    'error' => 'Si è verificato un errore durante l\'operazione',
    'not_found' => 'Appuntamento non trovato',
    'unauthorized' => 'Non sei autorizzato a eseguire questa operazione',
  ),
  'validation' => 
  array (
    'patient_id_required' => 'Il paziente è obbligatorio',
    'doctor_id_required' => 'Il medico è obbligatorio',
    'studio_id_required' => 'Lo studio è obbligatorio',
    'start_time_required' => 'La data e ora di inizio sono obbligatorie',
    'end_time_required' => 'La data e ora di fine sono obbligatorie',
    'end_time_after_start' => 'La data di fine deve essere successiva alla data di inizio',
    'status_required' => 'Lo stato è obbligatorio',
    'status_invalid' => 'Stato non valido',
  ),
);
