<?php

<<<<<<< HEAD
<<<<<<< HEAD
return array (
  'navigation' => 
  array (
    'name' => 'Attività',
    'plural' => 'Attività',
    'group' => 
    array (
      'name' => 'Monitoraggio',
      'description' => 'Monitoraggio delle attività di sistema',
    ),
    'label' => 'Attività',
    'sort' => 60,
    'icon' => 'activity-activity-animated',
  ),
  'fields' => 
  array (
    'user' => 
    array (
      'label' => 'Utente',
      'name' => 'Nome',
      'email' => 'Email',
      'role' => 'Ruolo',
    ),
    'action' => 
    array (
      'label' => 'Azione',
      'created' => 'Creato',
      'updated' => 'Modificato',
      'deleted' => 'Eliminato',
      'viewed' => 'Visualizzato',
      'downloaded' => 'Scaricato',
      'uploaded' => 'Caricato',
      'logged_in' => 'Accesso',
      'logged_out' => 'Uscita',
    ),
    'subject' => 
    array (
      'label' => 'Oggetto',
      'type' => 'Tipo',
      'id' => 'ID',
      'name' => 'Nome',
    ),
    'description' => 'Descrizione',
    'ip_address' => 'Indirizzo IP',
    'user_agent' => 'User Agent',
    'created_at' => 'Data',
    'properties' => 
    array (
      'label' => 'Proprietà',
      'old' => 'Vecchio Valore',
      'new' => 'Nuovo Valore',
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
  'filters' => 
  array (
    'user' => 'Utente',
    'action' => 'Azione',
    'subject_type' => 'Tipo Oggetto',
    'date_range' => 'Intervallo Date',
    'ip_address' => 'Indirizzo IP',
  ),
  'actions' => 
  array (
    'view_details' => 'Visualizza Dettagli',
    'export' => 'Esporta',
    'clear_old' => 'Pulisci Vecchie',
  ),
  'messages' => 
  array (
    'no_activities' => 'Nessuna attività trovata',
    'cleared' => 'Attività vecchie eliminate con successo',
    'exported' => 'Attività esportate con successo',
  ),
  'export' => 
  array (
    'formats' => 
    array (
      'csv' => 'CSV',
      'excel' => 'Excel',
      'pdf' => 'PDF',
    ),
    'columns' => 
    array (
      'date' => 'Data',
      'user' => 'Utente',
      'action' => 'Azione',
      'subject' => 'Oggetto',
      'ip' => 'IP',
    ),
  ),
);
=======
=======
>>>>>>> c5f8a42 (.)
declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Attività',
        'plural' => 'Attività',
        'group' => [
            'name' => 'Monitoraggio',
            'description' => 'Monitoraggio delle attività di sistema',
        ],
        'label' => 'Attività',
        'sort' => 60,
        'icon' => 'activity-activity-animated',
    ],
    'fields' => [
        'user' => [
            'label' => 'Utente',
            'placeholder' => 'Seleziona un utente',
            'help' => 'L\'utente che ha eseguito l\'azione',
            'name' => [
                'label' => 'Nome',
                'placeholder' => 'Inserisci il nome',
                'help' => 'Nome completo dell\'utente',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Inserisci l\'email',
                'help' => 'Indirizzo email dell\'utente',
            ],
            'role' => [
                'label' => 'Ruolo',
                'placeholder' => 'Seleziona un ruolo',
                'help' => 'Ruolo dell\'utente nel sistema',
            ],
        ],
        'action' => [
            'label' => 'Azione',
            'placeholder' => 'Seleziona un\'azione',
            'help' => 'Tipo di azione eseguita',
            'created' => 'Creato',
            'updated' => 'Modificato',
            'deleted' => 'Eliminato',
            'viewed' => 'Visualizzato',
            'downloaded' => 'Scaricato',
            'uploaded' => 'Caricato',
            'logged_in' => 'Accesso',
            'logged_out' => 'Uscita',
        ],
        'subject' => [
            'label' => 'Oggetto',
            'placeholder' => 'Seleziona un oggetto',
            'help' => 'L\'oggetto interessato dall\'azione',
            'type' => [
                'label' => 'Tipo',
                'placeholder' => 'Tipo di oggetto',
                'help' => 'Classe o tipo dell\'oggetto',
            ],
            'id' => [
                'label' => 'ID',
                'placeholder' => 'ID dell\'oggetto',
                'help' => 'Identificativo unico dell\'oggetto',
            ],
            'name' => [
                'label' => 'Nome',
                'placeholder' => 'Nome dell\'oggetto',
                'help' => 'Nome descrittivo dell\'oggetto',
            ],
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'help' => 'Descrizione dettagliata dell\'attività',
        ],
        'ip_address' => [
            'label' => 'Indirizzo IP',
            'placeholder' => 'Es. 192.168.1.1',
            'help' => 'Indirizzo IP da cui è stata eseguita l\'azione',
        ],
        'user_agent' => [
            'label' => 'User Agent',
            'placeholder' => 'Browser e sistema operativo',
            'help' => 'Informazioni sul browser e sistema dell\'utente',
        ],
        'created_at' => [
            'label' => 'Data',
            'placeholder' => 'Seleziona data e ora',
            'help' => 'Data e ora di creazione dell\'attività',
        ],
        'properties' => [
            'label' => 'Proprietà',
            'placeholder' => 'Proprietà aggiuntive',
            'help' => 'Dati aggiuntivi dell\'attività',
            'old' => [
                'label' => 'Vecchio Valore',
                'placeholder' => 'Valore precedente',
                'help' => 'Valore prima della modifica',
            ],
            'new' => [
                'label' => 'Nuovo Valore',
                'placeholder' => 'Valore attuale',
                'help' => 'Valore dopo la modifica',
            ],
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'placeholder' => '',
            'help' => 'Configura la visibilità delle colonne',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
            'placeholder' => '',
            'help' => 'Riordina i record nella tabella',
        ],
    ],
    'filters' => [
        'user' => [
            'label' => 'Utente',
            'placeholder' => 'Filtra per utente',
            'help' => 'Filtra le attività per utente specifico',
        ],
        'action' => [
            'label' => 'Azione',
            'placeholder' => 'Filtra per azione',
            'help' => 'Filtra le attività per tipo di azione',
        ],
        'subject_type' => [
            'label' => 'Tipo Oggetto',
            'placeholder' => 'Filtra per tipo oggetto',
            'help' => 'Filtra le attività per tipo di oggetto',
        ],
        'date_range' => [
            'label' => 'Intervallo Date',
            'placeholder' => 'Seleziona intervallo',
            'help' => 'Filtra le attività per periodo di tempo',
        ],
        'ip_address' => [
            'label' => 'Indirizzo IP',
            'placeholder' => 'Filtra per IP',
            'help' => 'Filtra le attività per indirizzo IP',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => 'Visualizza Dettagli',
            'success' => 'Dettagli caricati con successo',
            'error' => 'Errore nel caricamento dei dettagli',
            'confirmation' => 'Vuoi visualizzare i dettagli di questa attività?',
        ],
        'export' => [
            'label' => 'Esporta',
            'success' => 'Esportazione completata con successo',
            'error' => 'Errore durante l\'esportazione',
            'confirmation' => 'Vuoi esportare le attività selezionate?',
        ],
        'clear_old' => [
            'label' => 'Pulisci Vecchie',
            'success' => 'Attività vecchie eliminate con successo',
            'error' => 'Errore nella pulizia delle attività',
            'confirmation' => 'Sei sicuro di voler eliminare le attività vecchie? Questa azione non può essere annullata.',
        ],
    ],
    'messages' => [
        'no_activities' => 'Nessuna attività trovata',
        'cleared' => 'Attività vecchie eliminate con successo',
        'exported' => 'Attività esportate con successo',
    ],
    'export' => [
        'formats' => [
            'csv' => 'CSV',
            'excel' => 'Excel',
            'pdf' => 'PDF',
        ],
        'columns' => [
            'date' => 'Data',
            'user' => 'Utente',
            'action' => 'Azione',
            'subject' => 'Oggetto',
            'ip' => 'IP',
        ],
    ],
];
<<<<<<< HEAD
>>>>>>> a0afe1b (.)
=======
>>>>>>> c5f8a42 (.)
