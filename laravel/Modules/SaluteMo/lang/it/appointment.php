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
    'title' => 
    array (
      'label' => 'Titolo',
      'placeholder' => 'Inserisci il titolo dell\'appuntamento',
      'help' => 'Titolo o descrizione breve dell\'appuntamento',
      'tooltip' => 'Titolo dell\'appuntamento',
      'helper_text' => '',
    ),
    'starts_at' => 
    array (
      'label' => 'Data e Ora Inizio',
      'placeholder' => 'Seleziona data e ora di inizio',
      'help' => 'Data e ora di inizio dell\'appuntamento',
      'tooltip' => 'Quando inizia l\'appuntamento',
      'helper_text' => '',
    ),
    'ends_at' => 
    array (
      'label' => 'Data e Ora Fine',
      'placeholder' => 'Seleziona data e ora di fine',
      'help' => 'Data e ora di fine dell\'appuntamento',
      'tooltip' => 'Quando termina l\'appuntamento',
      'helper_text' => '',
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
    ),
    'notes' => 
    array (
      'label' => 'Note',
      'placeholder' => 'Inserisci note aggiuntive...',
      'help' => 'Note o commenti aggiuntivi sull\'appuntamento',
      'tooltip' => 'Informazioni aggiuntive sull\'appuntamento',
      'helper_text' => '',
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
      'placeholder' => 'Conferma l\'eligibilità',
      'help' => 'Indica se l\'eligibilità del paziente è stata confermata',
      'tooltip' => 'Conferma dell\'eligibilità',
      'helper_text' => '',
    ),
    'reminder_sent' => 
    array (
      'label' => 'Promemoria Inviato',
      'placeholder' => 'Seleziona se il promemoria è stato inviato',
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
      'placeholder' => 'Data di creazione',
      'help' => 'Data e ora di creazione dell\'appuntamento',
      'tooltip' => 'Quando è stato creato l\'appuntamento',
      'helper_text' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Data Aggiornamento',
      'placeholder' => 'Data di aggiornamento',
      'help' => 'Data e ora dell\'ultimo aggiornamento',
      'tooltip' => 'Quando è stato aggiornato l\'ultima volta',
      'helper_text' => '',
    ),
    'apply_filters' => 
    array (
      'label' => 'Applica Filtri',
      'placeholder' => 'Applica i filtri selezionati',
      'help' => 'Applica i filtri per filtrare i risultati',
      'tooltip' => 'Applica i filtri di ricerca',
      'helper_text' => '',
    ),
    'toggle_columns' => 
    array (
      'label' => 'Mostra/Nascondi Colonne',
      'placeholder' => 'Gestisci visibilità colonne',
      'help' => 'Mostra o nascondi colonne nella tabella',
      'tooltip' => 'Gestisci la visibilità delle colonne',
      'helper_text' => '',
    ),
    'reorder_records' => 
    array (
      'label' => 'Riordina Record',
      'placeholder' => 'Riordina i record',
      'help' => 'Riordina i record nella tabella',
      'tooltip' => 'Modifica l\'ordine dei record',
      'helper_text' => '',
    ),
    'reset_filters' => 
    array (
      'label' => 'Reset Filtri',
      'placeholder' => 'Ripristina filtri predefiniti',
      'help' => 'Ripristina tutti i filtri ai valori predefiniti',
      'tooltip' => 'Rimuovi tutti i filtri applicati',
      'helper_text' => '',
    ),
    'open_filters' => 
    array (
      'label' => 'Apri Filtri',
      'placeholder' => 'Apri pannello filtri',
      'help' => 'Apri il pannello dei filtri di ricerca',
      'tooltip' => 'Mostra le opzioni di filtro',
      'helper_text' => '',
    ),
    'value' => 
    array (
      'label' => 'Valore',
      'placeholder' => 'Inserisci il valore',
      'help' => 'Valore del campo',
      'tooltip' => 'Valore del campo',
      'helper_text' => '',
      'description' => 'value',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'placeholder' => 'Elimina elemento',
      'help' => 'Elimina l\'elemento selezionato',
      'tooltip' => 'Rimuovi definitivamente',
      'helper_text' => '',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'placeholder' => 'Modifica elemento',
      'help' => 'Modifica l\'elemento selezionato',
      'tooltip' => 'Modifica i dati',
      'helper_text' => '',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'placeholder' => 'Visualizza dettagli',
      'help' => 'Visualizza i dettagli dell\'elemento',
      'tooltip' => 'Mostra informazioni complete',
      'helper_text' => '',
    ),
    'layout' => 
    array (
      'label' => 'Layout',
      'placeholder' => 'Seleziona layout',
      'help' => 'Layout di visualizzazione',
      'tooltip' => 'Tipo di layout',
      'helper_text' => '',
    ),
    'create' => 
    array (
      'label' => 'Crea',
      'placeholder' => 'Crea nuovo elemento',
      'help' => 'Crea un nuovo elemento',
      'tooltip' => 'Aggiungi nuovo record',
      'helper_text' => '',
    ),
    'states' => 
    array (
      'label' => 'Stati',
      'placeholder' => 'Seleziona stati',
      'help' => 'Stati disponibili',
      'tooltip' => 'Lista degli stati',
      'helper_text' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Seleziona stato',
      'help' => 'Stato corrente',
      'tooltip' => 'Stato dell\'elemento',
      'helper_text' => '',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => 'Inserisci numero di telefono',
      'help' => 'Numero di telefono di contatto',
      'tooltip' => 'Telefono per contatti',
      'helper_text' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci indirizzo email',
      'help' => 'Indirizzo email di contatto',
      'tooltip' => 'Email per comunicazioni',
      'helper_text' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome',
      'help' => 'Cognome della persona',
      'tooltip' => 'Cognome completo',
      'helper_text' => '',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'help' => 'Nome della persona',
      'tooltip' => 'Nome completo',
      'helper_text' => '',
    ),
    'patient' => 
    array (
      'full_name' => 
      array (
        'label' => 'Nome Completo Paziente',
        'placeholder' => 'Nome e cognome del paziente',
        'help' => 'Nome completo del paziente',
        'tooltip' => 'Nome e cognome del paziente',
        'helper_text' => '',
      ),
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
  ),
  'statuses' => 
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
      'helper_text' => '',
    ),
    'state' => 
    array (
      'label' => 'Per Stato',
      'tooltip' => 'Filtra per stato dell\'appuntamento',
      'helper_text' => '',
    ),
    'emergency' => 
    array (
      'label' => 'Solo Emergenze',
      'tooltip' => 'Mostra solo appuntamenti di emergenza',
      'helper_text' => '',
    ),
    'doctor' => 
    array (
      'label' => 'Per Medico',
      'tooltip' => 'Filtra per medico',
      'helper_text' => '',
    ),
    'patient' => 
    array (
      'label' => 'Per Paziente',
      'tooltip' => 'Filtra per paziente',
      'helper_text' => '',
    ),
    'studio' => 
    array (
      'label' => 'Per Studio',
      'tooltip' => 'Filtra per studio',
      'helper_text' => '',
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
    'mark_completed' => 
    array (
      'label' => 'Segna Completato',
      'icon' => 'heroicon-o-check',
      'tooltip' => 'Segna l\'appuntamento come completato',
      'success' => 'Appuntamento segnato come completato',
      'error' => 'Errore durante l\'aggiornamento dello stato',
      'helper_text' => '',
    ),
    'send_reminder' => 
    array (
      'label' => 'Invia Promemoria',
      'icon' => 'heroicon-o-bell',
      'tooltip' => 'Invia un promemoria al paziente',
      'success' => 'Promemoria inviato con successo',
      'error' => 'Errore durante l\'invio del promemoria',
      'helper_text' => '',
    ),
    'bulk_confirm' => 
    array (
      'label' => 'Conferma Selezionati',
      'icon' => 'heroicon-o-check-circle',
      'modal_heading' => 'Conferma Appuntamenti Selezionati',
      'modal_description' => 'Sei sicuro di voler confermare gli appuntamenti selezionati?',
      'tooltip' => 'Conferma tutti gli appuntamenti selezionati',
      'success' => 'Appuntamenti confermati con successo',
      'error' => 'Errore durante la conferma degli appuntamenti',
      'helper_text' => '',
    ),
    'bulk_cancel' => 
    array (
      'label' => 'Annulla Selezionati',
      'icon' => 'heroicon-o-x-circle',
      'modal_heading' => 'Annulla Appuntamenti Selezionati',
      'modal_description' => 'Sei sicuro di voler annullare gli appuntamenti selezionati?',
      'tooltip' => 'Annulla tutti gli appuntamenti selezionati',
      'success' => 'Appuntamenti annullati con successo',
      'error' => 'Errore durante l\'annullamento degli appuntamenti',
      'helper_text' => '',
    ),
    'bulk_delete' => 
    array (
      'label' => 'Elimina Selezionati',
      'icon' => 'heroicon-o-trash',
      'tooltip' => 'Elimina tutti gli appuntamenti selezionati',
      'success' => 'Appuntamenti eliminati con successo',
      'error' => 'Errore durante l\'eliminazione degli appuntamenti',
      'confirmation' => 'Sei sicuro di voler eliminare tutti gli appuntamenti selezionati?',
      'helper_text' => '',
    ),
    'export' => 
    array (
      'label' => 'Esporta',
      'icon' => 'heroicon-o-arrow-down-tray',
      'tooltip' => 'Esporta gli appuntamenti',
      'success' => 'Esportazione completata con successo',
      'error' => 'Errore durante l\'esportazione',
      'helper_text' => '',
    ),
  ),
  'bulk_actions' => 
  array (
    'confirm_selected' => 
    array (
      'label' => 'Conferma Selezionati',
      'icon' => 'heroicon-o-check-circle',
      'success' => 'Appuntamenti confermati con successo',
      'error' => 'Errore durante la conferma',
      'helper_text' => '',
    ),
    'cancel_selected' => 
    array (
      'label' => 'Annulla Selezionati',
      'icon' => 'heroicon-o-x-circle',
      'success' => 'Appuntamenti annullati con successo',
      'error' => 'Errore durante l\'annullamento',
      'helper_text' => '',
    ),
    'delete_selected' => 
    array (
      'label' => 'Elimina Selezionati',
      'icon' => 'heroicon-o-trash',
      'success' => 'Appuntamenti eliminati con successo',
      'error' => 'Errore durante l\'eliminazione',
      'helper_text' => '',
    ),
    'export_selected' => 
    array (
      'label' => 'Esporta Selezionati',
      'icon' => 'heroicon-o-arrow-down-tray',
      'success' => 'Esportazione completata con successo',
      'error' => 'Errore durante l\'esportazione',
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
      'string' => 'Le note devono essere una stringa',
    ),
    'treatment_plan' => 
    array (
      'max' => 'Il piano di trattamento non può superare :max caratteri',
      'string' => 'Il piano di trattamento deve essere una stringa',
    ),
    'reminder_sent_at' => 
    array (
      'date' => 'La data di invio promemoria deve essere una data valida',
      'after' => 'La data di invio promemoria deve essere nel passato',
    ),
  ),
  'search_placeholder' => 'Cerca per titolo, paziente, medico o studio...',
);
