<?php

<<<<<<< HEAD
declare(strict_types=1);

return [
    'model' => [
        'label' => 'Studio Medico',
        'plural' => 'Studi Medici',
        'description' => 'Gestione degli studi medici e delle relative informazioni',
    ],

    'navigation' => [
        'label' => 'Studi Medici',
        'group' => 'Gestione Strutture',
        'icon' => 'heroicon-o-building-office',
        'sort' => 30,
    ],

    'pages' => [
        'index' => [
            'title' => 'Elenco Studi',
            'subtitle' => 'Gestisci gli studi registrati',
            'description' => 'Visualizza e gestisci tutti gli studi medici presenti nella piattaforma',
        ],
        'create' => [
            'title' => 'Nuovo Studio',
            'subtitle' => 'Registra un nuovo studio',
            'description' => 'Inserisci i dati per registrare un nuovo studio medico',
        ],
        'edit' => [
            'title' => 'Modifica Studio',
            'subtitle' => 'Modifica le informazioni dello studio',
            'description' => 'Aggiorna i dati dello studio medico',
        ],
        'view' => [
            'title' => 'Dettagli Studio',
            'subtitle' => 'Visualizza le informazioni complete',
            'description' => 'Dettagli completi del profilo studio',
        ],
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
            'helper_text' => 'Identificativo univoco dello studio',
        ],
        'active' => [
            'label' => 'Attivo',
            'helper_text' => 'Indica se lo studio è attualmente operativo',
        ],
        'name' => [
            'label' => 'Nome Studio',
            'placeholder' => 'Inserisci il nome dello studio',
            'helper_text' => 'Nome completo dello studio medico',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Inserisci l\'indirizzo completo',
            'helper_text' => 'Indirizzo completo dello studio',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il numero di telefono',
            'helper_text' => 'Numero di telefono principale dello studio',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'esempio@studio.it',
            'helper_text' => 'Indirizzo email di contatto dello studio',
        ],
        'website' => [
            'label' => 'Sito Web',
            'placeholder' => 'https://www.esempio.it',
            'helper_text' => 'URL del sito web dello studio',
        ],
        'registration_number' => [
            'label' => 'Numero di Registrazione',
            'placeholder' => 'Inserisci il numero di registrazione',
            'helper_text' => 'Numero di registrazione presso l\'ordine',
        ],
        'vat_number' => [
            'label' => 'Partita IVA',
            'placeholder' => 'IT12345678901',
            'helper_text' => 'Partita IVA dello studio',
        ],
        'open_filters' => [
            'label' => 'Filtri',
            'helper_text' => 'Apri il pannello dei filtri',
        ],
        'apply_filters' => [
            'label' => 'Applica',
            'helper_text' => 'Applica i filtri selezionati',
        ],
        'reset_filters' => [
            'label' => 'Azzera',
            'helper_text' => 'Rimuovi tutti i filtri',
        ],
        'reorder_records' => [
            'label' => 'Riordina',
            'helper_text' => 'Riordina i record',
        ],
        'toggle_columns' => [
            'label' => 'Colonne',
            'helper_text' => 'Mostra/nascondi colonne',
        ],
    ],

    'actions' => [
        'view_appointments' => [
            'label' => 'Vedi Appuntamenti',
            'icon' => 'heroicon-o-calendar-days',
            'tooltip' => 'Visualizza gli appuntamenti di questo studio',
        ],
        'manage_doctors' => [
            'label' => 'Gestisci Medici',
            'icon' => 'heroicon-o-user-group',
            'tooltip' => 'Gestisci i medici associati a questo studio',
        ],
        'activate' => [
            'label' => 'Attiva',
            'icon' => 'heroicon-o-check-circle',
            'tooltip' => 'Rendi lo studio attivo',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
            'icon' => 'heroicon-o-x-circle',
            'tooltip' => 'Disattiva temporaneamente lo studio',
        ],
    ],

    'filters' => [
        'active' => [
            'label' => 'Solo Attivi',
        ],
        'city' => [
            'label' => 'Per Città',
        ],
    ],

    'bulk_actions' => [
        'activate_selected' => [
            'label' => 'Attiva Selezionati',
            'icon' => 'heroicon-o-check-circle',
        ],
        'deactivate_selected' => [
            'label' => 'Disattiva Selezionati',
            'icon' => 'heroicon-o-x-circle',
        ],
    ],

    'messages' => [
        'created' => 'Studio creato con successo',
        'updated' => 'Studio aggiornato con successo',
        'deleted' => 'Studio rimosso con successo',
        'activated_successfully' => 'Studio attivato con successo',
        'deactivated_successfully' => 'Studio disattivato con successo',
        'error' => 'Si è verificato un errore durante l\'operazione',
    ],

    'validation' => [
        'name_required' => 'Il nome dello studio è obbligatorio',
        'email_email' => 'Inserisci un indirizzo email valido',
        'phone_required' => 'Il numero di telefono è obbligatorio',
    ],

    'search_placeholder' => 'Cerca per nome, indirizzo, telefono o email...',
];
=======
return array (
  'navigation' => 
  array (
    'label' => 'Studi Medici',
    'group' => 'Gestione Studi',
    'icon' => 'heroicon-o-building-office',
    'sort' => 30,
  ),
  'model' => 
  array (
    'label' => 'Studio Medico',
    'plural' => 'Studi Medici',
    'description' => 'Gestione degli studi medici e delle relative informazioni',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Elenco Studi',
      'subtitle' => 'Gestisci gli studi registrati',
      'description' => 'Visualizza e gestisci tutti gli studi medici presenti nella piattaforma',
    ),
    'create' => 
    array (
      'title' => 'Nuovo Studio',
      'subtitle' => 'Registra un nuovo studio',
      'description' => 'Inserisci i dati per registrare un nuovo studio medico',
    ),
    'edit' => 
    array (
      'title' => 'Modifica Studio',
      'subtitle' => 'Modifica le informazioni dello studio',
      'description' => 'Aggiorna i dati dello studio medico',
    ),
    'view' => 
    array (
      'title' => 'Dettagli Studio',
      'subtitle' => 'Visualizza le informazioni complete dello studio',
      'description' => 'Dettagli completi del profilo studio',
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => '',
      'helper_text' => '',
    ),
    'active' => 
    array (
      'label' => 'Attivo',
      'placeholder' => '',
      'helper_text' => 'Lo studio è attivo e visibile nella piattaforma',
    ),
    'name' => 
    array (
      'label' => 'Nome Studio',
      'placeholder' => 'Inserisci il nome dello studio',
      'helper_text' => 'Nome identificativo dello studio medico',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Via Roma, 123',
      'helper_text' => 'Indirizzo completo dello studio',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => '+39 051 1234567',
      'helper_text' => 'Numero di telefono principale dello studio',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'studio@email.com',
      'helper_text' => 'Indirizzo email per comunicazioni',
    ),
    'website' => 
    array (
      'label' => 'Sito Web',
      'placeholder' => 'https://www.studiomedico.it',
      'helper_text' => 'Sito web ufficiale dello studio',
    ),
    'registration_number' => 
    array (
      'label' => 'Numero di Registrazione',
      'placeholder' => 'Inserisci il numero di registrazione',
      'helper_text' => 'Numero di registrazione presso l\'Ordine',
    ),
    'vat_number' => 
    array (
      'label' => 'Partita IVA',
      'placeholder' => 'IT01234567890',
      'helper_text' => 'Partita IVA dello studio',
    ),
    'open_filters' => 
    array (
      'label' => 'Apri Filtri',
      'placeholder' => '',
      'helper_text' => '',
    ),
    'apply_filters' => 
    array (
      'label' => 'Applica Filtri',
      'placeholder' => '',
      'helper_text' => '',
    ),
    'reset_filters' => 
    array (
      'label' => 'Azzera Filtri',
      'placeholder' => '',
      'helper_text' => '',
    ),
    'reorder_records' => 
    array (
      'label' => 'Riordina Record',
      'placeholder' => '',
      'helper_text' => '',
    ),
    'toggle_columns' => 
    array (
      'label' => 'Mostra/Nascondi Colonne',
      'placeholder' => '',
      'helper_text' => '',
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
  ),
  'actions' => 
  array (
    'activate' => 
    array (
      'label' => 'Attiva',
      'icon' => 'heroicon-o-check-circle',
      'tooltip' => 'Rendi lo studio attivo',
    ),
    'deactivate' => 
    array (
      'label' => 'Disattiva',
      'icon' => 'heroicon-o-x-circle',
      'tooltip' => 'Disattiva temporaneamente lo studio',
    ),
    'view_doctors' => 
    array (
      'label' => 'Vedi Medici',
      'icon' => 'heroicon-o-user-plus',
      'tooltip' => 'Visualizza i medici associati allo studio',
    ),
  ),
  'filters' => 
  array (
    'active' => 
    array (
      'label' => 'Solo Attivi',
    ),
    'city' => 
    array (
      'label' => 'Per Città',
    ),
  ),
  'bulk_actions' => 
  array (
    'activate_selected' => 
    array (
      'label' => 'Attiva Selezionati',
      'icon' => 'heroicon-o-check-circle',
    ),
    'deactivate_selected' => 
    array (
      'label' => 'Disattiva Selezionati',
      'icon' => 'heroicon-o-x-circle',
    ),
  ),
  'messages' => 
  array (
    'activated_successfully' => 'Studio attivato con successo',
    'deactivated_successfully' => 'Studio disattivato con successo',
  ),
  'search_placeholder' => 'Cerca per nome, indirizzo, telefono o email...',
);
>>>>>>> 631510b4 (fix bashscripts structure + translation of module saluteMo)
