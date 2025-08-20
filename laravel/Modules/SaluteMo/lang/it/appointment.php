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
      'description' => 'Selezione paziente per appuntamento',
      'icon' => 'heroicon-o-user',
      'color' => 'primary',
    ),
    'doctor_id' => 
    array (
      'label' => 'Medico',
      'placeholder' => 'Seleziona il medico',
      'help' => 'Scegli il medico che effettuerà la visita',
      'tooltip' => 'Il medico responsabile dell\'appuntamento',
      'helper_text' => '',
      'description' => 'Selezione medico per appuntamento',
      'icon' => 'heroicon-o-user-circle',
      'color' => 'success',
    ),
    'studio_id' => 
    array (
      'label' => 'Studio',
      'placeholder' => 'Seleziona lo studio',
      'help' => 'Scegli lo studio dove si terrà l\'appuntamento',
      'tooltip' => 'Lo studio medico dove si terrà l\'appuntamento',
      'helper_text' => '',
      'description' => 'Selezione studio per appuntamento',
      'icon' => 'heroicon-o-building-office',
      'color' => 'info',
    ),
    'patient' => 
    array (
      'label' => 'Paziente',
      'placeholder' => 'Seleziona un\'opzione',
      'help' => 'Scegli il paziente per questo appuntamento',
      'tooltip' => 'Il paziente che ha prenotato l\'appuntamento',
      'helper_text' => '',
      'description' => 'Selezione paziente per appuntamento',
      'icon' => 'heroicon-o-user',
      'color' => 'primary',
    ),
    'doctor' => 
    array (
      'label' => 'Medico',
      'placeholder' => 'Seleziona un\'opzione',
      'help' => 'Scegli il medico che effettuerà la visita',
      'tooltip' => 'Il medico responsabile dell\'appuntamento',
      'helper_text' => '',
      'description' => 'Selezione medico per appuntamento',
      'icon' => 'heroicon-o-user-circle',
      'color' => 'success',
    ),
    'studio' => 
    array (
      'label' => 'Studio',
      'placeholder' => 'Seleziona un\'opzione',
      'help' => 'Scegli lo studio dove si terrà l\'appuntamento',
      'tooltip' => 'Lo studio medico dove si terrà l\'appuntamento',
      'helper_text' => '',
      'description' => 'Selezione studio per appuntamento',
      'icon' => 'heroicon-o-building-office',
      'color' => 'info',
    ),
    'title' => 
    array (
      'label' => 'Titolo',
      'placeholder' => 'Inserisci il titolo dell\'appuntamento',
      'help' => 'Titolo o descrizione breve dell\'appuntamento',
      'tooltip' => 'Titolo dell\'appuntamento',
      'helper_text' => '',
      'description' => 'Titolo breve per l\'appuntamento',
      'icon' => 'heroicon-o-document-text',
      'color' => 'primary',
    ),
    'starts_at' => 
    array (
      'label' => 'Data e Ora Inizio',
      'placeholder' => 'Seleziona data e ora di inizio',
      'help' => 'Data e ora di inizio dell\'appuntamento',
      'tooltip' => 'Quando inizia l\'appuntamento',
      'helper_text' => '',
      'description' => 'Data e ora di inizio appuntamento',
      'icon' => 'heroicon-o-calendar-days',
      'color' => 'success',
    ),
    'ends_at' => 
    array (
      'label' => 'Data e Ora Fine',
      'placeholder' => 'Seleziona data e ora di fine',
      'help' => 'Data e ora di fine dell\'appuntamento',
      'tooltip' => 'Quando termina l\'appuntamento',
      'helper_text' => '',
      'description' => 'Data e ora di fine appuntamento',
      'icon' => 'heroicon-o-calendar-days',
      'color' => 'warning',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'placeholder' => 'Seleziona un\'opzione',
      'help' => 'Tipo di appuntamento (visita, controllo, ecc.)',
      'tooltip' => 'Tipo di appuntamento',
      'helper_text' => '',
      'description' => 'Tipo di appuntamento',
      'icon' => 'heroicon-o-clipboard-document-list',
      'color' => 'secondary',
      'options' => 
      array (
        'consultation' => 'Consulenza',
        'checkup' => 'Controllo',
        'treatment' => 'Trattamento',
        'follow_up' => 'Controllo di Follow-up',
        'emergency' => 'Emergenza',
      ),
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Programmato',
      'help' => 'Stato attuale dell\'appuntamento',
      'tooltip' => 'Lo stato corrente dell\'appuntamento',
      'helper_text' => '',
      'description' => 'Stato dell\'appuntamento',
      'icon' => 'heroicon-o-flag',
      'color' => 'info',
      'options' => 
      array (
        'pending' => 'In Attesa',
        'confirmed' => 'Confermato',
        'scheduled' => 'Programmato',
        'cancelled' => 'Annullato',
        'rejected' => 'Rifiutato',
        'no_show' => 'Non Presentato',
        'rescheduled' => 'Riprogrammato',
        'report_pending' => 'Referto in Attesa',
        'report_completed' => 'Referto Completato',
        'banned' => 'Bannato',
        'refund_pending' => 'Rimborso in Attesa',
        'refund_accepted' => 'Rimborso Accettato',
        'refund_completed' => 'Rimborso Completato',
        'refund_to_integrate' => 'Rimborso da Integrare',
        'refund_integrate' => 'Rimborso da Integrare',
        'pro_bono' => 'Pro Bono',
      ),
    ),
    'emergency' => 
    array (
      'label' => 'Emergenza',
      'placeholder' => 'Seleziona se è un\'emergenza',
      'help' => 'Indica se si tratta di un appuntamento di emergenza',
      'tooltip' => 'Flag per appuntamenti di emergenza',
      'helper_text' => '',
      'description' => 'Flag emergenza appuntamento',
      'icon' => 'heroicon-o-exclamation-triangle',
      'color' => 'danger',
    ),
    'notes' => 
    array (
      'label' => 'Note',
      'placeholder' => 'Inserisci note aggiuntive...',
      'help' => 'Note o commenti aggiuntivi sull\'appuntamento',
      'tooltip' => 'Informazioni aggiuntive sull\'appuntamento',
      'helper_text' => '',
      'description' => 'Note aggiuntive appuntamento',
      'icon' => 'heroicon-o-document-text',
      'color' => 'gray',
    ),
    'treatment_plan' => 
    array (
      'label' => 'Piano di Trattamento',
      'placeholder' => 'Inserisci il piano di trattamento...',
      'help' => 'Piano di trattamento per questo appuntamento',
      'tooltip' => 'Piano di trattamento dettagliato',
      'helper_text' => '',
      'description' => 'Piano di trattamento',
      'icon' => 'heroicon-o-clipboard-document-list',
      'color' => 'info',
    ),
    'diagnosis' => 
    array (
      'label' => 'Diagnosi',
      'placeholder' => 'Inserisci la diagnosi...',
      'help' => 'Diagnosi effettuata durante l\'appuntamento',
      'tooltip' => 'Diagnosi medica',
      'helper_text' => '',
      'description' => 'Diagnosi medica',
      'icon' => 'heroicon-o-document-magnifying-glass',
      'color' => 'warning',
    ),
    'prescription' => 
    array (
      'label' => 'Prescrizione',
      'placeholder' => 'Inserisci la prescrizione...',
      'help' => 'Prescrizione medica rilasciata',
      'tooltip' => 'Prescrizione farmaci o terapie',
      'helper_text' => '',
      'description' => 'Prescrizione medica',
      'icon' => 'heroicon-o-document-text',
      'color' => 'success',
    ),
    'follow_up_date' => 
    array (
      'label' => 'Data Follow-up',
      'placeholder' => 'Seleziona la data del follow-up',
      'help' => 'Data per il prossimo controllo',
      'tooltip' => 'Data del prossimo appuntamento di controllo',
      'helper_text' => '',
      'description' => 'Data follow-up',
      'icon' => 'heroicon-o-calendar-days',
      'color' => 'info',
    ),
    'cost' => 
    array (
      'label' => 'Costo',
      'placeholder' => 'Inserisci il costo...',
      'help' => 'Costo dell\'appuntamento',
      'tooltip' => 'Costo dell\'appuntamento in euro',
      'helper_text' => '',
      'description' => 'Costo appuntamento',
      'icon' => 'heroicon-o-currency-euro',
      'color' => 'warning',
    ),
    'payment_status' => 
    array (
      'label' => 'Stato Pagamento',
      'placeholder' => 'Seleziona lo stato del pagamento',
      'help' => 'Stato del pagamento per questo appuntamento',
      'tooltip' => 'Stato del pagamento',
      'helper_text' => '',
      'description' => 'Stato pagamento',
      'icon' => 'heroicon-o-credit-card',
      'color' => 'secondary',
      'options' => 
      array (
        'pending' => 'In Attesa',
        'paid' => 'Pagato',
        'partial' => 'Pagamento Parziale',
        'refunded' => 'Rimborsato',
        'cancelled' => 'Annullato',
      ),
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'placeholder' => 'Data di creazione',
      'help' => 'Data e ora di creazione dell\'appuntamento',
      'tooltip' => 'Quando è stato creato l\'appuntamento',
      'helper_text' => '',
      'description' => 'Data creazione',
      'icon' => 'heroicon-o-clock',
      'color' => 'gray',
    ),
    'updated_at' => 
    array (
      'label' => 'Data Aggiornamento',
      'placeholder' => 'Data di aggiornamento',
      'help' => 'Data e ora dell\'ultimo aggiornamento',
      'tooltip' => 'Quando è stato aggiornato l\'ultima volta',
      'helper_text' => '',
      'description' => 'Data aggiornamento',
      'icon' => 'heroicon-o-clock',
      'color' => 'gray',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => 'Inserisci il numero di telefono',
      'tooltip' => 'Numero di telefono del paziente',
      'helper_text' => '',
      'description' => 'Numero di telefono per contatti',
      'icon' => 'heroicon-o-phone',
      'color' => 'info',
    ),
    'state' => 
    array (
      'description' => 'state',
      'helper_text' => 'state',
      'placeholder' => 'state',
      'label' => 'state',
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
    'value' => 
    array (
      'description' => 'value',
      'helper_text' => 'value',
      'placeholder' => 'value',
      'label' => 'value',
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
    'layout' => 
    array (
      'label' => 'layout',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Appuntamento',
      'icon' => 'heroicon-o-plus',
      'tooltip' => 'Crea un nuovo appuntamento',
      'success' => 'Appuntamento creato con successo',
      'error' => 'Errore durante la creazione dell\'appuntamento',
      'helper_text' => '',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'icon' => 'heroicon-o-eye',
      'tooltip' => 'Visualizza i dettagli dell\'appuntamento',
      'success' => 'Dettagli appuntamento caricati',
      'error' => 'Errore nel caricamento dei dettagli',
      'helper_text' => '',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'icon' => 'heroicon-o-pencil',
      'tooltip' => 'Modifica l\'appuntamento',
      'success' => 'Appuntamento aggiornato con successo',
      'error' => 'Errore durante l\'aggiornamento',
      'helper_text' => '',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'icon' => 'heroicon-o-trash',
      'tooltip' => 'Elimina l\'appuntamento',
      'success' => 'Appuntamento eliminato con successo',
      'error' => 'Errore durante l\'eliminazione',
      'confirmation' => 'Sei sicuro di voler eliminare questo appuntamento?',
      'helper_text' => '',
    ),
    'confirm' => 
    array (
      'label' => 'Conferma',
      'icon' => 'heroicon-o-check-circle',
      'modal_heading' => 'Conferma Appuntamento',
      'modal_description' => 'Sei sicuro di voler confermare questo appuntamento?',
      'tooltip' => 'Conferma l\'appuntamento programmato',
      'success' => 'Appuntamento confermato con successo',
      'error' => 'Errore durante la conferma',
      'helper_text' => '',
    ),
    'cancel' => 
    array (
      'label' => 'Annulla',
      'icon' => 'heroicon-o-x-circle',
      'modal_heading' => 'Annulla Appuntamento',
      'modal_description' => 'Sei sicuro di voler annullare questo appuntamento?',
      'tooltip' => 'Annulla l\'appuntamento',
      'success' => 'Appuntamento annullato con successo',
      'error' => 'Errore durante l\'annullamento',
      'helper_text' => '',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Appuntamento creato con successo',
    'updated' => 'Appuntamento aggiornato con successo',
    'deleted' => 'Appuntamento eliminato con successo',
    'confirmed' => 'Appuntamento confermato con successo',
    'cancelled' => 'Appuntamento annullato con successo',
    'error' => 'Si è verificato un errore durante l\'operazione',
    'not_found' => 'Appuntamento non trovato',
    'unauthorized' => 'Non sei autorizzato a eseguire questa operazione',
  ),
  'validation' => 
  array (
    'patient_id' => 
    array (
      'required' => 'Il paziente è obbligatorio',
      'exists' => 'Il paziente selezionato non esiste',
    ),
    'doctor_id' => 
    array (
      'required' => 'Il medico è obbligatorio',
      'exists' => 'Il medico selezionato non esiste',
    ),
    'studio_id' => 
    array (
      'required' => 'Lo studio è obbligatorio',
      'exists' => 'Lo studio selezionato non esiste',
    ),
    'title' => 
    array (
      'required' => 'Il titolo è obbligatorio',
      'max' => 'Il titolo non può superare :max caratteri',
      'string' => 'Il titolo deve essere una stringa',
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
    'status' => 
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
      'string' => 'Le note devono essere una stringa',
    ),
  ),
);
