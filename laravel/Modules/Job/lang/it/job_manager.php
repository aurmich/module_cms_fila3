<?php

return array (
  'navigation' => 
  array (
    'name' => 'Gestione Jobs',
    'plural' => 'Gestione Jobs',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione centralizzata di tutti i jobs',
    ),
    'label' => 'Job Manager',
    'sort' => 1,
    'icon' => 'job-manager-animated',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Identificativo unico del Job Manager',
      'placeholder' => 'ID del Manager',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome del Job Manager',
      'placeholder' => 'Inserisci nome',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'tooltip' => 'Breve descrizione del job manager',
      'placeholder' => 'Descrizione del Job Manager',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'tooltip' => 'Stato corrente del Job Manager',
      'placeholder' => 'Seleziona stato',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'tooltip' => 'Tipo di Job Manager',
      'placeholder' => 'Seleziona tipo',
    ),
    'priority' => 
    array (
      'label' => 'Priorità',
      'tooltip' => 'Priorità di esecuzione del job manager',
      'placeholder' => 'Seleziona priorità',
    ),
    'max_attempts' => 
    array (
      'label' => 'Tentativi Massimi',
      'tooltip' => 'Numero massimo di tentativi per eseguire il job manager',
      'placeholder' => 'Tentativi massimi',
    ),
    'timeout' => 
    array (
      'label' => 'Timeout',
      'tooltip' => 'Tempo massimo per l\'esecuzione del job manager',
      'placeholder' => 'Timeout',
    ),
    'created_at' => 
    array (
      'label' => 'Creato il',
      'tooltip' => 'Data di creazione del Job Manager',
      'placeholder' => 'Data di creazione',
    ),
    'updated_at' => 
    array (
      'label' => 'Aggiornato il',
      'tooltip' => 'Data dell\'ultimo aggiornamento',
      'placeholder' => 'Data aggiornamento',
    ),
    'last_run' => 
    array (
      'label' => 'Ultima Esecuzione',
      'tooltip' => 'Data e ora dell\'ultima esecuzione',
      'placeholder' => 'Ultima esecuzione',
    ),
    'next_run' => 
    array (
      'label' => 'Prossima Esecuzione',
      'tooltip' => 'Data e ora della prossima esecuzione',
      'placeholder' => 'Prossima esecuzione',
    ),
    'cron_expression' => 
    array (
      'label' => 'Espressione Cron',
      'tooltip' => 'Espressione cron per la pianificazione del job',
      'placeholder' => 'Inserisci espressione cron',
    ),
    'output' => 
    array (
      'label' => 'Output',
      'tooltip' => 'Output dell\'esecuzione del job',
      'placeholder' => 'Output',
    ),
    'error' => 
    array (
      'label' => 'Errore',
      'tooltip' => 'Messaggio di errore se il job fallisce',
      'placeholder' => 'Errore',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'tooltip' => 'Guard a cui è associato il Job Manager',
      'placeholder' => 'Seleziona Guard',
    ),
    'permissions' => 
    array (
      'label' => 'Permessi',
      'tooltip' => 'Permessi associati al Job Manager',
      'placeholder' => 'Seleziona permessi',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome dell\'utente associato',
      'placeholder' => 'Inserisci nome',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'tooltip' => 'Cognome dell\'utente associato',
      'placeholder' => 'Inserisci cognome',
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
    'import' => 
    array (
      'label' => 'Importa',
      'modal' => 
      array (
        'heading' => 'Importa Job Manager',
        'description' => 'Seleziona un file XLS o CSV da caricare per importare il Job Manager',
      ),
      'messages' => 
      array (
        'success' => 'Importazione del Job Manager avviata con successo',
      ),
      'icon' => 'upload',
      'color' => 'primary',
    ),
    'export' => 
    array (
      'label' => 'Esporta',
      'modal' => 
      array (
        'heading' => 'Esporta Job Manager',
        'description' => 'Esporta i dati del Job Manager in un file',
      ),
      'messages' => 
      array (
        'success' => 'Job Manager esportato con successo',
      ),
      'icon' => 'download',
      'color' => 'success',
    ),
    'run' => 
    array (
      'label' => 'Esegui',
      'modal' => 
      array (
        'heading' => 'Esegui Job Manager',
        'description' => 'Vuoi eseguire questo Job Manager?',
      ),
      'messages' => 
      array (
        'success' => 'Job Manager avviato con successo',
      ),
      'icon' => 'play',
      'color' => 'primary',
    ),
    'pause' => 
    array (
      'label' => 'Pausa',
      'modal' => 
      array (
        'heading' => 'Metti in Pausa',
        'description' => 'Vuoi mettere in pausa questo Job Manager?',
      ),
      'messages' => 
      array (
        'success' => 'Job Manager messo in pausa con successo',
      ),
      'icon' => 'pause',
      'color' => 'warning',
    ),
    'resume' => 
    array (
      'label' => 'Riprendi',
      'modal' => 
      array (
        'heading' => 'Riprendi Esecuzione',
        'description' => 'Vuoi riprendere l\'esecuzione di questo Job Manager?',
      ),
      'messages' => 
      array (
        'success' => 'Job Manager ripreso con successo',
      ),
      'icon' => 'redo',
      'color' => 'success',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'modal' => 
      array (
        'heading' => 'Elimina Job Manager',
        'description' => 'Sei sicuro di voler eliminare questo Job Manager?',
      ),
      'messages' => 
      array (
        'success' => 'Job Manager eliminato con successo',
      ),
      'icon' => 'trash',
      'color' => 'danger',
    ),
  ),
  'messages' => 
  array (
    'no_jobs' => 'Nessun Job Manager presente',
    'manager_started' => 'Job Manager avviato',
    'manager_paused' => 'Job Manager in pausa',
    'manager_resumed' => 'Job Manager ripreso',
    'manager_completed' => 'Job Manager completato',
    'manager_failed' => 'Job Manager fallito',
  ),
  'statuses' => 
  array (
    'active' => 'Attivo',
    'paused' => 'In Pausa',
    'completed' => 'Completato',
    'failed' => 'Fallito',
  ),
  'types' => 
  array (
    'scheduler' => 'Schedulatore',
    'queue' => 'Coda',
    'worker' => 'Worker',
    'monitor' => 'Monitor',
  ),
  'priorities' => 
  array (
    'low' => 'Bassa',
    'normal' => 'Normale',
    'high' => 'Alta',
    'urgent' => 'Urgente',
  ),
);
