<?php

return array (
  'navigation' => 
  array (
    'name' => 'Menu',
    'plural' => 'Menu',
    'group' => 
    array (
      'name' => 'Gestione Menu',
      'description' => 'Gestione dei menu del sito',
    ),
    'label' => 'Menu',
    'sort' => 57,
    'icon' => 'heroicon-o-bars-3',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'ID del menu',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Nome del menu',
    ),
    'slug' => 
    array (
      'label' => 'Slug',
      'placeholder' => 'Slug del menu',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'placeholder' => 'Descrizione del menu',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'placeholder' => 'Tipo di menu',
      'options' => 
      array (
        'main' => 'Principale',
        'footer' => 'Footer',
        'sidebar' => 'Barra laterale',
      ),
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Stato del menu',
      'options' => 
      array (
        'active' => 'Attivo',
        'inactive' => 'Inattivo',
        'draft' => 'Bozza',
      ),
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
    'message' => 
    array (
      'label' => 'message',
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
    'delete' => 
    array (
      'label' => 'delete',
    ),
    'title' => 
    array (
      'label' => 'title',
    ),
  ),
  'actions' => 
  array (
    'create' => 'Crea Menu',
    'edit' => 'Modifica Menu',
    'delete' => 'Elimina Menu',
    'sort' => 'Ordina Voci',
    'add_item' => 'Aggiungi Voce',
  ),
  'messages' => 
  array (
    'created' => 'Menu creato con successo',
    'updated' => 'Menu aggiornato con successo',
    'deleted' => 'Menu eliminato con successo',
    'sorted' => 'Voci del menu ordinate con successo',
    'item_added' => 'Voce aggiunta con successo',
  ),
  'validation' => 
  array (
    'name_required' => 'Il nome è obbligatorio',
    'slug_unique' => 'Lo slug deve essere unico',
    'type_in' => 'Il tipo deve essere uno tra: main, footer, sidebar',
  ),
  'model' => 
  array (
    'label' => 'menu.model',
  ),
);
