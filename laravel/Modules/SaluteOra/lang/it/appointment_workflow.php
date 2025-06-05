<?php

return array (
  'navigation' =>
  array (
    'label' => 'Flusso Appuntamenti',
    'group' => 'Agenda',
    'icon' => 'heroicon-o-document-chart-bar',
    'sort' => 60,
    'tooltip' => 'Gestione dei flussi di prenotazione e appuntamenti',
  ),
  'model' =>
  array (
    'label' => 'Flusso Appuntamento',
    'plural_label' => 'Flussi Appuntamenti',
  ),
  'actions' =>
  array (
    'create' =>
    array (
      'label' => 'Crea Nuovo',
      'tooltip' => 'Crea un nuovo flusso di appuntamento',
      'icon' => 'heroicon-o-plus',
    ),
    'edit' =>
    array (
      'label' => 'Modifica',
      'tooltip' => 'Modifica questo flusso di appuntamento',
      'icon' => 'heroicon-o-pencil',
    ),
    'delete' =>
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina questo flusso di appuntamento',
      'icon' => 'heroicon-o-trash',
    ),
    'view' =>
    array (
      'label' => 'Visualizza',
      'tooltip' => 'Visualizza i dettagli del flusso',
      'icon' => 'heroicon-o-eye',
    ),
  ),
  'fields' =>
  array (
    'id' =>
    array (
      'label' => 'ID',
      'tooltip' => 'Identificativo univoco del flusso',
    ),
    'patient' =>
    array (
      'label' => 'Paziente',
      'tooltip' => 'Paziente associato al flusso',
      'placeholder' => 'Seleziona paziente',
      'helper_text' => 'Il paziente che ha richiesto l\'appuntamento',
      'last_name' => [
        'label' => 'Cognome',
        'placeholder' => 'Inserisci il cognome',
        'help' => 'Inserisci il cognome completo',
      ],
    ),
    'current_step' =>
    array (
      'label' => 'Fase Attuale',
      'tooltip' => 'Fase attuale del flusso di appuntamento',
      'placeholder' => 'Seleziona fase',
      'helper_text' => 'Indica a che punto del processo si trova l\'appuntamento',
    ),
    'status' =>
    array (
      'label' => 'Stato',
      'tooltip' => 'Stato corrente del flusso',
      'placeholder' => 'Seleziona stato',
      'helper_text' => 'Indica se il flusso è attivo, completato o annullato',
      'options' =>
      array (
        'pending' => 'In attesa',
        'active' => 'Attivo',
        'completed' => 'Completato',
        'cancelled' => 'Annullato',
      ),
    ),
    'appointment' =>
    array (
      'label' => 'Appuntamento',
      'tooltip' => 'Appuntamento collegato al flusso',
      'placeholder' => 'Seleziona appuntamento',
      'helper_text' => 'L\'appuntamento associato a questo flusso',
      'title' =>
      array (
        'label' => 'Titolo Appuntamento',
        'tooltip' => 'Titolo dell\'appuntamento collegato',
        'placeholder' => 'Inserisci titolo',
        'helper_text' => 'Breve descrizione dell\'appuntamento',
      ),
    ),
    'started_at' =>
    array (
      'label' => 'Data Inizio',
      'tooltip' => 'Data di inizio del flusso',
      'placeholder' => 'Seleziona data inizio',
      'helper_text' => 'Quando è stato avviato il flusso di prenotazione',
    ),
    'completed_at' =>
    array (
      'label' => 'Data Completamento',
      'tooltip' => 'Data di completamento del flusso',
      'placeholder' => 'Seleziona data completamento',
      'helper_text' => 'Quando è stato completato il flusso di prenotazione',
    ),
    'session_id' =>
    array (
      'label' => 'ID Sessione',
      'tooltip' => 'Identificativo della sessione utente',
      'placeholder' => 'ID Sessione',
      'helper_text' => 'Identificativo tecnico della sessione di navigazione',
    ),
    'created_at' =>
    array (
      'label' => 'Data Creazione',
      'tooltip' => 'Data di creazione del record',
      'placeholder' => 'Data creazione',
      'helper_text' => 'Data e ora di creazione nel sistema',
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
  ),
  'filters' =>
  array (
    'title' => 'Filtri',
    'open' => 'Apri Filtri',
    'apply' => 'Applica Filtri',
    'reset' => 'Reimposta Filtri',
    'close' => 'Chiudi Filtri',
  ),
  'table' =>
  array (
    'reorder' => 'Riordina Record',
    'toggle_columns' => 'Mostra/Nascondi Colonne',
    'empty' => 'Nessun flusso di appuntamento trovato',
    'loading' => 'Caricamento flussi di appuntamento...',
  ),
  'messages' =>
  array (
    'success' =>
    array (
      'created' => 'Flusso di appuntamento creato con successo',
      'updated' => 'Flusso di appuntamento aggiornato con successo',
      'deleted' => 'Flusso di appuntamento eliminato con successo',
    ),
    'error' =>
    array (
      'create' => 'Errore durante la creazione del flusso di appuntamento',
      'update' => 'Errore durante l\'aggiornamento del flusso di appuntamento',
      'delete' => 'Errore durante l\'eliminazione del flusso di appuntamento',
    ),
    'confirm' =>
    array (
      'delete' => 'Sei sicuro di voler eliminare questo flusso di appuntamento?',
    ),
  ),
);
