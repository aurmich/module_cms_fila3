<?php

declare(strict_types=1);

return [
    'label' => 'Attivo',
    'description' => 'Utente attivo nel sistema',
    'tooltip' => 'L\'utente è attivo e può utilizzare il sistema',
    'color' => 'success',
    'bg_color' => '#10b981',
    'icon' => 'heroicon-o-check-circle',
    'modal_heading' => 'Gestione Utente Attivo',
    'modal_description' => 'Questo utente è attualmente attivo nel sistema e può accedere a tutte le funzionalità.',
    
    'actions' => [
        'deactivate' => [
            'label' => 'Disattiva',
            'confirmation' => 'Sei sicuro di voler disattivare questo utente?',
            'success' => 'Utente disattivato con successo',
            'error' => 'Errore durante la disattivazione dell\'utente',
        ],
        'suspend' => [
            'label' => 'Sospendi',
            'confirmation' => 'Sei sicuro di voler sospendere questo utente?',
            'success' => 'Utente sospeso con successo',
            'error' => 'Errore durante la sospensione dell\'utente',
        ],
        'view_details' => [
            'label' => 'Visualizza Dettagli',
            'tooltip' => 'Visualizza i dettagli completi dell\'utente',
        ],
    ],
    
    'modal' => [
        'heading' => 'Gestione Utente Attivo',
        'description' => 'Questo utente è attualmente attivo nel sistema e può accedere a tutte le funzionalità.',
        'confirm' => 'Conferma',
        'cancel' => 'Annulla',
    ],
    
    'messages' => [
        'status_active' => 'L\'account è attualmente attivo',
        'full_access' => 'L\'utente ha accesso completo al sistema',
        'operational' => 'Tutte le funzionalità sono operative',
    ],
    
    'fields' => [
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci un messaggio',
            'helper_text' => '',
            'description' => 'Messaggio relativo allo stato attivo dell\'account',
        ],
        'activation_date' => [
            'label' => 'Data di Attivazione',
            'placeholder' => 'Seleziona la data di attivazione',
            'helper_text' => '',
            'description' => 'Data in cui l\'utente è stato attivato nel sistema',
        ],
        'last_login' => [
            'label' => 'Ultimo Accesso',
            'placeholder' => 'Data ultimo accesso',
            'helper_text' => '',
            'description' => 'Data e ora dell\'ultimo accesso dell\'utente',
        ],
    ],
];
