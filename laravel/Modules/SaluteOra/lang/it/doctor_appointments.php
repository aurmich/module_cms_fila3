<?php

declare(strict_types=1);

return [
  'title' => 'Appuntamenti Dottore',
  'description' => 'Gestione appuntamenti per i dottori',
  'actions' => 
  [
    'delete' => 
    [
      'label' => 'Elimina',
      'tooltip' => 'Elimina questo appuntamento',
      'confirmation' => 'Sei sicuro di voler eliminare questo appuntamento?',
      'success' => 'Appuntamento eliminato con successo',
      'error' => 'Errore durante l\'eliminazione dell\'appuntamento',
    ],
    'accept' => 
    [
      'label' => 'Accetta',
      'tooltip' => 'Accetta questo appuntamento',
      'confirmation' => 'Sei sicuro di voler accettare questo appuntamento?',
      'success' => 'Appuntamento accettato con successo',
      'error' => 'Errore durante l\'accettazione dell\'appuntamento',
    ],
    'confirm' => 
    [
      'label' => 'Conferma',
      'tooltip' => 'Conferma questo appuntamento',
      'confirmation' => 'Sei sicuro di voler confermare questo appuntamento?',
      'success' => 'Appuntamento confermato con successo',
      'error' => 'Errore durante la conferma dell\'appuntamento',
    ],
    'reject' => 
    [
      'label' => 'Rifiuta',
      'tooltip' => 'Rifiuta questo appuntamento',
      'confirmation' => 'Sei sicuro di voler rifiutare questo appuntamento?',
      'success' => 'Appuntamento rifiutato con successo',
      'error' => 'Errore durante il rifiuto dell\'appuntamento',
    ],
    'reschedule' => 
    [
      'label' => 'Riprogramma',
      'tooltip' => 'Riprogramma questo appuntamento',
      'confirmation' => 'Sei sicuro di voler riprogrammare questo appuntamento?',
      'success' => 'Appuntamento riprogrammato con successo',
      'error' => 'Errore durante la riprogrammazione dell\'appuntamento',
    ],
    'complete' => 
    [
      'label' => 'Completa',
      'tooltip' => 'Completa questo appuntamento',
      'confirmation' => 'Sei sicuro di voler completare questo appuntamento?',
      'success' => 'Appuntamento completato con successo',
      'error' => 'Errore durante il completamento dell\'appuntamento',
    ],
    'cancel' => 
    [
      'label' => 'Annulla',
      'tooltip' => 'Annulla questo appuntamento',
      'confirmation' => 'Sei sicuro di voler annullare questo appuntamento?',
      'success' => 'Appuntamento annullato con successo',
      'error' => 'Errore durante l\'annullamento dell\'appuntamento',
    ],
    'view_details' => 
    [
      'label' => 'Visualizza Dettagli',
      'tooltip' => 'Visualizza i dettagli completi dell\'appuntamento',
    ],
    'edit' => 
    [
      'label' => 'Modifica',
      'tooltip' => 'Modifica questo appuntamento',
      'success' => 'Appuntamento modificato con successo',
      'error' => 'Errore durante la modifica dell\'appuntamento',
    ],
    'generate_report' => 
    [
      'label' => 'Genera Referto',
      'tooltip' => 'Genera un referto per questo appuntamento',
      'modal_heading' => 'Generazione Referto',
      'modal_description' => 'Sei sicuro di voler generare un referto per questo appuntamento?',
      'modal_icon' => 'heroicon-o-document-text',
      'icon' => 'heroicon-o-document-text',
      'success' => 'Referto generato con successo',
      'error' => 'Errore durante la generazione del referto',
    ],
    'send_reminder' => 
    [
      'label' => 'Invia Promemoria',
      'tooltip' => 'Invia un promemoria al paziente',
      'confirmation' => 'Sei sicuro di voler inviare un promemoria al paziente?',
      'success' => 'Promemoria inviato con successo',
      'error' => 'Errore durante l\'invio del promemoria',
    ],
    'add_note' => 
    [
      'label' => 'Aggiungi Nota',
      'tooltip' => 'Aggiungi una nota all\'appuntamento',
      'modal_heading' => 'Aggiungi Nota',
      'modal_description' => 'Inserisci una nota per questo appuntamento',
      'success' => 'Nota aggiunta con successo',
      'error' => 'Errore durante l\'aggiunta della nota',
    ],
    'proBonoAction' => 
    [
      'label' => 'proBonoAction',
    ],
    'refundPendingAction' => 
    [
      'label' => 'refundPendingAction',
    ],
    'info' => 
    [
      'label' => 'info',
    ],
    'rejectedAction' => 
    [
      'label' => 'rejectedAction',
    ],
    'confirmedAction' => 
    [
      'label' => 'confirmedAction',
    ],
    'reportPendingAction' => 
    [
      'label' => 'reportPendingAction',
    ],
    'noShowAction' => 
    [
      'label' => 'noShowAction',
    ],
    'cancelledAction' => 
    [
      'label' => 'cancelledAction',
    ],
    'reportCompletedAction' => 
    [
      'label' => 'reportCompletedAction',
    ],
    'completedAction' => 
    [
      'label' => 'completedAction',
    ],
    'refundToIntegrateAction' => 
    [
      'label' => 'refundToIntegrateAction',
    ],
    'refundAcceptedAction' => 
    [
      'label' => 'refundAcceptedAction',
    ],
    'refundCompletedAction' => 
    [
      'label' => 'refundCompletedAction',
    ],
  ],
  'messages' => 
  [
    'appointment_accepted' => 'Appuntamento accettato con successo',
    'appointment_confirmed' => 'Appuntamento confermato con successo',
    'appointment_rejected' => 'Appuntamento rifiutato con successo',
    'appointment_deleted' => 'Appuntamento eliminato con successo',
    'appointment_rescheduled' => 'Appuntamento riprogrammato con successo',
    'appointment_completed' => 'Appuntamento completato con successo',
    'appointment_cancelled' => 'Appuntamento annullato con successo',
    'appointment_updated' => 'Appuntamento aggiornato con successo',
    'error_occurred' => 'Si è verificato un errore',
    'no_appointments_found' => 'Nessun appuntamento trovato',
    'appointment_not_found' => 'Appuntamento non trovato',
  ],
  'status' => 
  [
    'pending' => 'In Attesa',
    'confirmed' => 'Confermato',
    'rejected' => 'Rifiutato',
    'completed' => 'Completato',
    'cancelled' => 'Annullato',
    'rescheduled' => 'Riprogrammato',
    'in_progress' => 'In Corso',
  ],
  'states' => 
  [
    'pending' => 
    [
      'label' => 'In Attesa',
      'color' => 'warning',
      'bg_color' => '#FEF3C7',
      'icon' => 'heroicon-o-clock',
      'description' => 'Appuntamento in attesa di conferma',
    ],
    'confirmed' => 
    [
      'label' => 'Confermato',
      'color' => 'success',
      'bg_color' => '#D1FAE5',
      'icon' => 'heroicon-o-check-circle',
      'description' => 'Appuntamento confermato dal dottore',
    ],
    'rejected' => 
    [
      'label' => 'Rifiutato',
      'color' => 'danger',
      'bg_color' => '#FEE2E2',
      'icon' => 'heroicon-o-x-circle',
      'description' => 'Appuntamento rifiutato dal dottore',
    ],
    'completed' => 
    [
      'label' => 'Completato',
      'color' => 'success',
      'bg_color' => '#ECFDF5',
      'icon' => 'heroicon-o-check-badge',
      'description' => 'Appuntamento completato con successo',
    ],
    'cancelled' => 
    [
      'label' => 'Annullato',
      'color' => 'gray',
      'bg_color' => '#F3F4F6',
      'icon' => 'heroicon-o-no-symbol',
      'description' => 'Appuntamento annullato',
    ],
    'rescheduled' => 
    [
      'label' => 'Riprogrammato',
      'color' => 'info',
      'bg_color' => '#DBEAFE',
      'icon' => 'heroicon-o-arrow-path',
      'description' => 'Appuntamento riprogrammato per nuova data',
    ],
    'in_progress' => 
    [
      'label' => 'In Corso',
      'color' => 'primary',
      'bg_color' => '#E0E7FF',
      'icon' => 'heroicon-o-play-circle',
      'description' => 'Appuntamento attualmente in corso',
    ],
  ],
  'fields' => 
  [
    'message' => 
    [
      'label' => 'Messaggio',
      'placeholder' => 'Inserisci un messaggio per il paziente',
      'helper_text' => 'Il messaggio verrà inviato al paziente',
      'description' => 'Messaggio personalizzato per il paziente',
    ],
    'note' => 
    [
      'label' => 'Nota',
      'placeholder' => 'Inserisci una nota privata',
      'helper_text' => 'Questa nota sarà visibile solo ai dottori',
      'description' => 'Nota privata per i dottori',
    ],
    'reason' => 
    [
      'label' => 'Motivo',
      'placeholder' => 'Inserisci il motivo del rifiuto/annullamento',
      'helper_text' => 'Il motivo verrà comunicato al paziente',
      'description' => 'Motivo del rifiuto o annullamento',
    ],
    'new_date' => 
    [
      'label' => 'Nuova Data',
      'placeholder' => 'Seleziona la nuova data',
      'helper_text' => 'Seleziona la nuova data per l\'appuntamento',
      'description' => 'Nuova data per l\'appuntamento riprogrammato',
    ],
    'new_time' => 
    [
      'label' => 'Nuovo Orario',
      'placeholder' => 'Seleziona il nuovo orario',
      'helper_text' => 'Seleziona il nuovo orario per l\'appuntamento',
      'description' => 'Nuovo orario per l\'appuntamento riprogrammato',
    ],
    'invoice' => 
    [
      'label' => 'Fattura',
      'placeholder' => 'Carica la fattura',
      'helper_text' => '',
      'description' => 'Documento fiscale per la prestazione sanitaria',
    ],
  ],
  'filters' => 
  [
    'status' => 
    [
      'label' => 'Stato',
      'placeholder' => 'Filtra per stato',
    ],
    'date_range' => 
    [
      'label' => 'Intervallo Date',
      'placeholder' => 'Seleziona intervallo date',
    ],
    'patient' => 
    [
      'label' => 'Paziente',
      'placeholder' => 'Filtra per paziente',
    ],
  ],
];
