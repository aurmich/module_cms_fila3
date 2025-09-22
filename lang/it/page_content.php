<?php

<<<<<<< HEAD
declare(strict_types=1);


return [
    'navigation' => [
        'name' => 'Contenuti Pagina',
        'plural' => 'Contenuti Pagina',
        'group' => [
            'name' => 'Gestione Contenuti',
            'description' => 'Gestione dei contenuti delle pagine del sito',
        ],
        'label' => 'Contenuti Pagina',
        'sort' => 87,
        'icon' => 'heroicon-o-document-text',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'ID del contenuto pagina',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Nome del contenuto',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'Slug del contenuto pagina',
            'description' => 'slug',
            'helper_text' => 'slug',
        ],
        'blocks' => [
            'label' => 'Blocchi',
            'placeholder' => 'Blocchi di contenuto',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
        'created_by' => [
            'label' => 'Creato da',
            'placeholder' => 'Creato da',
        ],
        'updated_by' => [
            'label' => 'Aggiornato da',
            'placeholder' => 'Aggiornato da',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'view' => [
            'label' => 'view',
        ],
    ],
    'actions' => [
        'view' => 'Visualizza Contenuto',
        'create' => [
            'label' => 'create',
        ],
        'edit' => 'Modifica Contenuto',
        'delete' => 'Elimina Contenuto',
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
    ],
    'messages' => [
        'created' => 'Contenuto creato con successo',
        'updated' => 'Contenuto aggiornato con successo',
        'deleted' => 'Contenuto eliminato con successo',
    ],
    'validation' => [
        'name_required' => 'Il nome è obbligatorio',
        'slug_unique' => 'Lo slug deve essere unico',
        'blocks_required' => 'I blocchi di contenuto sono obbligatori',
    ],
    'model' => [
        'label' => 'page content.model',
    ],
];
=======
return array (
  'navigation' => 
  array (
    'name' => 'Contenuti Pagina',
    'plural' => 'Contenuti Pagina',
    'group' => 
    array (
      'name' => 'Gestione Contenuti',
      'description' => 'Gestione dei contenuti delle pagine del sito',
    ),
    'label' => 'Contenuti Pagina',
    'sort' => 87,
    'icon' => 'heroicon-o-document-text',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'ID del contenuto pagina',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Nome del contenuto',
    ),
    'slug' => 
    array (
      'label' => 'Slug',
      'placeholder' => 'Slug del contenuto pagina',
      'description' => 'slug',
      'helper_text' => 'slug',
    ),
    'blocks' => 
    array (
      'label' => 'Blocchi',
      'placeholder' => 'Blocchi di contenuto',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
    ),
    'created_by' => 
    array (
      'label' => 'Creato da',
      'placeholder' => 'Creato da',
    ),
    'updated_by' => 
    array (
      'label' => 'Aggiornato da',
      'placeholder' => 'Aggiornato da',
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
  ),
  'actions' => 
  array (
    'view' => 'Visualizza Contenuto',
    'create' => 
    array (
      'label' => 'create',
    ),
    'edit' => 'Modifica Contenuto',
    'delete' => 'Elimina Contenuto',
    'activeLocale' => 
    array (
      'label' => 'activeLocale',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Contenuto creato con successo',
    'updated' => 'Contenuto aggiornato con successo',
    'deleted' => 'Contenuto eliminato con successo',
  ),
  'validation' => 
  array (
    'name_required' => 'Il nome è obbligatorio',
    'slug_unique' => 'Lo slug deve essere unico',
    'blocks_required' => 'I blocchi di contenuto sono obbligatori',
  ),
  'model' => 
  array (
    'label' => 'page content.model',
  ),
);
>>>>>>> bc33217 (.)
