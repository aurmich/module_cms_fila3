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
      'description' => 'doctor_id',
    ),
    'studio_id' => 
    array (
      'label' => 'Studio',
      'placeholder' => 'Seleziona lo studio',
      'help' => 'Scegli lo studio dove si terrà l\'appuntamento',
      'tooltip' => 'Lo studio medico dove si terrà l\'appuntamento',
      'helper_text' => '',
      'description' => 'studio_id',
    ),
    'title' => 
    array (
      'label' => 'Titolo',
      'placeholder' => 'Inserisci il titolo dell\'appuntamento',
      'help' => 'Titolo o descrizione breve dell\'appuntamento',
      'tooltip' => 'Titolo dell\'appuntamento',
      'helper_text' => '',
      'description' => 'title',
    ),
    'starts_at' => 
    array (
      'label' => 'Data e Ora Inizio',
      'placeholder' => 'Seleziona data e ora di inizio',
      'help' => 'Data e ora di inizio dell\'appuntamento',
      'tooltip' => 'Quando inizia l\'appuntamento',
      'helper_text' => '',
      'description' => 'starts_at',
    ),
    'ends_at' => 
    array (
      'label' => 'Data e Ora Fine',
      'placeholder' => 'Seleziona data e ora di fine',
      'help' => 'Data e ora di fine dell\'appuntamento',
      'tooltip' => 'Quando termina l\'appuntamento',
      'helper_text' => '',
      'description' => 'ends_at',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'placeholder' => 'Seleziona il tipo di appuntamento',
      'help' => 'Tipo di appuntamento (visita, controllo, ecc.)',
      'tooltip' => 'Tipo di appuntamento',
      'helper_text' => '',
      'options' => 
      array (
        'consultation' => 'Consulenza',
        'checkup' => 'Controllo',
        'treatment' => 'Trattamento',
        'follow_up' => 'Controllo di Follow-up',
        'emergency' => 'Emergenza',
      ),
      'description' => 'type',
    ),
    'state' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Seleziona lo stato',
      'help' => 'Stato attuale dell\'appuntamento',
      'tooltip' => 'Lo stato corrente dell\'appuntamento',
      'helper_text' => '',
      'options' => 
      array (
        'pending' => 'In Attesa',
        'confirmed' => 'Confermato',
        'completed' => 'Completato',
        'cancelled' => 'Annullato',
        'no_show' => 'Non Presentato',
      ),
    ),
    'emergency' => 
    array (
      'label' => 'Emergenza',
      'help' => 'Indica se si tratta di un appuntamento di emergenza',
      'tooltip' => 'Flag per appuntamenti di emergenza',
      'helper_text' => '',
      'description' => 'emergency',
      'placeholder' => 'emergency',
    ),
    'notes' => 
    array (
      'label' => 'Note',
      'placeholder' => 'Inserisci note aggiuntive...',
      'help' => 'Note o commenti aggiuntivi sull\'appuntamento',
      'tooltip' => 'Informazioni aggiuntive sull\'appuntamento',
      'helper_text' => '',
      'description' => 'notes',
    ),
    'treatment_plan' => 
    array (
      'label' => 'Piano di Trattamento',
      'placeholder' => 'Descrivi il piano di trattamento',
      'help' => 'Piano di trattamento per questo appuntamento',
      'tooltip' => 'Piano di trattamento',
      'helper_text' => '',
    ),
    'eligibility_confirmed' => 
    array (
      'label' => 'Eligibilità Confermata',
      'help' => 'Indica se l\'eligibilità del paziente è stata confermata',
      'tooltip' => 'Conferma dell\'eligibilità',
      'helper_text' => '',
    ),
    'reminder_sent' => 
    array (
      'label' => 'Promemoria Inviato',
      'help' => 'Indica se è stato inviato un promemoria al paziente',
      'tooltip' => 'Stato dell\'invio del promemoria',
      'helper_text' => '',
    ),
    'reminder_sent_at' => 
    array (
      'label' => 'Data Invio Promemoria',
      'placeholder' => 'Seleziona la data',
      'help' => 'Data e ora di invio del promemoria',
      'tooltip' => 'Quando è stato inviato il promemoria',
      'helper_text' => '',
    ),
    'invoice' => 
    array (
      'label' => 'Fattura',
      'placeholder' => 'Carica la fattura',
      'help' => 'File della fattura per questo appuntamento',
      'tooltip' => 'Fattura dell\'appuntamento',
      'helper_text' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'help' => 'Data e ora di creazione dell\'appuntamento',
      'tooltip' => 'Quando è stato creato l\'appuntamento',
      'helper_text' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Data Aggiornamento',
      'help' => 'Data e ora dell\'ultimo aggiornamento',
      'tooltip' => 'Quando è stato aggiornato l\'ultima volta',
      'helper_text' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
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
    'openFilters' => 
    array (
      'label' => 'openFilters',
    ),
    'patient' => 
    array (
      'full_name' => 
      array (
        'label' => 'patient.full_name',
      ),
    ),
    'create' => 
    array (
      'label' => 'create',
    ),
    'layout' => 
    array (
      'label' => 'layout',
    ),
    'view' => 
    array (
      'label' => 'view',
    ),
    'edit' => 
    array (
      'label' => 'edit',
    ),
    'delete' => 
    array (
      'label' => 'delete',
    ),
    'value' => 
    array (
      'label' => 'value',
      'placeholder' => 'value',
      'helper_text' => 'value',
      'description' => 'value',
    ),
    'states' => 
    array (
      'label' => 'states',
    ),
    'status' => 
    array (
      'description' => 'status',
    ),
    'phone' => 
    array (
      'description' => 'phone',
      'helper_text' => 'phone',
      'placeholder' => 'phone',
      'label' => 'phone',
    ),
    'email' => 
    array (
      'description' => 'email',
      'helper_text' => 'email',
      'placeholder' => 'email',
      'label' => 'email',
    ),
    'last_name' => 
    array (
      'description' => 'last_name',
      'helper_text' => 'last_name',
      'placeholder' => 'last_name',
      'label' => 'last_name',
    ),
    'first_name' => 
    array (
      'description' => 'first_name',
      'helper_text' => 'first_name',
    ),
  ),
  'statuses' => 
  array (
    'pending' => 'In Attesa',
    'confirmed' => 'Confermato',
    'completed' => 'Completato',
    'cancelled' => 'Annullato',
    'no_show' => 'Non Presentato',
  ),
  'types' => 
  array (
    'consultation' => 'Consulenza',
    'checkup' => 'Controllo',
    'treatment' => 'Trattamento',
    'follow_up' => 'Controllo di Follow-up',
    'emergency' => 'Emergenza',
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
    'type' => 
    array (
      'label' => 'Per Tipo',
      'tooltip' => 'Filtra per tipo di appuntamento',
    ),
    'state' => 
    array (
      'label' => 'Per Stato',
      'tooltip' => 'Filtra per stato dell\'appuntamento',
    ),
    'emergency' => 
    array (
      'label' => 'Solo Emergenze',
      'tooltip' => 'Mostra solo appuntamenti di emergenza',
    ),
    'doctor' => 
    array (
      'label' => 'Per Medico',
      'tooltip' => 'Filtra per medico',
    ),
    'patient' => 
    array (
      'label' => 'Per Paziente',
      'tooltip' => 'Filtra per paziente',
    ),
    'studio' => 
    array (
      'label' => 'Per Studio',
      'tooltip' => 'Filtra per studio',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Appuntamento',
      'icon' => 'heroicon-o-plus',
      'tooltip' => 'Crea un nuovo appuntamento',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'icon' => 'heroicon-o-eye',
      'tooltip' => 'Visualizza i dettagli dell\'appuntamento',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'icon' => 'heroicon-o-pencil',
      'tooltip' => 'Modifica l\'appuntamento',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'icon' => 'heroicon-o-trash',
      'tooltip' => 'Elimina l\'appuntamento',
    ),
    'confirm' => 
    array (
      'label' => 'Conferma',
      'icon' => 'heroicon-o-check-circle',
      'modal_heading' => 'Conferma Appuntamento',
      'modal_description' => 'Sei sicuro di voler confermare questo appuntamento?',
      'tooltip' => 'Conferma l\'appuntamento programmato',
    ),
    'cancel' => 
    array (
      'label' => 'Annulla',
      'icon' => 'heroicon-o-x-circle',
      'modal_heading' => 'Annulla Appuntamento',
      'modal_description' => 'Sei sicuro di voler annullare questo appuntamento?',
      'tooltip' => 'Annulla l\'appuntamento',
    ),
    'mark_completed' => 
    array (
      'label' => 'Segna Completato',
      'icon' => 'heroicon-o-check',
      'tooltip' => 'Segna l\'appuntamento come completato',
    ),
    'send_reminder' => 
    array (
      'label' => 'Invia Promemoria',
      'icon' => 'heroicon-o-bell',
      'tooltip' => 'Invia un promemoria al paziente',
    ),
    'bulk_confirm' => 
    array (
      'label' => 'Conferma Selezionati',
      'icon' => 'heroicon-o-check-circle',
      'modal_heading' => 'Conferma Appuntamenti Selezionati',
      'modal_description' => 'Sei sicuro di voler confermare gli appuntamenti selezionati?',
      'tooltip' => 'Conferma tutti gli appuntamenti selezionati',
    ),
    'bulk_cancel' => 
    array (
      'label' => 'Annulla Selezionati',
      'icon' => 'heroicon-o-x-circle',
      'modal_heading' => 'Annulla Appuntamenti Selezionati',
      'modal_description' => 'Sei sicuro di voler annullare gli appuntamenti selezionati?',
      'tooltip' => 'Annulla tutti gli appuntamenti selezionati',
    ),
    'bulk_delete' => 
    array (
      'label' => 'Elimina Selezionati',
      'icon' => 'heroicon-o-trash',
      'tooltip' => 'Elimina tutti gli appuntamenti selezionati',
    ),
    'export' => 
    array (
      'label' => 'Esporta',
      'icon' => 'heroicon-o-arrow-down-tray',
      'tooltip' => 'Esporta gli appuntamenti',
    ),
  ),
  'bulk_actions' => 
  array (
    'confirm_selected' => 
    array (
      'label' => 'Conferma Selezionati',
      'icon' => 'heroicon-o-check-circle',
    ),
    'cancel_selected' => 
    array (
      'label' => 'Annulla Selezionati',
      'icon' => 'heroicon-o-x-circle',
    ),
    'delete_selected' => 
    array (
      'label' => 'Elimina Selezionati',
      'icon' => 'heroicon-o-trash',
    ),
    'export_selected' => 
    array (
      'label' => 'Esporta Selezionati',
      'icon' => 'heroicon-o-arrow-down-tray',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Appuntamento creato con successo',
    'updated' => 'Appuntamento aggiornato con successo',
    'deleted' => 'Appuntamento eliminato con successo',
    'confirmed' => 'Appuntamento confermato con successo',
    'cancelled' => 'Appuntamento annullato con successo',
    'completed' => 'Appuntamento segnato come completato',
    'reminder_sent' => 'Promemoria inviato con successo',
    'bulk_confirmed' => 'Appuntamenti confermati con successo',
    'bulk_cancelled' => 'Appuntamenti annullati con successo',
    'bulk_deleted' => 'Appuntamenti eliminati con successo',
    'error' => 'Si è verificato un errore durante l\'operazione',
    'not_found' => 'Appuntamento non trovato',
    'unauthorized' => 'Non sei autorizzato a eseguire questa operazione',
    'time_conflict' => 'Conflitto di orario con un altro appuntamento',
    'invalid_date' => 'Data non valida per l\'appuntamento',
  ),
  'notifications' => 
  array (
    'created' => 'Appuntamento creato con successo',
    'updated' => 'Appuntamento aggiornato con successo',
    'deleted' => 'Appuntamento eliminato con successo',
    'confirmed' => 'Appuntamento confermato con successo',
    'cancelled' => 'Appuntamento annullato con successo',
    'reminder_sent' => 'Promemoria inviato con successo',
    'error' => 'Si è verificato un errore durante l\'operazione',
  ),
  'validation' => 
  array (
    'patient_id' => 
    array (
      'required' => 'Il paziente è obbligatorio',
    ),
    'doctor_id' => 
    array (
      'required' => 'Il medico è obbligatorio',
    ),
    'studio_id' => 
    array (
      'required' => 'Lo studio è obbligatorio',
    ),
    'title' => 
    array (
      'required' => 'Il titolo è obbligatorio',
      'max' => 'Il titolo non può superare :max caratteri',
    ),
    'starts_at' => 
    array (
      'required' => 'La data e ora di inizio sono obbligatorie',
      'date' => 'La data di inizio deve essere una data valida',
      'after' => 'La data di inizio deve essere nel futuro',
    ),
    'ends_at' => 
    array (
      'required' => 'La data e ora di fine sono obbligatorie',
      'date' => 'La data di fine deve essere una data valida',
      'after' => 'La data di fine deve essere successiva alla data di inizio',
    ),
    'type' => 
    array (
      'required' => 'Il tipo è obbligatorio',
      'in' => 'Tipo di appuntamento non valido',
    ),
    'state' => 
    array (
      'required' => 'Lo stato è obbligatorio',
      'in' => 'Stato non valido',
    ),
    'emergency' => 
    array (
      'boolean' => 'Il campo emergenza deve essere vero o falso',
    ),
    'notes' => 
    array (
      'max' => 'Le note non possono superare :max caratteri',
    ),
  ),
  'search_placeholder' => 'Cerca per titolo, paziente, medico o studio...',
);
