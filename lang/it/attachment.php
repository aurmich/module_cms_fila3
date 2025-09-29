<?php

return array (
  'navigation' => 
  array (
    'label' => 'Allegati',
    'group' => 'Contenuti',
    'icon' => 'heroicon-o-paper-clip',
    'sort' => 89,
  ),
  'fields' => 
  array (
    'attachment' => 
    array (
      'label' => 'File',
      'placeholder' => 'Seleziona un file',
      'helper_text' => 'Carica un nuovo file o selezionalo dalla libreria',
      'description' => 'I file supportati sono: PDF, documenti Word, Excel, immagini e archivi ZIP',
    ),
    'title' => 
    array (
      'label' => 'Titolo',
      'placeholder' => 'Inserisci il titolo',
      'helper_text' => 'Inserisci un titolo descrittivo per questo allegato',
      'description' => 'Il titolo verrà mostrato nell\'elenco degli allegati',
    ),
    'slug' => 
    array (
      'label' => 'Slug',
      'placeholder' => 'slug-del-file',
      'helper_text' => 'Identificativo univoco per il file',
      'description' => 'Lo slug verrà generato automaticamente dal titolo',
    ),
    'created_at' => 
    array (
      'label' => 'Data di creazione',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima modifica',
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
    'layout' => 
    array (
      'label' => 'layout',
    ),
    'create' => 
    array (
      'label' => 'create',
    ),
    'description' => 
    array (
      'description' => 'description',
      'label' => 'description',
      'placeholder' => 'description',
      'helper_text' => 'description',
    ),
    'disk' => 
    array (
      'description' => 'disk',
      'label' => 'disk',
      'placeholder' => 'disk',
      'helper_text' => 'disk',
    ),
  ),
  'actions' => 
  array (
    'create' => 'Nuovo allegato',
    'edit' => 'Modifica allegato',
    'delete' => 'Elimina allegato',
    'view' => 'Visualizza allegato',
    'download' => 'Scarica file',
    'activeLocale' => 
    array (
      'label' => 'activeLocale',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Allegato creato con successo',
    'updated' => 'Allegato aggiornato con successo',
    'deleted' => 'Allegato eliminato con successo',
    'delete_confirm' => 'Sei sicuro di voler eliminare questo allegato?',
    'file_too_large' => 'Il file è troppo grande. Dimensione massima consentita: :size MB',
    'file_type_not_allowed' => 'Tipo di file non consentito',
  ),
  'filters' => 
  array (
    'search' => 'Cerca allegati...',
    'all' => 'Tutti gli allegati',
    'type' => 
    array (
      'label' => 'Tipo di file',
      'options' => 
      array (
        'all' => 'Tutti i tipi',
        'image' => 'Immagini',
        'document' => 'Documenti',
        'spreadsheet' => 'Fogli di calcolo',
        'archive' => 'Archivi',
        'other' => 'Altro',
      ),
    ),
    'date' => 
    array (
      'label' => 'Data',
      'options' => 
      array (
        'today' => 'Oggi',
        'week' => 'Questa settimana',
        'month' => 'Questo mese',
        'year' => 'Quest\'anno',
        'all' => 'Tutte le date',
      ),
    ),
  ),
  'table' => 
  array (
    'columns' => 
    array (
      'title' => 'Titolo',
      'type' => 'Tipo',
      'size' => 'Dimensione',
      'created_at' => 'Caricato il',
      'actions' => 'Azioni',
    ),
    'empty' => 'Nessun allegato trovato',
    'search' => 'Cerca allegati...',
    'actions' => 
    array (
      'edit' => 'Modifica',
      'delete' => 'Elimina',
      'download' => 'Scarica',
      'view' => 'Visualizza',
    ),
  ),
  'sections' => 
  array (
    'details' => 
    array (
      'label' => 'Dettagli allegato',
      'description' => 'Gestisci le informazioni di base dell\'allegato',
    ),
    'file' => 
    array (
      'label' => 'File',
      'description' => 'Carica o seleziona un file',
    ),
    'empty' => 
    array (
      'heading' => 'empty',
      'label' => 'empty',
    ),
  ),
  'empty' => 
  array (
    'label' => 'Nessun contenuto',
    'heading' => 'Nessun allegato presente',
  ),
  'model' => 
  array (
    'label' => 'attachment.model',
  ),
);
