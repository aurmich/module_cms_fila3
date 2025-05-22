<?php

return array (
  'pages' => 'Pagine',
  'widgets' => 'Widgets',
  'navigation' => 
  array (
    'name' => 'Jobs Import Falliti',
    'plural' => 'Jobs Import Falliti',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione e recupero dei jobs falliti',
    ),
    'label' => 'Jobs Import Falliti',
    'sort' => 93,
    'icon' => 'job-failed-job',
  ),
  'model' => 
  array (
    'label' => 'Job Fallito',
    'plural' => 
    array (
      'label' => 'Jobs Falliti',
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
    ),
    'uuid' => 
    array (
      'label' => 'UUID',
    ),
    'connection' => 
    array (
      'label' => 'Connessione',
    ),
    'queue' => 
    array (
      'label' => 'Coda',
    ),
    'payload' => 
    array (
      'label' => 'Payload',
    ),
    'exception' => 
    array (
      'label' => 'Eccezione',
    ),
    'failed_at' => 
    array (
      'label' => 'Fallito il',
    ),
    'attempts' => 
    array (
      'label' => 'Tentativi',
    ),
    'max_attempts' => 
    array (
      'label' => 'Tentativi Massimi',
    ),
    'status' => 
    array (
      'label' => 'Stato',
    ),
    'created_at' => 
    array (
      'label' => 'Creato il',
    ),
    'updated_at' => 
    array (
      'label' => 'Aggiornato il',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
    ),
  ),
  'actions' => 
  array (
    'retry' => 
    array (
      'label' => 'Riprova',
      'modal' => 
      array (
        'heading' => 'Riprova Job',
        'description' => 'Vuoi riprovare ad eseguire questo job?',
      ),
      'messages' => 
      array (
        'success' => 'Job riavviato con successo',
        'error' => 'Errore durante il riavvio del job',
      ),
    ),
    'retry_all' => 
    array (
      'label' => 'Riprova Tutti',
      'modal' => 
      array (
        'heading' => 'Riprova Tutti i Jobs',
        'description' => 'Vuoi riprovare tutti i jobs falliti?',
      ),
      'messages' => 
      array (
        'success' => 'Jobs riavviati con successo',
        'error' => 'Errore durante il riavvio dei jobs',
      ),
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'modal' => 
      array (
        'heading' => 'Elimina Job',
        'description' => 'Sei sicuro di voler eliminare questo job fallito?',
      ),
      'messages' => 
      array (
        'success' => 'Job eliminato con successo',
        'error' => 'Errore durante l\'eliminazione del job',
      ),
    ),
    'delete_all' => 
    array (
      'label' => 'Elimina Tutti',
      'modal' => 
      array (
        'heading' => 'Elimina Tutti i Jobs',
        'description' => 'Sei sicuro di voler eliminare tutti i jobs falliti?',
      ),
      'messages' => 
      array (
        'success' => 'Jobs eliminati con successo',
        'error' => 'Errore durante l\'eliminazione dei jobs',
      ),
    ),
    'clear' => 
    array (
      'label' => 'Pulisci Tutto',
      'modal' => 
      array (
        'heading' => 'Pulisci Jobs Falliti',
        'description' => 'Sei sicuro di voler eliminare tutti i jobs falliti?',
      ),
      'messages' => 
      array (
        'success' => 'Jobs puliti con successo',
        'error' => 'Errore durante la pulizia dei jobs',
      ),
    ),
  ),
  'messages' => 
  array (
    'no_jobs' => 'Nessun job fallito trovato',
    'import_success' => 'Importazione completata con successo',
    'import_error' => 'Errore durante l\'importazione',
    'row_error' => 'Errore nella riga :row: :error',
  ),
  'status' => 
  array (
    'pending' => 'In attesa',
    'processing' => 'In elaborazione',
    'failed' => 'Fallito',
    'completed' => 'Completato',
  ),
  'error_types' => 
  array (
    'max_attempts' => 'Tentativi Massimi Superati',
    'timeout' => 'Timeout',
    'memory_limit' => 'Limite Memoria Superato',
    'connection' => 'Errore di Connessione',
    'queue' => 'Errore di Coda',
    'payload' => 'Errore nel Payload',
    'system' => 'Errore di Sistema',
  ),
  'plural' => 
  array (
    'model' => 
    array (
      'label' => 'failed job.plural.model',
    ),
    'label' => 'Jobs Falliti',
    'sort' => 93,
    'icon' => 'job-failed-job',
  ),
);
