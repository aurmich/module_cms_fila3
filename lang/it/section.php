<?php

<<<<<<< HEAD
declare(strict_types=1);


return [
    'navigation' => [
        'label' => 'Sezioni',
        'group' => 'Gestione Contenuti',
        'icon' => 'heroicon-o-rectangle-stack',
        'sort' => 85,
    ],
    'fields' => [
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
        ],
        'resetFilters' => [
            'label' => 'Reimposta Filtri',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome della sezione',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'Inserisci lo slug della sezione',
        ],
        'blocks' => [
            'label' => 'Blocchi',
            'placeholder' => 'Aggiungi blocchi alla sezione',
        ],
        'created_at' => [
            'label' => 'Data di Creazione',
        ],
        'updated_at' => [
            'label' => 'Data di Aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
        ],
        'edit' => [
            'label' => 'Modifica',
        ],
        'view' => [
            'label' => 'Visualizza',
        ],
        'message' => [
            'label' => 'Messaggio',
        ],
        'create' => [
            'label' => 'Crea',
        ],
        'caption' => [
            'label' => 'Didascalia',
        ],
        'items' => [
            'label' => 'Elementi',
        ],
        'label' => [
            'label' => 'Etichetta',
        ],
        'url' => [
            'label' => 'URL',
        ],
        'style' => [
            'label' => 'Stile',
        ],
        'icon' => [
            'label' => 'Icona',
        ],
        'size' => [
            'label' => 'Dimensione',
        ],
        'alignment' => [
            'label' => 'Allineamento',
        ],
        'gap' => [
            'label' => 'Spaziatura',
        ],
        'title' => [
            'label' => 'Titolo',
        ],
        'description' => [
            'label' => 'Descrizione',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'phone' => [
            'label' => 'Telefono',
        ],
        'address' => [
            'label' => 'Indirizzo',
        ],
        'map_url' => [
            'label' => 'URL Mappa',
        ],
        'button_text' => [
            'label' => 'Testo Bottone',
        ],
        'button_link' => [
            'label' => 'Link Bottone',
        ],
        'sections' => [
            'label' => 'Sezioni',
        ],
        'subtitle' => [
            'label' => 'Sottotitolo',
        ],
        'image' => [
            'label' => 'Immagine',
        ],
        'cta_text' => [
            'label' => 'Testo CTA',
        ],
        'cta_link' => [
            'label' => 'Link CTA',
        ],
        'background_color' => [
            'label' => 'Colore Sfondo',
        ],
        'text_color' => [
            'label' => 'Colore Testo',
        ],
        'cta_color' => [
            'label' => 'Colore CTA',
        ],
        'logo' => [
            'label' => 'Logo',
        ],
        'copyright' => [
            'label' => 'Copyright',
        ],
        'links' => [
            'label' => 'Link',
        ],
        'alt' => [
            'label' => 'Testo alternativo',
        ],
        'text' => [
            'label' => 'Testo',
        ],
        'type' => [
            'label' => 'Tipo',
        ],
        'width' => [
            'label' => 'Larghezza',
        ],
        'height' => [
            'label' => 'Altezza',
        ],
        'children' => [
            'label' => 'children',
        ],
        'orientation' => [
            'label' => 'orientation',
        ],
        'placeholder' => [
            'label' => 'placeholder',
        ],
        'success_message' => [
            'label' => 'success_message',
        ],
        'error_message' => [
            'label' => 'error_message',
        ],
        'content' => [
            'label' => 'content',
        ],
        'target' => [
            'label' => 'target',
        ],
        'social_links' => [
            'label' => 'social_links',
        ],
        'platform' => [
            'label' => 'platform',
        ],
        'stats' => [
            'label' => 'stats',
        ],
        'number' => [
            'label' => 'number',
        ],
        'level' => [
            'label' => 'level',
        ],
        'background' => [
            'label' => 'background',
        ],
        'buttons' => [
            'label' => 'buttons',
        ],
        'class' => [
            'label' => 'class',
        ],
        'link' => [
            'label' => 'link',
        ],
        'ratio' => [
            'label' => 'ratio',
        ],
        'img_uuid' => [
            'label' => 'img_uuid',
        ],
        'gallery' => [
            'label' => 'gallery',
        ],
        'version' => [
            'label' => 'version',
        ],
        'method' => [
            'label' => 'method',
        ],
        'video' => [
            'label' => 'video',
        ],
    ],
    'model' => [
        'label' => 'Sezione',
        'plural' => 'Sezioni',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Sezione',
            'modal' => [
                'heading' => 'Crea Nuova Sezione',
                'submit' => 'Crea',
                'cancel' => 'Annulla',
            ],
        ],
        'edit' => [
            'label' => 'Modifica Sezione',
            'modal' => [
                'heading' => 'Modifica Sezione',
                'submit' => 'Salva',
                'cancel' => 'Annulla',
            ],
        ],
        'delete' => [
            'label' => 'Elimina Sezione',
            'modal' => [
                'heading' => 'Elimina Sezione',
                'description' => 'Sei sicuro di voler eliminare questa sezione?',
                'submit' => 'Elimina',
                'cancel' => 'Annulla',
            ],
        ],
        'view' => [
            'label' => 'Visualizza Sezione',
        ],
        'activeLocale' => [
            'label' => 'Lingua Attiva',
        ],
        'cancel' => [
            'label' => 'cancel',
        ],
        'save' => [
            'label' => 'save',
        ],
        'preview' => [
            'label' => 'preview',
        ],
    ],
    'messages' => [
        'created' => 'Sezione creata con successo',
        'updated' => 'Sezione aggiornata con successo',
        'deleted' => 'Sezione eliminata con successo',
        'bulk_deleted' => 'Sezioni eliminate con successo',
    ],
];
=======
return array (
  'navigation' => 
  array (
    'label' => 'Sezioni',
    'group' => 'Gestione Contenuti',
    'icon' => 'heroicon-o-rectangle-stack',
    'sort' => 85,
  ),
  'fields' => 
  array (
    'toggleColumns' => 
    array (
      'label' => 'Mostra/Nascondi Colonne',
    ),
    'resetFilters' => 
    array (
      'label' => 'Reimposta Filtri',
    ),
    'reorderRecords' => 
    array (
      'label' => 'Riordina Record',
    ),
    'applyFilters' => 
    array (
      'label' => 'Applica Filtri',
    ),
    'openFilters' => 
    array (
      'label' => 'Apri Filtri',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome della sezione',
    ),
    'slug' => 
    array (
      'label' => 'Slug',
      'placeholder' => 'Inserisci lo slug della sezione',
    ),
    'blocks' => 
    array (
      'label' => 'Blocchi',
      'placeholder' => 'Aggiungi blocchi alla sezione',
    ),
    'created_at' => 
    array (
      'label' => 'Data di Creazione',
    ),
    'updated_at' => 
    array (
      'label' => 'Data di Aggiornamento',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
    ),
    'create' => 
    array (
      'label' => 'Crea',
    ),
    'caption' => 
    array (
      'label' => 'Didascalia',
    ),
    'items' => 
    array (
      'label' => 'Elementi',
    ),
    'label' => 
    array (
      'label' => 'Etichetta',
    ),
    'url' => 
    array (
      'label' => 'URL',
    ),
    'style' => 
    array (
      'label' => 'Stile',
    ),
    'icon' => 
    array (
      'label' => 'Icona',
    ),
    'size' => 
    array (
      'label' => 'Dimensione',
    ),
    'alignment' => 
    array (
      'label' => 'Allineamento',
    ),
    'gap' => 
    array (
      'label' => 'Spaziatura',
    ),
    'title' => 
    array (
      'label' => 'Titolo',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
    ),
    'email' => 
    array (
      'label' => 'Email',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
    ),
    'map_url' => 
    array (
      'label' => 'URL Mappa',
    ),
    'button_text' => 
    array (
      'label' => 'Testo Bottone',
    ),
    'button_link' => 
    array (
      'label' => 'Link Bottone',
    ),
    'sections' => 
    array (
      'label' => 'Sezioni',
    ),
    'subtitle' => 
    array (
      'label' => 'Sottotitolo',
    ),
    'image' => 
    array (
      'label' => 'Immagine',
    ),
    'cta_text' => 
    array (
      'label' => 'Testo CTA',
    ),
    'cta_link' => 
    array (
      'label' => 'Link CTA',
    ),
    'background_color' => 
    array (
      'label' => 'Colore Sfondo',
    ),
    'text_color' => 
    array (
      'label' => 'Colore Testo',
    ),
    'cta_color' => 
    array (
      'label' => 'Colore CTA',
    ),
    'logo' => 
    array (
      'label' => 'Logo',
    ),
    'copyright' => 
    array (
      'label' => 'Copyright',
    ),
    'links' => 
    array (
      'label' => 'Link',
    ),
    'alt' => 
    array (
      'label' => 'Testo alternativo',
    ),
    'text' => 
    array (
      'label' => 'Testo',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
    ),
    'width' => 
    array (
      'label' => 'Larghezza',
    ),
    'height' => 
    array (
      'label' => 'Altezza',
    ),
    'children' => 
    array (
      'label' => 'children',
    ),
    'orientation' => 
    array (
      'label' => 'orientation',
    ),
    'placeholder' => 
    array (
      'label' => 'placeholder',
    ),
    'success_message' => 
    array (
      'label' => 'success_message',
    ),
    'error_message' => 
    array (
      'label' => 'error_message',
    ),
    'content' => 
    array (
      'label' => 'content',
    ),
    'target' => 
    array (
      'label' => 'target',
    ),
    'social_links' => 
    array (
      'label' => 'social_links',
    ),
    'platform' => 
    array (
      'label' => 'platform',
    ),
    'stats' => 
    array (
      'label' => 'stats',
    ),
    'number' => 
    array (
      'label' => 'number',
    ),
    'level' => 
    array (
      'label' => 'level',
    ),
    'background' => 
    array (
      'label' => 'background',
    ),
    'buttons' => 
    array (
      'label' => 'buttons',
    ),
    'class' => 
    array (
      'label' => 'class',
    ),
    'link' => 
    array (
      'label' => 'link',
    ),
    'ratio' => 
    array (
      'label' => 'ratio',
    ),
    'img_uuid' => 
    array (
      'label' => 'img_uuid',
    ),
    'gallery' => 
    array (
      'label' => 'gallery',
    ),
    'version' => 
    array (
      'label' => 'version',
    ),
    'method' => 
    array (
      'label' => 'method',
    ),
    'video' => 
    array (
      'label' => 'video',
    ),
  ),
  'model' => 
  array (
    'label' => 'Sezione',
    'plural' => 'Sezioni',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Sezione',
      'modal' => 
      array (
        'heading' => 'Crea Nuova Sezione',
        'submit' => 'Crea',
        'cancel' => 'Annulla',
      ),
    ),
    'edit' => 
    array (
      'label' => 'Modifica Sezione',
      'modal' => 
      array (
        'heading' => 'Modifica Sezione',
        'submit' => 'Salva',
        'cancel' => 'Annulla',
      ),
    ),
    'delete' => 
    array (
      'label' => 'Elimina Sezione',
      'modal' => 
      array (
        'heading' => 'Elimina Sezione',
        'description' => 'Sei sicuro di voler eliminare questa sezione?',
        'submit' => 'Elimina',
        'cancel' => 'Annulla',
      ),
    ),
    'view' => 
    array (
      'label' => 'Visualizza Sezione',
    ),
    'activeLocale' => 
    array (
      'label' => 'Lingua Attiva',
    ),
    'cancel' => 
    array (
      'label' => 'cancel',
    ),
    'save' => 
    array (
      'label' => 'save',
    ),
    'preview' => 
    array (
      'label' => 'preview',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Sezione creata con successo',
    'updated' => 'Sezione aggiornata con successo',
    'deleted' => 'Sezione eliminata con successo',
    'bulk_deleted' => 'Sezioni eliminate con successo',
  ),
);
>>>>>>> bc33217 (.)
